<?php
    require_once('protected/admin/models/A_Model.php');
    
    class A_Products extends A_Model {
        
        /*
         * array of IDs of entried authors
         */
        private $_authorId = array();
        
        /*
         * array of IDs of entried categories
         */
        private $_categoryId = array();
        
        /*
         * inserted book ID reference
         */
        private $_bookId;
        
        /*
         * boolean flag to indicate if book_authors table is successfully updated
         */
        private $_junctionAuthors = false;
        
        /*
         * boolean flag to indicate if book_category table is successfully updated 
         */
        private $_junctionCategories = false;
        
        /*
         * gets all products for admin panel
         * @return array
         */
        public function getAllProducts() {
            $queryStr = "SELECT b.book_id, b.title, DATE_FORMAT(b.date_published, '%M %e, %Y') AS datePublished, "
                    . "b.price, b.stock, p.name AS publisherName, f.format, "
                    . "GROUP_CONCAT(DISTINCT a.first_name, ' ', a.last_name SEPARATOR ', ') AS authorName FROM books b "
                    . "JOIN publisher p ON b.publisher_id = p.publisher_id "
                    . "JOIN book_authors ba ON b.book_id = ba.book_id "
                    . "JOIN authors a ON a.author_id = ba.author_id "
                    . "JOIN formats f ON b.format_id = f.format_id GROUP BY ba.book_id";
            return $this->_registry->getObject('db')->makeMultiDataArray($queryStr, 'book_id');
        }
        
        /*
         * gets choosen product info
         * @param int $productId
         * @return array
         */
        public function getProductInfo($productId) {
            $queryStr = "SELECT b.book_id, b.title, DATE_FORMAT(b.date_published, '%M %e, %Y') AS datePublished, b.isbn, b.isbn13, b.asin, b.price, "
                    . "b.stock, b.description, b.image, b.edition, b.series, DATE_FORMAT(b.date_created, '%M %e, %Y') AS dateCreated, "
                    . "p.publisher_id, p.name AS publisherName, GROUP_CONCAT(DISTINCT a.first_name, ' ', a.last_name SEPARATOR ', ') AS authorName, "
                    . "GROUP_CONCAT(DISTINCT c.category SEPARATOR ', ') AS categories, f.format_id, f.format FROM books b "
                    . "JOIN book_authors ba ON b.book_id = ba.book_id "
                    . "JOIN authors a ON ba.author_id = a.author_id "
                    . "JOIN book_category bc ON b.book_id = bc.book_id "
                    . "JOIN categories c ON bc.cat_id = c.cat_id "
                    . "JOIN formats f ON b.format_id = f.format_id "
                    . "JOIN publisher p ON b.publisher_id = p.publisher_id "
                    . "WHERE b.book_id = ? GROUP BY ba.book_id";
            return $this->_registry->getObject('db')->makeAssocArray($queryStr, [$productId]);
        }
        
        /******************************************************************************************************************************************************
         ************************************************************** insert new product methods ************************************************************
         ******************************************************************************************************************************************************/
        
        /*
         * - checks if user entered authors in new product form exists in the database
         * - sets authorId array populated with ids of entered authors in the form
         * @param string $authorsString - string of names of the authors
         */
        private function checkAuthors($authorsString) {
            $authors = explode(',', $authorsString);
            $queryStr = "SELECT author_id, CONCAT(first_name, ' ', last_name) AS authorName FROM authors";
            $authorsFromDatabase = $this->_registry->getObject('db')->makeDataArray($queryStr, 'author_id', 'authorName');
            $this->_authorId = array_intersect($authorsFromDatabase, $authors);
            if (empty($this->_authorId) || count($authors) != count($this->_authorId)) {
                $this->_errors['author'] = 'Author does not exists';
            }
        }
        
        /*
         * - checks if user entered categories in new product form exists in the database
         * - sets categoryId array populated with ids of entered categories in the form
         * @param string $categoriesString - string of names of categories
         */
        private function checkCategories($categoriesString) {
            $categories = explode(',', $categoriesString);
            $queryStr = "SELECT cat_id, category FROM categories";
            $categoriesFromDatabase = $this->_registry->getObject('db')->makeDataArray($queryStr, 'cat_id', 'category');
            $this->_categoryId = array_intersect($categoriesFromDatabase, $categories);
            if (empty($this->_categoryId) || count($categories) != count($this->_categoryId)) {
                $this->_errors['category'] = 'Category does not exists';
            }
        }
        
        /*
         * selects all publishers 
         */
        public function selectPublisher() {
            $queryStr = "SELECT publisher_id, name FROM publisher";
            return $this->_registry->getObject('db')->makeDataArray($queryStr, 'publisher_id', 'name');
        }
        
        /*
         * selects all formats
         */
        public function selectFormat() {
            $queryStr = "SELECT format_id, format FROM formats";
            return $this->_registry->getObject('db')->makeDataArray($queryStr, 'format_id', 'format');
        }
        
        /*
         * - validates and sanitizes form fields for inserting new products
         * - there are some fields which are not required and also needs to be passed 
         *   to Validator class if filled in 
         * - final array for validation process is maded with merging two arrays: 
         *   1. required fields array
         *   2. submitted values from $_POST request
         */
        private function checkNewProductFields() {
            $required = array('title' => 'title', 'author' => 'author', 'category' => 'category', 'publisher' => 'publisher', 'format_id' => 'format_id', 
                              'datePublished' => 'datePublished', 'price' => 'price', 'stock' => 'stock', 'edition' => 'edition');
            $submittedFields = $this->_registry->getObject('template')->createRequiredArray(['token', 'image', 'create']);
            $requiredFinal = array_merge($required, $submittedFields);
            $this->_val->setRequired($requiredFinal);
            $this->_val->matches('title', '/^[A-Za-z0-9\s\-_,\'\.;:&()]+$/');
            $this->_val->matches('author', '/^[A-Za-z\s\'.,-]{2,80}$/i');
            $this->_val->matches('category', '/^[a-zA-Z0-9\s,]+$/');
            $this->_val->isInt('publisher');
            $this->_val->isInt('format_id');
            $this->_val->matches('datePublished', '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/');
            $this->_val->isFloat('price');
            $this->_val->isInt('stock');
            $this->_val->isInt('edition');
            if (in_array('isbn', $requiredFinal)) { $this->_val->matches('isbn', '/^\d{9}(?:\d|X)$/'); }
            if (in_array('isbn13', $requiredFinal)) { $this->_val->matches('isbn13', '/^\d{12}(?:\d|X)$/'); }
            if (in_array('asin', $requiredFinal)) { $this->_val->matches('asin', '/B[0-9]{2}[0-9A-Z]{7}|[0-9]{9}(X|0-9])/'); }
            if (in_array('series', $requiredFinal)) { $this->_val->matches('series', '/^[A-Za-z0-9\s\-_,\.()#]+$/'); }
            if (in_array('description', $requiredFinal)) { $this->_val->matches('description', "/^[a-zA-Z0-9?$@#\(\)\'\"!,+\-=_:;.&%\s]+$/"); }
            $this->checkValidation();
        }
        
        /*
         * - inserts new products, checks if authors and categories entered exists
         * - checks uploaded product image, populates products table and three intermediate tables
         * @return string - confirmation about success or failure
         */
        public function insertNewProduct() {
            $this->checkNewProductFields();
            $this->checkAuthors($this->_submittedValues['author']);
            $this->checkCategories($this->_submittedValues['category']);
            $this->checkUploadedFile(1048576, "protected\uploads\product-images\\", ['jpg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif']);
            if (empty($this->_errors) && empty($this->_missingValues)) {
                $book = array('title' => $this->_sanitizedValues['title'],
                              'publisher_id' => $this->_sanitizedValues['publisher'],
                              'date_published' => $this->_sanitizedValues['datePublished'],
                              'format_id' => $this->_sanitizedValues['format_id'],
                              'isbn' => (isset($this->_sanitizedValues['isbn']) ? $this->_sanitizedValues['isbn'] : null), 
                              'isbn13' => (isset($this->_sanitizedValues['isbn13']) ? $this->_sanitizedValues['isbn13'] : null),
                              'asin' => (isset($this->_sanitizedValues['asin']) ? $this->_sanitizedValues['asin'] : null),
                              'price' => $this->_sanitizedValues['price'],
                              'stock' => $this->_sanitizedValues['stock'],
                              'description' => (isset($this->_sanitizedValues['description']) ? $this->_sanitizedValues['description'] : null),
                              'image' => $this->_file,
                              'edition' => $this->_sanitizedValues['edition'],
                              'series' => (isset($this->_sanitizedValues['series']) ? $this->_sanitizedValues['series'] : null));
                if ($this->_registry->getObject('db')->insert('books', $book)) {
                    $this->_bookId = $this->_registry->getObject('db')->lastInsertId();
                    return (($this->insertBookAuthors() === false)
                            || ($this->insertBookCategories() === false)) ? 'junction-failure' : 'success';
                } else {
                    return 'failure';
                }
            }
        }
        
        /*
         * inserts book id and author id into intermediate table
         * @return bool
         */
        public function insertBookAuthors() {
            $queryStr = "INSERT INTO book_authors (author_id, book_id) VALUES ";
            $it = new ArrayIterator($this->_authorId);
            $cit = new CachingIterator($it);
            foreach ($cit as $key => $value) {
                $queryStr .= "(" . $key . "," . $this->_bookId . ")";
                if ($cit->hasNext()) {
                    $queryStr .= ",";
                }
            }
            $this->_registry->getObject('db')->execute($queryStr);
            return ($this->_registry->getObject('db')->affectedRows() == count($this->_authorId)) ? true : false ;
        }
        
        /*
         * inserts book id and category id into intermediate table
         * @return bool
         */
        public function insertBookCategories() {
            $queryStr = "INSERT INTO book_category (book_id, cat_id) VALUES ";
            $it = new ArrayIterator($this->_categoryId);
            $cit = new CachingIterator($it);
            foreach ($cit as $key => $value) {
                $queryStr .= "(" . $this->_bookId . "," . $key . ")";
                if ($cit->hasNext()) {
                    $queryStr .= ",";
                }
            }
            $this->_registry->getObject('db')->execute($queryStr);
            return ($this->_registry->getObject('db')->affectedRows() == count($this->_categoryId)) ? true : false;
        }
        
        /******************************************************************************************************************************************************
         ************************************************************* update product methods ***************************************************************** 
         ******************************************************************************************************************************************************/
        
        /*
         * - checks settings form fields, change is optional so in required array are only values submitted in POST request
         * - POST value of 'token' and 'update' (submit input) should not be included in validation process
         */
        private function checkUpdateProductFields() {
            $this->setRequiredFields(['token', 'updateProduct']);
            if (in_array('title', $this->_required)) { $this->_val->matches('title', '/^[A-Za-z0-9\s\-_,\'\.;:()]+$/'); }
            if (in_array('author', $this->_required)) { $this->_val->matches('author', '/^[A-Za-z\s\'.,-]{2,80}$/i'); }
            if (in_array('category', $this->_required)) { $this->_val->matches('category', '/^[a-zA-Z0-9\s,]+$/'); }
            if (in_array('publisher_id', $this->_required)) { $this->_val->isInt('publisher_id'); }
            if (in_array('format_id', $this->_required)) { $this->_val->isInt('format_id'); }
            if (in_array('datePublished', $this->_required)) { $this->_val->matches('datePublished', '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/'); }
            if (in_array('price', $this->_required)) { $this->_val->isFloat('price'); }
            if (in_array('stock', $this->_required)) { $this->_val->isInt('stock'); }
            if (in_array('edition', $this->_required)) { $this->_val->isInt('edition'); }
            if (in_array('isbn', $this->_required)) { $this->_val->matches('isbn', '/^\d{9}(?:\d|X)$/'); }
            if (in_array('isbn13', $this->_required)) { $this->_val->matches('isbn13', '/^\d{12}(?:\d|X)$/'); }
            if (in_array('asin', $this->_required)) { $this->_val->matches('asin', '/B[0-9]{2}[0-9A-Z]{7}|[0-9]{9}(X|0-9])/'); }
            if (in_array('series', $this->_required)) { $this->_val->matches('series', '/^[A-Za-z0-9\s\-_,\.()#]+$/'); }
            if (in_array('description', $this->_required)) { $this->_val->matches('description', "/^[a-zA-Z0-9?$@#\(\)\'\"!,+\-=_:;.&%\s]+$/"); }
            $this->checkValidationOnUpdate();
        }
        
        /*
         * deletes old rows in book_authors table and updates it with the new ones
         */
        private function updateBookAuthors() {
            $this->_registry->getObject('db')->delete('book_authors', $this->_bookId, 'book_id');
            $this->insertBookAuthors();
        }
        
        /*
         * deletes old rows in book_category table and updates it with th new ones 
         */
        private function updateBookCategories() {
            $this->_registry->getObject('db')->delete('book_category', $this->_bookId, 'book_id');
            $this->insertBookCategories();
        }
        
        /*
         * - updates changes to product tables if any
         * - if author or category is entered checks if they exists in the database, checks if appropriate array 
         *   (with authors ids or categories ids) is populated, and sets boolean flag which indicates that the 
         *   update of either book_authors or book_category table was successful
         * - if file is set and succesfully validated, the old file from upload folder is 
         *   deleted and replaced with the new one 
         * @param int $productId 
         * @return string - confirmation about success or failure
         */
        public function updateProduct($productId) {
            $bookInfo = $this->getProductInfo($productId);
            $this->_bookId = $productId;
            $this->checkUpdateProductFields();
            if (!empty($this->_submittedValues['author'])) {
                $this->checkAuthors($this->_submittedValues['author']);
            }
            if (!empty($this->_submittedValues['category'])) {
                $this->checkCategories($this->_submittedValues['category']);
            }
            if (isset($_FILES)) {
                $this->checkUploadedFile(1048576, "protected\uploads\product-images\\", ['jpg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif'], false);
            }
            if (empty($this->_errors)) {
                if (!empty($this->_authorId)) {
                    unset($this->_sanitizedValues['author']);
                    $this->_junctionAuthors = ($this->updateBookAuthors() === true) ? true : false;
                }    
                if (!empty($this->_categoryId)) {
                    unset($this->_sanitizedValues['category']);
                    $this->_junctionCategories = ($this->updateBookCategories() === true) ? true : false;
                }
                if (isset($this->_file)) {
                    $this->_sanitizedValues['image'] = $this->_file;
                    $this->_registry->getModel('upload')->destroyFile("protected\uploads\product-images\\", $bookInfo['image']);
                }
                return ($this->_registry->getObject('db')->update('books', $this->_sanitizedValues, $productId, 'book_id') 
                        || $this->_junctionAuthors === true || $this->_junctionCategories === true) ? 'success' : 'failure';
            } else {
                return 'failure';
            }
        }
    }