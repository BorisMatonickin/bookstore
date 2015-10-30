<?php
    class Validator {
        /*
         * choosen input type for validation GET or POST
         */
        private $_inputType;
        
        /*
         * users submitted values
         */
        private $_submitted;
        
        /*
         * required data
         */
        private $_required;
        
        /*
         * filtering arguments
         */
        private $_filterArgs;
        
        /*
         * filtered, sanitized database ready data
         */
        private $_filtered;
        
        /*
         * required fields that are missing
         */
        private $_missing;
        
        /*
         * errors in the process of validation and sanitizing
         */
        private $_errors;
        
        /*
         * object constructor, checks if filter functions are present 
         *   in current version of php
         * defines required, filter arguments and errors arrays
         * @param array $required - required form fields
         * @param string $inputType - select input type, default POST
         */
        public function __construct($inputType = 'post') {
            if (!function_exists('filter_list')) {
                throw new Exception('The Validator class requires the Filter Functions in >=PHP 5.2');
            }
            $this->setInputType($inputType);
            $this->_filterArgs = array();
            $this->_errors = array();
        }
        
        /*
         * 
         */
        public function setRequired($required = array()) {
            if (!is_null($required) && !is_array($required)) {
                throw new Exception('The names of required fields must be an array, even if one field is required.');
            }
            $this->_required = $required;
            if ($this->_required) {
                $this->checkRequired();
            }
        }
        
        /*
         * sets the choosen input type
         * @param string $type - input type, POST or GET
         */
        private function setInputType($type) {
            switch (strtolower($type)) {
                case 'post':
                    $this->_inputType = INPUT_POST;
                    $this->_submitted = $_POST;
                break;
                case 'get':
                    $this->_inputType = INPUT_GET;
                    $this->_submitted = $_GET;
                break;
                default:
                    throw new Exception('Invalid input type.');
            }
        }
        
        /*
         * checks required fields array
         */
        private function checkRequired() {
            $ok = array();
            foreach ($this->_submitted as $name => $value) {
                $value = is_array($value) ? $value : trim($value);
                if (!empty($value)) {
                    $ok[] = $name;
                }
            }
            $this->_missing = array_diff($this->_required, $ok);
            foreach ($this->_missing as $key => $value) {
                $this->_missing[$key] = 'Missing entry!';
            }
        }
        
        /*
         * checks for duplicate filter usage
         * @param string $fieldName - form field to check
         */
        private function checkDuplicateFilter($fieldName) {
            if (isset($this->_filterArgs[$fieldName])) {
                throw new Exception("A filter has already been set for the following field: $fieldName");
            }
        }
        
        /*
         * removes tags from field
         * @param string $fieldName
         */
        public function removeTags($fieldName) {
            $this->checkDuplicateFilter($fieldName);
            $this->_filterArgs[$fieldName]['filter'] = FILTER_SANITIZE_STRING;
        }
        
        /*
         * checks is input matches the required regular expression pattern
         * @param string $fieldName - the name of field to aply the filter
         * @param string $pattern - the regular expression pattern
         */
        public function matches($fieldName, $pattern) {
            $this->checkDuplicateFilter($fieldName);
            $cleanField = strip_tags($fieldName);
            $this->_filterArgs[$cleanField] = array(
                'filter' => FILTER_VALIDATE_REGEXP,
                'options' => array('regexp' => $pattern));
        }
        
        /*
         * checks if field is URL
         * @param string @fieldName - name of field to check
         */
        public function isURL($fieldName) {
            $this->checkDuplicateFilter($fieldName);
            $this->_filterArgs[$fieldName]['filter'] = FILTER_VALIDATE_URL;
        }
        
        /*
         * checks if input is email
         * @param $fieldName - name of field to check
         */
        public function isEmail($fieldName) {
            $this->checkDuplicateFilter($fieldName);
            $this->_filterArgs[$fieldName] = FILTER_VALIDATE_EMAIL;
        }
        
        /*
         * checks if input is integer
         * @param string $fieldName - the name of field to check
         * @param int $min - optional, minimum value of integer
         * @param int $max - optiona, maximum value of integer
         */
        public function isInt($fieldName, $min = NULL, $max = NULL) {
            $this->checkDuplicateFilter($fieldName);
            $this->_filterArgs[$fieldName] = array('filter' => FILTER_VALIDATE_INT);
            if (is_int($min)) {
                $this->_filterArgs[$fieldName]['options']['min_range'] = $min;
            }
            if (is_int($max)) {
                $this->_filterArgs[$fieldName]['options']['max_range'] = $max;
            }
        }
        
        /*
         * checks if input is float type number
         * @param string $fieldName - the name of field to check
         * @param string $decimalPoint - default decimal point is .
         */
        public function isFloat($fieldName, $decimalPoint = '.') {
            if ($decimalPoint != '.' && $decimalPoint != ',') {
                throw new Exception('Decimal point must be a comma or period in isFloat().');
            }
            $this->checkDuplicateFilter($fieldName);
            $this->_filterArgs[$fieldName] = array('filter' => FILTER_VALIDATE_FLOAT,
                                                   'options' => array('decimal' => $decimalPoint));
        }
        
        /*
         * sanitizes HTML special chars
         * @param string $fieldName - the name of field to sanitize
         */
        public function useEntities($fieldName) {
            $this->checkDuplicateFilter($fieldName);
            $this->_filterArgs[$fieldName]['filter'] = FILTER_SANITIZE_SPECIAL_CHARS;
        }
        
        /*
         * checks if two fields have same value
         * @param string $field1
         * @param string $field2
         */
        public function checkMatch($field1, $field2) {
            if ($this->_submitted[$field1] != $this->_submitted[$field2]) {
                $this->_errors[$field2] = 'Entries are not the same!';
            }
        }
        
        /*
         * checks if form field matches the session value
         * @param string $field - form field
         * @param string $sessionVar - index of variable in session array
         */
        public function checkSessionMatch($field, $sessionVar) {
            if (isset($_SESSION[$sessionVar])) {
                if ($this->_submitted[$field] != $_SESSION[$sessionVar]) {
                    $this->_errors[$field] = 'Invalid entry!';
                }
            }
        }
        
        /*
         * validates input in accordance with rules we defined in filterArgs array
         * @return array - validated input as array
         */
        public function validateInput() {
            // initialize an array for required items that haven't been validated
            $noFiltered = array();
            // get the names of all fields that have been validated
            $tested = array_keys($this->_filterArgs);
            // loop through the rerquired fields and add any missing ones to $nofiltered
            foreach ($this->_required as $field) {
                if (!in_array($field, $tested)) {
                    $noFiltered[] = $field;
                }
            }
            // throw an exception if any items have been added to the $noFiltered array
            if ($noFiltered) {
                throw new Exception('No filter has been set for the following required item(s): ' . implode(', ', $noFiltered));
            }
            // apply the validation tests using filter_input_array() function
            $this->_filtered = filter_input_array($this->_inputType, $this->_filterArgs);
            // find which items failed validation
            foreach ($this->_filtered as $key => $value) {
                // skip items that are either missing or not required
                if (in_array($key, $this->_missing) || !in_array($key, $this->_required)) {
                    continue;
                } elseif ($value === false) {
                    // add filtered value to the $_errors array if it failed validation
                    $this->_errors[$key] = 'Invalid entry!';
                }
            }
            // return the validated input as array
            return $this->_filtered;
        }
        
        /*
         * getter methods
         */
        public function getMissing() {
            return $this->_missing;
        }
        
        public function getFiltered() {
            return $this->_filtered;
        }
        
        public function getErrors() {
            return $this->_errors;
        }
        
        public function getSubmitted() {
            return $this->_submitted;
        }
    }

