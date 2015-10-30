<?php
    class Controller {
        
        /*
         * registry object reference
         */
        protected $_registry;
        
        /*
         * reference to main model for current controller
         */
        protected $_model;
        
        /*
         * url bits for routing
         */
        protected $_urlBits;
        
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
         * references to objects used by controllers
         */
        protected $_session;
        protected $_template;
        protected $_url;
        protected $_security;
        protected $_mail;
        protected $_paginator;
        
        /*
         * object constructor, loads registry object
         * @param $registry - an object instance of type registry
         * @param string $model - the name of controller's appropriate main model
         */
        public function __construct(Registry $registry, $model = null) {
            $this->_registry = $registry;
            if (isset($model)) {
                $this->_model = $this->_registry->getModel($model);
            }
            $this->_session = $this->_registry->getObject('session');
            $this->_template = $this->_registry->getObject('template');
            $this->_url = $this->_registry->getObject('url');
            $this->_security = $this->_registry->getObject('security');
            $this->_mail = $this->_registry->getObject('mailout');
            $this->_paginator = $this->_registry->getObject('paginator');
            $this->_urlBits = $this->_url->getURLBits();
            $this->_template->isAdmin = $this->_registry->getModel('authenticate')->isAdmin();
            require_once('protected/models/Validator.php');
            $this->_val = new Validator();
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
         * - sets template variables for processing form errors
         * - if errors holder is not set, errors are handled by the same controller
         * @param string $errorsHolder - the model which holds error
         */
        protected function displayFormErrors($errorsHolder = null) {
            $this->_template->errors = (isset($errorsHolder)) ? $this->$errorsHolder->getErrors() : $this->getErrors();
            $this->_template->missing = (isset($errorsHolder)) ? $this->$errorsHolder->getMissingValues() : $this->getMissingValues();
            $this->_template->input = (isset($errorsHolder)) ? $this->$errorsHolder->getSubmittedValues() : $this->getSubmittedValues();
            $this->_template->error = '<p class="error">An error occurred. Please try again.</p>';
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
