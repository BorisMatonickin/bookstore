<?php
    require_once('Model.php');
    
    class Authors extends Model {

        /*
         * number of rows in database table (used in pagination)
         */
        private $_countAll;

        /*
         * gets list of authors for display on the sidebar
         * @return array
         */
        public function authorsForSidebar() {
            $queryStr = "SELECT author_id, CONCAT(`first_name`, ' ', `last_name`) AS author FROM `authors` ORDER BY RAND() LIMIT 12";
            return $this->_registry->getObject('db')->makeMultiDataArray($queryStr, 'author_id');
        }
        
        /*
         * gets list of authors with the most popular book and count of all books written by author,
         *   genre and how many time book is reviewed by members of the site
         * @return array
         */
        public function listOfAuthors() {
            $queryStr = "SELECT b.book_id AS bookId, b.title AS bookTitle, a.author_id AS authorId, a.image, c.cat_id, c.category, COUNT(ba.book_id) AS booksNumber, "
                    . "CONCAT(a.first_name, ' ', a.last_name) AS authorName, "
                    . "(SELECT COUNT(r.book_id) FROM reviews r WHERE b.book_id = r.book_id GROUP BY r.book_id) AS totalReviews "
                    . "FROM books b "
                    . "JOIN book_authors ba ON b.book_id = ba.book_id "
                    . "JOIN authors a ON a.author_id = ba.author_id "
                    . "JOIN categories c ON a.cat_id = c.cat_id GROUP BY a.author_id ORDER BY date_published DESC";
            $authors = $this->_registry->getObject('db')->makeMultiDataArray($queryStr, 'authorName');
            $this->_countAll = $this->_registry->getObject('db')->affectedRows();
            return $authors;
        }
        
        /*
         * gets all details for selected author main page
         * @param string $authorName - the name of the selected author
         * @return array
         */
        public function authorInfo($authorName) {
            $queryStr = "SELECT CONCAT(a.first_name, ' ', a.last_name) AS authorName, "
                    . "CONCAT(a.place_of_birth, ', ', co.country_name) AS bornIn, "
                    . "a.gender, a.about, a.image, a.website, c.category FROM authors a "
                    . "JOIN categories c ON a.cat_id = c.cat_id "
                    . "JOIN countries co ON a.country = co.country_abbrev "
                    . "WHERE CONCAT(a.first_name, ' ', a.last_name) = ?";
            return $this->_registry->getObject('db')->makeMultiDataArray($queryStr, 'authorName', [$authorName]);
        }
        
        /*
         * gets all books for selected author
         * @param string $authorName - the name of the selected author
         * @return array
         */
        public function booksOfAuthor($authorName) {
            $queryStr = "SELECT b.book_id AS bookId, b.title, DATE_FORMAT(b.date_published, '%M %e, %Y') AS datePublished, b.image, p.name AS publisherName, "
                    . "(SELECT IFNULL(ROUND(sum(rating)/count(*), 2), 0) FROM book_ratings br WHERE br.book_id = b.book_id) AS averageRating, "
                    . "CONCAT(a.first_name, ' ', a.last_name) AS authorName "
                    . "FROM books b "
                    . "JOIN publisher p ON b.publisher_id = p.publisher_id "
                    . "JOIN book_authors ba ON b.book_id = ba.book_id "
                    . "JOIN authors a ON a.author_id = ba.author_id "
                    . "WHERE CONCAT(a.first_name, ' ', a.last_name) = ? "
                    . "ORDER BY b.date_published DESC";
            $books = $this->_registry->getObject('db')->makeMultiDataArray($queryStr, 'title', [$authorName]);
            $this->_countAll = $this->_registry->getObject('db')->affectedRows();
            return $books;
        }
        
        /*
         * gets author data used for creating URL bits
         * @return array
         */
        public function selectAuthorsForUrl() {
            $queryStr = "SELECT author_id, CONCAT(first_name, ' ', last_name) AS authorName FROM authors";
            return $this->_registry->getObject('db')->makeMultiDataArray($queryStr, 'author_id');
        }
        
        /*
         * gets all records from last query (used in pagination)
         */
        public function countAll() {
            return $this->_countAll;
        }
    }