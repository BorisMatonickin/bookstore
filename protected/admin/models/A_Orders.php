<?php
    require_once('protected/admin/models/A_Model.php');
    
    class A_Orders extends A_Model {
        
        /*
         * gets latest orders for main admin page
         * @return array
         */
        public function getLatestOrders() {
            $queryStr = "SELECT o.order_id, o.user_id, o.delivery_name, o.total, DATE_FORMAT(o.order_date, '%M %e, %Y') AS dateOrdered, os.name AS status FROM orders o "
                    . "JOIN order_statuses os ON o.order_status = os.status_id "
                    . "ORDER BY order_date DESC LIMIT 6";
            return $this->_registry->getObject('db')->makeMultiDataArray($queryStr, 'order_id');
        }
        
        /*
         * gets all orders
         * return array
         */
        public function getAllOrders() {
            $queryStr = "SELECT o.order_id, o.user_id, o.delivery_name, o.total, DATE_FORMAT(o.order_date, '%M %e, %Y') AS dateOrdered, os.name AS status FROM orders o "
                    . "JOIN order_statuses os ON o.order_status = os.status_id "
                    . "ORDER BY order_date DESC";
            return $this->_registry->getObject('db')->makeMultiDataArray($queryStr, 'order_id');
        }
        
        /*
         * gets order info
         * @param $orderId
         * @return array
         */
        public function getOrderInfo($orderId) {
            $queryStr = "SELECT o.order_id, o.user_id, o.delivery_name, o.delivery_city, o.delivery_state, o.delivery_country, o.delivery_zip, o.subtotal, "
                    . "o.delivery_address, o.discount, o.total, o.voucher_code, os.status_id, os.name as orderStatus, DATE_FORMAT(o.order_date, '%M %e, %Y %H:%i:%s') as orderDate "
                    . "FROM orders o JOIN order_statuses os ON o.order_status = status_id WHERE o.order_id = ?";
            return $this->_registry->getObject('db')->makeAssocArray($queryStr, [$orderId]);
        }
        
        /*
         * gets all possible order status options
         */
        public function getOrderUpdateOptions() {
            $queryStr = "SELECT status_id, name FROM order_statuses";
            return $this->_registry->getObject('db')->makeDataArray($queryStr, 'status_id', 'name');
        }
        
        /*
         * updates order status 
         * @param int $orderId
         * @return string - confirmation about success or failure
         */
        public function updateOrder($orderId) {
            $this->setRequiredFields(['token', 'updateOrder']);
            if (in_array('order_status', $this->_required)) { $this->_val->isInt('order_status'); }
            $this->checkValidationOnUpdate();
            if (empty($this->_errors)) {
                return ($this->_registry->getObject('db')->update('orders', $this->_sanitizedValues, $orderId, 'order_id')) ? 'success' : 'failure';
            } else {
                return 'failure';
            }
        }
    }