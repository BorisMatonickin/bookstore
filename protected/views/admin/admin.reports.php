<!-- ********************************************************** sales reports tables ************************************************************************** -->
<!-- products purchased table -->
<fieldset>
    <legend>Products Purchased</legend>
    <table class="user-info orders">
        <thead>
            <tr>
                <th>Book ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Orders</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $id => $product) : ?>
            <tr>
                <td><?php echo $product['book_id']; ?></td>
                <td><?php echo $product['title']; ?></td>
                <td><?php echo $product['authorName']; ?></td>
                <td><?php echo $product['orders']; ?></td>
                <td><?php echo $product['totalQuantity']; ?></td>
                <td><?php echo $product['totalAmount']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>

<!-- **************************************************** number of pages displayed for navigation ********************************************************* -->
<div class="pagination">
<?php foreach ($numbersOfPages as $num) : ?>
    <a href="admin/reports/<?php echo $num; ?>" class="page"><?php echo $num; ?></a>
<?php endforeach; ?>
</div>
