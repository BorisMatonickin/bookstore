<?php
    require_once('Model.php');
    
    class User extends Model {
        
        /*
         * user details
         */
        private $_userId;
        private $_firstName;
        private $_lastName;
        private $_email;
        private $_userLevel = 0;
        private $_active;
        
        /*
         * flag to indicate if user is valid
         */
        private $_isValid = false;
        
        /*
         * reset password token
         */
        private $_passToken;
        
        /*
         * reset password token flags
         */
        private $_tokenInserted = false;
        private $_tokenExpired = true;
        private $_tokenDeleted = false;
        
        /*
         * object constructor, loads registry object
         * @param int $id - user ID
         * @param string $email - user email
         * @param string $password - user password
         */
        public function __construct(Registry $registry, $id = 0, $email = '', $password = '') {
            parent::__construct($registry);
            // if the user id is not set ($id = 0) check email and password are valid credentials
            if ($id == 0 && $email != '' && $password != '') {
                $pass = $this->hashedPassword($email);
                if (password_verify($password, $pass)) {
                    $queryStr = "SELECT * FROM `users` WHERE `email`=? AND `pass`=? AND `active` IS NULL";
                    $this->_registry->getObject('db')->execute($queryStr, [$email, $pass]);
                    if ($this->_registry->getObject('db')->affectedRows() == 1) {
                        $user = $this->_registry->getObject('db')->getRows();
                        $this->_userId = $user['user_id'];
                        $this->_firstName = $user['first_name'];
                        $this->_lastName = $user['last_name'];
                        $this->_email = $user['email'];
                        $this->_active = $user['active'];
                        $this->_userLevel = $user['user_level'];
                        $this->_isValid = true;
                    }
                }
            } elseif ($id > 0) {
                $id = intval($id);
                $queryStr = "SELECT * FROM `users` WHERE `user_id`=? AND `active` IS NULL";
                $this->_registry->getObject('db')->execute($queryStr, [$id]);
                if ($this->_registry->getObject('db')->affectedRows() == 1) {
                    $user = $this->_registry->getObject('db')->getRows();
                    $this->_userId = $user['user_id'];
                    $this->_firstName = $user['first_name'];
                    $this->_lastName = $user['last_name'];
                    $this->_email = $user['email'];
                    $this->_active = $user['active'];
                    $this->_userLevel = $user['user_level'];
                    $this->_isValid = true;
                }
            }
        }
        
        /*
         * gets hashed password from users table to be compared with the user entered password
         * @param string $email - user email
         */
        private function hashedPassword($email = '') {
            if (!empty($email)) {
                $password = $this->_registry->getObject('db')->selectOne('users', $email, 'email');
                if (!empty($password)) {
                    return $password['pass'];
                }
                return false;
            }
            return false;
        }
        
        /*******************************************************************************************************************************************************
         ******************************************************* reset password methods ************************************************************************
         *******************************************************************************************************************************************************/
        
        /*
         * inserts access token for reseting password if an email address entered is valid
         */
        public function forgotPassword() {
            $this->checkEmailField();   
            if (empty($this->_errors) && empty($this->_missingValues)) {
                $queryStr = "SELECT user_id FROM users WHERE email = ? AND active IS NULL";
                $this->_registry->getObject('db')->execute($queryStr, [$this->_sanitizedValues['email']]);
                $row = $this->_registry->getObject('db')->getRows();
                $user = $row['user_id'];
                if ($user) {
                    $token = openssl_random_pseudo_bytes(32);
                    $this->_passToken = bin2hex($token);
                    $queryStr = "REPLACE INTO access_tokens (user_id, token, date_expires) "
                            . "VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 15 MINUTE))";
                    $this->_registry->getObject('db')->execute($queryStr, [$user, $this->_passToken]);
                    return ($this->_registry->getObject('db')->affectedRows() > 0) ? $this->_tokenInserted = true : $this->_tokenInserted = false;
                } else {
                    $this->_tokenInserted = false;
                }
            }
        }
        
        /*
         * validates and sanitizes email form field in forgot password form
         */
        private function checkEmailField() {
            $required = array('email' => 'email', 'token' => 'token');
            $this->_val->setRequired($required);
            $this->_val->isEmail('email');
            $this->_val->removeTags('token');
            $this->checkValidation();
        }
        
        /*
         * handles reseting the user password
         * @param string $token
         * @return string - response of success or failure of the process
         */
        public function resetPassword($token) {
            $this->checkPasswordFields();
            if (empty($this->_errors) && empty($this->_missingValues)) {
                $this->deletePasswordToken($token);
                if ($this->_tokenDeleted == true) {
                    $pass = password_hash($this->_sanitizedValues['password1'], PASSWORD_BCRYPT);
                    return ($this->_registry->getObject('db')->update('users', ['pass' => $pass], $this->_userId, 'user_id')) ? 'changed' : 'not changed';
                } else {
                    return 'token not deleted';
                }   
            } else {
                return 'val errors';
            }
        }
        
        /*
         * handles deleting reset password token from database
         * @param string $token - token which is sended to user email
         */
        private function deletePasswordToken($token) {
            $queryStr = "SELECT user_id, date_expires FROM access_tokens WHERE token = ? AND date_expires > NOW()";
            $this->_registry->getObject('db')->execute($queryStr, [$token]);
            $row = $this->_registry->getObject('db')->getRows();
            $this->_userId = $row['user_id'];
            if ($this->_userId) {
                return ($this->_registry->getObject('db')->delete('access_tokens', $this->_userId, 'user_id')) ? $this->_tokenDeleted = true : $this->_tokenDeleted = false;
            } else {
                $this->_tokenDeleted = false;
            }
        }
        
        /*
         * checks if reset password token has expired
         * @param string $token
         */
        public function checkTokenExpired($token) {
            $queryStr = "SELECT date_expires FROM access_tokens WHERE token = ? AND date_expires > NOW()";
            $this->_registry->getObject('db')->execute($queryStr, [$token]);
            return ($this->_registry->getObject('db')->affectedRows() > 0) ? $this->_tokenExpired = false : $this->_tokenExpired = true;
        }
        
        /*
         * validates and sanitizes new password form fields
         */
        private function checkPasswordFields() {
            $required = array('password1' => 'password1', 'password2' => 'password2', 'token' => 'token');
            $this->_val->setRequired($required);
            $this->_val->matches('password1', '/^\w{4,20}$/');
            $this->_val->matches('password2', '/^\w{4,20}$/');
            $this->_val->checkMatch('password1', 'password2');
            $this->_val->removeTags('token');
            $this->checkValidation();
        }
        
        /*****************************************************************************************************************************************************
         ******************************************************** methods for changing password of registered user *******************************************
         *****************************************************************************************************************************************************/
        
        /*
         * changes user password if all conditions are satisfied
         * @param string password
         * @return string - response of success or failure of the process
         */
        public function changePassword($email) {
            $this->checkPasswordFormFields();
            if (empty($this->_errors) && empty($this->_missingValues)) {
                if ($this->checkOldPassword($this->_sanitizedValues['password1'], $email) == true) {
                    $pass = password_hash($this->_sanitizedValues['password2'], PASSWORD_BCRYPT);
                    return ($this->_registry->getObject('db')->update('users', ['pass' => $pass], $email, 'email')) ? 'success' : 'failure';
                } else {
                    $this->_errors['password1'] = 'Invalid entry!';
                    return 'incorrect password';
                }
            } else {
                return 'val errors';
            }
        }
        
        /*
         * checks if old password entered matches password stored in database
         * @param string $password
         * @return boolean
         */
        private function checkOldPassword($password, $email){
            $pass = $this->hashedPassword($email);
            return (password_verify($password, $pass)) ? true : false; 
        }
        
        /*
         * validates and sanitizes reset password form fields of registered users
         */
        private function checkPasswordFormFields() {
            $required = array('password1' => 'password1', 'password2' => 'password2', 'password3' => 'password3');
            $this->_val->setRequired($required);
            $this->_val->matches('password1', '/^\w{4,20}$/');
            $this->_val->matches('password2', '/^\w{4,20}$/');
            $this->_val->matches('password3', '/^\w{4,20}$/');
            $this->_val->checkMatch('password2', 'password3');
            $this->checkValidation();
        }
        
        /*
         * getter methods
         */
        public function getUserId() {
            return $this->_userId;
        }
        
        public function getFirstName() {
            return $this->_firstName;
        }
        
        public function getLastName() {
            return $this->_lastName;
        }
        
        public function getFullName() {
            return $this->_firtsName . ' ' . $this->_lastName;
        }
        
        public function getEmail() {
            return $this->_email;
        }
        
        public function isActive() {
            return ($this->_active == NULL) ? true : false;
        }
        
        public function isAdmin() {
            return ($this->_userLevel == 1) ? true : false;
        }
        
        public function isValid() {
            return $this->_isValid;
        }
        
        public function getPassToken() {
            return $this->_passToken;
        }
        
        public function isTokenInserted() {
            return $this->_tokenInserted;
        }
        
        public function isTokenExpired() {
            return $this->_tokenExpired;
        }
    }