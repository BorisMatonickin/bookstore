<!-- ******************************************************** product info with rating ******************************************************************** -->
<div id="sidebar">
    <!-- book info -->
    <img src="protected/uploads/product-images/<?php echo $productInfo[$productId]['image']; ?>" alt="" width="190" height="250" />
    <p>Format: <?php echo $productInfo[$productId]['format']; ?></p>
    <p>Published: <?php echo $productInfo[$productId]['datePublished']; ?> <br />
       by <?php echo $productInfo[$productId]['publisherName']; ?></p>
    <p>ISBN: <?php echo $productInfo[$productId]['isbn']; ?></p>
    <p>ISBN13: <?php echo $productInfo[$productId]['isbn13']; ?></p>
    <?php if (isset($productInfo[$productId]['series'])) { ?>
    <p>Part of series: <?php echo $productInfo[$productId]['series']; ?></p>
    <?php } ?>
    
    <!-- rating info -->
    <h4>Your rating:</h4>
    <?php if (isset($isRated) && $isRated == false) { ?>
    <div class="rating">
        <form method="post" action="rating" id="rating_form">
            <span><input type="radio" name="rating" id="str5" value="5"><label for="str5"></label></span>
            <span><input type="radio" name="rating" id="str4" value="4"><label for="str4"></label></span>
            <span><input type="radio" name="rating" id="str3" value="3"><label for="str3"></label></span>
            <span><input type="radio" name="rating" id="str2" value="2"><label for="str2"></label></span>
            <span><input type="radio" name="rating" id="str1" value="1"><label for="str1"></label></span>
            <input type="hidden" name="bookId" id="bookId" value="<?php echo $productInfo[$productId]['book_id']; ?>" />
            <?php if(isset($rateMessage)) { echo $rateMessage; } ?>
            <input type="submit" name="rate" value="Rate!" class="rate-btn"/>
        </form>
    </div>
    <?php } else { ?>
        <span class="stars"><?php echo $rating['rating']; ?></span>
        <?php if(isset($rateMessage)) { echo $rateMessage; } ?>
    <?php } ?>
    <!-- space for flash message -->    
    <?php if (isset($flashMessage)) { echo $flashMessage; } ?>
    
    
<!-- ************************************************** wish list and add to cart buttons ************************************************************* -->
    <?php if($productInfo[$productId]['stock'] == 0) { ?>
        <p class="stock">Product is currently out of stock!</p>    
        <a <?php if (isset($loggedIn) && $loggedIn = true) { ?> 
            href="account/wish-list/add/<?php echo $productId; ?>" 
            <?php } else { ?>
            href="authenticate/login"
            <?php } ?> class="wish-btn">
            <span class="wish-sidebar-text">Add To Wish List</span>
            <span class="wish-sidebar-image"><span></span></span>
        </a>
    <?php } else {?>    
        <a class="buybtn-sidebar" href="basket/add-product/<?php echo $productId; ?>">
            <span class="buybtn-sidebar-text">Add To Cart</span>
            <span class="buybtn-sidebar-hidden-text">$<?php echo $productInfo[$productId]['price']; ?></span>
            <span class="buybtn-sidebar-image"><span></span></span>
        </a>
        <a <?php if (isset($loggedIn) && $loggedIn = true) { ?> 
            href="account/wish-list/add/<?php echo $productId; ?>" 
            <?php } else { ?>
            href="authenticate/login"
            <?php } ?> class="wish-btn">
            <span class="wish-sidebar-text">Add To Wish List</span>
            <span class="wish-sidebar-image"><span></span></span>
        </a>
    <?php } ?> 
    
<!-- ******************************************************* similar products box ************************************************************************* -->
    <h4>Similar Books</h4>
    <ul class="similar">
        <?php foreach ($similarProducts as $product) : ?>
        <li><a href="products/view/<?php echo $urlProducts[$product['book_id']]; ?>">
                <img src="protected/uploads/product-images/<?php echo $product['image']; ?>" alt="" 
                title="<?php echo $product['title']; ?> by <?php echo $product['authorName']; ?>" width="55" height="80" /></a></li>
        <?php endforeach; ?>
    </ul>
</div>

<!-- ****************************************************** main page content ***************************************************************************** -->
<div id="content">
