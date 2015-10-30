<?php
    require_once('protected/admin/models/A_Model.php');
    
    class A_Customers extends A_Model {
        
        private $_activationCode;
        
        /*
         * gets all customers with selected info
         * @return array
         */
        public function getAllCustomers() {
            $queryStr = "SELECT u.user_id, u.first_name, u.last_name, u.user_level, DATE_FORMAT(u.registration_date, '%M %e, %Y') AS dateRegistered, "
                    . "c.country_name, IF(u.active IS NULL,1,0) AS isActive "
                    . "FROM users u "
                    . "JOIN countries c ON u.country = c.country_abbrev ORDER BY u.user_id";
            return $this->_registry->getObject('db')->makeMultiDataArray($queryStr, 'user_id');
        }
        
        /*
         * gets user info 
         * @parm int $userId
         * @return array
         */
        public function getUserInfo($userId) {
            $queryStr = "SELECT u.user_id, u.first_name, u.last_name, u.address, u.city, c.country_abbrev, c.country_name, s.state_abbrev, s.state_name, u.zip, u.email, "
                    . "u.user_level, IF(u.active IS NULL,1,0) AS isActive, DATE_FORMAT(u.registration_date, '%M %e, %Y %H:%i:%s') AS dateRegistered, "
                    . "COUNT(o.order_id) AS totalOrders FROM users u JOIN countries c ON u.country = c.country_abbrev "
                    . "LEFT OUTER JOIN states s ON u.state = s.state_abbrev AND u.state IS NOT NULL "
                    . "LEFT OUTER JOIN orders o ON u.user_id = o.user_id WHERE u.user_id = ? GROUP BY u.user_id";
            return $this->_registry->getObject('db')->makeAssocArray($queryStr, [$userId]);
        }
        
        /*
         * - checks update user form fields, change is optional so in required array are only values submitted in POST request
         * - POST value of 'token' and 'update' (submit input) should not be included in validation process
         */
        private function checkUpdateUserFields() {
            $this->setRequiredFields(['token', 'updateUser']);
            if (in_array('first_name', $this->_required)) { $this->_val->matches('first_name', '/^[A-Za-z\'\.\-]{2,20}$/i'); }
            if (in_array('last_name', $this->_required)) { $this->_val->matches('last_name', '/^[A-Za-z\'\.\-]{2,40}$/i'); }
            if (in_array('address', $this->_required)) { $this->_val->matches('address', '/^[A-Za-z0-9\',\.#\-\s]{2,80}$/i'); }
            if (in_array('city', $this->_required)) { $this->_val->matches('city', '/^[A-Za-z\'\.\-\s]{2,60}$/i'); }
            if (in_array('country', $this->_required)) { $this->_val->removeTags('country'); }
            if (in_array('state', $this->_required)) { $this->_val->removeTags('state'); }
            if (in_array('zip', $this->_required)) { $this->_val->matches('zip', '/^(\d{5}$)|(^\d{5}\-\d{4})$/'); }
            if (in_array('email', $this->_required)) { $this->_val->isEmail('email'); }
            if (in_array('user_level', $this->_required)) { $this->_val->isInt('user_level'); }
            $this->checkValidationOnUpdate();
        }
        
        /*
         * updates changes in user table if any
         * @param int $userId
         * @return string - confirmation about success or failure
         */
        public function updateUser($userId) {
            $this->checkUpdateUserFields();
            if (empty($this->_errors)) {
                if ($this->checkDoubleEmail($userId) === true) {
                    $this->_sanitizedValues['state'] = (isset($this->_sanitizedValues['state'])) ? $this->_sanitizedValues['state'] : null;
                    return ($this->_registry->getObject('db')->update('users', $this->_sanitizedValues, $userId, 'user_id')) ? 'success' : 'failure';
                } else {
                    return 'failure';
                }
            } else {
                return 'failure';
            }
        }
        
        /*
         * - checks if an email already exists in datatabase
         * - inserts activation code into table if email address going to be changed
         * @param int $userId - needed when inserting new activation code
         * @return bool
         */
        private function checkDoubleEmail($userId) {
            if (isset($this->_sanitizedValues['email'])) {
                if ($this->_registry->getModel('register')->checkDoubleEmail($this->_sanitizedValues['email']) === false) {
                    $this->_registry->getObject('template')->doubleEmail = '<p class="error">Email address already exists. Please enter another one.</p>';
                    return false;
                } else {
                    $this->_activationCode = md5(uniqid(rand(), true));
                    $this->_registry->getObject('db')->update('users', ['active' => $this->_activationCode], $userId, 'user_id');
                    return true;
                }
            } else {
                return true;
            }
        }
        
        /*
         * getter methods
         */
        public function getActivationCode() {
            return $this->_activationCode;
        }
    }
