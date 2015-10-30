<?php
    require_once('protected/controllers/Controller.php');
    
    class CheckoutController extends Controller {
        
        /*
         * basket object reference
         */
        private $_basket;
        
        /*
         * delivery address array stored in the session
         */
        private $_deliveryAddress;
        
        /*
         * discount code notice
         */
        public $voucherNotice;
        
        /*
         * object constructor
         * @param $registry - an object instance of type Registry
         */
        public function __construct(Registry $registry) {
            parent::__construct($registry, 'checkout');
            $this->_basket = $this->_registry->getModel('basket');
            $this->_registry->getModel('authenticate')->redirectInvalidUser('basket/view');
            if ($this->_basket->isEmpty() == true) {
                $this->_session->flash('message', '<p class="stock">Your basket is currently empty.');
                $this->_registry->redirectTo('basket/view');
            } else {
                if (isset($this->_urlBits[1])) {
                    switch ($this->_urlBits[1]) {
                        case 'order-details':
                            $this->orderDetails();
                            break;
                        case 'confirm-order':
                            $this->confirmOrder();
                            break;
                        case 'save-order':
                            $this->saveOrder();
                            break;
                        case 'cancel-order':
                            $this->cancelOrder();
                            break;
                        default:
                            $this->_registry->redirectTo('basket/view');
                            break;
                    }
                } else {
                    $this->_registry->redirectTo('basket/view');
                }
            }
        }
        
        /*
         * - handles order details with delivery address, selects payment method and discount codes eventually
         * - stores order details with delivery address into session
         * - template variables are used in: main.order.php
         */
        private function orderDetails() {
            $this->_template->title = 'Order Details';
            $this->_template->countries = $this->_registry->getModel('register')->selectCountries();
            $this->_template->states = $this->_registry->getModel('register')->selectStates();
            $this->_template->paymentMethods = $this->_model->getPaymentMethods();
            $orderDetails = $this->_model->getBasketContentForOrder();
            $this->_template->orderDetails = $orderDetails;
            if (filter_has_var(INPUT_POST, 'submitAddress')) {
                $this->checkDeliveryAddressForm();
                $this->checkVoucher();
                $token = $this->_sanitizedValues['token'];
                $this->_security->checkCsrfToken($token);
                if (empty($this->_errors) && empty($this->_missingValues)) {
                    $this->storeDeliveryAddress();
                    $this->storeTotalAndDiscount();
                    $this->_session->put('orderDetails', serialize($orderDetails));
                    $this->_session->flash('message', $this->voucherNotice);
                    $this->_security->deleteTokenFromSession();
                    $this->_registry->redirectTo('checkout/confirm-order');
                } else {
                    $this->_template->token = $this->_security->generateToken();
                    $this->displayFormErrors();
                    $this->_template->buildFromTemplates('header.checkout.php', 'main.order.php', 'footer.checkout.php');
                }
            } else {
                $this->_template->token = $this->_security->generateToken();
                $this->_template->buildFromTemplates('header.checkout.php', 'main.order.php', 'footer.checkout.php');
            }
        }
        
        /*
         * - confirms user order, pulls order details with delivery address from session
         * - template variables are used in: main.confirm.php
         */
        private function confirmOrder() {
            $this->_template->title = 'Confirm Order';
            $this->_template->totalAndDiscount = unserialize($this->_session->get('totalAndDiscount'));
            $this->_template->deliveryAddress = unserialize($this->_session->get('customerDeliveryAddress'));
            $this->_template->orderDetails = unserialize($this->_session->get('orderDetails'));
            $this->_template->buildFromTemplates('header.checkout.php', 'main.confirm.php', 'footer.checkout.php');
        }
        
        /*
         * cancels the order before proceed to payment gateway, deletes order details with 
         *   delivery address from session, redirects the user back to basket
         */
        private function cancelOrder() {
            $this->_session->delete('orderDetails');
            $this->_session->delete('customerDeliveryAddress');
            $this->_session->delete('totalAndDiscount');
            $this->_session->flash('message', '<p class="stock">Order canceled</p>');
            $this->_registry->redirectTo('basket/view');
        }
        
        /*
         * - saves order to database if confirmed, and redirects the user to the payment process
         * - still, this is application without payment process integrated, redirects the user 
         *    back to the basket with message of succesfully saved order
         */
        private function saveOrder() {
            $orderDetails = unserialize($this->_session->get('orderDetails'));
            $deliveryAddress = unserialize($this->_session->get('customerDeliveryAddress'));
            $totalAndDiscount = unserialize($this->_session->get('totalAndDiscount'));
            $user = $this->_registry->getModel('authenticate')->getUserId();
            $state = (isset($deliveryAddress['state'])) ? $deliveryAddress['state'] : null;
            $order = array('user_id' => $user,
                           'delivery_name' => $deliveryAddress['name'],
                           'delivery_address' => $deliveryAddress['address'],
                           'delivery_city' => $deliveryAddress['city'],
                           'delivery_state' => $state,
                           'delivery_country' => $deliveryAddress['country'],
                           'delivery_zip' => $deliveryAddress['zip'],
                           'subtotal' => $totalAndDiscount['subtotal'],
                           'discount' => $totalAndDiscount['discount'],
                           'total' => $totalAndDiscount['total'],
                           'voucher_code' => $totalAndDiscount['discountCode'],
                           'order_status' => 1);
            $this->_registry->getObject('db')->insert('orders', $order);
            $orderId = $this->_registry->getObject('db')->lastInsertId();
            foreach ($orderDetails as $product => $data) {
                $orderContent = array('order_id' => $orderId,
                                      'book_id' => $product,
                                      'quantity' => $data['quantity'],
                                      'price_per' => $data['unitcost']);
                $this->_registry->getObject('db')->insert('order_contents', $orderContent);
            }
            $this->_registry->getObject('db')->delete('carts', $user, 'user_id');
            $this->_session->delete('orderDetails');
            $this->_session->delete('customerDeliveryAddress');
            $this->_session->delete('totalAndDiscount');
            //$this->_registry->redirectTo('payment/make-payment/' . $orderId);
            $this->_session->flash('message', '<p class="stock success">Order Saved</p>');
            $this->_registry->redirectTo('basket/view-basket');
        }
        
        /*
         * validates and sanitize delivery address form fields
         */
        private function checkDeliveryAddressForm() {
            $required = array('name' => 'name', 'address' => 'address', 'city' => 'city', 'country' => 'country', 
                                'zip' => 'zip', 'paymentMethod' => 'paymentMethod', 'token' => 'token');
            $submittedFields = $this->_registry->getObject('template')->createRequiredArray(['token', 'submitAddress']);
            $finalRequired = array_merge($required, $submittedFields);
            $this->_val->setRequired($finalRequired);
            $this->_val->removeTags('paymentMethod');
            $this->_val->matches('name', '/^[A-Za-z09\'\.\-\s]{2,80}$/i');
            $this->_val->matches('address', '/^[A-Za-z0-9\',\.#\-\s]{2,80}$/i');
            $this->_val->matches('city', '/^[A-Za-z\'\.\-\s]{2,60}$/i');
            if (in_array('state', $finalRequired)) { $this->_val->removeTags('state'); }
            if (in_array('voucher', $finalRequired)) { $this->_val->removeTags('voucher'); }
            $this->_val->removeTags('country');
            $this->_val->matches('zip', '/^(\d{5}$)|(^\d{5}-\d{4})$/');
            $this->_val->removeTags('token');
            $this->checkValidation();
        }
        
        /*
         * stores delivery address in session
         */
        private function storeDeliveryAddress() {
            if (isset($this->_sanitizedValues['state'])) {
                $data = $this->_model->getCountryStateMethod($this->_sanitizedValues['paymentMethod'], $this->_sanitizedValues['country'], $this->_sanitizedValues['state']);
                var_dump($data);
            } else {
                $data = $this->_model->getCountryStateMethod($this->_sanitizedValues['paymentMethod'], $this->_sanitizedValues['country']); 
            }
            $this->_deliveryAddress = array('paymentMethod' => $data['name'],
                                            'name' => $this->_sanitizedValues['name'],
                                            'address' => $this->_sanitizedValues['address'],
                                            'city' => $this->_sanitizedValues['city'],
                                            'country' => $data['country_name'],
                                            'state' => (isset($data['state_name'])) ? $data['state_name'] : null,
                                            'zip' => $this->_sanitizedValues['zip']);
            $this->_session->put('customerDeliveryAddress', serialize($this->_deliveryAddress));
        }
        
        /*
         * stores subtotal, total, discount amount and discount code in session
         */
        private function storeTotalAndDiscount() {
            $data = array('subtotal' => $this->_basket->getTotal(),
                          'total' => $this->_model->getOrderTotal(),
                          'discount' => $this->_model->getDiscountAmount(),
                          'discountCode' => (isset($this->_sanitizedValues['voucher']) ? $this->_sanitizedValues['voucher'] : null));
            $this->_session->put('totalAndDiscount', serialize($data));
        }
        
        /*
         * checks if user enters a valid discount code 
         */
        private function checkVoucher() {
            if (isset($this->_sanitizedValues['voucher'])) {
                $this->_model->considerVouchers($this->_sanitizedValues['voucher']);
                $this->voucherNotice = $this->_model->getVoucherNotice();
            }
        }
    }