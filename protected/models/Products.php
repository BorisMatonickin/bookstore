<?php
    require_once('Model.php');
    
    class Products extends Model {

        /*
         * gets products from database to display on index page
         * @return array
         */
        public function selectProductsForIndex() {
            $queryStr = "SELECT b.book_id, b.title, b.price, b.image, "
                    . "(SELECT IFNULL(ROUND(sum(rating)/count(*), 2), 0) FROM book_ratings br WHERE br.book_id = b.book_id) AS averageRating, "
                    . "GROUP_CONCAT(DISTINCT a.first_name, ' ', a.last_name SEPARATOR ', ') AS authorName FROM books b "
                    . "JOIN book_authors ba ON b.book_id = ba.book_id "
                    . "JOIN authors a ON a.author_id = ba.author_id "
                    . "GROUP BY ba.book_id ORDER BY RAND() LIMIT 8 OFFSET 0";
            return $this->_registry->getObject('db')->makeMultiDataArray($queryStr, 'book_id');
        }
        
        /*
         * gets the most popular products by rating
         * @return array
         */
        public function selectMostPopularProducts() {
            $queryStr = "SELECT b.book_id, b.title, b.price, b.image, "
                    . "(SELECT IFNULL(ROUND(sum(rating)/count(*), 2), 0) FROM book_ratings br WHERE br.book_id = b.book_id) AS averageRating, "
                    . "GROUP_CONCAT(DISTINCT a.first_name, ' ', a.last_name SEPARATOR ', ') AS authorName FROM books b "
                    . "JOIN book_authors ba ON b.book_id = ba.book_id "
                    . "JOIN authors a ON a.author_id = ba.author_id "
                    . "GROUP BY ba.book_id ORDER BY averageRating DESC LIMIT 8";
            return $this->_registry->getObject('db')->makeMultiDataArray($queryStr, 'book_id');
        } 
        
        /*
         * gets product info to display on main product page
         * @param int $bookId
         * @return array
         */
        public function productInfo($bookId) {
            $queryStr = "SELECT b.book_id, b.title as bookTitle, DATE_FORMAT(b.date_published, '%M %e, %Y') "
                    . "AS datePublished, b.isbn, b.isbn13, b.asin, b.price, b.stock, b.description, "
                    . "b.image, b.edition, b.series, p.name AS publisherName, f.format, "
                    . "(SELECT IFNULL(ROUND(sum(rating)/count(*), 2), 0) FROM book_ratings br WHERE br.book_id = b.book_id) AS averageRating, "
                    . "(SELECT COUNT(user_id) FROM book_ratings br WHERE br.book_id = b.book_id) AS usersRated, "
                    . "GROUP_CONCAT(DISTINCT a.author_id SEPARATOR ', ') AS authorId, "
                    . "GROUP_CONCAT(DISTINCT a.first_name, ' ', a.last_name SEPARATOR ', ') as authorName, "
                    . "GROUP_CONCAT(DISTINCT c.cat_id SEPARATOR ', ') AS categoryId, "
                    . "GROUP_CONCAT(DISTINCT c.category SEPARATOR ', ') AS categories FROM books b "
                    . "JOIN publisher p ON b.publisher_id = p.publisher_id "
                    . "JOIN book_authors ba ON b.book_id = ba.book_id "
                    . "JOIN authors a ON a.author_id = ba.author_id "
                    . "JOIN formats f ON b.format_id = f.format_id "
                    . "JOIN book_category bc ON b.book_id = bc.book_id "
                    . "JOIN categories c ON c.cat_id = bc.cat_id "
                    . "WHERE b.book_id = ? GROUP BY ba.book_id";
            return $this->_registry->getObject('db')->makeMultiDataArray($queryStr, 'book_id', [$bookId]);
        }
        
        /*
         * gets products similar to product currently beeing viewed
         * @param int $bookId
         * @return array
         */
        public function getSimilarProducts($category, $bookId) {
            $queryStr = "SELECT b.book_id, b.title, b.image, c.category, GROUP_CONCAT(DISTINCT a.first_name, ' ', a.last_name SEPARATOR ', ') AS authorName "
                    . "FROM books b "
                    . "JOIN book_category bc ON b.book_id = bc.book_id "
                    . "JOIN categories c ON c.cat_id = bc.cat_id "
                    . "JOIN book_authors ba ON b.book_id = ba.book_id "
                    . "JOIN authors a ON a.author_id = ba.author_id "
                    . "WHERE c.category = ? AND b.book_id != ? GROUP BY ba.book_id ORDER BY RAND() DESC LIMIT 3";
            return $this->_registry->getObject('db')->makeMultiDataArray($queryStr, 'book_id', [$category, $bookId]);
        }
        
        /*
         * gets list of all products with appropriate info to display on page which lists products
         * @return array
         */
        public function selectAllProducts() {
            $queryStr = "SELECT b.book_id AS bookId, b.title AS bookTitle, b.image, DATE_FORMAT(b.date_published, '%M %e, %Y') AS datePublished, "
                    . "(SELECT IFNULL(ROUND(sum(rating)/count(*), 2), 0) FROM book_ratings br WHERE br.book_id = b.book_id) AS averageRating, "
                    . "(SELECT count(user_id) FROM book_ratings br WHERE br.book_id = b.book_id) AS usersRated, a.author_id AS authorId, "
                    . "p.name AS publisherName, GROUP_CONCAT(DISTINCT a.first_name, ' ', a.last_name SEPARATOR ', ') as authorName, "
                    . "GROUP_CONCAT(a.author_id SEPARATOR ', ') AS authorId FROM books b "
                    . "JOIN book_authors ba ON b.book_id = ba.book_id "
                    . "JOIN authors a ON a.author_id = ba.author_id "
                    . "JOIN publisher p ON p.publisher_id = b.publisher_id "
                    . "GROUP BY ba.book_id ORDER BY b.date_published DESC";
            return $this->_registry->getObject('db')->makeMultiDataArray($queryStr, 'bookTitle');
        }
        
        /*
         * gets 4 new released products for slider on main index page
         */
        public function selectNewReleases() {
            $queryStr = "SELECT b.book_id AS bookId, b.title AS bookTitle, b.image, "
                    . "GROUP_CONCAT(DISTINCT a.first_name, ' ', a.last_name SEPARATOR ', ') AS authorName "
                    . "FROM books b "
                    . "JOIN book_authors ba ON b.book_id = ba.book_id "
                    . "JOIN authors a ON a.author_id = ba.author_id "
                    . "GROUP BY ba.book_id ORDER BY b.date_published DESC LIMIT 4";
            return $this->_registry->getObject('db')->makeMultiDataArray($queryStr, 'bookId');        
        }
        
        /*
         * gets product data for usage in creating URL bits
         * @return array
         */
        public function selectProductsForUrl() {
            $queryStr = "SELECT book_id, title FROM books";
            return $this->_registry->getObject('db')->makeMultiDataArray($queryStr, 'book_id');
        }
    }