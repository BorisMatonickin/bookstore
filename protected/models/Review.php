<?php
    require_once('Model.php');
    
    class Review extends Model {
        
        /*
         * review save flag
         */
        private $_saved;

        /*
         * checks if user already have reviewed product
         * @param int $productId
         * @return bool - is user already reviewed product or not
         */
        public function checkIfReviewed($productId) {
            $user = $this->_registry->getModel('authenticate')->getUserId();
            $queryStr = "SELECT review_id FROM reviews WHERE book_id = ? AND user_id = ?";
            $this->_registry->getObject('db')->execute($queryStr, [$productId, $user]);
            return ($this->_registry->getObject('db')->affectedRows() > 0) ? true : false;
        }
        
        /*
         * validates and sanitizes review form fields data
         */
        private function checkReviewForm() {
            $required = array('title' => 'title', 'review' => 'review');
            $this->_val->setRequired($required);
            $this->_val->matches('title', '/^[A-Za-z0-9.,+]/');
            $this->_val->matches('review', "/^[a-zA-Z0-9?$@#\(\)\'!,+\-=_:\.&€£*%\s]+$/");
            $this->_val->isInt('captcha');
            $this->_val->checkSessionMatch('captcha', 'vercode');
            $this->checkValidation();
        }
        
        /*
         * saves review
         * @param int $productId
         * @param int $userId
         * @return bool
         */
        public function saveReview($productId, $userId) {
            $this->checkReviewForm();
            if (empty($this->_errors) && empty($this->_missingValues)) {
                return ($this->_registry->getObject('db')->insert('reviews', ['book_id' => $productId,
                                                                            'user_id' => $userId,
                                                                            'title' => $this->_sanitizedValues['title'], 
                                                                            'review' => $this->_sanitizedValues['review']])) ? $this->_saved = true : $this->_saved = false;
            } else {
                $this->_saved = false;
            }  
        }
        
        /*
         * gets product info for review sidebar
         * @param int $productId
         * @return array
         */
        public function getBookForReviewSidebar($productId) {
            $queryStr = "SELECT b.book_id, b.title, b.image, GROUP_CONCAT(DISTINCT a.first_name, ' ', a.last_name SEPARATOR ', ') as authorName, "
                    . "a.author_id AS authorId FROM books b "
                    . "JOIN book_authors ba ON b.book_id = ba.book_id "
                    . "JOIN authors a ON a.author_id = ba.author_id "
                    . "WHERE b.book_id = ? GROUP BY ba.book_id";
            return $this->_registry->getObject('db')->makeAssocArray($queryStr, [$productId]);
        }
        
        /*
         * gets review and rating info for choosen product
         * @param int $productId
         * @return array
         */
        public function reviewInfo($productId) {
            $queryStr = "SELECT r.review_id, r.title, r.review, DATE_FORMAT(r.date_created, '%M %e, %Y') AS dateReviewed, "
                    . "u.user_id, CONCAT(u.first_name, ' ', u.last_name) AS userName, f.format, "
                    . "(SELECT COUNT(rr.helpful) FROM review_ratings rr WHERE r.review_id = rr.review_id) AS totalReviewRating, "
                    . "(SELECT COUNT(rr.helpful) FROM review_ratings rr WHERE r.review_id = rr.review_id AND rr.helpful = 1) AS isHelpful, "
                    . "IFNULL((SELECT br.rating FROM book_ratings br WHERE br.book_id = ? AND br.user_id = u.user_id), 0) AS rating "
                    . "FROM reviews r "
                    . "JOIN books b ON b.book_id = r.book_id "
                    . "JOIN formats f ON f.format_id = r.format_id "
                    . "JOIN users u ON r.user_id = u.user_id "
                    . "WHERE r.book_id = ? AND r.approved = ?";
            return $this->_registry->getObject('db')->makeMultiDataArray($queryStr, 'review_id', [$productId, $productId, 1]);
        }
        
        /*
         * checks if user has rated the displayed review
         * @param int $userId
         * @return bool
         */
        public function checkReviewRating($userId, $reviewId) {
            $queryStr = "SELECT helpful FROM review_ratings WHERE user_id = ? AND review_id = ?";
            $this->_registry->getObject('db')->execute($queryStr, [$userId, $reviewId]);
            return ($this->_registry->getObject('db')->affectedRows() > 0) ? true : false;
        }
        
        /*
         * saves users choice if displayed review was helpful or not, allowed only for logged users
         * @param int $reviewId
         * @param int $userId
         * @param int helpful - simply 0 or 1, 1 for it is helpful, and 0 for it's not
         */
        public function saveReviewRating($userId, $reviewId, $helpful) {
            $reviewRating = array('user_id' => $userId, 
                                  'review_id' => $reviewId, 
                                  'helpful' => $helpful);
            return ($this->_registry->getObject('db')->insert('review_ratings', $reviewRating)) ? true : false;
        }
        
        /*
         * getter methods
         */
        public function isReviewSaved() {
            return $this->_saved;
        }
    }