<!-- *************************************************************** list of books from category ************************************************************ -->
<fieldset>
<?php foreach($books as $id => $book) : ?>
    <div class="element-list">
        <a href="admin/products/view/<?php echo $book['book_id']; ?>"><img src="protected/uploads/product-images/<?php echo $book['image']; ?>" alt="" width="50" height="66" /></a>
        <div class="author-info">
            <a href="admin/products/view/<?php echo $book['book_id']; ?>"><?php echo $book['bookTitle']; ?></a>
            <br />by <?php echo $book['authorName']; ?>
            <br />Published: <?php echo $book['datePublished']; ?> by <?php echo $book['publisherName']; ?>
            <br /><span class="stars"><?php echo $book['averageRating']; ?></span> &nbsp; <?php echo $book['averageRating']; ?> - average rating
        </div>
    </div>
<?php endforeach; ?>
</fieldset>
<a href="admin/categories/">&#8656; Back to Categories</a>