<?php
    require_once('protected/admin/models/A_Model.php');
    
    class A_Reviews extends A_Model {
        
        /*
         * gets lates product reviews
         * @return array
         */
        public function getLatestReviews() {
            $queryStr = "SELECT r.review_id, r.approved, DATE_FORMAT(r.date_created, '%M %e, %Y') AS reviewDate, b.title, "
                    . "CONCAT(u.first_name, ' ', u.last_name) AS reviewAuthor, "
                    . "GROUP_CONCAT(DISTINCT a.first_name, ' ', a.last_name SEPARATOR ', ') AS bookAuthors "
                    . "FROM reviews r JOIN books b ON r.book_id = b.book_id "
                    . "JOIN users u ON r.user_id = u.user_id "
                    . "JOIN book_authors ba ON r.book_id = ba.book_id "
                    . "JOIN authors a ON ba.author_id = a.author_id "
                    . "GROUP BY ba.book_id ORDER BY r.date_created DESC LIMIT 6";
            return $this->_registry->getObject('db')->makeMultiDataArray($queryStr, 'review_id');
        }
        
        /*
         * gets all product reviews
         * @return array
         */
        public function getAllReviews() {
            $queryStr = "SELECT r.review_id, r.approved, DATE_FORMAT(r.date_created, '%M %e, %Y') AS reviewDate, b.title, "
                    . "CONCAT(u.first_name, ' ', u.last_name) AS reviewAuthor, "
                    . "GROUP_CONCAT(DISTINCT a.first_name, ' ', a.last_name SEPARATOR ', ') AS bookAuthors "
                    . "FROM reviews r JOIN books b ON r.book_id = b.book_id "
                    . "JOIN users u ON r.user_id = u.user_id "
                    . "JOIN book_authors ba ON r.book_id = ba.book_id "
                    . "JOIN authors a ON ba.author_id = a.author_id "
                    . "GROUP BY ba.book_id ORDER BY r.date_created DESC";
            return $this->_registry->getObject('db')->makeMultiDataArray($queryStr, 'review_id');
        }
        
        /*
         * gets review details
         * @param int $reviewId
         * @return array
         */
        public function getReviewInfo($reviewId) {
            $queryStr = "SELECT r.review_id, b.book_id, b.title AS bookTitle, GROUP_CONCAT(DISTINCT a.first_name, ' ', a.last_name SEPARATOR ', ') AS authorName, "
                    . "f.format, u.user_id, GROUP_CONCAT(u.first_name, ' ', u.last_name) AS user, r.title, r.review, r.approved, "
                    . "DATE_FORMAT(r.date_created, '%M %e, %Y %H:%i:%s') AS dateCreated FROM reviews r "
                    . "JOIN books b ON b.book_id = r.book_id "
                    . "JOIN book_authors ba ON ba.book_id = r.book_id "
                    . "JOIN authors a ON a.author_id = ba.author_id "
                    . "JOIN formats f ON f.format_id = r.format_id "
                    . "JOIN users u ON u.user_id = r.user_id WHERE r.review_id = ?";
            return $this->_registry->getObject('db')->makeAssocArray($queryStr, [$reviewId]);
        }
        
        /*
         * updates review status
         * @param int $reviewId
         * @return string - confirmation about success or failure
         */
        public function updateReview($reviewId) {
            $this->setRequiredFields(['token', 'updateReview']);
            if (in_array('approved', $this->_required)) { $this->_val->isInt('approved'); }
            $this->checkValidationOnUpdate();
            if (empty($this->_errors)) {
                return ($this->_registry->getObject('db')->update('reviews', $this->_sanitizedValues, $reviewId, 'review_id')) ? 'success' : 'failure';
            } else {
                return 'failure';
            }
        }
    }