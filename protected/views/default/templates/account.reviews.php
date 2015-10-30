<!-- ******************************************************* user reviews info ****************************************************************************** -->
<?php foreach ($reviews as $review => $info) : ?>
<div class="review-element review-account">
    <h4>On <a href="products/view/<?php echo $urlProducts[$info['book_id']]; ?>"><?php echo $info['bookTitle']; ?></a> 
        By <?php echo $info['authorName']; ?></h4>
    <?php if ($info['totalReviewRating'] != 0) { ?>
        <p><?php echo $info['isHelpful'] ?> of <?php echo $info['totalReviewRating']; ?> people find this review helpful</p>
    <?php } ?>
    <span class="stars review-stars"><?php echo $info['rating']; ?></span><p class="rating-info title"><?php echo $info['title']; ?>
    <?php if ($info['approved'] == 0) { ?>
        <span class="approval">Pending admin approval!</span></p>
    <?php } ?>
    <div class="cl">&nbsp;</div>
    <p class="review-author">On <?php echo $info['dateReviewed']; ?></p>
    <p>Format: <?php echo $info['format']; ?></p>
    <p class="review-text"><?php echo $info['review']; ?></p>
</div>
<?php endforeach; ?>