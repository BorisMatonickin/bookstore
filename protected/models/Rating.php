<?php
    require_once('Model.php');
    
    class Rating extends Model {
        
        /*
         * rating
         */
        private $_rating;
        
        /*
         * checks if user have been rated this product already
         * @return bool - is it user already rated this product or not?
         */
        public function checkRating($productId) {
            $sessionId = session_id();
            $ipAddress = $_SERVER['REMOTE_ADDR'];
            $user = $this->_registry->getModel('authenticate')->getUserId();
            if ($this->_registry->getModel('authenticate')->isLoggedIn() == true) {
                $queryStr = "SELECT rating FROM book_ratings "
                        . "WHERE user_id = ? AND book_id = ?";
                $this->_registry->getObject('db')->execute($queryStr, [$user, $productId]);
            } else {
                $queryStr = "SELECT rating FROM book_ratings "
                        . "WHERE user_id = ? AND user_session_id = ? AND ip_address = ? AND book_id = ?";
                $this->_registry->getObject('db')->execute($queryStr, [$user, $sessionId, $ipAddress, $productId]);
            }
            $this->_rating = $this->_registry->getObject('db')->getRows();
            return ($this->_registry->getObject('db')->affectedRows() > 0) ? true : false;
        }

        /*
         * saves product rating from user, allowed once
         * @param int $productId
         * @param int $bookRating - rating from 1 to 5 represented by stars
         * @return string - success or failure of inserting rating
         */
        public function saveRating($productId, $bookRating) {
            $rating = array();
            $rating['user_id'] = $this->_registry->getModel('authenticate')->getUserId();
            $rating['user_session_id'] = session_id();
            $rating['ip_address'] = $_SERVER['REMOTE_ADDR'];
            $rating['book_id'] = $productId;
            $rating['rating'] = $bookRating;
            return ($this->_registry->getObject('db')->insert('book_ratings', $rating)) ? 'success' : 'failure';
        }
        
        /*
         * gets the rating for the current user
         */
        public function getRating() {
            return $this->_rating;
        }
    }