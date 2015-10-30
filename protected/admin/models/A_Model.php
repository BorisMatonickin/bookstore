<?php
    class A_Model {
        /*
         * registry object reference
         */
        protected $_registry;
        
        /*
         * form submitted values
         */
        protected $_submittedValues = array();
        
        /*
         * form sanitized values
         */
        protected $_sanitizedValues = array();
        
        /*
         * validation errors
         */
        protected $_errors = array();
        
        /*
         * form missing values
         */
        protected $_missingValues = array();
        
        /*
         * uploaded file name
         */
        protected $_file;
        
        /*
         * required form fields
         */
        protected $_required;
        
        /*
         * validator model reference
         */
        protected $_val;
        
        /*
         * object constructor - loads registry object
         * @param $registry - an object instance of type Registry
         */
        public function __construct(Registry $registry) {
            $this->_registry = $registry;
            require_once('protected/models/Validator.php');
            $this->_val = new Validator();
        }
        
        /*
         * - checks size, allowed types, sets upload directory for file which needs to be uploaded
         * - return appropriate error from UploadFile class if conditions are not met
         * @param int $maxFileSize - the max file size
         * @param string $uploadDir
         * @param array $allowedType - array of allowed file types to be uploaded
         * @param bool $isRequired - boolean flag if file upload is required in the form
         */
        protected function checkUploadedFile($maxFileSize, $uploadDir, $allowedTypes = array(), $isRequired = true) {
            $this->_registry->getModel('upload')->setMaxFileSize($maxFileSize);
            $this->_registry->getModel('upload')->setAllowedFileTypes($allowedTypes);
            $this->_registry->getModel('upload')->setUploadDir(BASE_URI . $uploadDir);
            if ($this->_registry->getModel('upload')->attachFile($_FILES['image']) === true) {
                $this->_file = $this->_registry->getModel('upload')->getFileName();
            } else {
                $this->_errors['image'] = $this->_registry->getModel('upload')->getErrors();
                if ($isRequired == false && ($this->_errors['image'] == 'No file' || $this->_errors['image'] == 'No file was uploaded')) {
                    unset($this->_errors['image']);
                }
            }
        }
        
        /*
         * process the validation and assigns results to properties
         */
        protected function checkValidation() {
            $this->_sanitizedValues = array_map('trim', $this->_val->validateInput());
            $this->_missingValues = $this->_val->getMissing();
            $this->_errors = $this->_val->getErrors();
            $this->_submittedValues = array_map('trim', $this->_val->getSubmitted());
        }
        
        /*
         * process the validation in update form and assings results to properties 
         */
        protected function checkValidationOnUpdate() {
            $this->_submittedValues = array_map('trim', $this->_val->getSubmitted());
            if (!empty($this->_required) && !empty($this->_submittedValues)) {
                $this->_sanitizedValues = array_map('trim', $this->_val->validateInput());
                $this->_errors = $this->_val->getErrors();
            }
        }
        
        /*
         * sets required form fields
         * @param array $fieldsExcluded - index of fields which are not included in validation
         */
        protected function setRequiredFields($fieldsExcluded = array()) {
            $this->_required = $this->_registry->getObject('template')->createRequiredArray($fieldsExcluded);
            $this->_val->setRequired($this->_required);
        }
        
        /*
         * getter methods
         */
        public function getSanitizedValues() {
            return $this->_sanitizedValues;
        }
        
        public function getSanitizedValue($index) {
            return $this->_sanitizedValues[$index];
        }
        
        public function getMissingValues() {
            return $this->_missingValues;
        }
        
        public function getErrors() {
            return $this->_errors;
        }
        
        public function getSubmittedValues() {
            return $this->_submittedValues;
        }
    }