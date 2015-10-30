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
    <!--[if IE 6]>
            <script type="text/javascript" src="js/png-fix.js"></script>
    <![endif]-->
    <script type="text/javascript" src="public/js/functions.js"></script>
</head>
<body>
    <!-- ******************************************************* header for admin area ********************************************************************** -->
    <div id="header" class="shell">
        <div id="logo"><h1><a href="">BestSeller</a></h1><span><a href="http://css-free-templates.com/">free css template</a></span></div>
        <h3 class="admin-header">Administration Area</h3>
        <!-- Navigation -->
        <div id="navigation">
            <ul>
                <li><a href="admin/main" <?php if ($title == 'Admin') { ?>class="active"<?php } ?>>Home</a></li>
                <li><a href="admin/products" <?php if (isset($productTitles) && in_array($title, $productTitles)) { ?>class="active"<?php } ?>>Products</a></li>
                <li><a href="admin/categories" <?php if (isset($categoryTitles) && in_array($title, $categoryTitles)) { ?>class="active"<?php } ?>>Categories</a></li>
                <li><a href="admin/authors" <?php if (isset($authorTitles) && in_array($title, $authorTitles)) { ?>class="active"<?php } ?>>Authors</a></li>
                <li><a href="admin/publishers" <?php if (isset($publisherTitles) && in_array($title, $publisherTitles)) { ?>class="active"<?php } ?>>Publishers</a></li>
                <li><a href="admin/customers" <?php if (isset($userTitles) && in_array($title, $userTitles)) { ?>class="active"<?php } ?>>Customers</a></li>
                <li><a href="admin/orders" <?php if (isset($orderTitles) && in_array($title, $orderTitles)) { ?>class="active"<?php } ?>>Orders</a></li>
                <li><a href="admin/reviews" <?php if (isset($reviewTitles) && in_array($title, $reviewTitles)) { ?>class="active"<?php } ?>>Reviews</a></li>
                <li><a href="admin/reports" <?php if ($title == 'Reports') { ?>class="active"<?php } ?>>Reports</a></li>
                <li><a href="admin/settings" <?php if (isset($settingTitles) && in_array($title, $settingTitles)) { ?>class="active"<?php } ?>>Settings</a></li>
            </ul>
        </div>
        <div class="cl">&nbsp;</div>
        <!-- Login-details -->
        <div id="login-details">
            <h4>Welcome <?php if (isset($username)) { echo $username; }?></h4>
            <a href="" class="back-button">Back To Site</a>
        </div>
    </div>
    <!-- ******************************************************* main ************************************************************************************* -->
    <div id="main" class="shell">
