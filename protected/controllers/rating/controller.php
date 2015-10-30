<?php
    require_once('protected/controllers/Controller.php');
    
    class RatingController extends Controller {  
        
        /*
         * object constructor
         * @param $registry - an object instance of type Registry
         */
        public function __construct(Registry $registry) {
            parent::__construct($registry, 'rating');
            $this->_registry->checkVarInSession('productPage', 'products');
            if (filter_has_var(INPUT_POST, 'rate')) {
                if (isset($_POST['rating']) && filter_var($_POST['rating'], FILTER_VALIDATE_INT, ['min_range' => 1, 'max_range' => 5]) && 
                    isset($_POST['bookId']) && filter_var($_POST['bookId'], FILTER_VALIDATE_INT)) {
                    $productId = $_POST['bookId'];
                    $rating = $_POST['rating'];
                    $this->saveRating($productId, $rating);
                } else {
                    $this->_registry->redirectToProduct();
                }  
            } else {
                $this->_registry->redirectToProduct();
            }
        }
        
        /*
         * saves users rating of the product
         * @param int $productId
         * @param int $rating
         */
        private function saveRating($productId, $rating) {
            if ($this->_model->checkRating($productId) == false) {
                $saved = $this->_model->saveRating($productId, $rating);
                if ($saved == 'success') {
                    $this->_session->flash('rate', '<p class="stock success">Thank you for rating!</p>');
                    $this->_registry->redirectToProduct();
                } else {
                    $this->_session->flash('rate', '<p classs="stock">Product is not rated!</p>');
                    $this->_registry->redirectToProduct();
                }
            } else {
                $this->_session->flash('rate', '<p class="stock">Book already rated!</p>');
                $this->_registry->redirectToProduct();
            }
        }
    }
