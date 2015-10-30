<?php
    require_once('protected/admin/controllers/BaseController.php');
    
    class CustomersController extends BaseController {                
        /*
         * object constructor - checks URL bits and loads appropriate method
         * @param $registry - an object instance of type Registry
         */
        public function __construct(Registry $registry) {
            parent::__construct($registry, 'A_Customers');
            $this->_template->userTitles = ['Customers', 'Customer Details', 'Update Customer'];
            if (isset($this->_urlBits[1]) && $this->_urlBits[1] == 'customers') {
                if (isset($this->_urlBits[2]) && isset($this->_urlBits[3])) {
                    $userId = filter_var($this->_urlBits[3], FILTER_VALIDATE_INT);
                    switch($this->_urlBits[2]) {
                        case 'view':
                            $this->viewUser($userId);
                            break;
                        case 'update':
                            $this->updateUser($userId);
                            break;
                        default:
                            $this->showCustomers();
                            break;
                    }
                } else {
                    $this->showCustomers();
                }
            } else {
                $this->_registry->redirectTo();
            }
        }
        
        /*
         * - sets variables for displaying customers info
         * - template variables are used in admin.customers.php
         */
        private function showCustomers() {
            $this->_template->title = 'Customers';
            $customers = $this->_model->getAllCustomers();
            $this->_template->numbersOfPages = $this->_registry->getObject('paginator')->paginate($customers, 8, 2);
            $this->_template->customers = $this->_registry->getObject('paginator')->displayPaginatedData();
            $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.customers.php', 'admin.footer.php');
        }
        
        /*
         * - sets template variables for displaying user info 
         * - variables are used in admin.customer.php
         * @param int $userId
         */
        private function viewUser($userId) {
            $this->_template->title = 'Customer Details';
            $this->_template->customer = $this->_model->getUserInfo($userId);
            $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.customer.php', 'admin.footer.php');
        }
        
        /*
         * - sets template variables for update user form
         * - variables are used in admin.updateuser.php
         * @param int $userId
         */
        private function updateUser($userId) {
            $this->_template->title = 'Update Customer';
            $user = $this->_template->user = $this->_model->getUserInfo($userId);
            $this->_template->countries = $this->_registry->getModel('register')->selectCountries();
            $this->_template->states = $this->_registry->getModel('register')->selectStates();
            if (filter_has_var(INPUT_POST, 'updateUser')) {
                $this->checkToken();
                $response = $this->_model->updateUser($userId);
                if ($response == 'success') {
                    $email = $this->_model->getSanitizedValue('email');
                    if (isset($email)) {
                        $fullName = $user['first_name'] . ' ' . $user['last_name'];
                        $activationCode = $this->_model->getActivationCode();
                        $this->_registry->getObject('security')->deleteTokenFromSession();
                        $this->_registry->getObject('mailout')->sendMailOnEmailUpdate($userId, $fullName, $email, $activationCode);
                    } else {
                        $this->_registry->getObject('session')->flash('message', '<p class="success">User account info was successfully updated.</p>');
                        $this->_registry->redirectTo('admin/customers/view/' . $userId);
                    }
                } else {
                    $this->_template->token = $this->_registry->getObject('security')->generateToken();
                    $this->displayFormErrors();
                    $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.updateuser.php', 'admin.footer.php');
                }
            } else {
                $this->_template->token = $this->_registry->getObject('security')->generateToken();
                $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.updateuser.php', 'admin.footer.php');
            }
        }
    }
