<!-- *********************************************************** orders info ***************************************************************************** -->
<!-- table with orders info -->
<fieldset>
    <legend>Orders</legend>
    <table class="user-info orders">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Status</th>
                <th>Date Added</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $id => $order) : ?>
            <tr>
                <td><?php echo $order['order_id']; ?></td>
                <td><?php echo $order['delivery_name']; ?></td>
                <td class="order-status"><?php echo $order['status']; ?></td>
                <td><?php echo $order['dateOrdered']; ?></td>
                <td>$<?php echo $order['total']; ?></td>
                <td class="order-options">
                    <a href="admin/orders/view/<?php echo $order['order_id']; ?>">Order Details</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>

<!-- **************************************************** number of pages displayed for navigation ********************************************************* -->
<div class="pagination">
<?php foreach ($numbersOfPages as $num) : ?>
    <a href="admin/orders/<?php echo $num; ?>" class="page"><?php echo $num; ?></a>
<?php endforeach; ?>
</div>

