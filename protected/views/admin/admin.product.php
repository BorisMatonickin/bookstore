<!-- **************************************************************** main info about product *************************************************************** -->
<?php if (isset($flashMessage)) { echo $flashMessage; } ?>
<fieldset>
    <legend><?php echo $productInfo['title']; ?></legend>
    <table class="user-info admin-info">
        <tr>
            <td>Book Title:</td>
            <td><?php echo $productInfo['title']; ?></td>
        </tr>
        <tr>
            <td>Authors:</td>
            <td><?php echo $productInfo['authorName']; ?></td>
        </tr>
        <tr>
            <td>Publisher:</td>
            <td><?php echo $productInfo['publisherName']; ?></td>
        </tr>
        <tr>
            <td>Date Published:</td>
            <td><?php echo $productInfo['datePublished']; ?></td>
        </tr>
        <tr>
            <td>ISBN:</td>
            <td><?php echo ($productInfo['isbn'] === null ? '-' : $productInfo['isbn']); ?></td>
        </tr>
        <tr>
            <td>ISBN13:</td>
            <td><?php echo ($productInfo['isbn13'] === null ? '-' : $productInfo['isbn13']); ?></td>
        </tr>
        <tr>
            <td>ASIN:</td>
            <td><?php echo ($productInfo['asin'] === null ? '-' : $productInfo['asin']); ?>
        </tr>
        <tr>
            <td>Price:</td>
            <td>$<?php echo $productInfo['price']; ?></td>
        </tr>
        <tr>
            <td>Stock:</td>
            <td><?php echo $productInfo['stock']; ?></td>
        </tr>
        <tr>
            <td>Format:</td>
            <td><?php echo $productInfo['format']; ?></td>
        </tr>
        <tr>
            <td>Edition:</td>
            <td><?php echo $productInfo['edition']; ?></td>
        </tr>
        <tr>
            <td>Series:</td>
            <td><?php echo ($productInfo['series'] === null ? '-' : $productInfo['series']); ?></td>
        </tr>
        <tr>
            <td>Categories:</td>
            <td><?php echo $productInfo['categories']; ?></td>
        </tr>
        <tr>
            <td>Date Created:</td>
            <td><?php echo $productInfo['dateCreated']; ?></td>
        </tr>
        <tr>
            <td class="upper-left">Image:</td>
            <td><img src="protected/uploads/product-images/<?php echo $productInfo['image']; ?>" alt="" /></td>
        </tr>
        <tr>
            <td class="upper-left">Description:</td>
            <td><?php echo $productInfo['description']; ?></td>
        </tr>
    </table>
</fieldset>
<a href="admin/products/">&#8656; Back to Products</a>
<a href="admin/products/update/<?php echo $productInfo['book_id']; ?>" class="update-btn">Update</a>
