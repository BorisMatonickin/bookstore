<!DOCTYPE html>
<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
    <title><?php echo $title; ?></title>
    <base href="https://localhost/bookstore/" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="shortcut icon" href="public/css/images/favicon.ico" />
    <link rel="stylesheet" href="public/css/style.css" type="text/css" media="all" />
    <script type="text/javascript" src="public/js/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="public/js/jquery.jcarousel.min.js"></script>
    <script type="text/javascript" src="public/js/functions.js"></script>
    <!--[if IE 6]>
            <script type="text/javascript" src="js/png-fix.js"></script>
    <![endif]-->
</head>
<body>
<!-- *************************************************************** header ******************************************************************************** -->
<div id="header" class="shell">
    <div id="logo"><h1><a href="">BestSeller</a></h1><span><a href="http://css-free-templates.com/">free css template</a></span></div>
    <!-- Navigation -->
    <div id="navigation">
        <ul>
            <li><a href="" <?php if ($title == 'Book Store') { ?>class="active"<?php } ?>>Home</a></li>
            <li><a href="products" <?php if ($title == 'Products') { ?>class="active"<?php } ?>>Products</a></li>
            <li><a href="authors" <?php if ($title == 'Authors') { ?>class="active"<?php } ?>>Authors</a></li>
            <?php if (isset($loggedIn) && $loggedIn == true) { ?> 
            <li><a href="account/info"<?php if (isset($accountTitles)) {
                if (in_array($title, $accountTitles)) { ?>class="active"<?php } } ?>>Account</a></li>
            <li><a href="authenticate/logout">Logout</a></li>   
            <?php } else { ?>
            <li><a href="authenticate/login" <?php if ($title == 'Login') { ?>class="active"<?php } ?>>Login</a></li>
            <li><a href="registration/register" <?php if ($title == 'Register') { ?>class="active"<?php } ?>>Register</a></li>
            <?php } ?>
            <li><a href="about" <?php if ($title == 'About Us') { ?>class="active"<?php } ?>>About Us</a></li>
            <li><a href="contact"<?php if ($title == 'Contact Us') { ?>class="active"<?php } ?>>Contact Us</a></li>
        </ul>
    </div>
    <div class="cl">&nbsp;</div>
    <!-- Login-details -->
    <div id="login-details">
        <p>Welcome, <?php if (isset($username)) { ?> 
        <a href="account/info" id="user"><?php echo $username;
        } else { ?>
        <a href="authenticate/login" id="user"> Guest
        <?php } ?>    
        </a>.</p><p><a href="basket/view" class="cart" ><img src="public/css/images/cart-icon.png" alt="" /></a>Shopping Cart (<?php echo $itemsNumber; ?>) 
            <a href="basket/view" class="sum">$<?php echo $total; ?></a></p>
        <?php if (isset($isAdmin) && $isAdmin === true) : ?>
            <a href="admin/main" class="back-button store-area">Admin Area</a>
        <?php endif; ?>
    </div>
</div>
<!-- ********************************************************************* new releases slider ************************************************************ -->
<div id="slider">
        <div class="shell">
            <ul>
                <?php foreach ($newProducts as $id => $book) : ?>
                <li>
                    <div class="image">
                        <img src="protected/uploads/product-images/<?php echo $book['image']; ?>" />
                    </div>
                    <div class="details">
                        <h3>New Releases</h3>
                        <p class="title"><?php echo $book['bookTitle']; ?></p>
                        <h4>by <?php echo $book['authorName']; ?></h4>
                        <p class="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent id odio in tortor scelerisque dictum. Phasellus varius sem sit amet metus volutpat vel vehicula nunc lacinia.</p>
                        <a href="products/view/<?php echo $urlProducts[$id]; ?>" class="read-more-btn">Read More</a>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
            <div class="nav">
                <a href="">1</a>
                <a href="">2</a>
                <a href="">3</a>
                <a href="">4</a>
            </div>
        </div>
    </div>
<!-- ***************************************************************** main ******************************************************************************* -->
    <div id="main" class="shell">