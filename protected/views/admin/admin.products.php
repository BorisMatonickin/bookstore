<!-- ************************************************************** list of products ************************************************************************ -->
<!-- products info table -->
<?php if (isset($flashMessage)) { echo $flashMessage; } ?>
<fieldset>
    <legend>Products</legend>
    <table class="user-info orders">
        <thead>
            <tr>
                <th>Book ID</th>
                <th>Title</th>
                <th>Authors</th>
                <th>Format</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Publisher</th>
                <th>Date Published</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $id => $product) : ?>
            <tr>
                <td><?php echo $product['book_id']; ?></td>
                <td><?php echo $product['title']; ?></td>
                <td><?php echo $product['authorName']; ?></td>
                <td><?php echo $product['format']; ?></td>
                <td>$<?php echo $product['price']; ?></td>
                <td><?php echo $product['stock']; ?></td>
                <td><?php echo $product['publisherName']; ?></td>
                <td><?php echo $product['datePublished']; ?></td>
                <td>
                    <a href="admin/products/view/<?php echo $product['book_id']; ?>">Details</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>

<!-- **************************************************** number of pages displayed for navigation ********************************************************* -->
<div class="pagination">
<?php foreach ($numbersOfPages as $num) : ?>
    <a href="admin/products/<?php echo $num; ?>" class="page"><?php echo $num; ?></a>
<?php endforeach; ?>
</div>
<a href="admin/products/create" class="back-button add-button">Add New Product</a>