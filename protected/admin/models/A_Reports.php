<?php
    class A_Reports {
        /*
         * registry object reference
         */
        private $_registry;
        
        /*
         * object constructor - loads registry object
         * @param $registry - an object instance of type Registry
         */
        public function __construct(Registry $registry) {
            $this->_registry = $registry;
        }
        
        /*
         * gets info about purchased products
         * @return array
         */
        public function getPurchasedProducts() {
            $queryStr = "SELECT oc.book_id, b.title, GROUP_CONCAT(DISTINCT a.first_name, ' ', a.last_name SEPARATOR ', ') AS authorName, "
                    . "SUM(oc.quantity) AS totalQuantity, SUM(oc.quantity) * oc.price_per AS totalAmount, COUNT(oc.order_id) AS orders "
                    . "FROM order_contents oc "
                    . "JOIN books b ON oc.book_id = b.book_id "
                    . "JOIN book_authors ba ON oc.book_id = ba.book_id "
                    . "JOIN authors a ON ba.author_id = a.author_id "
                    . "GROUP BY oc.book_id";
            return $this->_registry->getObject('db')->makeMultiDataArray($queryStr, 'book_id');
        }
    }