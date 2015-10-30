<?php
    require_once('protected/admin/controllers/BaseController.php');
    
    class SettingsController extends BaseController {
        /*
         * object constructor - checks URL bits and loads appropriate method
         * @param $registry - an object instance of type Registry
         */
        public function __construct(Registry $registry) {
            parent::__construct($registry, 'A_Settings');
            $this->_template->settingTitles = ['Settings', 'New Discount', 'Discount Details', 'Update Discount'];
            if (isset($this->_urlBits[1]) && $this->_urlBits[1] == 'settings') {
                if (isset($this->_urlBits[2]) && $this->_urlBits[2] == 'create-discount') {
                    $this->createNewDiscount();
                } elseif (isset($this->_urlBits[2]) && isset($this->_urlBits[3])) {
                    $discountId = filter_var($this->_urlBits[3], FILTER_VALIDATE_INT);
                    switch($this->_urlBits[2]) {
                        case 'view-discount':
                            $this->viewDiscount($discountId);
                            break;
                        case 'update-discount':
                            $this->updateDiscount($discountId);
                            break;
                        default:
                            $this->showSettings();
                            break;
                    }
                } else {
                    $this->showSettings();
                }
            } else {
                $this->registry->redirectTo();
            }
        }
        
        /*
         * - sets template variables for discount codes table info
         * - variables are used in admin.settings.php
         */
        private function showSettings() {
            $this->_template->title = 'Settings';
            $vouchers = $this->_model->getVouchersInfo();
            $this->_template->numbersOfPages = $this->_registry->getObject('paginator')->paginate($vouchers, 8, 2);
            $this->_template->vouchers = $this->_registry->getObject('paginator')->displayPaginatedData();
            $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.settings.php', 'admin.footer.php');
        }
        
        /*
         * - creates new discount code 
         * - template variables are used in admin.newdiscount.php
         */
        private function createNewDiscount() {
            $this->_template->title = 'New Discount';
            if (filter_has_var(INPUT_POST, 'createDiscount')) {
                $this->checkToken();
                $response = $this->_model->insertNewDiscount();
                if ($response == 'success') {
                    $this->_registry->getObject('session')->flash('message', '<p class="success">Discount code was successfully added.</p>');
                    $this->_registry->redirectTo('admin/settings');
                } else {
                    $this->_template->token = $this->_registry->getObject('security')->generateToken();
                    $this->displayFormErrors();
                    $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.newdiscount.php', 'admin.footer.php');
                }
            } else {
                $this->_template->token = $this->_registry->getObject('security')->generateToken();
                $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.newdiscount.php', 'admin.footer.php');
            }
        }
        
        /*
         * - sets template variables for diplaying discount code info
         * - variables are used in admin.discount.php
         * @param int $discountId
         */
        private function viewDiscount($discountId) {
            $this->_template->title = 'Discount Details';
            $this->_template->discount = $this->_model->getDiscountInfo($discountId);
            $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.discount.php', 'admin.footer.php');
        }
        
        /*
         * - sets template variables for update discount code form
         * - variables are used in admin.updatediscount.php
         * @param int $discountId
         */
        private function updateDiscount($discountId) {
            $this->_template->title = 'Update Discount';
            $this->_template->discount = $this->_model->getDiscountInfo($discountId);
            if (filter_has_var(INPUT_POST, 'updateDiscount')) {
                $this->checkToken();
                $response = $this->_model->updateDiscount($discountId);
                if ($response == 'success') {
                    $this->_registry->getObject('session')->flash('message', '<p class="success">Discount code was updated successfully.</p>');
                    $this->_registry->redirectTo('admin/settings/view-discount/' . $discountId);
                } else {
                    $this->_template->token = $this->_registry->getObject('security')->generateToken();
                    $this->displayFormErrors();
                    $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.updatediscount.php', 'admin.footer.php');
                }
            } else {
                $this->_template->token = $this->_registry->getObject('security')->generateToken();
                $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.updatediscount.php', 'admin.footer.php');
            }
        }
    }
