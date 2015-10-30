<!-- ******************************************************************** update order form ******************************************************************* -->
<div id="page" class="order-shell">
    <h1>Update Order</h1>
    <form action="" method="post">
        <fieldset>
            <p><input type="hidden" name="token" id="token" value="<?php echo $token; ?>"></p>
            
            <p><label>Order Status:<strong><?php if (isset($errors['order_status'])) { echo $errors['order_status']; } ?></strong></label>
            <select name="order_status">
                <?php foreach ($options as $id => $option) : ?>
                <option value="<?php echo $id; ?>"
                <?php if ($id == $order['status_id']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
                <?php endforeach; ?>
            </select></p>
            
            <p><label>&nbsp;</label>
            <input type="submit" name="updateOrder" id="updateOrder" value="Update" class="submit-btn"/></p>
        </fieldset>
    </form>
</div>
<a href="admin/orders/view/<?php echo $order['order_id']; ?>">&#8656; Back to Order</a>

