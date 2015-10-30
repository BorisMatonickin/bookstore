<?php
    require_once('protected/admin/models/A_Model.php');
    
    class A_Publishers extends A_Model {
        
        /*
         * gets all publisher with selected info
         * @return array
         */
        public function getAllPublishers() {
            $queryStr = "SELECT p.publisher_id, p.name, p.address, p.city, c.country_name AS country, p.phone FROM publisher p "
                    . "JOIN countries c ON p.country = c.country_abbrev ORDER BY p.publisher_id ASC";
            return $this->_registry->getObject('db')->makeMultiDataArray($queryStr, 'publisher_id');
        }
        
        /*
         * gets publisher info 
         * @param int $publisherId
         * @return array
         */
        public function getPublisherInfo($publisherId) {
            $queryStr = "SELECT p.publisher_id, p.name, p.address, p.city, c.country_abbrev, c.country_name, p.phone, p.description, p.email, p.website "
                    . "FROM publisher p JOIN countries c ON p.country = c.country_abbrev WHERE p.publisher_id = ?";
            return $this->_registry->getObject('db')->makeAssocArray($queryStr, [$publisherId]);
        }
        
        /*
         * - validates and sanitize form fields for inserting new publisher
         * - there are some fields which are not required and also needs to be passed 
         *   to Validator class if filled in 
         * - final array for validation process is maded with merging two arrays: 
         *   1. required fields array
         *   2. submitted values from $_POST request
         */
        private function checkNewPublisherFields() {
            $required = array('name' => 'name', 'address' => 'address', 'city' => 'city', 'country' => 'country', 'phone' => 'phone');
            $submittedFields = $this->_registry->getObject('template')->createRequiredArray(['token', 'createPublisher']);
            $requiredFinal = array_merge($required, $submittedFields);
            $this->_val->setRequired($requiredFinal);
            $this->_val->matches('name', '/^[A-Za-z09\'\.\-\s&\(\)]{2,100}$/i');
            $this->_val->matches('address', '/^[A-Za-z0-9\',\.#\-\s]{2,80}$/i');
            $this->_val->matches('city', '/^[A-Za-z\'\s\.\-]{2,60}$/i');
            $this->_val->removeTags('country');
            $this->_val->matches('phone', '/\(?\d{1,3}\)?\-\d{3,3}\-\d{4,4}/');
            if (in_array('email', $requiredFinal)) { $this->_val->isEmail('email'); }
            if (in_array('website', $requiredFinal)) { $this->_val->isURL('website'); }
            if (in_array('description', $requiredFinal)) { $this->_val->matches('description', "/^[a-zA-Z0-9?$@#\(\)\'\"!,+\-=_:;\.&%\s]+$/"); }
            $this->checkValidation();
        }
        
        /*
         * inserts new publisher
         * @return string - confirmation about success or failure
         */
        public function insertNewPublisher() {
            $this->checkNewPublisherFields();
            if (empty($this->_errors) && empty($this->_missing)) {
                $publisher = array('name' => $this->_sanitizedValues['name'],
                                   'address' => $this->_sanitizedValues['address'],
                                   'city' => $this->_sanitizedValues['city'],
                                   'country' => $this->_sanitizedValues['country'],
                                   'phone' => $this->_sanitizedValues['phone'],
                                   'description' => (isset($this->_sanitizedValues['description'])) ? $this->_sanitizedValues['description'] : null,
                                   'email' => (isset($this->_sanitizedValues['email'])) ? $this->_sanitizedValues['email'] : null,
                                   'website' => (isset($this->_sanitizedValues['website'])) ? $this->_sanitizedValues['website'] : null);
                return ($this->_registry->getObject('db')->insert('publisher', $publisher)) ? 'success' : 'failure';
            }
        }
        
        /*
         * - checks update publisher form fields, change is optional so in required array are only values submitted in POST request
         * - POST value of 'token' and 'update' (submit input) should not be included in validation process
         */
        private function checkUpdatePublisherFields() {
            $this->setRequiredFields(['token', 'updatePublisher']);
            if (in_array('name', $this->_required)) { $this->_val->matches('name', '/^[A-Za-z09\'\.\-\s&\(\)]{2,100}$/i'); }
            if (in_array('address', $this->_required)) { $this->_val->matches('address', '/^[A-Za-z0-9\',\.#\-\s]{2,80}$/i'); }
            if (in_array('city', $this->_required)) { $this->_val->matches('city', '/^[A-Za-z\'\s\.\-]{2,60}$/i'); }
            if (in_array('country', $this->_required)) { $this->_val->removeTags('country'); }
            if (in_array('phone', $this->_required)) { $this->_val->matches('phone', '/\(?\d{1,3}\)?\-\d{3,3}\-\d{4,4}/'); }
            if (in_array('email', $this->_required)) { $this->_val->isEmail('email'); }
            if (in_array('website', $this->_required)) { $this->_val->isURL('website'); }
            if (in_array('description', $this->_required)) { $this->_val->matches('description', "/^[a-zA-Z0-9?$@#\(\)\'\"!,+\-=_:;\.&%\s]+$/"); }
            $this->checkValidation();
        }
        
        /*
         * updates changes into publishers table if any
         * @param int $publisherId
         */
        public function updatePublisher($publisherId) {
            $this->checkUpdatePublisherFields();
            if (empty($this->_errors)) {
                return ($this->_registry->getObject('db')->update('publisher', $this->_sanitizedValues, $publisherId, 'publisher_id')) ? 'success' : 'failure';
            } else {
                return 'failure';
            }
        }
    }