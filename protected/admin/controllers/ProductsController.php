<?php
    require_once('protected/admin/controllers/BaseController.php');
    
    class ProductsController extends BaseController {
        /*
         * object constructor - checks URL bits and loads appropriate method
         * @param $registry - an object instance of type Registry
         */
        public function __construct(Registry $registry) {
            parent::__construct($registry, 'A_Products');
            $this->_template->productTitles = ['Products', 'New Product', 'Product Details', 'Update Book'];
            if (isset($this->_urlBits[1]) && $this->_urlBits[1] == 'products') {
                if (isset($this->_urlBits[2]) && $this->_urlBits[2] == 'create') {
                    $this->createNewProduct();
                } elseif (isset($this->_urlBits[2]) && isset($this->_urlBits[3])) {
                    $productId = filter_var($this->_urlBits[3], FILTER_VALIDATE_INT);
                    switch($this->_urlBits[2]) {
                        case 'view':
                            $this->viewProduct($productId);
                            break;
                        case 'update':
                            $this->updateProduct($productId);
                            break;
                        default:
                            $this->showProducts();
                            break;
                    }
                } else {
                    $this->showProducts();
                }
            } else {
                $this->_registry->redirectTo();
            }
        }
        
        /*
         * - displays all products
         * - template variables are used in admin.products.php
         */
        private function showProducts() {
            $this->_template->title = 'Products';
            $products = $this->_model->getAllProducts();
            $this->_template->numbersOfPages = $this->_registry->getObject('paginator')->paginate($products, 6, 2);
            $this->_template->products = $this->_registry->getObject('paginator')->displayPaginatedData();
            $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.products.php', 'admin.footer.php');
        }
        
        /*
         * - handles creating new product by calling methods form appropriate model
         * - product can be inserted, but if intermediate tables are not populated an error 
         *    notification is thrown to the user
         * - template variables are used in admin.newproduct.php
         */
        private function createNewProduct() {
            $this->_template->title = 'New Product';
            $this->_template->publishers = $this->_model->selectPublisher();
            $this->_template->formats = $this->_model->selectFormat();
            if (filter_has_var(INPUT_POST, 'create')) {
                $this->checkToken();
                $response = $this->_model->insertNewProduct();
                if ($response == 'success') {
                    $this->_registry->getObject('session')->flash('message', '<p class="success">Product was successfully added.</p>');
                    $this->_registry->redirectTo('admin/products');
                } elseif ($response == 'junction-failure') {
                    $this->_registry->getObject('session')->flash('message', '<p class="stock">Product was successfully added but is not viewable '
                            . 'due to a system error. Please contact webmaster.');
                    $this->_registry->redirectTo('admin/products');
                } else {
                    $this->_template->token = $this->_registry->getObject('security')->generateToken();
                    $this->displayFormErrors();
                    $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.newproduct.php', 'admin.footer.php');
                }
            } else {
                $this->_template->token = $this->_registry->getObject('security')->generateToken();
                $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.newproduct.php', 'admin.footer.php');
            }
        }
        
        /*
         * - sets template variable for viewing choosen product info 
         * - variables are used in admin.product.php
         * @param int $productId
         */
        private function viewProduct($productId) {
            $this->_template->title = 'Product Details';
            $this->_template->productInfo = $this->_model->getProductInfo($productId);
            $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.product.php', 'admin.footer.php');
        }
        
        /*
         * - handles updating the product by calling methods from appropriate model
         * - template variables are used in admin.updateproduct.php
         * @param int $productId
         */
        private function updateProduct($productId) {
            $this->_template->title = 'Update Book';
            $this->_template->productInfo = $this->_model->getProductInfo($productId);
            $this->_template->publishers = $this->_model->selectPublisher();
            $this->_template->formats = $this->_model->selectFormat();
            if (filter_has_var(INPUT_POST, 'updateProduct')) {
                $this->checkToken();
                $response = $this->_model->updateProduct($productId);
                if ($response == 'success') {
                    $this->_registry->getObject('session')->flash('message', '<p class="success">Product was updated successfully.</p>');
                    $this->_registry->redirectTo('admin/products/view/' . $productId);
                } else {
                    $this->_template->token = $this->_registry->getObject('security')->generateToken();
                    $this->displayFormErrors();
                    $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.updateproduct.php', 'admin.footer.php');
                }
            } else {
                $this->_template->token = $this->_registry->getObject('security')->generateToken();
                $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.updateproduct.php', 'admin.footer.php');
            }
        }
    }
