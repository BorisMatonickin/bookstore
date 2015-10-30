<!-- ***************************************************************** info about customer ******************************************************************** -->
<?php if (isset($flashMessage)) { echo $flashMessage; } ?>
<fieldset>
    <legend><?php echo $customer['first_name'] . ' ' . $customer['last_name']; ?></legend>
    <table class="user-info admin-info">
        <tr>
            <td>First Name:</td>
            <td><?php echo $customer['first_name']; ?></td>
        </tr>
        <tr>
            <td>Last Name:</td>
            <td><?php echo $customer['last_name']; ?></td>
        </tr>
        <tr>
            <td>Address:</td>
            <td><?php echo $customer['address']; ?></td>
        </tr>
        <tr>
            <td>City:</td>
            <td><?php echo $customer['city']; ?></td>
        </tr>
        <tr>
            <td>Country:</td>
            <td><?php echo $customer['country_name']; ?></td>
        </tr>
        <tr>
            <td>State:</td>
            <td><?php echo ($customer['state_name'] == null ? '-' : $customer['state_name']); ?></td>
        </tr>
        <tr>
            <td>Zip:</td>
            <td><?php echo $customer['zip']; ?></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><?php echo $customer['email']; ?></td>
        </tr>
        <tr>
            <td>User Status:</td>
            <td><?php echo ($customer['isActive'] == 1 ? 'ACTIVE' : 'NOT ACTIVE'); ?></td>    
        </tr>
        <tr>
            <td>User Level:</td>
            <td><?php echo ($customer['user_level'] == 1 ? 'ADMIN' : 'REGULAR USER'); ?></td>
        </tr>
        <tr>
            <td>Date Registered:</td>
            <td><?php echo $customer['dateRegistered']; ?></td>
        </tr>
        <tr>
            <td>Total Orders:</td>
            <td><?php echo ($customer['totalOrders'] == 0 ? '-' : $customer['totalOrders']); ?>
                <a href="admin/orders/view-by-customer/<?php echo $customer['user_id']; ?>" class="back-button">View Orders</a></td>
        </tr>
    </table>
</fieldset>
<a href="admin/customers/">&#8656; Back to Customers</a>
<a href="admin/customers/update/<?php echo $customer['user_id']; ?>" class="update-btn">Update</a>