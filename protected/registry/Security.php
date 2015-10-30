<?php
    class Security {
        /*
         * reference to registry object
         */
        private $_registry;
        
        /*
         * reference to session object
         */
        private $_session;
        
        /*
         * salt for encryption
         */
        private $_salt;
        
        /*
         * csrf token
         */
        private $_token;
        
        /*
         * captcha number
         */
        private $_captcha;
        
        /*
         * object constructor, loads registry and session objects
         * @param $registry - an object instance of type Registry
         */
        public function __construct(Registry $registry) {
           $this->_registry = $registry;
           $this->_salt = 'vo1su2ce3_pa4i5ka6ja7';
           require_once('Session.php');
           $this->_session = new Session();
        }

        /********************************************************************************************************************************************************
         ********************************************************* csrf token methods *************************************************************************** 
         ********************************************************************************************************************************************************/
        
        /*
         * generates csrf token
         * @return string - randomized token
         */
        public function generateToken() {
            return $this->_session->put('token', md5(uniqid(rand(), true)));
        }
        
        
        /*
         * checks if csrf token is valid
         * @param string $token
         * @return bool
         */
        public function checkCsrfToken($token) {
            $sessionToken = $this->_session->get('token');
            if ($token !== $sessionToken) {
                $this->_registry->getObject('session')->flash('message', '<p class="error">An error occured.We apologize for any inconvenience.</p>');
                $this->deleteTokenFromSession();
                $this->_registry->redirectTo(); 
            }
        }
        
        /*
         * deletes token from session when it's no more valid and when leaving the page
         */
        public function deleteTokenFromSession() {
            $this->_session->delete('token');
        }
        
        /*
         * allows specified parameters through GET request
         * @param array $allowedParam - array of allowed params
         * @return array - allowed params
         */
        public function allowedGetParams($allowedParams = array()) {
            $allowedArray = array();
            foreach ($allowedParams as $param) {
                if (isset($_GET[$param])) {
                    $allowedArray[$param] = $_GET[$param];
                } else {
                    $allowedArray[$param] = NULL;
                }
                return $allowedArray;
            }   
        }
        
        /*
         * removes new lines and other not allowed words in contact forms (preventing spam)
         * @param string $value - string to check
         */
        public function spamScrubber($value = '') {
            $notAllowed = array('to:', 'cc:', 'bcc:', 'content-type:', 'mime-version:', 'multipart-mixed:', 'content-transfer-encoding:');
            foreach ($notAllowed as $x) {
                if (stripos($value, $x) != false) {
                    return '';
                }
            }
            $value = str_replace(array("\r", "\n", "%0a", "%0d"), ' ', $value);
            return trim($value);
        }
        
        /******************************************************************************************************************************************************
         ******************************************************* encryption and decryption methods ************************************************************
         ******************************************************************************************************************************************************/
        
        /*
         * encrypts data using cbc mcrypt mode with initialization vector
         * @param string $salt - salt for encryption
         * @param string $data - data which needs to be encrypted
         */
        public function encryptData($data) {
            $cipherType = MCRYPT_RIJNDAEL_256;
            $cipherMode = MCRYPT_MODE_CBC;
            $ivSize = mcrypt_get_iv_size($cipherType, $cipherMode);
            $iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);
            $encryptedData = rtrim(mcrypt_encrypt($cipherType, $this->_salt, $data, $cipherMode, $iv));
            // return initialization vector + encrypted string - iv needed for decryption 
            return base64_encode($iv . $encryptedData);
        }
        
        /*
         * decrypts encrypted data - configuration must match encryption 
         * extracts initialization vector which comes before encrypted string and has fixed size
         * @param string $data - it's actually iv with string from encrypt method
         */
        public function decryptData($data) {
            $dataDecoded = base64_decode($data);
            $cipherType = MCRYPT_RIJNDAEL_256;
            $cipherMode = MCRYPT_MODE_CBC;
            $ivSize = mcrypt_get_iv_size($cipherType, $cipherMode);
            $iv = substr($dataDecoded, 0, $ivSize);
            $encryptedData = substr($dataDecoded, $ivSize);
            $decryptedData = rtrim(mcrypt_decrypt($cipherType, $this->_salt, $encryptedData, $cipherMode, $iv));
            return $decryptedData;
        }
        
        /*
         * creates captcha image for forms
         */
        public function createCaptcha() {
            // $text = rand(10000,99999);
            $a = rand(1,10);
            $b = rand(1,10);
            $text = $a . ' + ' . $b . ' =';
            $this->_captcha = $a + $b;
            $this->_registry->getObject('session')->put('vercode', $this->_captcha);
            return $text;
        }
    }