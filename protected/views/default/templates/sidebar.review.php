<!-- ************************************************************* sidebar for review form ******************************************************************* -->
<div id="sidebar">
    <img src="protected/uploads/product-images/<?php echo $product['image']; ?>" alt="" width="190" height="250" />
    <h4> <a href="products/view/<?php echo $urlProducts[$product['book_id']]; ?>"><?php echo $product['title']; ?></a></h4>
    <p>by <a href="authors/<?php echo $urlAuthors[$product['authorId']]; ?>"><?php echo $product['authorName']; ?></a></p>
</div>

<!-- *************************************************************** main page content ************************************************************************ -->
<div id="content">