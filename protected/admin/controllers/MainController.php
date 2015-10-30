<?php
    require_once('protected/admin/controllers/BaseController.php');
    
    class MainController extends BaseController {       
        /*
         * reviews object reference
         */
        private $_reviews;
        
        /*
         * object constructor - checks URL bits and loads appropriate method
         * @param $registry - an object instance of type Registry
         */
        public function __construct(Registry $registry) {
            parent::__construct($registry, 'A_Orders');
            require_once('protected/admin/models/A_Reviews.php');
            $this->_reviews = new A_Reviews($registry);
            if (isset($this->_urlBits[1]) && $this->_urlBits[1] == 'main') {
                $this->main();
            } else {
                $this->_registry->redirectTo();
            }
        }
        
        /*
         * - calls default administration area home page
         * - template variables are used in admin.main.php
         */
        private function main() {
            $this->_template->title = 'Admin';
            $this->_template->orders = $this->_model->getLatestOrders();
            $this->_template->reviews = $this->_reviews->getLatestReviews();
            $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.main.php', 'admin.footer.php');
        }
    }