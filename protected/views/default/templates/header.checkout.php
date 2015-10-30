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
    <!-- ******************************************************* header for checkout ********************************************************************** -->
    <div id="header" class="shell">
        <div id="logo"><h1><a href="">BestSeller</a></h1><span><a href="http://css-free-templates.com/">free css template</a></span></div>
        <div class="cl">&nbsp;</div>
        <!-- Login-details -->
        <div id="login-details">
            <h4>Welcome <?php if (isset($username)) { echo $username; }?>.</h4>
        </div>
    </div>
    <!-- ******************************************************* main ************************************************************************************* -->
    <div id="main" class="shell">