<?php
    require_once('protected/admin/models/A_Model.php');
    
    class A_Authors extends A_Model {
        
        /*
         * category id
         */
        private $_catId;
        
        /*
         * gets all authors with selected info
         * @return array
         */
        public function getAllAuthors() {
            $queryStr = "SELECT a.author_id, a.first_name, a.last_name, CONCAT(a.place_of_birth, ', ', a.country) AS bornIn, "
                    . "a.gender, c.category FROM authors a "
                    . "JOIN categories c ON a.cat_id = c.cat_id ORDER BY a.author_id ASC";
            return $this->_registry->getObject('db')->makeMultiDataArray($queryStr, 'author_id');
        }
        
        /*
         * gets author info
         * @param int $authorId
         * @return array
         */
        public function getAuthorInfo($authorId) {
            $queryStr = "SELECT a.author_id, a.first_name, a.last_name, a.gender, a.address, a.place_of_birth, c.country_abbrev, c.country_name, a.zip, a.phone, "
                    . "a.email, a.website, a.about, cat.category, a.image FROM authors a "
                    . "JOIN countries c ON a.country = c.country_abbrev "
                    . "JOIN categories cat ON a.cat_id = cat.cat_id "
                    . "WHERE a.author_id = ?";
            return $this->_registry->getObject('db')->makeAssocArray($queryStr, [$authorId]);
        }
        
        /*
         * - validates and sanitize form fields for inserting new author
         * - there are some fields which are not required and also needs to be passed 
         *   to Validator class if filled in 
         * - final array for validation process is maded with merging two arrays: 
         *   1. required fields array
         *   2. submitted values from $_POST request
         */
        public function checkNewAuthorFields() {
            $required = array('firstName' => 'firstName', 'lastName' => 'lastName', 'gender' => 'gender', 'birthPlace' => 'birthPlace', 
                              'country' => 'country', 'category' => 'category');
            $submittedFields = $this->_registry->getObject('template')->createRequiredArray(['token', 'image', 'createAuthor']);
            $finalRequired = array_merge($required, $submittedFields);
            $this->_val->setRequired($finalRequired);
            $this->_val->matches('firstName', '/^[A-Za-z\'\.\-]{2,20}$/i');
            $this->_val->matches('lastName', '/^[A-Za-z\'\.\-]{2,40}$/i');
            $this->_val->removeTags('gender');
            $this->_val->matches('birthPlace', '/^[A-Za-z\'\s\.\-]{2,60}$/i');
            $this->_val->removeTags('country');
            $this->_val->matches('category', '/^[a-zA-Z0-9\s,]+$/');
            if (in_array('address', $finalRequired)) { $this->_val->matches('address', '/^[A-Za-z0-9\',\.#\-\s]{2,80}$/i'); }
            if (in_array('zipCode', $finalRequired)) { $this->_val->matches('zipCode', '/^(\d{5}$)|(^\d{5}\-\d{4})$/'); }
            if (in_array('phone', $finalRequired)) { $this->_val->matches('phone', '/\(?\d{1,3}\)?\-\d{3,3}\-\d{4,4}/'); }
            if (in_array('email', $finalRequired)) { $this->_val->isEmail('email'); }
            if (in_array('website', $finalRequired)) { $this->_val->isUrl('website'); }
            if (in_array('about', $finalRequired)) { $this->_val->matches('about', "/^[a-zA-Z0-9?$@#\(\)\'\"!,+\-=_:;\.&%\s]+$/"); }
            $this->_sanitizedValues = array_map('trim', $this->_val->validateInput());
            $this->_missingValues = $this->_val->getMissing();
            $this->_errors = $this->_val->getErrors();
            $this->_submittedValues = array_map('trim', $this->_val->getSubmitted());
        }
        
        /*
         * checks if category entered in the form exists in database
         * @param string $category
         */
        private function checkCategory($category) {
            $row = $this->_registry->getObject('db')->selectOne('categories', $category, 'category');
            if ($this->_registry->getObject('db')->affectedRows() > 0) {    
                $this->_catId = $row['cat_id'];
            } else {
                $this->_errors['category'] = 'Category does not exists';
            }
        }
        
        /*
         * inserts new author, checks if entered category exists and if uploaded file is valid image
         * @return string - confirmation about success or failure
         */
        public function insertNewAuthor() {
            $this->checkNewAuthorFields();
            $this->checkCategory($this->_submittedValues['category']);
            $uploadDir = "protected\uploads\author-images\\";
            $allowedTypes = array('jpg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif');
            $this->checkUploadedFile(1048576, $uploadDir, $allowedTypes);
            if (empty($this->_errors) && empty($this->_missingValues)) {
                $author = array('first_name' => $this->_sanitizedValues['firstName'],
                                'last_name' => $this->_sanitizedValues['lastName'],
                                'gender' => $this->_sanitizedValues['gender'],
                                'address' => (isset($this->_sanitizedValues['address'])) ? $this->_sanitizedValues['address'] : null,
                                'place_of_birth' => $this->_sanitizedValues['birthPlace'],
                                'country' => $this->_sanitizedValues['country'],
                                'zip' => (isset($this->_sanitizedValues['zipCode'])) ? $this->_sanitizedValues['zipCode'] : null,
                                'phone' => (isset($this->_sanitizedValues['phone'])) ? $this->_sanitizedValues['phone'] : null,
                                'email' => (isset($this->_sanitizedValues['email'])) ? $this->_sanitizedValues['email'] : null,
                                'website' => (isset($this->_sanitizedValues['website'])) ? $this->_sanitizedValues['website'] : null,
                                'about' => (isset($this->_sanitizedValues['about'])) ? $this->_sanitizedValues['about'] : null,
                                'cat_id' => $this->_catId,
                                'image' => $this->_file);
                return ($this->_registry->getObject('db')->insert('authors', $author)) ? 'success' : 'failure';
            }
        }
        
        /*
         * - validate and sanitize update author form fields
         * - all fields are optional, and should be entered only if change is needed
         */
        private function checkUpdateAuthorFields() {
            $this->setRequiredFields(['token', 'image', 'updateAuthor']);
            if (in_array('first_name', $this->_required)) { $this->_val->matches('first_name', '/^[A-Za-z\'\.\-]{2,20}$/i'); }
            if (in_array('last_name', $this->_required)) { $this->_val->matches('last_name', '/^[A-Za-z\'\.\-]{2,40}$/i'); }
            if (in_array('gender', $this->_required)) { $this->_val->removeTags('gender'); }
            if (in_array('address', $this->_required)) { $this->_val->matches('address', '/^[A-Za-z0-9\',\.#\-\s]{2,80}$/i'); }
            if (in_array('place_of_birth', $this->_required)) { $this->_val->matches('place_of_birth', '/^[A-Za-z\'\s\.\-]{2,60}$/i'); }
            if (in_array('country', $this->_required)) { $this->_val->removeTags('country'); }
            if (in_array('zip', $this->_required)) { $this->_val->matches('zip', '/^(\d{5}$)|(^\d{5}\-\d{4})$/'); }
            if (in_array('phone', $this->_required)) { $this->_val->matches('phone', '/\(?\d{1,3}\)?\-\d{3,3}\-\d{4,4}/'); }
            if (in_array('email', $this->_required)) { $this->_val->isEmail('email'); }
            if (in_array('website', $this->_required)) { $this->_val->isUrl('website'); }
            if (in_array('category', $this->_required)) { $this->_val->matches('category', '/^[a-zA-Z0-9\s,]+$/'); }
            if (in_array('about', $this->_required)) { $this->_val->matches('about', "/^[a-zA-Z0-9?$@#\(\)\'\"!,+\-=_:;\.&%\s]+$/"); }
            $this->checkValidationOnUpdate();
        }
        
        /*
         * - updates changes in authors table 
         * - if category is entered checks if it exists in database
         * - file is optional, so if it's choosen for upload it must be validated
         * - old file associated with author is then deleted in the uploads folder
         * @param int $authorId
         */
        public function updateAuthor($authorId) {
            $authorInfo = $this->getAuthorInfo($authorId);
            $this->checkUpdateAuthorFields();
            if (isset($this->_submittedValues['category'])) {
                $this->checkCategory($this->_submittedValues['category']);
            }
            if (isset($_FILES)) {
                $this->checkUploadedFile(1048576, "protected\uploads\author-images\\", ['jpg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif'], false);
            }
            if (empty($this->_errors)) {
                if (isset($this->_catId)) {
                    unset($this->_sanitizedValues['category']);
                    $this->_sanitizedValues['cat_id'] = $this->_catId;
                }
                if (isset($this->_file)) {
                    $this->_sanitizedValues['image'] = $this->_file;
                    $this->_registry->getModel('upload')->destroyFile("protected\uploads\author-images\\", $authorInfo['image']);
                }
                return ($this->_registry->getObject('db')->update('authors', $this->_sanitizedValues, $authorId, 'author_id')) ? 'success' : 'failure';
            } else {
                return 'failure';
            }
        }
    }