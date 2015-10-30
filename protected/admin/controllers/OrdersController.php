<?php
    require_once('protected/admin/controllers/BaseController.php');
    
    class OrdersController extends BaseController {
        /*
         * object constructor - checks URL bits and loads appropriate method
         * @param $registry - an object instance of type Registry
         */
        public function __construct(Registry $registry) {
            parent::__construct($registry, 'A_Orders');
            $this->_template->orderTitles = ['Orders', 'Order Details', 'Update Order', 'Customer Orders'];
            if (isset($this->_urlBits[1]) && $this->_urlBits[1] == 'orders') {
                if (isset($this->_urlBits[2]) && isset($this->_urlBits[3])) {
                    $id = filter_var($this->_urlBits[3], FILTER_VALIDATE_INT);
                    switch($this->_urlBits[2]) {
                        case 'view':
                            $this->viewOrder($id);
                            break;
                        case 'update':
                            $this->updateOrder($id);
                            break;
                        case 'view-by-customer':
                            $this->viewOrdersByCustomer($id);
                            break;
                        default:
                            $this->showOrders();
                            break;
                    }
                } else {
                    $this->showOrders();
                }
            } else {
                $this->_registry->redirectTo();
            }
        }
        
        /*
         * - prepare template variables for displaying user orders
         * - variables are used in admin.orders.php
         */
        private function showOrders() {
            $this->_template->title = 'Orders';
            $orders = $this->_model->getAllOrders();
            $this->_template->numbersOfPages = $this->_registry->getObject('paginator')->paginate($orders, 8, 2);
            $this->_template->orders = $this->_registry->getObject('paginator')->displayPaginatedData();
            $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.orders.php', 'admin.footer.php');
        }
        
        /*
         * - sets template variables for displaying order details
         * - variables are used in admin.order.php
         * @param int $orderId
         */
        private function viewOrder($orderId) {
            $this->_template->title = 'Order Details';
            $this->_template->order = $this->_model->getOrderInfo($orderId);
            $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.order.php', 'admin.footer.php');
        }
        
        /*
         * - sets template variables to update order status
         * - variables are used in admin.updateorder.php
         * @param int $orderId
         */
        private function updateOrder($orderId) {
            $this->_template->title = 'Update Order';
            $this->_template->order = $this->_model->getOrderInfo($orderId);
            $this->_template->options = $this->_model->getOrderUpdateOptions();
            if (filter_has_var(INPUT_POST, 'updateOrder')) {
                $this->checkToken();
                $response = $this->_model->updateOrder($orderId);
                if ($response == 'success') {
                    $this->_registry->getObject('session')->flash('message', '<p class="success">Order status was successfully updated.</p>');
                    $this->_registry->redirectTo('admin/orders/view/' . $orderId);
                } else {
                    $this->_template->token = $this->_registry->getObject('security')->generateToken();
                    $this->displayFormErrors();
                    $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.updateorder.php', 'admin.footer.php');
                }
            } else {
                $this->_template->token = $this->_registry->getObject('security')->generateToken();
                $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.updateorder.php', 'admin.footer.php');
            }
        }
        
        /*
         * - sets template variables for view overview of all user orders
         * - template variables are used in admin.customerorders.php
         * @param int $userId
         */
        private function viewOrdersByCustomer($userId) {
            $this->_template->title = 'Customer Orders';
            $this->_template->orders = $this->_registry->getModel('account')->ordersInfo($userId);
            $this->_template->userId = $userId;
            $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.customerorders.php', 'admin.footer.php');
        }
    }
