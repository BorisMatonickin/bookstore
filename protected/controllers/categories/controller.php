<?php
    require_once('protected/controllers/Controller.php');
    
    class CategoriesController extends Controller {
        
        /*
         * - object constructor
         * - checks if category is set in URL, if it is then displays main info about category with books listed, 
         *    if it's not then list of categories is displayed by default
         * - template variables are used in: main.categories.php, main.category.php
         * @param $registry - an object instance of type Registry
         */
        public function __construct(Registry $registry) {
            parent::__construct($registry, 'categories');
            $this->_session->put('url', $_SERVER['REQUEST_URI']);
            $catArray = array();
            $categories = $this->_template->categories = $this->_model->listCategories();
            foreach ($categories as $array) {
                $catArray[] = $array['category'];
            }
            if (isset($this->_urlBits[1])) {
                $cat = filter_var(str_replace('-', ' ', $this->_urlBits[1]), FILTER_SANITIZE_STRING);
                if (in_array($cat, $catArray)) {
                    $this->_template->category = $cat;
                    $this->_template->books = $this->_model->listBooksFromCategory($cat);
                    $this->displayCategory();
                } else {
                   $this->displayCategories(); 
                }
            } else {
                $this->displayCategories();
            }
        }
        
        /*
         * displays template parts for selected category
         */
        private function displayCategory() {
            $this->_template->title = $this->_urlBits[1];
            $this->_template->buildFromTemplates('header.php', 'sidebar.php', 'main.category.php', 'footer.php');  
        }
        
        /*
         * displays template parts for list of categories
         */
        private function displayCategories() {
            $this->_template->title = 'Categories';
            $this->_template->buildFromTemplates('header.php', 'sidebar.php', 'main.categories.php', 'footer.php');
        }
    }

