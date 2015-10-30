<?php
    require_once('protected/controllers/Controller.php');
    
    class AuthenticateController extends Controller {
        
        /*
         * user model reference
         */
        private $_user;
        
        /*
         * controller contructor, loads user model
         * @param registry - an object instance of type Registry
         */
        public function __construct(Registry $registry) {
            parent::__construct($registry, 'authenticate');
            $this->_user = $this->_registry->getModel('user');
            if (isset($this->_urlBits[1])) {
                switch($this->_urlBits[1]) {
                    case 'logout':
                        $this->logout();
                        break;
                    case 'login':
                        $this->login();
                        break;
                    case 'password':
                        $this->forgotPassword();
                        break;
                    case 'reset-password':
                        $this->resetPassword(filter_var($this->_urlBits[2], FILTER_SANITIZE_STRING));
                        break;
                    default:
                        $this->login();
                        break;
                }
            } else {
                $this->login();
            }
        }
        
        /*
         * - handles user login form, redirects logged in user to the account page
         * - template variables are used in: main.login.php  
         */
        private function login() {
            $this->_template->title = 'Login';
            $this->_template->loginErrors = $this->_model->getErrors();
            $this->_template->input = $this->_model->getSubmittedValues();
            $this->_template->missing = $this->_model->getMissingValues();
            $this->_template->token = $this->_security->generateToken();
            if ($this->_model->isJustProcessed()) {
                if (filter_has_var(INPUT_POST, 'login') && $this->_model->isLoggedIn() === false) {
                    $this->_template->buildFromTemplates('header.php', 'sidebar.php', 'main.login.php', 'footer.php');
                } elseif ($this->_model->isLoggedIn() === true && $this->_model->isAdmin() === true) {
                    $this->_security->deleteTokenFromSession();
                    $this->_registry->redirectTo('admin/main');
                } else {
                    $this->_security->deleteTokenFromSession();
                    $this->_session->exists('url') === true ? $this->_registry->redirectToPrevious() : $this->_registry->redirectTo('account/info');   
                }
            } else {
                if ($this->_model->isLoggedIn() === true) {
                    $this->_security->deleteTokenFromSession();
                    $this->_session->exists('url') === true ? $this->_registry->redirectToPrevious() : $this->_registry->redirectTo('account/info');
                } elseif ($this->_model->isLoggedIn() === true && $this->_model->isAdmin() === true) {
                    $this->_security->deleteTokenFromSession();
                    $this->_registry->redirectTo('admin/main');
                } else {
                    $this->_template->buildFromTemplates('header.php', 'sidebar.php', 'main.login.php', 'footer.php');
                }
            }       
        }
        
        /*
         * handles user logout redirecting to main index page
         */
        private function logout() {
            $this->_model->logout();
            $this->_registry->redirectTo();
        }
        
        /*
         * - dealing with forgot password form
         * - if email is correct and exists in database an email with password token and link 
         *    for reseting the password is send to the user
         * - template variables are used in: main.forgotpass.php
         */
        private function forgotPassword() {
            $this->_template->title = 'Forgot Password';
            if (filter_has_var(INPUT_POST, 'forgotPassword')) {
                $this->_user->forgotPassword();
                $passToken = $this->_user->getPassToken();
                $email = $this->_user->getSanitizedValue('email');
                $token = $this->_user->getSanitizedValue('token');
                $this->_security->checkCsrfToken($token);
                if ($this->_user->isTokenInserted() == true) {
                    $this->_mail->sendPasswordToken($email, $passToken);
                } else {
                    $this->_template->token = $this->_security->generateToken();
                    $this->_template->forgotError = '<p class="error">Please try again.</p>';
                    $this->_template->errors = $this->_user->getErrors();
                    $this->_template->missing = $this->_user->getMissingValues();
                    $this->_template->buildFromTemplates('header.php', 'sidebar.php', 'main.forgotpass.php', 'footer.php');
                }
            } else {
                $this->_template->token = $this->_security->generateToken();
                $this->_template->buildFromTemplates('header.php', 'sidebar.php', 'main.forgotpass.php', 'footer.php');
            }
        }
        
        /*
         * - handles form for changing the password of not logged users
         * - template variables are used in: main.resetpass.php 
         * @param string $token - token which is sended to user through email
         */
        private function resetPassword($token) {
            $this->_template->title = 'Change Password';
            if (strlen($token) == 64 && $this->_model->isLoggedIn() == false) {
                $this->checkTokenExpired($token);
                if (filter_has_var(INPUT_POST, 'resetPassword')) {
                    $response = $this->_user->resetPassword($token);
                    $csrfToken = $this->_user->getSanitizedValue('token');
                    $this->_security->checkCsrfToken($csrfToken);
                    switch ($response) {
                        case 'changed':
                            $this->_session->flash('message', '<h4>Your password has been changed. You may now <a href="authenticate/login">Login</a></h4>');
                            $this->_security->deleteTokenFromSession();
                            $this->_registry->redirectTo();
                            break;
                        case 'not changed':
                            $this->_session->flash('message', '<p class="error">Your password could not be changed due to a system error. We apologize for any inconvenience.</p>');
                            $this->_security->deleteTokenFromSession();
                            $this->_registry->redirectTo();
                            break;
                        case 'token not deleted':
                            $this->_session->flash('message', '<p class="error">Token is invalid or has been expired!</p>');
                            $this->_security->deleteTokenFromSession();
                            $this->_registry->redirectTo();
                            break;
                        case 'val errors':
                            $this->_template->token = $this->_security->generateToken();
                            $this->_template->resetErrors = $this->_user->getErrors();
                            $this->_template->missing = $this->_user->getMissingValues();
                            $this->_template->input = $this->_user->getSubmittedValues();
                            $this->_template->buildFromTemplates('header.php', 'sidebar.php', 'main.resetpass.php', 'footer.php');
                            break;       
                    }
                } else {
                    $this->_template->token = $this->_security->generateToken();
                    $this->_template->resetErrors = $this->_user->getErrors();
                    $this->_template->missing = $this->_user->getMissingValues();
                    $this->_template->input = $this->_user->getSubmittedValues();
                    $this->_template->buildFromTemplates('header.php', 'sidebar.php', 'main.resetpass.php', 'footer.php');
                }
            } else {
                $this->_session->flash('message', '<p class="error">Token is invalid or has been expired!</p>');
                $this->_security->deleteTokenFromSession();
                $this->_registry->redirectTo();
            }    
        }
        
        /*
         * checks if reset password token is not expired
         * @param string $token
         */
        private function checkTokenExpired($token) {
            $this->_user->checkTokenExpired($token);
            if ($this->_user->isTokenExpired() == true) {
                $this->_session->flash('message', '<p class="error">Token is invalid or has been expired!</p>');
                $this->_registry->redirectTo();
            }
        }
    }