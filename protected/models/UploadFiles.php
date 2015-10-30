<?php
    class UploadFiles {
        /*
         * name of the file
         */
        private $_fileName;
        
        /*
         * destination of final upload
         */
        private $_uploadDir;
        
        /*
         * maximum allowed file size
         */
        private $_maxFileSize;
        
        /*
         * allowed MIME file types
         */
        private $_allowedFileTypes = array();
        
        /*
         * file extension
         */
        private $_extension;
        
        /*
         * upload errors
         */
        private $_error;
        private $_uploadErrors = array(
            UPLOAD_ERR_OK => 'No errors',
            UPLOAD_ERR_INI_SIZE => 'Larger than upload_max_file_size',
            UPLOAD_ERR_FORM_SIZE => 'Larger than form MAX_FILE_SIZE',
            UPLOAD_ERR_PARTIAL => 'Partial upload',
            UPLOAD_ERR_NO_FILE => 'No file',
            UPLOAD_ERR_NO_TMP_DIR => 'No temporary directory',
            UPLOAD_ERR_CANT_WRITE => 'Cant write to disk',
            UPLOAD_ERR_EXTENSION => 'File upload stopped by extension'
        );
        
        public function __construct() {}
        
        /*
         * - checks and validate uploaded file
         * - if all conditions are satisfied moves uploaded file to choosen upload directory
         * @param array $file - file array from $_FILES array from form
         * @return bool
         */
        public function attachFile($file = array()) {
            // throws error if file doesn't exists, is empty and is not array
            if (!$file || empty($file) || !is_array($file)) {
                $this->_error = 'No file was uploaded';
                return false;
            // throws error if error index in $file array is not set or is subarray    
            } elseif (!isset($file['error']) || is_array($file['error'])) {
                $this->_error = 'Invalid parameters';
            // throws appropriate error if error index in $file array is other than 0   
            } elseif ($file['error'] != 0) {
                $this->_error = $this->_uploadErrors[$file['error']];
                return false;
            // throws error if type of file is not as it is set it should be    
            } elseif ($this->validateMIMEType($file['tmp_name']) === false) {
                $this->_error = 'Invalid file format';
                return false;
            // throws error if file size is larger then one that's set    
            } elseif ($this->validateFileSize($file['size']) === false) {
                $this->_error = 'Invalid file size';
            } else {
                $this->_fileName = $this->nameFile($file['tmp_name']);
                if (!move_uploaded_file($file['tmp_name'], $this->_uploadDir . $this->_fileName)) {
                    $this->_error = 'The file upload failed';
                    return false;
                } else {
                    return true;
                }
            }    
        }
 
        /*
         * validates file MIME type
         * @param string $file
         * @return bool
         */
        private function validateMIMEType($file) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $this->_extension = array_search($finfo->file($file), $this->_allowedFileTypes, true);
            return ($this->_extension === false) ? false : true;
        }
        
        /*
         * validates file size
         * @param int $fileSize
         * @return bool
         */
        private function validateFileSize($fileSize) {
            if (!filter_var($fileSize, FILTER_VALIDATE_INT)) {
                return false;
            } else {
                return ($fileSize > $this->_maxFileSize) ? false : true;
            }
        }
        
        /*
         * sets the final name of the file
         * @param string $file
         * @return string
         */
        private function nameFile($file) {
            return sprintf('%s.%s', sha1_file($file), $this->_extension);
        }
        
        /*
         * destroys file when no longer needed
         */
        public function destroyFile($dir, $file) {
            $targetPath = $dir . $file;
            if (file_exists($targetPath)) {
                return unlink($targetPath) ? true : false;
            } else {
                return false;
            }
        }
        
        /*
         * sets the maximum file size
         * @param string $maxFileSize
         */
        public function setMaxFileSize($maxFileSize) {
            $this->_maxFileSize = $maxFileSize;
        }
        
        /*
         * sets allowed MIME types
         * @param array $allowedFileTypes
         */
        public function setAllowedFileTypes($allowedFileTypes = array()) {
            $this->_allowedFileTypes = $allowedFileTypes;
        }
        
        /*
         * sets upload directory
         * @param string $uploadDir
         */
        public function setUploadDir($uploadDir) {
            $this->_uploadDir = $uploadDir;
        }
        
        /*
         * getter methods
         */
        public function getErrors() {
            return $this->_error;
        }
        
        public function getFileName() {
            return $this->_fileName;
        }
    }