<?php
    require_once('protected/controllers/Controller.php');
    
    class RegistrationController extends Controller {
        
        /*
         * object constructor
         * @param $registry - an object instance of type Registry
         */
        public function __construct(Registry $registry) {
            parent::__construct($registry, 'register');
            if (isset($this->_urlBits[1])) {
                switch ($this->_urlBits[1]) {
                    case 'register':
                        $this->register();
                        break;
                    case 'activate':
                        $this->activate();
                        break;
                    default:
                        $this->_register();
                        break;
                }
            } else {
                $this->register();
            }
        }
        
        /*
         * - communicates with registration model and sends activation email if user is registered
         * - template variables are used in: main.register.php
         */
        private function register() {
            if ($this->_registry->getModel('authenticate')->isLoggedIn() === false) {
                $this->_template->title = 'Register';
                $this->_template->countries = $this->showCountries();
                $this->_template->states = $this->showStates();    
                if (filter_has_var(INPUT_POST, 'register')) {
                    $this->_model->checkRegistration();
                    $token = $this->_model->getSanitizedValue('token');
                    $this->_security->checkCsrfToken($token);
                    $this->_model->processRegistration();
                    if ($this->_model->isRegistered() == true) {
                        $name = $this->_model->getFullName();
                        $activationCode = $this->_model->getActivationCode();
                        $email = $this->getSanitizedValue('email');
                        $this->_security->deleteTokenFromSession();
                        $this->_mail->sendActivationCode($name, $email, $activationCode);
                    } else {
                        $this->_template->token = $this->_security->generateToken();
                        $this->_template->captcha = $this->_security->createCaptcha();
                        $this->displayFormErrors('_model');
                        $this->_template->buildFromTemplates('header.php', 'sidebar.php', 'main.register.php', 'footer.php');
                    }
                } else {
                    $this->_template->captcha = $this->_security->createCaptcha();
                    $this->_template->token = $this->_security->generateToken();
                    $this->_template->buildFromTemplates('header.php', 'sidebar.php', 'main.register.php', 'footer.php');
                }
            } else {
                $this->_registry->redirectTo('account');
            }
        }

        /*
         * - checks if email address and activation code in the URL are invalid 
         * - if activate proccess fails then redirects the user to main index page with notice about failure
         */
        private function activate() {
            $email = filter_var($this->_urlBits[2], FILTER_SANITIZE_EMAIL);
            $activationCode = filter_var($this->_urlBits[3], FILTER_SANITIZE_STRING);
            if (!$this->_model->activate($email, $activationCode)) {
                $this->_session->flash('message', '<p class="error">Your account could not be activated. Please re-check the link or contact the system administrator</p>');
                $this->_registry->redirectTo();
            }
        }
        
        /*
         * methods for getting countries and states to display in the form select tag
         */
        public function showCountries() {
            return $this->_model->selectCountries();
        }
        
        public function showStates() {
            return $this->_model->selectStates();
        }
    }