<?php
    require_once('protected/admin/models/A_Model.php');
    
    class A_Settings extends A_Model {

        /*
         * gets details about voucher codes
         * @return array
         */
        public function getVouchersInfo() {
            $queryStr = "SELECT discount_id, vouchercode, active, discount_operation, discount_amount, "
                    . "DATE_FORMAT(expiry, '%M %e, %Y %h:%i %p') AS dateExpires FROM discount_codes ORDER BY expiry DESC";
            return $this->_registry->getObject('db')->makeMultiDataArray($queryStr, 'discount_id');
        }
        
        /*
         * gets details about choosen discount code
         * @param int $discountId
         * @return array
         */
        public function getDiscountInfo($discountId) {
            $queryStr = "SELECT discount_id, vouchercode, active, discount_operation, discount_amount, "
                    . "DATE_FORMAT(expiry, '%M %e, %Y %h:%i %p') AS dateExpires, num_vouchers FROM discount_codes WHERE discount_id = ?";
            return $this->_registry->getObject('db')->makeAssocArray($queryStr, [$discountId]);
        }
        
        /*
         * - validates and sanitize form fields for inserting new discount code
         * - there are some fields which are not required and also needs to be passed 
         *   to Validator class if filled in 
         * - final array for validation process is maded with merging two arrays: 
         *   1. required fields array
         *   2. submitted values from $_POST request
         */
        private function checkNewDiscountFields() {
            $required = array('name' => 'name', 'active' => 'active', 'operation' => 'operation', 'amount' => 'amount', 
                              'minBasket' => 'minBasket', 'dateExpires' => 'dateExpires');
            $submittedFields = $this->_registry->getObject('template')->createRequiredArray(['token', 'createDiscount']);
            $finalRequired = array_merge($required, $submittedFields);
            $this->_val->setRequired($finalRequired);
            $this->_val->matches('name', '/^[A-Za-z0-9\s\-_\']+$/');
            $this->_val->isInt('active');
            $this->_val->matches('operation', '/^[\-%]$/');
            $this->_val->isFloat('amount');
            $this->_val->isFloat('minBasket');
            $this->_val->matches('dateExpires', '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/');
            if (in_array('available', $finalRequired)) { $this->_val->isInt('available'); }
            $this->_sanitizedValues = array_map('trim', $this->_val->validateInput());
            $this->_missingValues = $this->_val->getMissing();
            $this->_errors = $this->_val->getErrors();
            $this->_submittedValues = array_map('trim', $this->_val->getSubmitted());
        }
        
        /*
         * inserts new discount code into database
         * @return string - confirmation about success or failure
         */
        public function insertNewDiscount() {
            $this->checkNewDiscountFields();
            if (empty($this->_errors) && empty($this->_missing)) {
                $discount = array('vouchercode' => $this->_sanitizedValues['name'],
                                  'active' => $this->_sanitizedValues['active'],
                                  'min_basket_cost' => $this->_sanitizedValues['minBasket'],
                                  'discount_operation' => $this->_sanitizedValues['operation'],
                                  'discount_amount' => $this->_sanitizedValues['amount'],
                                  'num_vouchers' => (isset($this->_sanitizedValues['available'])) ? $this->_sanitizedValues['available'] : -1,
                                  'expiry' => $this->_sanitizedValues['dateExpires']);
                return ($this->_registry->getObject('db')->insert('discount_codes', $discount)) ? 'success' : 'failure';
            }
        }
        
        /*
         * updates discount code status and sets the expiration date
         * @param int $discountId
         * @return string - confirmation about success or failure
         */
        public function updateDiscount($discountId) {
            $this->setRequiredFields(['token', 'updateDiscount']);
            if (in_array('active', $this->_required)) { $this->_val->isInt('active'); }
            if (in_array('expiry', $this->_required)) { $this->_val->matches('expiry', '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/'); }
            $this->checkValidationOnUpdate();
            if (empty($this->_errors)) {
                return ($this->_registry->getObject('db')->update('discount_codes', $this->_sanitizedValues, $discountId, 'discount_id')) ? 'success' : 'failure';
            } else {
                return 'failure';
            }
        }
    }