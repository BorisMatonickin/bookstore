<?php
    require_once('Model.php');
    
    class Account extends Model {
        
        /*
         * gets user info to display on main account page
         */
        public function getUserInfo($userId) {
            $queryStr = "SELECT u.user_id, u.first_name, u.last_name, u.address, u.city, u.zip, u.email, c.country_name, s.state_name, c.country_abbrev, "
                    . "s.state_abbrev FROM users u JOIN countries c ON u.country = c.country_abbrev "
                    . "LEFT OUTER JOIN states s ON u.state = s.state_abbrev AND u.state IS NOT NULL WHERE user_id = ?";
            return $this->_registry->getObject('db')->makeAssocArray($queryStr, [$userId]);
        }
        
        /********************************************************************************************************************************************
         ****************************************************** wish list methods ******************************************************************* 
         ********************************************************************************************************************************************/
        
        /*
         * gets product info for wish list
         * @param int $userId
         * @return array
         */
        public function wishListProducts($userId) {
            $queryStr = "SELECT b.book_id AS bookId, b.title AS bookTitle, DATE_FORMAT(b.date_published, '%M %e, %Y') AS datePublished, "
                    . "b.image, p.name AS publisherName, f.format, "
                    . "GROUP_CONCAT(DISTINCT a.first_name, ' ', a.last_name SEPARATOR ', ') AS authorName, w.wish_id AS wishId, "
                    . "a.author_id AS authorId FROM books b "
                    . "JOIN wish_lists w ON b.book_id = w.book_id "
                    . "JOIN book_authors ba ON b.book_id = ba.book_id "
                    . "JOIN authors a ON a.author_id = ba.author_id "
                    . "JOIN publisher p ON b.publisher_id = p.publisher_id "
                    . "JOIN formats f ON b.format_id = f.format_id "
                    . "WHERE w.user_id = ? GROUP BY ba.book_id";
            return $this->_registry->getObject('db')->makeMultiDataArray($queryStr, 'bookId', [$userId]);
        }
        
        /*
         * adds product to wish list if user is logged in, checks if product is already on user wish list
         * @param int $productId
         * @return array
         */
        public function addProductToWishList($productId) {
            $userId = $this->_registry->getModel('authenticate')->getUserId();
            if ($this->checkWishList($userId, $productId) == false) {
                $wish = array();
                $wish['user_id'] = $userId;
                $wish['book_id'] = $productId;
                $wish['quantity'] = 1;
                return ($this->_registry->getObject('db')->insert('wish_lists', $wish)) ? 'success' : 'failure';
            } else {
                return 'onlist';
            }  
        }
        
        /*
         * removes product from wish list
         * @param int $wishId - id of the wish
         */
        public function removeProductFromWishList($wishId) {
            $this->_registry->getObject('db')->delete('wish_lists', $wishId, 'wish_id');
        }
        
        /*
         * checks if product is already on user wish list
         * @param $productId
         * @param $userId
         * @return bool
         */
        private function checkWishList($userId, $productId) {
            $queryStr = "SELECT wish_id FROM wish_lists WHERE user_id = ? AND book_id = ?";
            $this->_registry->getObject('db')->execute($queryStr, [$userId, $productId]);
            return ($this->_registry->getObject('db')->affectedRows() > 0) ? true : false;
        }
        
        /*************************************************************************************************************************************************
         ********************************************************** account settings methods *************************************************************
         *************************************************************************************************************************************************/
        
        /*
         * - checks settings form fields, change is optional so in required array are only values submitted in POST request
         * - POST value of 'token' and 'save' (submit input) should not be included in validation process
         */
        private function checkSettingsFields() {
            $required = $this->_registry->getObject('template')->createRequiredArray(['token', 'save']);
            $this->_val->setRequired($required);
            if (in_array('first_name', $required)) { $this->_val->matches('first_name', '/^[A-Za-z\'\.\-]{2,20}$/i'); }
            if (in_array('last_name', $required)) { $this->_val->matches('last_name', '/^[A-Za-z\'\.\-]{2,40}$/i'); }
            if (in_array('address', $required)) { $this->_val->matches('address', '/^[A-Za-z0-9\',\.#\-\s]{2,80}$/i'); }
            if (in_array('city', $required)) { $this->_val->matches('city', '/^[A-Za-z\'\.\-\s]{2,60}$/i'); }
            if (in_array('country', $required)) { $this->_val->removeTags('country'); }
            if (in_array('state', $required)) { $this->_val->removeTags('state'); }
            if (in_array('zip', $required)) { $this->_val->matches('zip', '/^(\d{5}$)|(^\d{5}\-\d{4})$/'); }
            $this->_submittedValues = array_map('trim', $this->_val->getSubmitted());
            if (!empty($required) && !empty($this->_submittedValues)) {
                $this->_sanitizedValues = array_map('trim', $this->_val->validateInput());
                $this->_errors = $this->_val->getErrors();
            }
        }
        
        /*
         * updating changes into users tables if any
         * @param int $userId
         * @return string
         */
        public function updateUserChanges($userId) {
            $this->checkSettingsFields();
            if (empty($this->_errors)) {
                $this->_sanitizedValues['state'] = (isset($this->_sanitizedValues['state'])) ? $this->_sanitizedValues['state'] : null;
                return ($this->_registry->getObject('db')->update('users', $this->_sanitizedValues, $userId, 'user_id')) ? 'success' : 'failure';
            } else {
                return 'failure';
            }
        }
        
        /*****************************************************************************************************************************************************
         *********************************************************** user orders methods *********************************************************************
         *****************************************************************************************************************************************************/
        
        /*
         * gets details about user orders
         * @param int $userId
         */
        public function ordersInfo($userId) {
            $queryStr = "SELECT o.order_id, o.delivery_name, o.total, DATE_FORMAT(o.order_date, '%d-%m-%Y') as dateOrdered, os.name AS orderStatus FROM orders o "
                    . "JOIN order_statuses os ON os.status_id = o.order_status "
                    . "WHERE o.user_id = ?";
            return $this->_registry->getObject('db')->makeMultiDataArray($queryStr, 'order_id', [$userId]);
        }
        
        /*
         * gets details about user order
         * @param int $orderId
         */
        public function orderDetails($orderId) {
            $queryStr = "SELECT o.order_id, o.delivery_name, o.delivery_address, o.delivery_city, o.delivery_state, o.delivery_country, "
                    . "o.delivery_zip, o.subtotal, o.discount, o.total, o.voucher_code FROM orders o WHERE o.order_id = ?";
            return $this->_registry->getObject('db')->makeAssocArray($queryStr, [$orderId]);
        }
        
        /*
         * gets detail about choosen order
         * @param int $orderId
         * @return array
         */
        public function orderBooksDetails($orderId) {
            $queryStr = "SELECT oc.quantity, oc.price_per, oc.quantity * oc.price_per AS lineTotal, b.book_id, b.title, b.image "
                    . "FROM order_contents oc "
                    . "JOIN books b ON b.book_id = oc.book_id AND oc.order_id = ?"
                    . "WHERE oc.order_id = ?";
            return $this->_registry->getObject('db')->makeMultiDataArray($queryStr, 'book_id', [$orderId, $orderId]);
        }
        
        /*****************************************************************************************************************************************************
         *********************************************************** view user reviews methods ***************************************************************
         *****************************************************************************************************************************************************/
        
        /*
         * get user reviews, approved and not approved
         * @param int $userId
         * @return arary
         */
        public function userReviewsInfo($userId) {
            $queryStr = "SELECT r.review_id, r.title, r.review, r.approved, DATE_FORMAT(r.date_created, '%M %e, %Y') as dateReviewed, f.format, "
                    . "GROUP_CONCAT(DISTINCT a.first_name, ' ', a.last_name SEPARATOR ', ') AS authorName, b.book_id, b.title AS bookTitle, "
                    . "(SELECT COUNT(rr.helpful) FROM review_ratings rr WHERE r.review_id = rr.review_id) AS totalReviewRating, "
                    . "(SELECT COUNT(rr.helpful) FROM review_ratings rr WHERE r.review_id = rr.review_id AND rr.helpful = 1) AS isHelpful, "
                    . "IFNULL((SELECT br.rating FROM book_ratings br WHERE br.book_id = b.book_id AND br.user_id = ?), 0) AS rating, "
                    . "GROUP_CONCAT(DISTINCT a.author_id SEPARATOR ', ') AS authorId "
                    . "FROM reviews r "
                    . "JOIN books b ON b.book_id = r.book_id "
                    . "JOIN formats f ON f.format_id = r.format_id "
                    . "JOIN users u ON u.user_id = ? "
                    . "JOIN book_authors ba ON r.book_id = ba.book_id "
                    . "JOIN authors a ON ba.author_id = a.author_id "
                    . "WHERE r.user_id = ? GROUP BY ba.book_id";
            return $this->_registry->getObject('db')->makeMultiDataArray($queryStr, 'review_id', [$userId, $userId, $userId]);
        }         
    }