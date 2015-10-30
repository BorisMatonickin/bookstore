<!-- *********************************************************** main admin page ***************************************************************************** -->
<!-- table with latest orders -->
<fieldset>
    <legend>Latest Orders</legend>
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

<!-- table with lates reviews -->
<fieldset class="review-table">
    <legend>Lates Reviews</legend>
    <table class="user-info orders">
        <thead>
            <tr>
                <th>Book</th>
                <th>Book Authors</th>
                <th>Review Author</th>
                <th>Status</th>
                <th>Date Reviewed</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reviews as $id => $review) : ?>
            <tr>
                <td><?php echo $review['title']; ?></td>
                <td><?php echo $review['bookAuthors']; ?></td>
                <td><?php echo $review['reviewAuthor']; ?></td>
                <?php if ($review['approved'] == 1) { ?>
                <td><img src="public/css/images/enabled.png" alt="" title="Approved" /></td>
                <?php } else { ?>
                <td><img src="public/css/images/disabled.png" alt="" title="Not Approved" /></td>
                <?php } ?>
                <td><?php echo $review['reviewDate']; ?></td>
                <td>
                    <a href="admin/reviews/view/<?php echo $review['review_id']; ?>">Review Details</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>    