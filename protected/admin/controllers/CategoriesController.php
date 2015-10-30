<?php
    require_once('protected/admin/controllers/BaseController.php');
    
    class CategoriesController extends BaseController {
        /*
         * object constructor - checks URL bits and loads appropriate method
         * @param $registry - an object instance of type Registry
         */
        public function __construct(Registry $registry) {
            parent::__construct($registry, 'A_Categories');
            $this->_template->categoryTitles = ['Categories', 'Category Details', 'Update Category', 'New Category', 'List of Books'];
            if (isset($this->_urlBits[1]) && $this->_urlBits[1] == 'categories') {
                if (isset($this->_urlBits[2]) && $this->_urlBits[2] == 'create') {
                    $this->createNewCategory();
                } elseif (isset($this->_urlBits[2]) && isset($this->_urlBits[3])) {
                    $catId = filter_var($this->_urlBits[3], FILTER_VALIDATE_INT);
                    switch($this->_urlBits[2]) {
                        case 'view':
                            $this->viewCategory($catId);
                            break;
                        case 'update':
                            $this->updateCategory($catId);
                            break;
                        case 'category-books':
                            $this->viewCategoryBooks($catId);
                            break;
                        default:
                            $this->showCategories();
                            break;
                    }
                } else {
                    $this->showCategories();
                }
            } else {
                $this->_registry->redirectTo();
            }
        }
        
        /*
         * calls default administration area home page
         */
        private function showCategories() {
            $this->_template->title = 'Categories';
            $categories = $this->_model->getAllCategories();
            $this->_template->numbersOfPages = $this->_registry->getObject('paginator')->paginate($categories, 10, 2);
            $this->_template->categories = $this->_registry->getObject('paginator')->displayPaginatedData();
            $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.categories.php', 'admin.footer.php');
        }
        
        /*
         * - handles creating new category by calling methods from appropriate model
         * - template variables are used in admin.newcategory.php
         */
        private function createNewCategory() {
            $this->_template->title = 'New Category';
            if (filter_has_var(INPUT_POST, 'createCategory')) {
                $this->checkToken();
                $response = $this->_model->insertNewCategory();
                if ($response == 'success') {
                    $this->_registry->getObject('session')->flash('message', '<p class="success">Category was successfully added.</p>');
                    $this->_registry->redirectTo('admin/categories');
                } else {
                    $this->_template->token = $this->_registry->getObject('security')->generateToken();
                    $this->displayFormErrors();
                    $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.newcategory.php', 'admin.footer.php');
                }
            } else {
                $this->_template->token = $this->_registry->getObject('security')->generateToken();
                $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.newcategory.php', 'admin.footer.php');
            }
        }
        
        /*
         * - sets template variables for choosen category info
         * - variables are used in admin.category.php
         * @param int $catId - id of the category
         */
        private function viewCategory($catId) {
            $this->_template->title = 'Category Details';
            $this->_template->categoryInfo = $this->_model->getCategoryInfo($catId);
            $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.category.php', 'admin.footer.php');
        }
        
        /*
         * - sets template variables for displaying books inside choosen category
         * - variables are used in admin.categorybooks.php
         * @param int $catId - id of the category
         */
        private function viewCategoryBooks($catId) {
            $this->_template->title = 'List of Books';
            $this->_template->books = $this->_model->getCategoryBooks($catId);
            $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.categorybooks.php', 'admin.footer.php');
        }
        
        /*
         * - handles updating categories by calling methods from appropriate model
         * - template variables are used in admin.updatecategory.php
         * @param int $categoryId
         */
        private function updateCategory($categoryId) {
            $this->_template->title = 'Update Category';
            $this->_template->category = $this->_model->getCategoryInfo($categoryId);
            if (filter_has_var(INPUT_POST, 'updateCategory')) {
                $this->checkToken();
                $response = $this->_model->updateCategory($categoryId);
                if ($response == 'success') {
                    $this->_registry->getObject('session')->flash('message', '<p class="success">Category was successfully updated.</p>');
                    $this->_registry->redirectTo('admin/categories/view/' . $categoryId);
                } else {
                    $this->_template->token = $this->_registry->getObject('security')->generateToken();
                    $this->displayFormErrors();
                    $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.updatecategory.php', 'admin.footer.php');
                }
            } else {
                $this->_template->token = $this->_registry->getObject('security')->generateToken();
                $this->_template->buildFromAdminTemplates('admin.header.php', 'admin.updatecategory.php', 'admin.footer.php');
            }
        }
    }    
