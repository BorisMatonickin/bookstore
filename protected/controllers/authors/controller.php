<?php
    require_once('protected/controllers/Controller.php');
    
    class AuthorsController extends Controller {
        
        /*
         * - object constructor, paginates the list of authors (and books for 
         *    currently viewed author)
         * - check if author name is part of URL, if it's not displays lists of all authors by default, if it is then 
         *    displays main author page
         * - template variables are used in: sidebar.author.php, main.authors.php, main.author.php 
         * @param $registry - an object instance of type Registry
         */
        public function __construct(Registry $registry) {
            parent::__construct($registry, 'authors');
            $this->_session->put('url', $_SERVER['REQUEST_URI']);
            $namesOfAuthors = array();
            $authors = $this->_registry->getModel('authors')->listOfAuthors();
            $this->_template->numbersOfPages = $this->_paginator->paginate($authors, 6);
            $this->_template->paginatedAuthors = $this->_paginator->displayPaginatedData();
            foreach ($authors as $array) {
                $namesOfAuthors[] = $array['authorName'];
            }
            if (isset($this->_urlBits[1])) {
                $aut = filter_var(str_replace('-', ' ', $this->_urlBits[1]), FILTER_SANITIZE_STRING);
                if (in_array($aut, $namesOfAuthors)) {
                    $this->_template->title = $aut;
                    $this->_template->author = $aut;
                    $this->_template->authorInfo = $this->_registry->getModel('authors')->authorInfo($aut);
                    $this->_template->booksOfAuthor = $this->_registry->getModel('authors')->booksOfAuthor($aut);
                    $this->displayAuthorInfo();
                } else {
                    $this->displayListOfAuthors();
                }
            } else {
                $this->displayListOfAuthors();
            }
        }
        
        /*
         * displays template parts for list of authors 
         */
        private function displayListOfAuthors() {
            $this->_template->title = 'Authors';
            $this->_template->buildFromTemplates('header.php', 'sidebar.php', 'main.authors.php', 'footer.php');
        }
        
        /*
         * displays template parts for info about current selected author
         */
        private function displayAuthorInfo() {
            $this->_template->buildFromTemplates('header.php', 'sidebar.author.php', 'main.author.php', 'footer.php');
        }
    }