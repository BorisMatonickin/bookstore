<?php
    require_once('protected/controllers/Controller.php');
    
    class ProductsController extends Controller {
        
        /*
         * review model reference
         */
        protected $_review;
        
        /*
         * - object constructor
         *    navigates the user to view product, review or review rating page based on url
         * - if url parameters are not valid list of products is displayed by default
         * @param $registry - an object instance of type Registry
         */
        public function __construct(Registry $registry) {
            parent::__construct($registry, 'products');
            $this->_review = $this->_registry->getModel('review');
            // url for products is constructed with product name and product id so these two needs to be separated for further usage
            $productWithId = isset($this->_urlBits[2]) ? filter_var(str_replace('-', ' ', $this->_urlBits[2]), FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES) : '';
            // removes number from string and also remove whitespace from the beginning of the string
            $product = ltrim(preg_replace('/[0-9]+/', '', $productWithId));
            $productId = preg_replace('/[^0-9]/','',$productWithId);
            if (isset($this->_urlBits[1]) && isset($this->_urlBits[2])) {
                switch ($this->_urlBits[1]) {
                    case 'view':
                        $this->displayProductInfo($productId);
                        break;
                    case 'review':
                        $this->processReview($productId);
                        break;
                    case 'review-rating':
                        $this->reviewRating(filter_var($this->_urlBits[2], FILTER_VALIDATE_INT));
                        break;
                    default:
                        $this->displayListOfProducts();
                }
            } else {
                $this->displayListOfProducts();
            }
        }
        
        /*
         * - displays main list of products
         * - template variables are used in: main.products.php
         */
        private function displayListOfProducts() {
            $this->_session->put('url', $_SERVER['REQUEST_URI']);
            $this->_template->title = 'Products';
            $products = $this->_model->selectAllProducts();
            $this->_template->numbersOfPages = $this->_paginator->paginate($products, 8);
            $this->_template->paginatedProducts = $this->_paginator->displayPaginatedData();
            $this->_template->buildFromTemplates('header.php', 'sidebar.php', 'main.products.php', 'footer.php');
        }
        
        /*
         * - displays main page for selected product with product details, product ratings, review info, list of similar products
         * - sets variables for template to check if user is already rated the product, reviewed the product or 
         *     reviewed the reviews as helpful or not
         * - template variables are used in: sidebar.product.php, main.product.php
         * @param string $product
         */
        private function displayProductInfo($productId) {
            $this->_session->put('productPage', $_SERVER['REQUEST_URI']);
            $this->_session->put('url', $_SERVER['REQUEST_URI']);
            // pulled from session if user is succesfully redirected from review-rating page (deleted from session after usage)
            $this->_template->reviewId = ($this->_session->exists('reviewId')) ? $this->_session->get('reviewId') : '';
            $productInfo = $this->_template->productInfo = $this->_model->productInfo($productId);
            $this->_session->delete('reviewId');
            $this->_template->title = $productInfo[$productId]['bookTitle'];
            $this->_template->product = $productInfo[$productId]['bookTitle'];
            // makes associative array with author id as index and author name as value
            $this->_template->authors = $this->_template->stringsToArray($productInfo[$productId]['authorId'], $productInfo[$productId]['authorName']);
            // makes associative array with category id as index and category name as value
            $cat = $this->_template->categories = $this->_template->stringsToArray($productInfo[$productId]['categoryId'], $productInfo[$productId]['categories']);
            $this->_template->similarProducts = $this->_model->getSimilarProducts(array_values($cat)[0], $productId);
            $this->_template->productId = $productInfo[$productId]['book_id'];
            $this->_template->isRated = $this->_registry->getModel('rating')->checkRating($productInfo[$productId]['book_id']);
            $this->_template->rating = $this->_registry->getModel('rating')->getRating();
            $this->_template->reviewsInfo = $this->_review->reviewInfo($productInfo[$productId]['book_id']);
            $this->_template->buildFromTemplates('header.php', 'sidebar.product.php', 'main.product.php', 'footer.php');
        }
        
        /*
         * - process the review system, csrf protection with token included in form processing
         * - after successfull validation process the review is saved and the user is redirected 
         *    back to product page
         * - review is also waiting for approval from admin 
         * @param int $productId
         */
        private function processReview($productId) {
            $this->_registry->getModel('authenticate')->redirectInvalidUser();
            $this->_registry->checkVarInSession('productPage', 'products');
            $this->_template->title = 'Review Book';
            $this->_template->product = $this->_review->getBookForReviewSidebar($productId);
            $this->checkIfReviewed($productId);
            if (filter_has_var(INPUT_POST, 'submitReview')) {
                $token = filter_var($_POST['token'], FILTER_SANITIZE_STRING);
                $this->_security->checkCsrfToken($token);
                $userId = $this->_registry->getModel('authenticate')->getUserId();
                $this->_review->saveReview($productId, $userId);
                if ($this->_review->isReviewSaved() == true) {
                    $this->_session->flash('review', '<p class="stock success">Thank you for reviewing this product. It will be approved in no time!</p>');
                    $this->_security->deleteTokenFromSession();
                    $this->_registry->redirectToProduct();
                } else {
                    $this->_template->token = $this->_security->generateToken();
                    $this->_template->captcha = $this->_security->createCaptcha();
                    $this->displayFormErrors('_review');
                    $this->_template->buildFromTemplates('header.php', 'sidebar.review.php', 'main.review.php', 'footer.php');
                }
            } else {
                $this->_template->token = $this->_security->generateToken();
                $this->_template->captcha = $this->_security->createCaptcha();
                $this->_template->buildFromTemplates('header.php', 'sidebar.review.php', 'main.review.php', 'footer.php');
            }   
        }
        
        /*
         * checks if user have already rated the product
         * @param int $productId
         */
        private function checkIfReviewed($productId) {
            if ($this->_review->checkIfReviewed($productId) == true) {
                $this->_session->flash('review', '<p class="stock">Product already reviewed!</p>');
                $this->_registry->redirectToProduct();
            }
        }
        
        /*
         * - allows user to choose if displayed review was helpful or not, allowed only to logged users 
         *    and just on time per review
         * - it is processed on review-rating page and after that the user is redirected back to product 
         *    page with appropriate message
         * @param int $userId
         * @param int $reviewId
         */
        private function reviewRating($reviewId) {
            $this->_registry->checkVarInSession('productPage', 'products');
            if (isset($_POST['helpful'])) {
                $helpfulValue = filter_var($_POST['helpful'], FILTER_SANITIZE_STRING);
                if ($this->_registry->getModel('authenticate')->isLoggedIn() == true) {
                    $this->_session->put('reviewId', $reviewId);
                    $helpful = ($helpfulValue == 'Yes') ? 1 : 0;
                    $userId = $this->_registry->getModel('authenticate')->getUserId();
                    if ($this->_review->checkReviewRating($userId, $reviewId) == false) {
                        $this->_review->saveReviewRating($userId, $reviewId, $helpful);
                        $this->_session->flash('reviewHelpful', '<p class="stock success">Thank you for feedback!</p>');
                        $this->_registry->redirectToProduct();
                    } else {
                        $this->_session->flash('reviewHelpful', '<p class="stock">Already Rated!</p>');
                        $this->_registry->redirectToProduct();
                    }
                } else {
                    $this->_registry->redirectTo('authenticate/login');
                }
            }
        }
    }