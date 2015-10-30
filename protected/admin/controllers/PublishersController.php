<?php
    require_once('protected/admin/controllers/BaseController.php');
    
    class PublishersController extends BaseController {       
        /*
         * object constructor - checks URL bits and loads appropriate method
         * @param $registry - an object instance of type Registry
         */
        public function __construct(Registry $registry) {
            parent::__construct($registry, 'A_Publishers');
            $this->_template->publisherTitles = ['Publishers', 'New Publisher', 'Publisher Details', 'Update Publisher'];
            if (isset($this->_urlBits[1]) && $this->_urlBits[1] == 'publishers') {
                if (isset($this->_urlBits[2]) && $this->_urlBits[2] == 'create') {
                    $this->createNewPublisher();
                } elseif (isset($this->_urlBits[2]) && isset($this->_urlBits[3])) {
                    $publisherId = filter_var($this->_urlBits[3], FILTER_VALIDATE_INT);
                    switch($this->_urlBits[2]) {
                        case 'view':
                            $this->viewPublisher($publisherId);
                            break;
                        case 'update':
                            $this->updatePublisher($publisherId);
                            break;
                        default:
                            $this->showAuthors();
                            break;
                    }
                } else {
                    $this->showPublishers();
                }        
            } else {
                $this->_registry->redirectTo();
            }
        }
        
        /*
         * - prepare template variables for displaying publisher info
         * - variables are used in admin.publishers.php
         */
        private function showPublishers() {
            $this->_template->title = 'Publishers';
            $publishers = $this->_model->getAllPublishers();
            $this->_template->numbersOfPages = $this->_registry->getObject('paginator')->paginate($publishers, 8, 2);
            $this->_template->publishers = $this->_registry->getObject('paginator')->displayPaginatedData();
            $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.publishers.php', 'admin.footer.php');
        }
        
        /*
         * - handles inserting new publisher into database, calls methods from appropriate model
         * - template variables are used in admin.newpublisher.php 
         */
        private function createNewPublisher() {
            $this->_template->title = 'New Publisher';
            $this->_template->countries = $this->_registry->getModel('register')->selectCountries();
            if (filter_has_var(INPUT_POST, 'createPublisher')) {
                $this->checkToken();
                $response = $this->_model->insertNewPublisher();
                if ($response == 'success') {
                    $this->_registry->getObject('session')->flash('message', '<p class="success">Publisher was successfully added</p>');
                    $this->_registry->redirectTo('admin/publishers');
                } else {
                    $this->_template->token = $this->_registry->getObject('security')->generateToken();
                    $this->displayFormErrors();
                    $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.newpublisher.php', 'admin.footer.php');
                }
            } else {
                $this->_template->token = $this->_registry->getObject('security')->generateToken();
                $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.newpublisher.php', 'admin.footer.php');
            }
        }
        
        /*
         * - sets template variables for display choosen publisher info
         * - variables are used in admin.publisher.php
         * @param int $publisherId
         */
        private function viewPublisher($publisherId) {
            $this->_template->title = 'Publisher Details';
            $this->_template->publisher = $this->_model->getPublisherInfo($publisherId);
            $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.publisher.php', 'admin.footer.php');
        }
        
        /*
         * - sets template variables for displaying choosen publisher info
         * - variables are used in admin.updatepublisher.php
         * @param int $publisherId
         */
        private function updatePublisher($publisherId) {
            $this->_template->title = 'Update Publisher';
            $this->_template->publisher = $this->_model->getPublisherInfo($publisherId);
            $this->_template->countries = $this->_registry->getModel('register')->selectCountries();
            if (filter_has_var(INPUT_POST, 'updatePublisher')) {
                $this->checkToken();
                $response = $this->_model->updatePublisher($publisherId);
                if ($response == 'success') {
                    $this->_registry->getObject('session')->flash('message', '<p class="success">Publisher was successfully updated.</p>');
                    $this->_registry->redirectTo('admin/publishers/view/' . $publisherId);
                } else {
                    $this->_template->token = $this->_registry->getObject('security')->generateToken();
                    $this->displayFormErrors();
                    $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.updatepublisher.php', 'admin.footer.php');
                }
            } else {
                $this->_template->token = $this->_registry->getObject('security')->generateToken();
                $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.updatepublisher.php', 'admin.footer.php');
            }
        }
    }