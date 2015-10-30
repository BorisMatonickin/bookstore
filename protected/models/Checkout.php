<?php
    require_once('Model.php');
    
    class Checkout extends Model {
        
        /*
         * total amount of cart
         */
        private $_total = 0;
        
        /*
         * notice about discount code
         */
        private $_voucherNotice;
        
        /*
         * discount code
         */
        private $_discountCode;
        
        /*
         * discount amount
         */
        private $_discount;
        
        /*
         * discount code data
         */
        public $voucher = array();
        
        /*
         * gets basket content for order confirmation
         * @return array
         */
        public function getBasketContentForOrder() {
            $basketContent = array();
            if ($this->_registry->getModel('authenticate')->isLoggedIn() == true) {
                $user = $this->_registry->getModel('authenticate')->getUserId();
                $queryStr = "SELECT c.id AS cartId, c.quantity AS productQuantity, b.book_id AS bookId, b.title AS bookTitle, b.image, "
                        . "b.stock, b.price, "
                        . "GROUP_CONCAT(DISTINCT a.first_name, ' ', a.last_name SEPARATOR ', ') AS authorName FROM carts c "
                        . "JOIN books b ON c.book_id = b.book_id "
                        . "JOIN book_authors ba ON b.book_id = ba.book_id "
                        . "JOIN authors a ON ba.author_id = a.author_id "
                        . "WHERE c.user_id = ? GROUP BY ba.book_id";
                $this->_registry->getObject('db')->execute($queryStr, [$user]);
                while ($row = $this->_registry->getObject('db')->getRows()) {
                    $basketContent[$row['bookId']] = array('unitcost' => $row['price'],
                                                           'subtotal' => ($row['price'] * $row['productQuantity']),
                                                           'quantity' => $row['productQuantity'],
                                                           'product' => $row['bookId'],
                                                           'basket' => $row['cartId'],
                                                           'name' => $row['bookTitle'],
                                                           'author' => $row['authorName'],
                                                           'image' => $row['image']);
                }
                $this->_total = $this->_registry->getModel('basket')->getTotal();
                return $basketContent;
            }
        }
        
        /*
         * gets payment method, state and country names for delivery address
         * @param string $countryAbbrev
         * @param string $stateAbbrev
         * @param int $paymentMethodId
         * @return array
         */
        public function getCountryStateMethod($paymentMethodId, $countryAbbrev, $stateAbbrev = null) {
            if (isset($stateAbbrev)) {
                $queryStr = "SELECT c.country_name, s.state_name, pm.name FROM countries c, states s, payment_methods pm "
                    . "WHERE pm.method_id = ? AND c.country_abbrev = ? AND s.state_abbrev = ?";
                return $this->_registry->getObject('db')->makeAssocArray($queryStr, [$paymentMethodId, $countryAbbrev, $stateAbbrev]);
            } else {
                $queryStr = "SELECT c.country_name, pm.name FROM countries c, payment_methods pm "
                    . "WHERE pm.method_id = ? AND c.country_abbrev = ?";
                return $this->_registry->getObject('db')->makeAssocArray($queryStr, [$paymentMethodId, $countryAbbrev]);
            }
        }
        
        /*
         * gets payment methods for select tag
         * @return array
         */
        public function getPaymentMethods() {
            $queryStr = "SELECT method_id, name FROM payment_methods";
            return $this->_registry->getObject('db')->makeMultiDataArray($queryStr, 'method_id');
        }
        
        /******************************************************************************************************************************************************
         ********************************************************** discount code methods ********************************************************************* 
         ******************************************************************************************************************************************************/
        
        /*
         * consider and apply voucher codes
         * types of voucher code:
         *   - = fixed ammount off
         *   % = percentage off
         * @param string $voucherCode
         */
        public function considerVouchers($voucherCode) {
            if ($voucherCode != '') {
                $date = date('Y-m-d H:i:s');
                $queryStr = "SELECT *, if(? > expiry, 1, 0) AS expired FROM discount_codes WHERE vouchercode = ? LIMIT 1";
                $this->_registry->getObject('db')->execute($queryStr, [$date, $voucherCode]);
                if ($this->_registry->getObject('db')->affectedRows() == 0) {
                    $this->_voucherNotice = 'Sorry, the voucher code you entered is invalid';
                    return false;
                } else {
                    $this->voucher = $this->_registry->getObject('db')->getRows();
                    if ($this->checkVoucherExpired() == true) {
                        if ($this->checkNumberOfVouchers() == true) {
                            return ($this->checkMinBasketCost() == true) ? $this->checkDiscountOperation() : false;
                        }
                    }
                }
            }
        }
        
        /*
         * checks if voucher has expired
         * @return bool
         */
        private function checkVoucherExpired() {
            if ($this->voucher['expired'] == 1) {
                $this->_voucherNotice = 'Sorry, this voucher has expired';
                return false;
            } else {
                return true;
            }
        }
        
        /*
         * check if number of vouchers for using is limited
         * @return bool
         */
        private function checkNumberOfVouchers() {
            if ($this->voucher['num_vouchers'] == 0) {
                $this->_voucherNotice = 'Sorry, this was a limited edition voucher code, there are no more instance of that code left';
                return false; 
            } else {
                return true;
            }
        }
        
        /*
         * check basket total amount minimal requirement for voucher
         * @return bool
         */
        private function checkMinBasketCost() {
            if ($this->_total < $this->voucher['min_basket_cost']) {
                $this->_voucherNotice = 'Sorry, your order total is not enough for your order to qualify for this discount code';
                return false;
            } else {
                return true;
            }
        }
        
        /*
         * performs the calculation based on the discount operation of the voucher (% or -)
         * @return bool
         */
        private function checkDiscountOperation() {
            if ($this->voucher['discount_operation'] == '%') {
                $this->_discount = (($this->_total)/100) * $this->voucher['discount_amount'];
                $this->_total = $this->_total - $this->_discount;
                $this->_discountCode = $this->_voucher['vouchercode'];
                $this->_voucherNotice = 'A ' . $this->voucher['discount_amount'] . '% discount has been applied to your order';
                return true;
            } elseif ($this->voucher['discount_operation'] == '-') {
                $this->_total = $this->_total - $this->voucher['discount_amount'];
                $this->_discount = $this->voucher['discount_amount'];
                $this->_discountCode = $this->_voucher['vouchercode'];
                $this->_voucherNotice = 'A discount of &#36;' . $this->voucher['discount_amount'] . ' has been applied to your order';
                return true;
            }
        }
        
        /*
         * - reducing the number of vouchers available when one is used
         * - implemented on final checkout stage when payment is confirmed 
         * @param int $codeId
         */
        private function adjustDiscountCodeQuantities($codeId) {
            $queryStr = "SELECT num_vouchers FROM discount_codes WHERE discount_id = ?";
            $this->_registry->getObject('db')->execute($queryStr, $codeId);
            if ($this->_registry->getObject('db')->affectedRows() > 0) {
                $codeData = $this->_registry->getObject('db')->getRows();
                if ($codeData['num_vouchers'] > 0) {
                    $this->_registry->getObject('db')->update('discount_codes', ['num_vouchers' => 'num_vouchers' - 1], $codeId, 'discount_id');
                }
            }
        }
        
        /*
         * getter methods
         */
        public function getVoucherNotice() {
            return $this->_voucherNotice;
        }
        
        public function getOrderTotal() {
            return $this->_total;
        }
        
        public function getDiscountCode() {
            return $this->_discountCode;
        }
        
        public function getDiscountAmount() {
            return $this->_discount;
        }
    }