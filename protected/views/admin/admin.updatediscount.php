<!-- *************************************************************** update discount code form *************************************************************** -->
<div id="page" class="order-shell">
    <h1>Update Discount Code</h1>
    <form action="" method="post">
        <fieldset>
            <p><input type="hidden" name="token" id="token" value="<?php echo $token; ?>"></p>
            
            <p><label>Discount Status:<strong><?php if (isset($errors['active'])) { echo $errors['active']; } ?></strong></label>
            <select name="active">
                <option value="1" <?php if ($discount['active'] == 1) { echo ' selected="selected"'; } ?>>Active</option>
                <option value="0" <?php if ($discount['active'] == 0) { echo ' selected="selected"'; } ?>>Not Active</option>
            </select></p>
            
            <p><label>Date Expires:<strong><?php if (isset($errors['expiry'])) { echo $errors['expiry']; } ?></strong></label>
            <input type="text" name="expiry" id="expiry" maxlength="60" value="" placeholder="YYYY-MM-DD" /></p>
            <small>Date should be in YYYY-MM-DD format</small>
            
            <p><label>&nbsp;</label>
            <input type="submit" name="updateDiscount" id="updateDiscount" value="Update" class="submit-btn"/></p>
        </fieldset>
    </form>
</div>
<a href="admin/settings/view-discount/<?php echo $discount['discount_id']; ?>">&#8656; Back to Discount</a>
