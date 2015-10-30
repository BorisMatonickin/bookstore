<?php
    require_once('protected/admin/controllers/BaseController.php');
    
    class ReportsController extends BaseController {
        /*
         * object constructor - checks URL bits and loads appropriate method
         * @param $registry - an object instance of type registry
         */
        public function __construct(Registry $registry) {
            parent::__construct($registry, 'A_Reports');
            if (isset($this->_urlBits[1]) && $this->_urlBits[1] == 'reports') {
                $this->showReports();
            } else {
                $this->registry->redirectTo();
            }
        }
        
        /*
         * - sets template variables for display sales reports
         * - variables are used in admin.reports.php
         */
        private function showReports() {
            $this->_template->title = 'Reports';
            $products = $this->_model->getPurchasedProducts();
            $this->_template->numbersOfPages = $this->_registry->getObject('paginator')->paginate($products, 8, 2);
            $this->_template->products = $this->_registry->getObject('paginator')->displayPaginatedData();
            $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.reports.php', 'admin.footer.php');
        }
    }
