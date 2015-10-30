<?php
    require_once('protected/controllers/Controller.php');
    
    class AccountController extends Controller {
        
        /*
         * user id reference
         */
        private $_userId = 0;
        
        /*
         * - controller constructor
         * - checks URL and call appropriate method
         * - redirects invalid (not logged) user to main index page
         * - sets account titles array for account section used in template
         * @param object $registry - an object instance of type Registry
         */
        public function __construct(Registry $registry) {
            parent::__construct($registry, 'account');
            $this->_userId = $this->_registry->getModel('authenticate')->getUserId();
            $this->_registry->getModel('authenticate')->redirectInvalidUser();
            $this->_template->accountTitles = ['My Account', 'My Orders', 'Book Shelf', 'Wish List', 'My Favorites', 'My Reviews', 'Settings'];
            if (isset($this->_urlBits[1])) {
                switch($this->_urlBits[1]) {
                    case 'info':
                        $this->displayUserInfo();
                        break;
                    case 'my-orders':
                        if (isset($this->_urlBits[2]) && isset($this->_urlBits[3])) {
                            switch($this->_urlBits[2]) {
                                case 'view':
                                    $this->viewOrder(filter_var($this->_urlBits[3], FILTER_VALIDATE_INT));
                                    break;
                                case 'invoice':
                                    break;
                                default:
                                    $this->userOrders($this->_userId);
                                    break;
                            }
                        } else {
                            $this->userOrders($this->_userId);
                        }
                        break;
                    case 'wish-list':
                        if (isset($this->_urlBits[2])) {
                            switch($this->_urlBits[2]) {
                                case 'add':
                                    $this->addProductToWishList(filter_var($this->_urlBits[3], FILTER_VALIDATE_INT));
                                    break;
                                case 'remove':
                                    $this->removeProductFromWishList(filter_var($this->_urlBits[3], FILTER_VALIDATE_INT));
                                    break;
                                case 'move-to-basket':
                                    $this->moveToBasket(filter_var($this->_urlBits[3], FILTER_VALIDATE_INT), 1, filter_var($this->_urlBits[4], FILTER_VALIDATE_INT));
                                    break;
                                default:
                                    $this->wishList();
                            }       
                        } else {
                            $this->wishList();
                        }
                        break;
                    case 'my-reviews':
                        $this->userReviews($this->_userId);
                        break;
                    case 'settings':
                        $this->accountSettings();
                        break;
                    case 'reset-password':
                        $this->resetPassword();
                        break;
                    default:
                        $this->displayUserInfo();
                }
            } else {
                $this->displayUserInfo();
            }    
        }
        
        /*
         * - displays users info on main account page
         * - template variables are used in: main.account.php
         */
        private function displayUserInfo() {
            $this->_template->title = 'My Account';
            $this->_template->username = $this->_session->get('firstName');
            $this->_template->userInfo = $this->_model->getUserInfo($this->_userId);
            $this->_template->buildFromTemplates('header.php', 'sidebar.php', 'account_nav.php', 'main.account.php', 'footer.php');
        }
        
        /*************************************************************************************************************************************************
         ***************************************************** wish list methods *************************************************************************
         *************************************************************************************************************************************************/
        
        /*
         * - displays wish list
         * - template variables are used in: main.wish.php
         */
        private function wishList() {
            $this->_template->title = 'Wish List';
            $this->_template->wishListProducts = $this->_model->wishListProducts($this->_userId);
            $this->_template->buildFromTemplates('header.php', 'sidebar.php', 'account_nav.php', 'main.wish.php', 'footer.php');
        }
        
        /*
         * inserts product on wish list if user is logged in, redirects user back to product page with appropriate 
         *   message about success or failure
         * @param int $productId
         */
        private function addProductToWishList($productId) {
            $this->_registry->checkVarInSession('productPage', 'products');
            $response = $this->_model->addProductToWishList($productId);
            if ($response == 'success') {
                $this->_session->flash('message', '<p class="stock success">Product added to your wish list</p>');
                $this->_registry->redirectToProduct();
            } elseif ($response == 'failure') {
                $this->_session->flash('message', '<p class="stock">Product was not added to your wish list</p>');
                $this->_registry->redirectToProduct();
            } elseif ($response == 'onlist') {
                $this->_session->flash('message', '<p class="stock">Product is already on your wish list</p>');
                $this->_registry->redirectToProduct();
            }
        }
        
        /*
         * removes product from wish list
         * @param int $wishId - id of wish
         */
        private function removeProductFromWishList($wishId) {
            $this->_model->removeProductFromWishList($wishId);
            $this->_session->flash('message', '<p class="stock">Product is removed from your wish list</p>');
            $this->_registry->redirectTo('account/wish-list');
        }
        
        /*
         * - moves product from wish list to shopping basket, displays appropriate message about success or failure
         * - if product is moved succesfully removes product from wishlists table
         * @param int $productId
         * @param int $quantity - set to 1 by default
         * @param int $wishId
         */
        public function moveToBasket($productId, $quantity, $wishId) {
            $response = $this->_registry->getModel('basket')->addProduct($productId, $quantity);
            if ($response == 'success') {
                $this->_model->removeProductFromWishList($wishId); 
                $this->_session->flash('message', '<p class="stock success">Product is moved to your shopping basket</p>');
                $this->_registry->redirectTo('account/wish-list');
            } elseif ($response == 'stock') {
                $this->_session->flash('message', '<p class="stock">Product is currently out of stock!</p>');
                $this->_registry->redirectTo('account/wish-list');
            } elseif ($response == 'noproduct') {
                $this->_session->flash('message', '<p class="stock">Product not found</p>');
                $this->_registry->redirectTo('account/wish-list');
            }
        }
        
        /************************************************************************************************************************************************
         ******************************************************** account settings methods **************************************************************
         ************************************************************************************************************************************************/
        
        /*
         * - handles user changing their account data, displays appropriate message about success or failure
         * - template variables are used in: account.settings.php
         */
        private function accountSettings() {
            $this->_registry->getModel('authenticate')->redirectInvalidUser();
            $this->_template->title = 'Settings';
            $this->_template->userInfo = $this->_model->getUserInfo($this->_session->get('authSessionUid'));
            $this->_template->countries = $this->_registry->getModel('register')->selectCountries();
            $this->_template->states = $this->_registry->getModel('register')->selectStates();
            if (filter_has_var(INPUT_POST, 'save')) {
                $token = filter_var($_POST['token'], FILTER_SANITIZE_STRING);
                $this->_security->checkCsrfToken($token);
                $response = $this->_model->updateUserChanges($this->_userId);
                if ($response == 'success') {
                    $this->_session->flash('message', '<p class="stock success">Your account has been updated.</p>');
                    $this->_registry->redirectTo('account/info');
                } elseif ($response == 'failure') {
                    $this->_template->token = $this->_security->generateToken();
                    $this->_template->settingsError = '<p class="error">Your account could not be updated.</p>';
                    $this->_template->errors = $this->_model->getErrors();
                    $this->_template->buildFromTemplates('header.php', 'sidebar.php', 'account_nav.php', 'account.settings.php', 'footer.php');
                }
            } else {
                $this->_template->token = $this->_security->generateToken();
                $this->_template->buildFromTemplates('header.php', 'sidebar.php', 'account_nav.php', 'account.settings.php', 'footer.php');
            }
        }
        
        /******************************************************************************************************************************************************
         *********************************************************** display user reviews methods ************************************************************* 
         ******************************************************************************************************************************************************/
        
        /*
         * - displays user reviews with info
         * - template variables are used in: account.reviews.php
         * @param int $userId
         */
        private function userReviews($userId) {
            $this->_template->title = 'My Reviews';
            $this->_template->reviews = $this->_model->userReviewsInfo($userId);
            $this->_template->buildFromTemplates('header.php', 'sidebar.php', 'account_nav.php', 'account.reviews.php', 'footer.php');
        }
        
        /******************************************************************************************************************************************************
         *********************************************************** display user orders methods **************************************************************
         ******************************************************************************************************************************************************/
        
        /*
         * - displays the history of user orders
         * - template variables are used in: account.orders.php
         * @param int $userId
         */
        private function userOrders($userId) {
            $this->_template->title = 'My Orders';
            $this->_template->userOrders = $this->_model->ordersInfo($userId);
            $this->_template->buildFromTemplates('header.php', 'sidebar.php', 'account_nav.php', 'account.orders.php', 'footer.php');
        }
        
        /*
         * - displays the details of user's choosen order
         * - template variables are used in: account.order.php
         * @param string $orderId
         */
        private function viewOrder($orderId) {
            $this->_template->title = 'View Order';
            $this->_template->order = $this->_model->orderDetails($orderId);
            $this->_template->books = $this->_model->orderBooksDetails($orderId);
            $this->_template->buildFromTemplates('header.php', 'sidebar.php', 'account_nav.php', 'account.order.php', 'footer.php');
        }
        
        /******************************************************************************************************************************************************
         ********************************************************** methods for changing password of registered user ******************************************
         ******************************************************************************************************************************************************/
        
        /*
         * resets user password, displays appropriate message about success or failure
         */
        private function resetPassword() {
            $this->_registry->getModel('authenticate')->redirectInvalidUser();
            $this->_template->title = 'Change Password';
            $email = ($this->_session->exists('email')) ? $this->_security->decryptData($this->_session->get('email')) : '';
            if (filter_has_var(INPUT_POST, 'resetPass')) {
                $token = filter_var($_POST['token'], FILTER_SANITIZE_STRING);
                $this->_security->checkCsrfToken($token);
                $response = $this->_registry->getModel('user')->changePassword($email);
                switch($response) {
                    case 'success':
                        $this->_session->flash('message', '<p class="stock success">Your password has been changed.</p>');
                        $this->_registry->redirectTo('account/info');
                        break;
                    case 'failure':
                        $this->_session->flash('message', '<p class="error">Your password could not be changed.</p>');
                        $this->_registry->redirectTo('account/info');
                        break;
                    case 'incorrect password':
                    case 'val errors':
                        $this->_template->token = $this->_security->generateToken();
                        $this->_template->changeError = '<p class="error">Please try again.</p>';
                        $this->_template->errors = $this->_registry->getModel('user')->getErrors();
                        $this->_template->missing = $this->_registry->getModel('user')->getMissingValues();
                        $this->_template->input = $this->_registry->getModel('user')->getSubmittedValues();
                        $this->_template->buildFromTemplates('header.php', 'sidebar.php', 'account.resetpass.php', 'footer.php');
                        break;
                }
            } else {
                $this->_template->token = $this->_security->generateToken();
                $this->_template->buildFromTemplates('header.php', 'sidebar.php', 'account.resetpass.php', 'footer.php');
            }   
        }
    }