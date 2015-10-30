<?php
    class Template {
        /*
         * reference to the registry object
         */
        private $_registry;
        
        /*
         * array of vars referenced to current page
         */
        private $_vars = array();
        
        /*
         * constructs object, loads registry object
         * @param $registry - an object instance of type Registry
         */
        public function __construct(Registry $registry) {
            $this->_registry = $registry;
        }
        
        /*
         * sets vars into array
         * @param string $key - key of the var
         * @param string $value - value of the var
         */
        public function __set($key, $value) {
            $this->_vars[$key] = $value;
        }
        
        /*
         * gets vars from the array
         * @param string $key - index in array
         */
        public function __get($key) {
            return $this->_vars[$key];
        }
        
        /*
         * sets the content of the page based on a number of templates, pass
         *   template file locations as individual arguments
         */
        public function buildFromTemplates() {
            $bits = func_get_args();
            foreach ($bits as $bit) {
                $bit = 'protected/views/' . $this->_registry->getSetting('view') . '/templates/' . $bit;
                if (file_exists($bit) == true) {
                    foreach ($this->_vars as $key => $value) {
                        $$key = $value;
                    }
                    include($bit);
                }
            }
        }
        
        /*
         * sets the content of the pages for admin area 
         */
        public function buildFromAdminTemplates() {
            $bits = func_get_args();
            foreach ($bits as $bit) {
                $bit = 'protected/views/admin/' . $bit;
                if (file_exists($bit) == true) {
                    foreach ($this->_vars as $key => $value) {
                        $$key = $value;
                    }
                    include($bit);
                }
            }
        }
        
        /*
         * handles multiple data in one string separating them into array
         * @param string $string
         * @return array
         */
        public function separateMultipleData($string = '') {
            $data = array();
            if (strpos($string, ',') !== false) {
                $data = explode(',', $string);
            } else {
                $data[] = $string;
            }
            return array_map('trim', $data);
        }
        
        /*
         * makes associative array from two strings, first contains values for 
         *   keys and second for values
         * @param string $stringOfIndexes
         * @param string $stringOfValues
         * @return array
         */
        public function stringsToArray($stringOfIndexes = '', $stringOfValues = '') {
            $arrayOfIndexes = $this->separateMultipleData($stringOfIndexes);
            $arrayOfValues = $this->separateMultipleData($stringOfValues);
            $combinedArray = array_combine($arrayOfIndexes, $arrayOfValues);
            return $combinedArray;
        }
        
        /*
         * creates required form fields array from optional fields
         * @param array $excludedParams - array of parameters that shoud be excluded from array
         * @return array
         */
        public function createRequiredArray($excludedParams = array()) {
            $required = array();
            foreach ($_POST as $key => $value) {
                if ($value !== '') {
                    $required[$key] = $key;
                }
            }
            foreach ($excludedParams as $param) {
                if (($key = array_search($param, $required)) !== false) {
                    unset($required[$key]);
                }
            }
            return $required;
        }
    }