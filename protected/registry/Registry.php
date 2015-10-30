<?php
    class Registry {
        /*
         * array of objects
         */
        private $_objects;
        
        /*
         * array of settings
         */
        private $_settings;
        
        /*
         * reference to models array
         */
        private $_models;
        
        public function __construct() {}
        
        /*
         * creates a new object and store it in the registry
         * @param string $object - the object file prefix
         * @param string $key - pair for the object
         */
        public function createAndStoreObject($object, $key) {
            require_once($object . '.php');
            $this->_objects[$key] = new $object($this);
        }
        
        /*
         * creates new model and store it in the registry
         * @param string $model - model class
         * @param string $key - key to store model in array
         */
        public function createAndStoreModel($model, $key) {
            require_once('protected/models/' . $model . '.php');
            $this->_models[$key] = new $model($this);
        }
        
        /*
         * get an object from the registries store
         * @param string $key - the objects array key
         * @return object
         */
        public function getObject($key) {
            return $this->_objects[$key];
        }
        
        /*
         * get a model from the models array
         * @param string $key - the models array key
         * @return object
         */
        public function getModel($key) {
            return $this->_models[$key];
        }
        
        /*
         * store settings in the array
         * @param string $setting - the setting data
         * @param string $key - the key for the array to acces the setting
         */
        public function storeSetting($setting, $key) {
            $this->_settings[$key] = $setting;
        }
        
        /*
         * gets a setting from the registry
         * @param string $key - the used to store the setting
         * @return string - the setting
         */
        public function getSetting($key) {
            return $this->_settings[$key];
        }
        
        /*
         * loads pages controllers based on url params
         * @param $registry - an object instance of type Registry
         * @param string $controller - the name of the controller
         */
        public function loadController(Registry $registry, $controller) {
            $controllers = array();
            $queryStr = "SELECT * FROM controllers WHERE active=1";
            $registry->getObject('db')->execute($queryStr);
            while ($ctrl = $registry->getObject('db')->getRows()) {
                $controllers[] = $ctrl['controller'];
            }
            if (isset($controller) && in_array($controller, $controllers)) {
                require_once('protected/controllers/' . $controller . '/controller.php');
                $controllerInc = ucfirst($controller) . 'Controller';
                $controller = new $controllerInc($registry);
                return $controller;
            } else {
                // default controller
                require_once('protected/controllers/main/controller.php');
                $controller = new MainController($registry);
                return $controller;
            }  
        }
        
        /*
         * loads controllers for admin area
         * @param $registry - an object instance of type Registry
         * @param string $controller - the of the controller
         */
        public function loadAdminController(Registry $registry, $controller) {
            $adminControllers = array();
            $queryStr = "SELECT * FROM controllers_admin WHERE active = 1";
            $registry->getObject('db')->execute($queryStr);
            while ($adctrl = $registry->getObject('db')->getRows()) {
                $adminControllers[] = $adctrl['controller'];
            }
            if (isset($controller) && is_string($controller) && in_array($controller, $adminControllers)) {
                require_once('protected/admin/controllers/' . ucfirst($controller)) . 'Controller.php';
                $controllerInc = ucfirst($controller) . 'Controller';
                $controller = new $controllerInc($registry);
                return $controller;
            } else {
                $registry->redirectTo();
            }
        }
        
        /*
         * redirects the user
         * @param string $location - default is /home
         */
        public function redirectTo($location = '') {
            $url = $this->getSetting('siteurl') . $location;
            ob_end_clean();
            header("Location: $url");
            exit();
        }
        
        /*
         * redirects the user to the product page
         */
        public function redirectToProduct() {
            $productPage = $this->getObject('session')->get('productPage');
            $url = $this->getSetting('protocol') . 'localhost' . $productPage;
            ob_end_clean();
            header("Location: $url");
            exit();
        }
        
        /*
         * redirects the user to the previously visited page
         */
        public function redirectToPrevious() {
            $location = $this->getObject('session')->get('url');
            $url = $this->getSetting('protocol') . 'localhost' . $location;
            ob_end_clean();
            header("Location: $url");
            exit();
        }
        
        /*
         * checks if variable is stored in session, redirects the user to desired location if it's not
         * @param string $var - session variable to check
         * @param string $redirectLocation - location to redirect
         */
        public function checkVarInSession($var, $redirectLocation = '') {
            if (!$this->getObject('session')->exists($var)) {
                $this->redirectTo($redirectLocation);
            }
        }
    }
