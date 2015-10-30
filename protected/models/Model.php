<?php
    class Model {
        /*
         * registry object reference
         */
        protected $_registry;
        
        /*
         * sanitized values from validation process
         */
        protected $_sanitizedValues = array();
        
        /*
         * errors occurred during validation process
         */
        protected $_errors = array();
        
        /*
         * missing values in form
         */
        protected $_missingValues;
        
        /*
         * user submitted values from form
         */
        protected $_submittedValues = array();
        
        /*
         * validator object reference
         */
        protected $_val;
        
        /*
         * session object reference
         */
        protected $_session;
        
        /*
         * object constructor, loads registry object
         * @param $registry - an object instance of type registry
         */
        public function __construct(Registry $registry) {
            $this->_registry = $registry;
            require_once('Validator.php');
            $this->_val = new Validator();
            $this->_session = $this->_registry->getObject('session');
        }
        
        /*
         * process the validation and assigns results to the properties
         */
        protected function checkValidation() {
            $this->_sanitizedValues = $this->_val->validateInput();
            $this->_missingValues = $this->_val->getMissing();
            $this->_errors = $this->_val->getErrors();
            $this->_submittedValues = $this->_val->getSubmitted();
        }
        
        /*
         * getter methods
         */
        public function getErrors() {
            return $this->_errors;
        }
        
        public function getSubmittedValues() {
            return $this->_submittedValues;
        }
 
        public function getMissingValues() {
            return $this->_missingValues;
        }
        
        public function getSanitizedValue($name) {
            return $this->_sanitizedValues[$name];
        }
    }

