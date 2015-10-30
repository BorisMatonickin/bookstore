<?php
    require_once('protected/controllers/Controller.php');
    
    class BasketController extends Controller {
        
        /*
         * discount code notice for displaying to the user
         */
        public $voucherNotice;
        
        /*
         * object constructor
         * @param $registry - an object instance of type Registry
         */
        public function __construct(Registry $registry) {
            parent::__construct($registry, 'basket');
            $this->_template->title = 'Basket';
            $this->_model->checkBasket();
            if (!isset($this->_urlBits[1])) {
                $this->viewBasket();
            } else {
                switch($this->_urlBits[1]) {
                    case 'view':
                        $this->viewBasket();
                        break;
                    case 'add-product':
                        $this->addProduct($this->_urlBits[2], 1);
                        break;
                    case 'update':
                        $this->updateBasket();
                        break;
                    case 'remove-product':
                        $this->removeProduct(intval($this->_urlBits[2]));
                        break;
                    default:
                        $this->viewBasket();
                        break;
                }
            }
        }
        
        /*
         * detects if customer is trying to view the basket, gets the basket 
         *  contents from the model, caches the same and associate it with 
         *  template variables
         * builds the view from appropriate templates
         */
        private function viewBasket() {
            $this->_session->put('url', $_SERVER['REQUEST_URI']);
            $contents = $this->_model->getContents();
            $products = array();
            foreach ($contents as $reference => $data) {
                $products[$data['product']] = $data;
            }
            $this->_template->basketProducts = $products;
            // $this->_template->total = $this->_basket->getTotal();
            $this->_template->buildFromTemplates('header.php', 'sidebar.php', 'main.basket.php', 'footer.php');
        }
        
        /*
         * adds product to the basket, first checks if basket is checked
         * @param int $productId - the product id reference
         * @param int $quantity - the quantity of the product
         */
        private function addProduct($productId, $quantity = 1) {
            $this->_registry->checkVarInSession('productPage', 'products');
            if (!$this->_model->isChecked() == true) {
                $this->_model->checkBasket();
            }
            // calling addProduct method from basket model and make note of the response it returns
            $response = $this->_model->addProduct($productId, $quantity);
            if ($response == 'success') {
                $this->_session->flash('message', '<p class="stock success">The product has been added to your basket.</p>');
                $this->_registry->redirectToProduct();
            } elseif ($response == 'stock') {
                $this->_session->flash('message', '<p class="stock">Product is currently out of stock!</p>');
                $this->_registry->redirectToProduct();
            } elseif ($response == 'noproduct') {
                $this->_session->flash('message', '<p class="stock">Product not found.</p>');
                $this->_registry->redirectTo();
            }
        }
  
        /*
         * updates basket quantities
         */
        private function updateBasket() {
            if (filter_has_var(INPUT_POST, 'update')) {
                if (!$this->_model->isChecked() == true) {
                    $this->_model->checkBasket();
                }
                foreach($this->_model->getContents() as $productId => $data) {
                    // get the product rows basket ID
                    $basketId = $data['basket'];
                    if (intval($_POST['qty_' . $basketId]) == 0) {
                        $this->_model->removeProduct($basketId);
                    } else {
                        $this->_model->updateProductQuantity($basketId, intval($_POST['qty_' . $basketId]));
                    }
                }
                // redirecting the user to the basket view page, informing that changes have been saved
                $this->_session->flash('message', '<p class="stock success">Your shopping basket has been updated</p>');
                $this->_registry->redirectTo('basket/view');
            }
        }
        
        /*
         * removes product from the basket if user enters quantity 0 or choose remove button
         */
        private function removeProduct($basketId) {
            $this->_model->removeProduct($basketId);
            $this->_session->flash('message', '<p class="stock">The product has been removed from your basket</p>');
            $this->_registry->redirectTo('basket/view');
        }
    }
    