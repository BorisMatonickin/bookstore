<!-- ************************************************************** order info table ************************************************************************ -->
<?php if (isset($flashMessage)) { echo $flashMessage; } ?>
<fieldset>
    <legend><?php echo 'Order Nr. ' . $order['order_id']; ?></legend>
    <table class="user-info admin-info">
        <tr>
            <td>Customer Name:</td>
            <td><?php echo $order['delivery_name']; ?></td>
        </tr>
        <tr>
            <td>Address:</td>
            <td><?php echo $order['delivery_address']; ?></td>
        </tr>
        <tr>
            <td>City:</td>
            <td><?php echo $order['delivery_city']; ?></td>
        </tr>
        <tr>
            <td>State:</td>
            <td><?php echo ($order['delivery_state'] == null ? '-' : $order['delivery_state']); ?></td>
        </tr>
        <tr>
            <td>Country:</td>
            <td><?php echo $order['delivery_country']; ?></td>
        </tr>
        <tr>
            <td>Zip:</td>
            <td><?php echo $order['delivery_zip']; ?></td>
        </tr>
        <tr>
            <td>Subtotal:</td>
            <td><?php echo $order['subtotal']; ?></td>
        </tr>
        <tr>
            <td>Discount:</td>
            <td><?php echo ($order['discount'] == null ? '-' : $order['discount']); ?></td>
        </tr>
        <tr>
            <td>Discount Code:</td>
            <td><?php echo ($order['voucher_code'] == null ? '-' : $order['voucher_code']); ?></td>
        </tr>
        <tr>
            <td>Total:</td>
            <td><?php echo $order['total']; ?></td>
        </tr>
        <tr>
            <td>Order Status:</td>
            <td><?php echo $order['orderStatus']; ?></td>
        </tr>
        <tr>
            <td>Order Date:</td>
            <td><?php echo $order['orderDate']; ?></td>
        </tr>
    </table>
</fieldset>
<a href="admin/orders/">&#8656; Back to Orders</a>
<a href="admin/orders/update/<?php echo $order['order_id']; ?>" class="update-btn">Update</a>
