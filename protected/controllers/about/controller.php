<?php
    require_once('protected/controllers/Controller.php');
    
    class AboutController extends Controller {
        
        /*
         * object constructor
         * @param $registry - an object instance of type Registry
         */
        public function __construct(Registry $registry) {
            parent::__construct($registry);
            $this->_session->put('url', $_SERVER['REQUEST_URI']);
            $this->_template->title = 'About Us';
            $this->_template->buildFromTemplates('header.php', 'sidebar.php', 'main.about.php', 'footer.php');
        }
    }