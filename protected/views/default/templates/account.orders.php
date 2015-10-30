<!-- ************************************************************* list of user orders *********************************************************************** -->
<table class="user-info orders">
    <thead>
        <tr>
            <th>Date</th>
            <th>Order Nr.</th>
            <th>Status</th>
            <th>Total</th>
            <th>Options</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($userOrders as $id => $order) : ?>
        <tr>
            <td><?php echo $order['dateOrdered']; ?></td>
            <td><?php echo $order['order_id']; ?></td>
            <td class="order-status"><?php echo $order['orderStatus']; ?></td>
            <td><?php echo $order['total']; ?></td>
            <td class="order-options"><a href="account/my-orders/view/<?php echo $id; ?>">View Order</a>
                                      <a href="">View Invoice</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>