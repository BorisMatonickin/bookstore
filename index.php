<?php
    ob_start();
    session_set_cookie_params(0, '/', '', true, true);
    session_start();
    
    // the application root path
    defined('BASE_URI') ? NULL : define('BASE_URI', dirname(__FILE__) . "\\");
    
    require_once('protected/registry/Registry.php');
    $registry = new Registry();
    // setup core registry objects and settings
    $registry->createAndStoreObject('Template', 'template');
    $registry->createAndStoreObject('Mysqldb', 'db');
    $registry->createAndStoreObject('UrlProcessor', 'url');
    $registry->createAndStoreObject('Security', 'security');
    $registry->createAndStoreObject('Session', 'session');
    $registry->createAndStoreObject('Email', 'mailout');
    $registry->createAndStoreObject('Paginator', 'paginator');
    $registry->createAndStoreModel('Authenticate', 'authenticate');
    $registry->createAndStoreModel('Registration', 'register');
    $registry->createAndStoreModel('Products', 'products');
    $registry->createAndStoreModel('Categories', 'categories');
    $registry->createAndStoreModel('Authors', 'authors');
    $registry->createAndStoreModel('Basket', 'basket');
    $registry->createAndStoreModel('User', 'user');
    $registry->createAndStoreModel('Account', 'account');
    $registry->createAndStoreModel('Rating', 'rating');
    $registry->createAndStoreModel('Review', 'review');
    $registry->createAndStoreModel('Checkout', 'checkout');
    $registry->createAndStoreModel('UploadFiles', 'upload');
    $registry->getObject('url')->getURLData();
    
    $registry->storeSetting('default', 'view');
    $registry->storeSetting('template', 'template');
    $registry->storeSetting('authentication', 'authenticate');
    $registry->storeSetting('Book Store', 'sitename');
    $registry->storeSetting('https://', 'protocol');
    $registry->storeSetting($registry->getSetting('protocol') . 'localhost/bookstore/', 'siteurl');
    
    include('protected/config/config.php');
    // create database connection
    $registry->getObject('db')->newConnection(DB_SERVER, DB_NAME, DB_USER, DB_PASS);
    
    // process authentication
    $registry->getModel('authenticate')->checkForAuthentication();
    if ($registry->getModel('authenticate')->isLoggedIn() === true) {
        $registry->getObject('template')->username = $registry->getObject('session')->get('firstName');
        $registry->getObject('template')->loggedIn = $registry->getModel('authenticate')->isLoggedIn();
    }

    // loads list of categories for sidebar menu
    // limits display on 12 categories randomly ordered
    $registry->getObject('template')->sidebarCategories = $registry->getModel('categories')->categoriesForSidebar();
    
    // loads list of authors for sidebar menu
    // limit display on 12 authors randomly ordered
    $registry->getObject('template')->sidebarAuthors = $registry->getModel('authors')->authorsForSidebar();
    
    // loads 4 new released products for main header slider
    $registry->getObject('template')->newProducts = $registry->getModel('products')->selectNewReleases();
    
    // loads list of categories for making SEO URL with hyphens
    $categories = $registry->getModel('categories')->selectCategoriesForUrl();
    $registry->getObject('template')->urlCategories = $registry->getObject('url')->makeUrlFromData($categories, 'category');
    
    // loads list of authors for making SEO URL with hyphens
    $authors = $registry->getModel('authors')->selectAuthorsForUrl();
    $registry->getObject('template')->urlAuthors = $registry->getObject('url')->makeUrlFromData($authors, 'authorName');
    
    // loads list of products for making SEO URL with hyphens
    $products = $registry->getModel('products')->selectProductsForUrl();
    $registry->getObject('template')->urlProducts = $registry->getObject('url')->makeUrlFromMultipleData($products, ['book_id', 'title']);
    
    // checking if flash messages exists
    $registry->getObject('template')->flashMessage = $registry->getObject('session')->checkFlashMessage('message');
    $registry->getObject('template')->rateMessage = $registry->getObject('session')->checkFlashMessage('rate');
    $registry->getObject('template')->reviewMessage = $registry->getObject('session')->checkFlashMessage('review');
    $registry->getObject('template')->voucherNotice = $registry->getObject('session')->checkFlashMessage('voucherNotice');
    $registry->getObject('template')->reviewHelpful = $registry->getObject('session')->checkFlashMessage('reviewHelpful');
    
    // dealing with small basket in the header
    if ($registry->getModel('basket')->isChecked() == false) {
        $registry->getModel('basket')->checkBasket();
    }
    if ($registry->getModel('basket')->isEmpty() == false) {
            $registry->getObject('template')->itemsNumber = $registry->getModel('basket')->getNumProducts();
            $registry->getObject('template')->total = $registry->getModel('basket')->getTotal();
        } else {
            $registry->getObject('template')->itemsNumber = 0;
            $registry->getObject('template')->total = 0.00;
    }

    // load controllers
    $controller = $registry->getObject('url')->getURLBit(0);
    $adminController = $registry->getObject('url')->getURLBit(1);
    if ($controller == 'admin') {
        $registry->loadAdminController($registry, $adminController);
    } else {
        $registry->loadController($registry, $controller);
    } 