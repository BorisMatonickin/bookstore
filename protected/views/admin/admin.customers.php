<!-- ************************************************************ customers info *************************************************************************** -->
<!-- customers info table -->
<fieldset>
    <legend>Customers</legend>
    <table class="user-info orders">
        <thead>
            <tr>
                <th>Customer ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Country</th>
                <th>Active</th>
                <th>Admin</th>
                <th>Date Registered</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customers as $id => $customer) : ?>
            <tr>
                <td><?php echo $customer['user_id']; ?></td>
                <td><?php echo $customer['first_name']; ?></td>
                <td><?php echo $customer['last_name']; ?></td>
                <td><?php echo $customer['country_name']; ?></td>
                <?php if ($customer['isActive'] == 1) : ?>
                <td><img src="public/css/images/enabled.png" alt="" title="Active" /></td>
                <?php else : ?>
                <td><img src="public/css/images/disabled.png" alt="" title="Not Active" /></td>
                <?php endif; ?>
                <?php if ($customer['user_level'] == 0) : ?>
                <td>-</td>
                <?php else : ?>
                <td><img src="public/css/images/enabled.png" alt="" title="Admin"/></td>
                <?php endif; ?>
                <td><?php echo $customer['dateRegistered']; ?></td>
                <td>
                    <a href="admin/customers/view/<?php echo $customer['user_id']; ?>">View Details</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>

<!-- **************************************************** number of pages displayed for navigation ********************************************************* -->
<div class="pagination">
<?php foreach ($numbersOfPages as $num) : ?>
    <a href="admin/customers/<?php echo $num; ?>" class="page"><?php echo $num; ?></a>
<?php endforeach; ?>
</div>