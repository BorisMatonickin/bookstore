<?php
    require_once('protected/admin/controllers/BaseController.php');
    
    class AuthorsController extends BaseController {       
        /*
         * object constructor - checks URL bits and loads appropriate method
         * @param $registry - an object instance of type Registry
         */
        public function __construct(Registry $registry) {
            parent::__construct($registry, 'A_Authors');
            $this->_template->authorTitles = ['Authors', 'New Author', 'Author Details', 'Update Author'];
            if (isset($this->_urlBits[1]) && $this->_urlBits[1] == 'authors') {
                if (isset($this->_urlBits[2]) && $this->_urlBits[2] == 'create') {
                    $this->createNewAuthor();
                } elseif (isset($this->_urlBits[2]) && isset($this->_urlBits[3])) {
                    $authorId = filter_var($this->_urlBits[3], FILTER_VALIDATE_INT);
                    switch($this->_urlBits[2]) {
                        case 'view':
                            $this->viewAuthor($authorId);
                            break;
                        case 'update':
                            $this->updateAuthor($authorId);
                            break;
                        default:
                            $this->showAuthors();
                            break;
                    }
                } else {
                    $this->showAuthors();
                }    
            } else {
                $this->_registry->redirectTo();
            }
        }
        
        /*
         * - shows main authors table
         * - template variables are used in admin.authors.php
         */
        private function showAuthors() {
            $this->_template->title = 'Authors';
            $authors = $this->_model->getAllAuthors();
            $this->_template->numbersOfPages = $this->_registry->getObject('paginator')->paginate($authors, 8, 2);
            $this->_template->authors = $this->_registry->getObject('paginator')->displayPaginatedData();
            $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.authors.php', 'admin.footer.php');
        }
        
        /*
         * - handles creation of new author by calling methods form appropriate model
         * - template variables are used in admin.newauthor.php
         */
        private function createNewAuthor() {
            $this->_template->title = 'New Author';
            $this->_template->countries = $this->_registry->getModel('register')->selectCountries();
            if (filter_has_var(INPUT_POST, 'createAuthor')) {
                $this->checkToken();
                $response = $this->_model->insertNewAuthor();
                if ($response == 'success') {
                    $this->_registry->getObject('session')->flash('message', '<p class="success">Author was successfully added.</p>');
                    $this->_registry->redirectTo('admin/authors');
                } else {
                    $this->_template->token = $this->_registry->getObject('security')->generateToken();
                    $this->displayFormErrors();
                    $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.newauthor.php', 'admin.footer.php');
                }
            } else {
                $this->_template->token = $this->_registry->getObject('security')->generateToken();
                $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.newauthor.php', 'admin.footer.php');
            }
        }
        
        /*
         * - sets template variables for choosen author details display
         * - variables are used in admin.author.php
         * @param int $authorId 
         */
        private function viewAuthor($authorId) {
            $this->_template->title = 'Author Details';
            $this->_template->authorInfo = $this->_model->getAuthorInfo($authorId);
            $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.author.php', 'admin.footer.php');
        }
        
        /*
         * - sets template variables for update author form
         * - variables are used in admin.updateauthor.php
         * @param int $authorId
         */
        private function updateAuthor($authorId) {
            $this->_template->title = 'Update Author';
            $this->_template->author = $this->_model->getAuthorInfo($authorId);
            $this->_template->countries = $this->_registry->getModel('register')->selectCountries();
            if (filter_has_var(INPUT_POST, 'updateAuthor')) {
                $this->checkToken();
                $response = $this->_model->updateAuthor($authorId);
                if ($response == 'success') {
                    $this->_registry->getObject('session')->flash('message', '<p class="success">Author was updated successfully.</p>');
                    $this->_registry->redirectTo('admin/authors/view/' . $authorId);
                } else {
                    $this->_template->token = $this->_registry->getObject('security')->generateToken();
                    $this->displayFormErrors();
                    $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.updateauthor.php', 'admin.footer.php');
                }
            } else {
                $this->_template->token = $this->_registry->getObject('security')->generateToken();
                $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.updateauthor.php', 'admin.footer.php');
            }
        }
    }