<!-- ************************************************************* list of products *************************************************************************** -->
<h3>Products</h3>
<?php foreach($paginatedProducts as $product) : ?>
    <div class="element-list">
        <a href="products/view/<?php echo $urlProducts[$product['bookId']]; ?>"><img src="protected/uploads/product-images/<?php echo $product['image']; ?>" alt="" width="50" height="66" /></a>
        <div class="author-info">
            <a href="products/view/<?php echo $urlProducts[$product['bookId']]; ?>"><?php echo $product['bookTitle']; ?></a>
            <br />by <?php echo $product['authorName']; ?>
            <br />Published: <?php echo $product['datePublished']; ?> by <?php echo $product['publisherName']; ?>
            <br /><span class="stars"><?php echo $product['averageRating']; ?></span> &nbsp; <?php echo $product['averageRating']; ?> - average rating
        </div>
    </div>
<?php endforeach; ?>

<!-- ************************************************* number of pages displayed for pagination of list of products ****************************************** -->
<div class="pagination">
<?php foreach ($numbersOfPages as $num) : ?>
    <a href="products/<?php echo $num; ?>" class="page"><?php echo $num; ?></a>
<?php endforeach; ?>
</div>
