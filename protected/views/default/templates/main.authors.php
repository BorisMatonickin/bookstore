<!-- **************************************************** list of authors ********************************************************************************** -->
<h3>Authors</h3>
<?php foreach ($paginatedAuthors as $author) : ?>
        <?php $books = $author['booksNumber'] - 1; ?>
        <div class="element-list">
            <a href="authors/<?php echo $urlAuthors[$author['authorId']]; ?>"><img src="protected/uploads/author-images/<?php echo $author['image']; ?>" alt="" width="50" height="66" /></a>
            <div class="author-info">
                <a href="authors/<?php echo $urlAuthors[$author['authorId']]; ?>"><?php echo $author['authorName']; ?></a>
                <br />Author of 
                <a href="products/view/<?php echo $urlProducts[$author['bookId']]; ?>"><?php echo $author['bookTitle']; ?></a>
                <?php 
                    if (isset($books) && $books != 0) {
                        switch ($books) {
                            case $books == 1:
                                echo ' and <a href="authors/' . $urlAuthors[$author['authorId']] . '">' . $books . ' more book</a>';
                                break;
                            case $books > 1:
                                echo ' and <a href="authors/' . $urlAuthors[$author['authorId']] . '">' . $books . ' more books</a>';
                                break;
                        }
                    }
                ?>
                <br />Category: 
                <a href="categories/<?php echo $urlCategories[$author['cat_id']]; ?>"><?php echo $author['category']; ?></a>
                <br /><?php if ($author['totalReviews'] == null) { ?>
                    No member reviews <?php } else { ?>
                    Total member reviews: <?php echo $author['totalReviews']; ?>
                <?php } ?>
            </div>
            <div class="cl">&nbsp;</div>
        </div>
<?php endforeach; ?>

<!-- **************************************************** number of pages displayed for navigation ********************************************************* -->
<div class="pagination">
<?php foreach ($numbersOfPages as $num) : ?>
    <a href="authors/<?php echo $num; ?>" class="page"><?php echo $num; ?></a>
<?php endforeach; ?>
</div>