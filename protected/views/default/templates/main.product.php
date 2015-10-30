<!-- **************************************************************** product info with rating *********************************************************************** -->
<h3><?php echo $product; ?></h3>
<h4>by 
    <?php foreach($authors as $id => $author) :?>
    <a href="authors/<?php echo $urlAuthors[$id]; ?>" class="selector"><?php echo $author; ?></a>
    <?php endforeach; ?>
</h4>

<!-- rating info -->
<span class="stars"><?php echo $productInfo[$productId]['averageRating']; ?></span>
<?php if($productInfo[$productId]['averageRating'] == NULL) { ?>
    <p class="rating-info">This book has not yet been rated. You can be the first to pass the judgment.</p>
<?php } else { ?>
    <p class="rating-info"><?php echo $productInfo[$productId]['averageRating']; ?> - average rating, 
        rated by <?php echo $productInfo[$productId]['usersRated']; echo $productInfo[$productId]['usersRated'] > 1 ? ' users' : ' user'; ?> </p>
<?php } ?>
<div class="cl">&nbsp;</div>

<!-- product info  -->
<p>Categories:
    <?php foreach($categories as $id => $category) : ?> 
    <a href="categories/<?php echo $urlCategories[$id]; ?>" class="selector"><?php echo $category; ?></a>
    <?php endforeach; ?>
</p>
        
<p><?php echo $productInfo[$productId]['description']; ?></p>

<!-- other formats of product
<h4>Other Formats</h4> -->

<!-- ******************************************************** product reviews ****************************************************************************** -->
<h3>Costumer Reviews</h3>
<h4>Most Recent Customer Reviews:</h4>
<?php if (isset($reviewMessage)) { echo $reviewMessage; } ?>
    <a <?php if (isset($loggedIn) && $loggedIn == true) { ?>
        href="products/review/<?php echo $urlProducts[$productId]; ?>"
        <?php } else { ?>
        href="authenticate/login"
        <?php } ?> class="review-btn">
        <span class="review-btn-text">Write a customer review</span>
    </a>

<?php foreach ($reviewsInfo as $review => $info) : ?>
<div class="review-element">
    <?php if ($info['totalReviewRating'] != 0) { ?>
        <p><?php echo $info['isHelpful']; ?> of <?php echo $info['totalReviewRating']; ?> people find this review helpful</p>
    <?php } ?>
    <span class="stars review-stars"><?php echo $info['rating']; ?></span><p class="rating-info title"><?php echo $info['title']; ?></p>
    <div class="cl">&nbsp;</div>
    <p class="review-author">By <span><?php echo $info['userName']; ?></span> on <?php echo $info['dateReviewed']; ?></p>
    <p>Format: <?php echo $info['format']; ?></p>
    <p class="review-text"><?php echo $info['review']; ?></p>

    <!-- rating of reviews -->
    <?php if ($reviewId == $review) { ?>
    <?php if (isset($reviewHelpful)) { echo $reviewHelpful; } ?>
    <?php } else { ?>
    <p class="helpful-quest">Was this review helpful to you?</p>
    <div class="helpful-quest-btn">
        <form action="products/review-rating/<?php echo $review; ?>" method="post">
            <input type="hidden" name="reviewId" value="<?php echo $review; ?>" />
            <input type="submit" name="helpful" value="Yes" class="helpful-btn" />
            <input type="submit" name="helpful" value="No" class="helpful-btn" />
        </form>
    </div>
    <div class="cl">&nbsp;</div>
    <?php } ?>
</div>
<?php endforeach; ?>
<div class="cl">&nbsp;</div>
<p><a href="products">&#8656; Back to products</a></p>