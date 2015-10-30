<?php
    require_once('protected/controllers/Controller.php');
    
    class MainController extends Controller {
        
        /*
         * - object constructor
         * - default constructor
         * - template variables are used in: main.php
         * @param $registry - an object instance of type Registry
         */
        public function __construct(Registry $registry) {
            parent::__construct($registry);
            if (isset($this->_urlBits[0]) && $this->_urlBits[0] == 'add-product' && isset($this->_urlBits[1]) && filter_var($this->_urlBits[1], FILTER_VALIDATE_INT)) {
                $this->addProductFromIndex($this->_urlBits[1], 1);
            }
            $this->_template->title = 'Book Store';
            $this->_template->products = $this->_registry->getModel('products')->selectProductsForIndex();
            $this->_template->mostPopularProducts = $this->_registry->getModel('products')->selectMostPopularProducts();
            $this->_template->buildFromTemplates('header.php', 'sidebar.php', 'main.php', 'footer.php');
        }
        
        /*
         * adds product to the basket from main index page, first checks if basket is checked
         * @param int $productId
         * @param int $quantity
         */
        private function addProductFromIndex($productId, $quantity = 1) {
            if (!$this->_registry->getModel('basket')->isChecked() == true) {
                $this->_registry->getModel('basket')->checkBasket();
            }
            // calling addProduct method from basket model and make note of the response it returns
            $response = $this->_registry->getModel('basket')->addProduct($productId, $quantity);
            if ($response == 'success') {
                $this->_session->flash('message', '<p class="stock success">The product has been added to your basket.</p>');
                $this->_registry->redirectTo();
            } elseif ($response == 'stock') {
                $this->_session->flash('message', '<p class="stock">Product is currently out of stock!</p>');
                $this->_registry->redirectTo();
            } elseif ($response == 'noproduct') {
                $this->_session->flash('message', '<p class="stock">Product not found.</p>');
                $this->_registry->redirectTo();
            }
        }
    }