<?php
    class Session {
        /*
         * checks if session variable exists
         * @param string $name - the name of the session index
         * @return bool
         */
        public function exists($name) {
            if (!empty($name)) {
                return (isset($_SESSION[$name])) ? true : false;
            }
        }
        
        /*
         * puts the value of the variable in the session
         * @param string $name - the name of the session index
         * @param string $value - the value to be put
         */
        public function put($name, $value) {
            if (!empty($name) && !empty($value)) {
                return $_SESSION[$name] = $value;
            }
        }
        
        /*
         * gets the session variable
         * @param string $name - the name of the session index
         */
        public function get($name) {
            if (!empty($name)) {
                return $_SESSION[$name];
            }
        }
        
        /*
         * deletes variable from session
         * @param string $name - the name of the session index
         */
        public function delete($name) {
            if ($this->exists($name)) {
                unset($_SESSION[$name]);
            }
        }
        
        /*
         * sets flash messages
         * @param string $name - the name of the session index
         * @param string $message - flash message to be stored in the session
         */
        public function flash($name = 'message', $message = '') {
            if ($this->exists($name)) {
                $session = $this->get($name);
                $this->delete($name);
                return $session;
            } else {
                $this->put($name, $message);
            }
        }
        
        /*
         * checks if flash message exists in the session
         * @param string $name - the name of the session index
         */
        public function checkFlashMessage($name) {
            if ($this->exists($name)) {
                return $this->flash($name);
            }
            return '';
        }
    }