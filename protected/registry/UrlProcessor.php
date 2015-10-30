<?php
    class UrlProcessor {
        /*
         * registry object reference
         */
        private $_registry;
        
        /*
         * the URL components array
         */
        private $_urlBits = array();
        
        /*
         * URL path
         */
        private $_urlPath;
        
        /*
         * object constructor, loads registry object
         * @param $registry - an object instance of type Registry
         */
        public function __construct(Registry $registry) {
            $this->_registry = $registry;
        }
        
        /*
         * sets the URL path
         * @param string $path - the url path
         */
        public function setURLPath($path) {
            $this->_urlPath = $path;
        }
        
        /*
         * gets the data from the current URL and breaks it down into parts, 
         *   building up an array of 'URL bits'
         * @return array
         */
        public function getURLData() {
            $urlData = (isset($_GET['page'])) ? $_GET['page'] : '';
            $this->_urlPath = $urlData;
            if ($urlData == '') {
                $this->_urlBits[] = '';
                $this->_urlPath = '';
            } else {
                $data = explode('/', $urlData);
                while (!empty($data) && strlen(reset($data)) === 0) {
                    array_shift($data);
                }
                while (!empty($data) && strlen(end($data)) === 0) {
                    array_pop($data);
                }
                $this->_urlBits = $this->arrayTrim($data);
            }
        }
        
        /*
         * gets URL bits array
         */
        public function getURLBits() {
            return $this->_urlBits;
        }
        
        /*
         * gets acces to specific bit
         * @param int $whichBit - bit position inside array of bits
         */
        public function getURLBit($whichBit) {
            return (isset($this->_urlBits[$whichBit])) ? $this->_urlBits[$whichBit] : 0;
        }
        
        /*
         * get the URL path
         */
        public function getURLPath() {
            return $this->_urlPath;
        }
        
        /*
         * trims the URL data array
         */
        private function arrayTrim($array) {
            while (!empty($array) && strlen(reset($array)) === 0) {
                array_shift($array);
            }
            while (!empty($array) && strlen(end($array)) === 0) {
                array_pop($array);
            }
            return $array;
        }
        
        /*
         * make SEO friendly URL, spaces separated by hyphens
         * @param array $array - the array of data to be converted to URL string
         * @param mixed $index - choosen index which contains data to convert
         * @return array
         */
        public function makeUrlFromData($array, $index) {
            $urlAuthors = array();
            foreach($array as $key => $data) {
                $urlAuthors[$key] = preg_replace('/[^A-Za-z0-9\-\.]/', '', $data[$index]);
                $urlAuthors[$key] = str_replace(' ', '-', $data[$index]);
            }
            return $urlAuthors;
        }
        
        /*
         * make SEO friendly URL, spaces separated by hyphens
         * @param array $array - the array of data to be converted to URL string
         * @param mixed $arrayOfIndexes - choosen indexes which contains data to convert
         * @return array
         */
        public function makeUrlFromMultipleData($array, $arrayOfIndexes) {
            $url = array();
            foreach ($arrayOfIndexes as $key) {
                foreach ($array as $index => $value) {
                   $urlValues = $index . '-' . $value[$key];
                   $url[$index] = preg_replace('/[^A-Za-z0-9\-\.]/', '', $urlValues);
                   $url[$index] = str_replace(' ', '-', $urlValues);
                }
            }
            return $url;
        }
    }

