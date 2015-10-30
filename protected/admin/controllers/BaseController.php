<?php
    class BaseController {
         /*
         * registry object reference
         */
        protected $_registry;
        
        /*
         * template object reference
         */
        protected $_template;
        
        /*
         * URL bits used for routing
         */
        protected $_urlBits;
        
        /*
         * reference to main model appropriate to controller
         */
        protected $_model;
        
        /*
        * object constructor - loads registry and template objects
        * @param $registry - an object instance of type registry
        * @param string $model- the name of the file containing appropriate model for controller
        */
        public function __construct(Registry $registry, $model) {
            $this->_registry = $registry;
            $this->_template = $this->_registry->getObject('template');
            require_once('protected/admin/models/' . $model . '.php');
            $this->_model = new $model($this->_registry);
            $this->_registry->getModel('authenticate')->redirectFromAdminArea();
            $this->_urlBits = $this->_registry->getObject('url')->getURLBits();
        }
        
        /*
         * checks csrf token
         */
        protected function checkToken() {
            $token = filter_var($_POST['token'], FILTER_SANITIZE_STRING);
            $this->_registry->getObject('security')->checkCsrfToken($token);
        }
        
        /*
         * sets template variables for processing form errors
         */
        protected function displayFormErrors() {
            $this->_template->errors = $this->_model->getErrors();
            $this->_template->missing = $this->_model->getMissingValues();
            $this->_template->input = $this->_model->getSubmittedValues();
            $this->_template->error = '<p class="error">An error occurred. Please try again.</p>';
        }
    }
