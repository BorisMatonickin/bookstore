<!-- ***************************************************** account wish list section ************************************************************************** -->
<?php if (isset($flashMessage)) { echo $flashMessage; } ?>
<?php foreach ($wishListProducts as $product) : ?>
<div class="element-list">
    <a href="products/view/<?php echo $urlProducts[$product['bookId']]; ?>"><img src="protected/uploads/product-images/<?php echo $product['image']; ?>" alt="" width="50" height="66" /></a>
    <div class="author-info">
        <a href="products/view/<?php echo $urlProducts[$product['bookId']]; ?>"><?php echo $product['bookTitle']; ?></a>
        <br />by <a href="authors/<?php echo $urlAuthors[$product['authorId']]; ?>"><?php echo $product['authorName']; ?></a>
        <br />Published: <?php echo $product ['datePublished']; ?> by <?php echo $product['publisherName']; ?>
        <br />Format: <?php echo $product['format']; ?>
        <div class="add-basket-small">
            <a href="account/wish-list/move-to-basket/<?php echo $product['bookId']; ?>/<?php echo $product['wishId']; ?>">Move To Cart</a>
            <a href="account/wish-list/remove/<?php echo $product['wishId']; ?>"><span class="remove-wish"><img src="public/css/images/trash.png" alt="X" title="Remove" /></span></a>
        </div>
    </div>
</div>
<?php endforeach;

