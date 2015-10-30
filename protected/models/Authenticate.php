<?php
    require_once('Model.php');
    
    class Authenticate extends Model {
        
        /*
         * reference to the user object
         */
        private $_user;
        
        /*
         * reference to user id
         */
        private $_userId = 0;
        
        /*
         * reference to validator object
         */
        //private $_validator;
        
        /*
         * boolean variable indicating if user is logged in
         */
        private $_loggedIn = false;
        
        /*
         * indicates if login has just been procesed or not
         */
        private $_justProcessed = false;
        private $_loginFailureReason;                            
        
        /*
         * checks both for an active session and user credentials being passed 
         *   in POST data, and calls additional methods to build the user object
         */
        public function checkForAuthentication() {
            if (isset($_SESSION['authSessionUid']) && intval($_SESSION['authSessionUid'] > 0)) {
                $this->sessionAuthenticate(intval($_SESSION['authSessionUid']));
                if ($this->_loggedIn == true) {
                    $this->_registry->getObject('template')->loginError = '';
                } else {
                    $this->_registry->getObject('template')->loginError = '<p class="error">Your email/password was not correct, please try again</p>';
                }
            } elseif (filter_has_var(INPUT_POST, 'login')) {
                $this->checkLogin();
                $token = $this->_sanitizedValues['token'];
                $this->_registry->getObject('security')->checkCsrfToken($token);
                if (empty($this->_errors)) {
                    $email = $this->_sanitizedValues['email'];
                    $password = $this->_sanitizedValues['password'];
                    $this->postAuthenticate($email, $password);
                    if ($this->_loggedIn == true) {
                        $this->_registry->getObject('template')->loginError = '';
                    } else {
                        $this->_registry->getObject('template')->loginError = '<p class="error">Your email/password was not correct, please try again.</p>';
                    }
                }
            } 
        }
        
        /*
         * utilizes the user object to query database if the user exists and is 
         *   logged in by submitting login form, sets the appropriate session data
         * @param string $email - user email
         * @param string $password - user password
         */
        private function postAuthenticate($email, $password) {
            $this->_justProcessed = true;
            require_once('User.php');
            $this->_user = new User($this->_registry, 0, $email, $password);
            if ($this->_user->isValid()) {
                if ($this->_user->isActive() == false) {
                    $this->_loggedIn = false;
                    $this->_loginFailureReason = 'inactive';
                } else {
                    $this->_loggedIn = true;
                    // transfers basket content to user if it's added to basket before login
                    $this->_registry->getModel('basket')->transferToUser($this->_user->getUserId());
                    session_regenerate_id();
                    $this->_session->put('authSessionUid', $this->_user->getUserId());
                    $this->_session->put('admin', serialize($this->_user->isAdmin()));
                    $this->_session->put('firstName', $this->_user->getFirstName());
                    $this->_session->put('lastName', $this->_user->getLastName());
                    $this->_session->put('email', $this->_registry->getObject('security')->encryptData($this->_user->getEmail()));
                    $this->_userId = $this->_user->getUserId();
                }
            } else {
                $this->_loggedIn = false;
                $this->_loginFailureReason = 'invalidcredencials';
            }
        }
        
        /*
         * try to authenticate user based on session data if it is set
         * @param int $uid - user ID
         */
        private function sessionAuthenticate() {
            require_once('User.php');
            $this->_user = new User($this->_registry, intval($_SESSION['authSessionUid']), '', '');
            if ($this->_user->isValid()) {
                if ($this->_user->isActive() == false) {
                    $this->_loggedIn = false;
                    $this->_loginFailureReason = 'inactive';
                } else {
                    $this->_loggedIn = true;
                    // transfers basket content to user if products are added to basket before login
                    $this->_registry->getModel('basket')->transferToUser($this->_user->getUserId());
                    session_regenerate_id();
                    $this->_userId = $this->_user->getUserId();
                }
            } else {
                $this->_loggedIn = false;
                $this->_loginFailureReason = 'nouser';
            }
            if ($this->_loggedIn == false) {
                $this->logout();
            }
        }
        
        /*
         * logs out the user clearing the session data
         */
        public function logout() {
            $_SESSION = array();
            session_destroy();
            setcookie(session_name(), '', time()-3600);
            $this->_loggedIn = false;
        }

        /*
         * validates and sanitizes entered form fields when user tries to login
         */
        private function checkLogin() {      
            $required = array('email' => 'email', 'password' => 'password', 'token' => 'token');
            $this->_val->setRequired($required);
            $this->_val->isEmail('email');
            $this->_val->matches('password', '/^\w{4,20}$/');
            $this->_val->removeTags('token');
            $this->checkValidation();
        }
        
        /*
         * redirects invalid user which don't have access to specific area of the site if they are not logged in
         * @param string $location - location for redirect the user
         */
        public function redirectInvalidUser($location = '') {
            if ($this->_loggedIn === false) {
                $this->_registry->redirectTo($location);
            }
        }
        
        /*
         * checks if user level is set to 1 which indicates that user is admin
         * @return bool
         */
        public function isAdmin() {
            return ($this->_session->exists('admin') && unserialize($this->_session->get('admin')) == 1) ? true : false;
        }
        
        /*
         * redirects invalid user without access to admin area
         * @param string $location - location for redirect the user
         */
        public function redirectFromAdminArea($location = '') {
            if ($this->isAdmin() === false) {
                $this->_registry->redirectTo($location);
            }
        }
  
        public function getUserId() {
            return $this->_userId;
        }
        
        public function isLoggedIn() {
            return $this->_loggedIn;
        }
        
        public function isJustProcessed() {
            return $this->_justProcessed;
        }
        
        public function getUser() {
            return $this->_user;
        }
    }