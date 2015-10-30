<?php
    require_once('Model.php');
    
    class Basket extends Model {
        
        /*
         * basket checked flag - this is to prevent checkBasked method to 
         *  being called uneccessary
         */
        private $_basketChecked = false;
        
        /*
         * basket empty flag
         */
        private $_basketEmpty = true;
        
        /*
         * contents of the basket
         */
        private $_contents = array();
        
        /*
         * number of products in the basket
         */
        private $_numProducts = 0;
        
        /*
         * total cost of the basket
         */
        private $_cost = 0;
        
        /*
         * id's of the basket products
         */
        private $_productIds = array();
        
        /*
         * checks basket, sets basketChecked flag to true to prevent this method 
         *  being called unnecessarily, gets user identifiable data 
         * if the customer is logged in, query is different
         */
        public function checkBasket() {
            $this->_basketChecked = true;
            $sessionId = session_id();
            $ipAddress = $_SERVER['REMOTE_ADDR'];
            if ($this->_registry->getModel('authenticate')->isLoggedIn() == true) {
                $user = $this->_registry->getModel('authenticate')->getUserId();
                $queryStr = "SELECT c.id AS cartId, c.quantity AS productQuantity, b.book_id AS bookId, b.title AS bookTitle, b.image, "
                        . "b.stock, b.price FROM carts c JOIN books b ON c.book_id = b.book_id "
                        . "WHERE c.user_id = ?";
                $this->_registry->getObject('db')->execute($queryStr, [$user]);
            } else {
                $queryStr = "SELECT c.id AS cartId, c.quantity AS productQuantity, b.book_id AS bookId, b.title AS bookTitle, b.image, "
                        . "b.stock, b.price FROM carts c JOIN books b ON c.book_id = b.book_id "
                        . "WHERE c.user_id = ? AND c.user_session_id = ? AND c.ip_address = ?";
                $this->_registry->getObject('db')->execute($queryStr, [0, $sessionId, $ipAddress]);
            }
            if ($this->_registry->getObject('db')->affectedRows() > 0) {
                $this->_basketEmpty = false;
                while ($row = $this->_registry->getObject('db')->getRows()) {
                    $this->_contents[$row['bookId']] = array('unitcost' => $row['price'], 
                                                             'subtotal' => ($row['price'] * $row['productQuantity']), 
                                                             'quantity' => $row['productQuantity'], 
                                                             'product' => $row['bookId'], 
                                                             'basket' => $row['cartId'], 
                                                             'name' => $row['bookTitle'],
                                                             'image' => $row['image']);
                    $this->_productIds[] = $row['bookId'];
                    $this->_numProducts = $this->_numProducts + $row['productQuantity'];
                    $this->_cost = $this->_cost + ($row['price'] * $row['productQuantity']);
                }
            }
        }
        
        /*
         * adds product to the shopping basket
         * @param int $productId - the product reference id
         * @param int $quantity - quantity of the product
         */
        public function addProduct($productId, $quantity = 1) {
            if (!$this->_basketChecked == true) {
                $this->checkBasket();
            }
            // checks if products exists
            $queryStr = "SELECT b.book_id AS bookId, b.title AS bookTitle, b.image, b.edition, b.price, b.stock, DATE_FORMAT(b.date_published, '%M %e, %Y') AS datepublished, "
                    . "p.name AS publisherName, f.format, GROUP_CONCAT(DISTINCT a.first_name, ' ', a.last_name SEPARATOR ', ') AS authorName FROM books b "
                    . "JOIN book_authors ba ON b.book_id = ba.book_id "
                    . "JOIN authors a ON a.author_id = ba.author_id "
                    . "JOIN publisher p ON b.publisher_id = p.publisher_id "
                    . "JOIN formats f ON b.format_id = f.format_id "
                    . "WHERE b.book_id = ? GROUP BY ba.book_id";
            $this->_registry->getObject('db')->execute($queryStr, $productId);
            if ($this->_registry->getObject('db')->affectedRows() == 1) {
                $data = $this->_registry->getObject('db')->getRows();
                // checking if product is already in the basket
                if (array_key_exists($data['bookId'], $this->_contents) == true) {
                    // check stock
                    if ($data['stock'] == -1 || $data['stock'] >= ($this->_contents[$data['bookId']]['quantity'] + $quantity)) {
                       // increment the quantitiy
                        $this->_contents[$data['bookId']]['quantity'] = $this->_contents[$data['bookId']]['quantity'] + $quantity;
                        // update the database
                        $this->_registry->getObject('db')->update('carts', ['quantity' => $this->_contents[$data['bookId']]['quantity']], $this->_contents[$data['bookId']]['basket'], 'id');
                        return 'success';
                    } else {
                        // error message
                        return 'stock';
                    }
                } else {
                    if ($data['stock'] == -1 || $data['stock'] >= $quantity) {
                        // add product, insert the new listing into the basket
                        $sessionId = session_id();
                        $user = ($this->_session->exists('authSessionUid')) ? $this->_session->get('authSessionUid') : 0;
                        $ip = $_SERVER['REMOTE_ADDR'];
                        $item = array('user_id' => $user, 
                                      'user_session_id' => $sessionId, 
                                      'book_id' => $data['bookId'], 
                                      'quantity' => $quantity, 
                                      'ip_address' => $ip);
                        $this->_registry->getObject('db')->insert('carts', $item, $this->_contents[$data['bookId']]['basket'], 'id');
                        $basketId = $this->_registry->getObject('db')->lastInsertId();
                        // add the product to the contents array
                        $this->_contents[$data['bookId']] = array('unitcost' => $data['price'], 
                                                                  'subtotal' => ($data['price'] * $quantity), 
                                                                  'quantity' => $quantity, 
                                                                  'product' => $data['bookId'], 
                                                                  'basket' => $basketId, 
                                                                  'name' => $data['bookTitle']);
                        return 'success';
                    } else {
                        return 'stock';
                    }  
                }
            } else {
                // product dont exists
                return 'noproduct';
            }
        } 
        
        /*
         * updates product quantity
         * @param int $basketItemId - ID of the basket item
         * @param int $quantity
         */
        public function updateProductQuantity($basketItemId, $quantity) {
            $changes = array('quantity' => $quantity, 'date_modified' => date('Y:m:d H:i:s'));
            $this->_registry->getObject('db')->update('carts', $changes, $basketItemId, 'id');
        }
        
        /*
         * removes product from basket
         * @param int $basketItemId - ID of the basket item
         */
        public function removeProduct($basketItemId) {
            $this->_registry->getObject('db')->delete('carts', $basketItemId, 'id');
        }
        
        /*
         * transfers the basket to another user
         * @param int $userId
         */
        public function transferToUser($userId) {
            $changes = array('user_id' => $userId, 'date_modified' => date('Y:m:d H:i:s'));
            $sessionId = session_id();
            $this->_registry->getObject('db')->update('carts', $changes, $sessionId, 'user_session_id');
        }
        
        
        
        /*
         * getter methods
         */
        public function getContents() {
            return $this->_contents;
        }
        
        public function isChecked() {
            return $this->_basketChecked;
        }
        
        public function getTotal() {
            return number_format($this->_cost, 2);
        }
        
        public function isEmpty() {
            return $this->_basketEmpty;
        }
        
        public function getNumProducts() {
            return $this->_numProducts;
        } 
    }
