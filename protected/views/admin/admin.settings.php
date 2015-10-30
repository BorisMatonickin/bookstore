<!-- ************************************************************** site settings ***************************************************************************** -->
<!-- discount code table -->
<?php if (isset($flashMessage)) { echo $flashMessage; } ?>
<fieldset>
    <legend>Discount Codes</legend>
    <table class="user-info orders">
        <thead>
            <tr>
                <th>Name</th>
                <th>Active</th>
                <th>Operation</th>
                <th>Amount</th>
                <th>Expires</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vouchers as $id => $voucher) : ?>
            <tr>
                <td><?php echo $voucher['vouchercode']; ?></td>
                <?php if ($voucher['active'] == 1) : ?>
                <td><img src="public/css/images/enabled.png" alt="" title="Active" /></td>
                <?php else : ?>
                <td><img src="public/css/images/disabled.png" alt="" title="Not Active" /></td>
                <?php endif; ?>
                <td><?php echo $voucher['discount_operation']; ?></td>
                <td><?php echo $voucher['discount_amount']; ?></td>
                <td><?php echo $voucher['dateExpires']; ?></td>
                <td>
                    <a href="admin/settings/view-discount/<?php echo $voucher['discount_id']; ?>">View Details</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>

<!-- **************************************************** number of pages displayed for navigation ********************************************************* -->
<div class="pagination">
<?php foreach ($numbersOfPages as $num) : ?>
    <a href="admin/settings/<?php echo $num; ?>" class="page"><?php echo $num; ?></a>
<?php endforeach; ?>
</div>
<a href="admin/settings/create-discount" class="back-button add-button">Add New Discount</a>



