<!-- ********************************************************************* discount info ****************************************************************** -->
<?php if (isset($flashMessage)) { echo $flashMessage; } ?>
<fieldset>
    <legend><?php echo $discount['vouchercode']; ?></legend>
    <table class="user-info admin-info">
        <tr>
            <td>Discount Name:</td>
            <td><?php echo $discount['vouchercode']; ?></td>
        </tr>
        <tr>
            <td>Status:</td>
            <td><?php echo ($discount['active'] == 1 ? 'ACTIVE' : 'NOT ACTIVE'); ?></td>
        </tr>
        <tr>
            <td>Discount Operation:</td>
            <td><?php echo ($discount['discount_operation'] == '%' ? 'Percentage (%)' : 'Fixed Amount Deducted (-)'); ?></td>
        </tr>
        <tr>
            <td>Discount Amount:</td>
            <td><?php echo $discount['discount_amount'] . ($discount['discount_operation'] == '%' ? '%' : ''); ?></td>
        </tr>
        <tr>
            <td>Available Number:</td>
            <td><?php echo ($discount['num_vouchers'] == -1 ? 'No Limit' : $discount['num_vouchers']); ?></td>
        </tr>
        <tr>
            <td>Date Expires:</td>
            <td><?php echo $discount['dateExpires']; ?></td>
        </tr>
    </table>
</fieldset>
<a href="admin/settings/">&#8656; Back to Settings</a>
<a href="admin/settings/update-discount/<?php echo $discount['discount_id']; ?>" class="update-btn">Update</a>
