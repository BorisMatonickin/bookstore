<?php
    require_once('protected/controllers/Controller.php');
    
    class ContactController extends Controller {
        
        /*
         * final cleaned form data
         */
        private $_scrubbed;
        
        /*
         * - object constructor
         * - sends an email to site admin with user queries
         * - template variables are used in: main.contact.php
         * @param $registry - an object instance of type Registry
         */
        public function __construct(Registry $registry) {
            parent::__construct($registry);
            $this->_template->title = 'Contact Us';
            if (filter_has_var(INPUT_POST, 'send')) {
                $this->checkContactForm();
                $token = $this->_scrubbed['token'];
                $this->_security->checkCsrfToken($token);
                if (empty($this->_errors) && empty($this->_missingValues)) {
                    $this->_template->buildFromTemplates('header.php', 'sidebar.php', 'main.contact.php', 'footer.php');
                    $this->_security->deleteTokenFromSession();
                    $this->_mail->sendMailToAdmin($this->_scrubbed['name'], $this->_scrubbed['email'], $this->_scrubbed['message']);
                } else {
                    $this->_template->token = $this->_security->generateToken();
                    $this->_template->captcha = $this->_security->createCaptcha();
                    $this->displayFormErrors();
                    $this->_template->buildFromTemplates('header.php', 'sidebar.php', 'main.contact.php', 'footer.php');
                }
            } else {
                $this->_template->token = $this->_security->generateToken();
                $this->_template->captcha = $this->_security->createCaptcha();
                $this->_template->buildFromTemplates('header.php', 'sidebar.php', 'main.contact.php', 'footer.php');
            }
        }
        
        /*
         * validates and sanitize contact form inputs
         */
        private function checkContactForm() {
            $required = array('name' => 'name', 'email' => 'email', 'message' => 'message', 'token' => 'token', 'captcha' => 'captcha');
            $this->_val->setRequired($required);
            $this->_val->matches('name', '/^[A-Za-z\'\.\-\s]{2,80}$/i');
            $this->_val->isEmail('email');
            $this->_val->matches('message', '/^[a-zA-Z0-9?$@#\(\)\'!,+\-=_:\.&€£*%\s]+$/');
            $this->_val->removeTags('token');
            $this->_val->isInt('captcha');
            $this->_val->checkSessionMatch('captcha', 'vercode');
            $this->checkValidation();
            $this->_scrubbed = array_map(array($this->_security, 'spamScrubber'), $this->_sanitizedValues);
        }
    }