<?php
    require_once('Model.php');
    
    class Registration extends Model {
        
        /*
         * activation code
         */
        private $_activationCode;
        
        /*
         * flag property indicating if user is registered successfully or not
         */
        private $_registered = false;
        
        /*
         * validates and sanitizes entered form fields when user tries to register
         */
        public function checkRegistration() {
            $required = array('firstName' => 'firstName', 'lastName' => 'lastName', 'address' => 'address', 'city' => 'city', 'country' => 'country',
                                 'zipCode' => 'zipCode', 'email' => 'email', 'password1' => 'password1', 'password2' => 'password2', 'token' => 'token', 
                                 'captcha' => 'captcha');
            $this->_val->setRequired($required);
            $this->_val->matches('firstName', '/^[A-Za-z\'\.\-]{2,20}$/i');
            $this->_val->matches('lastName', '/^[A-Za-z\'\.\-]{2,40}$/i');
            $this->_val->matches('address', '/^[A-Za-z0-9\',\.#\-\s]{2,80}$/i');
            $this->_val->matches('city', '/^[A-Za-z\'\.\-\s]{2,60}$/i');
            $this->_val->removeTags('country');
            $this->_val->removeTags('state');
            $this->_val->matches('zipCode', '/^(\d{5}$)|(^\d{5}\-\d{4})$/');
            $this->_val->isEmail('email');
            $this->_val->matches('password1', '/^\w{4,20}$/');
            $this->_val->matches('password2', '/^\w{4,20}$/');
            $this->_val->checkMatch('password1', 'password2');
            $this->_val->removeTags('token');
            $this->_val->isInt('captcha');
            $this->_val->checkSessionMatch('captcha', 'vercode');
            $this->checkValidation();
        }
        
        /*
         * checks if registration required email address is already used on the site
         * @return bool
         */
        public function checkDoubleEmail($email) {
            if ($this->_registry->getObject('db')->selectOne('users', $email, 'email')) {
                return false;
            } else {
                return true;
            }
        }
        
        /*
         * - process the registration if all conditions are satisfied by inserting data in users table
         * - failure if user is using already registered email
         */
        public function processRegistration() {
            //$this->checkRegistration();
            if (empty($this->_errors) && empty($this->_missingValues)) {
                if ($this->checkDoubleEmail($this->_sanitizedValues['email']) == true) {
                    $this->_activationCode = md5(uniqid(rand(), true));
                    $state = $this->_sanitizedValues['state'] == null ? null : $this->_sanitizedValues['state'];
                    $pass = password_hash($this->_sanitizedValues['password1'], PASSWORD_BCRYPT);
                    return ($this->_registry->getObject('db')->insert('users', array(
                            'first_name' => $this->_sanitizedValues['firstName'],
                            'last_name' => $this->_sanitizedValues['lastName'],
                            'address' => $this->_sanitizedValues['address'],
                            'city' => $this->_sanitizedValues['city'],
                            'country' => $this->_sanitizedValues['country'],
                            'state' => $state,
                            'zip' => $this->_sanitizedValues['zipCode'],
                            'email' => $this->_sanitizedValues['email'],
                            'pass' => $pass,
                            'active' => $this->_activationCode,
                            'registration_date' => date('Y-m-d H:i:s')))) ? $this->_registered = true : $this->_registered = false;     
                } else {
                    $this->_registry->getObject('template')->doubleEmailError = '<p class="error">That email address has already been registered. If you have forgotten your '
                        . 'password, use the <a href="authenticate/password">Forgot Password</a> link to reset your password.</p>';
                }
            } else {
                $this->_registry->getObject('template')->registrationError = '<p class="error">Please try again.</p>';
            }     
        }
        
        /*
         * selects the countries for display in HTML select form field
         */
        public function selectCountries() {
            $queryStr = 'SELECT country_name, country_abbrev FROM countries ORDER BY country_name';
            return $this->_registry->getObject('db')->makeDataArray($queryStr, 'country_abbrev', 'country_name');
        }
        
        /*
         * selects the USA states for display in HTML select form field
         */
        public function selectStates() {
            $queryStr = "SELECT state_abbrev, state_name FROM states ORDER BY CASE WHEN state_name = 'SELECT' THEN -1 ELSE state_name END";
            return $this->_registry->getObject('db')->makeDataArray($queryStr, 'state_abbrev', 'state_name');
        }
        
        /*
         * activates new user account
         * @param string $email - user email address
         * @param string $activationCode - activation coded sended to email address
         */
        public function activate($email, $activationCode) {
            if (isset($email, $activationCode) && strlen($activationCode) == 32) {
                $queryStr = 'UPDATE `users` SET active=NULL WHERE (email=? AND active=?) LIMIT 1';
                $this->_registry->getObject('db')->execute($queryStr, array($email, $activationCode));
                if ($this->_registry->getObject('db')->affectedRows() == 1) {
                    $this->_session->flash('message', '<h4>Your account is now active. You may now <a href="authenticate/login">Login.</a></h4>');
                    $this->_registry->redirectTo();
                } else {
                    $this->_session->flash('message', '<p class="error">Your account could not be activated. Please re-check the link or contact the system administrator</p>');
                    $this->_registry->redirectTo();
                }
            }
        }
        
        /*
         * check flag which indicates if user is logged in
         * @return bool - true if registration is successful, and false if not
         */
        public function isRegistered() {
            return $this->_registered;
        }
        
        /*
         * create full name of the user
         */
        public function getFullName() {
            return $this->getSanitizedValue('firstName') . ' ' . $this->getSanitizedValue('lastName');
        }
        
        /*
         * getter methods
         */               
        public function getActivationCode() {
            return $this->_activationCode;
        }
    }