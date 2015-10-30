<!-- ********************************************************** author info with new book releases ********************************************************** -->
<h3><?php echo $author; ?></h3>
<p><?php echo $authorInfo[$author]['about']; ?></p>

<!-- new book releases with short info -->
<h4 class="books-heading">New Releases</h4>
<?php foreach ($booksOfAuthor as $book) : ?>
<div class="element-list">
    <a href="products/view/<?php echo $urlProducts[$book['bookId']]; ?>"><img src="protected/uploads/product-images/<?php echo $book['image']; ?>" alt="" width="50" height="66" /></a>
    <div class="author-info">
        <a href="products/view/<?php echo $urlProducts[$book['bookId']]; ?>"><?php echo $book['title']; ?></a>
        <br />Publisher: <?php echo $book['publisherName']; ?>
        <br />Date published: <?php echo $book['datePublished']; ?>
        <br /><span class="stars"><?php echo $book['averageRating']; ?></span> &nbsp; <?php echo $book['averageRating']; ?> - average rating
    </div>
</div>
<?php endforeach; ?>
<div class="cl">&nbsp;</div>
<a href="authors">&#8656; Back to authors</a>