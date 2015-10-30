<!-- **************************************************** category info with images of books inside viewed category ***************************************** -->
<div class="products-category">
    <h3><?php echo $category; ?></h3>
    <p><?php echo $categories[$category]['catDescription']; ?></p>
    <!-- books inside category with description for each book on hover over image -->
    <h4>New Releases</h4>
    <ul>
    <?php foreach ($books as $book) : ?>
        <li>
            <div class="product-category">
                <div class="hide-display">
                    <a href="products/view/<?php echo $urlProducts[$book['book_id']]; ?>">
                        <img src="protected/uploads/product-images/<?php echo $book['image']; ?>" alt="" width="106" height="161" /></a>
                    <span class="show-display-on-hover">
                        <h3><a href="products/view/<?php echo $urlProducts[$book['book_id']]; ?>"><?php echo $book['bookTitle']; ?></a></h3>
                        <span class="author">by, <a href="authors/<?php echo $urlAuthors[$book['authorId']]; ?>"><?php echo $book['authorName']; ?></a></span>
                        <span class="show-body-of-display-on-hover">
                            <p><?php echo $book['bookDescription']; ?></p>
                        </span>
                    </span>
                </div>    
            </div>
        </li>    
    <?php endforeach; ?>
    </ul>    
    <div class="cl">&nbsp;</div>
</div>
