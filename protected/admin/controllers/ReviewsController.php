<?php
    require_once('protected/admin/controllers/BaseController.php');
    
    class ReviewsController extends BaseController {
        /*
         * object constructor - checks URL bits and loads appropriate method
         * @param $registry - an object instance of type Registry
         */
        public function __construct(Registry $registry) {
            parent::__construct($registry, 'A_Reviews');
            $this->_template->reviewTitles = ['Reviews', 'Review Details', 'Update Review'];
            if (isset($this->_urlBits[1]) && $this->_urlBits[1] == 'reviews') {
                if (isset($this->_urlBits[2]) && isset($this->_urlBits[3])) {
                    $reviewId = filter_var($this->_urlBits[3], FILTER_VALIDATE_INT);
                    switch($this->_urlBits[2]) {
                        case 'view':
                            $this->viewReview($reviewId);
                            break;
                        case 'update':
                            $this->updateReview($reviewId);
                            break;
                        default:
                            $this->showReviews();
                            break;
                    }
                } else {
                    $this->showReviews();
                }    
            } else {
                $this->_registry->redirectTo();
            }
        }
        
        /*
         * - prepare template variables for displaying user reviews of the products
         * - template variables are used in admin.reviews.php
         */
        private function showReviews() {
            $this->_template->title = 'Reviews';
            $reviews = $this->_model->getAllReviews();
            $this->_template->numbersOfPages = $this->_registry->getObject('paginator')->paginate($reviews, 8, 2);
            $this->_template->reviews = $this->_registry->getObject('paginator')->displayPaginatedData();
            $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.reviews.php', 'admin.footer.php');
        }
        
        /*
         * - prepare template variables for displaying info about choosen review
         * - variables are used in admin.review.php
         * @param int $reviewId
         */
        private function viewReview($reviewId) {
            $this->_template->title = 'Review Details';
            $this->_template->review = $this->_model->getReviewInfo($reviewId);
            $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.review.php', 'admin.footer.php');
        }
        
        /*
         * - sets template variables for update review status form
         * - variables are used in admin.updatereview.php
         * @param int $reviewId
         */
        private function updateReview($reviewId) {
            $this->_template->title = 'Update Review';
            $this->_template->review = $this->_model->getReviewInfo($reviewId);
            if (filter_has_var(INPUT_POST, 'updateReview')) {
                $this->checkToken();
                $response = $this->_model->updateReview($reviewId);
                if ($response == 'success') {
                    $this->_registry->getObject('session')->flash('message', '<p class="success">Review status was updated successfully.</p>');
                    $this->_registry->redirectTo('admin/reviews/view/' . $reviewId);
                } else {
                    $this->_template->token = $this->_registry->getObject('security')->generateToken();
                    $this->displayFormErrors();
                    $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.updatereview.php', 'admin.footer.php');
                }
            } else {
                $this->_template->token = $this->_registry->getObject('security')->generateToken();
                $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.updatereview.php', 'admin.footer.php');
            }
        }
    }