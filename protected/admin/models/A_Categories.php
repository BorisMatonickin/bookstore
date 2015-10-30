<?php
    require_once('protected/admin/models/A_Model.php');
    
    class A_Categories extends A_Model {
 
        /*
         * gets all product categories
         * @return array
         */
        public function getAllCategories() {
            return $this->_registry->getModel('categories')->listCategories();
        }
        
        /*
         * gets choosen category info
         * @param int $catId - id of the category
         * @return array
         */
        public function getCategoryInfo($catId) {
            $queryStr = "SELECT c.cat_id, c.category, c.description, COUNT(bc.book_id) AS booksNumber FROM categories c "
                    . "LEFT OUTER JOIN book_category bc ON c.cat_id = bc.cat_id WHERE c.cat_id = ? GROUP BY c.category";
            return $this->_registry->getObject('db')->makeAssocArray($queryStr, [$catId]);
        } 
        
        /*
         * gets all books within selected category
         * @param int $catId
         */
        public function getCategoryBooks($catId) {
            $queryStr = "SELECT b.book_id, b.title AS bookTitle, b.image, DATE_FORMAT(b.date_published, '%M %e, %Y') AS datePublished, "
                    . "(SELECT IFNULL(ROUND(sum(rating)/count(*), 2), 0) FROM book_ratings br WHERE br.book_id = b.book_id) AS averageRating, "
                    . "GROUP_CONCAT(DISTINCT a.first_name, ' ', a.last_name SEPARATOR ', ') AS authorName, "
                    . "a.author_id, c.category, p.name AS publisherName FROM books b "
                    . "JOIN book_category bc ON b.book_id = bc.book_id "
                    . "JOIN categories c ON bc.cat_id = c.cat_id "
                    . "JOIN book_authors ba ON b.book_id = ba.book_id "
                    . "JOIN authors a ON a.author_id = ba.author_id "
                    . "JOIN publisher p ON b.publisher_id = p.publisher_id "
                    . "WHERE c.cat_id = ? GROUP BY ba.book_id ORDER BY b.date_published DESC";
            return $this->_registry->getObject('db')->makeMultiDataArray($queryStr, 'book_id', [$catId]);
        }
        
        /*
         * validates and sanitizes the form field data for creating new category
         */
        private function checkNewCategoryFields() {
            $required = array('category' => 'category', 'description' => 'description');
            $this->_val->setRequired($required);
            $this->_val->matches('category', '/^[A-Za-z0-9\s\-_\']+$/');
            $this->_val->matches('description', "/^[a-zA-Z0-9?$@#\(\)\'\"!,+\-=_:;\.&%\s]+$/");
            $this->checkValidation();
        }
        
        /*
         * checks if entered category already exists
         */
        private function checkDoubleCategory($category) {
            $this->_registry->getObject('db')->selectOne('categories', $category, 'category');
            if ($this->_registry->getObject('db')->affectedRows() > 0) {
                $this->_errors['category'] = 'Category already exists';
            }
        }
        
        /*
         * inserts new category
         * @return string - confirmation about success or failure
         */
        public function insertNewCategory() {
            $this->checkNewCategoryFields();
            $this->checkDoubleCategory($this->_submittedValues['category']);
            if (empty($this->_errors) && empty($this->_missingValues)) {
                $category = array('category' => $this->_sanitizedValues['category'],
                                  'description' => $this->_sanitizedValues['description']);
                return ($this->_registry->getObject('db')->insert('categories', $category)) ? 'success' : 'failure';
            }
        }
        
        /*
         * - checks update category form fields, change is optional so in required array are only values submitted in POST request
         * - POST value of 'token' and 'update' (submit input) should not be included in validation process
         */
        private function checkUpdateCategoryFields() {
            $this->setRequiredFields(['token', 'updateCategory']);
            if (in_array('category', $this->_required)) { $this->_val->matches('category', '/^[A-Za-z0-9\s\-_\']+$/'); }
            if (in_array('description', $this->_required)) { $this->_val->matches('description', "/^[a-zA-Z0-9?$@#\(\)\'\"!,+\-=_:;\.&%\s]+$/"); }
            $this->checkValidationOnUpdate();
        }
        
        /*
         * updates changes into categories table if any
         * @param int $categoryId
         * @return string - confirmation about success or failure
         */
        public function updateCategory($categoryId) {
            $this->checkUpdateCategoryFields();
            if (empty($this->_errors)) {
                return ($this->_registry->getObject('db')->update('categories', $this->_sanitizedValues, $categoryId, 'cat_id')) ? 'success' : 'failure';
            } else {
                return 'failure';
            }
        }
    }
