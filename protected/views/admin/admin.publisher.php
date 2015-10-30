<!-- ******************************************************************* publisher info ********************************************************************** -->
<?php if (isset($flashMessage)) { echo $flashMessage; } ?>
<fieldset>
    <legend><?php echo $publisher['name']; ?></legend>
    <table class="user-info admin-info">
        <tr>
            <td>Publisher Name:</td>
            <td><?php echo $publisher['name']; ?></td>
        </tr>
        <tr>
            <td>Address:</td>
            <td><?php echo $publisher['address']; ?></td>
        </tr>
        <tr>
            <td>City:</td>
            <td><?php echo $publisher['city']; ?></td>
        </tr>
        <tr>
            <td>Country:</td>
            <td><?php echo $publisher['country_name']; ?></td>
        </tr>
        <tr>
            <td>Phone:</td>
            <td><?php echo $publisher['phone']; ?></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><?php echo ($publisher['email'] === null ? '-' : $publisher['email']); ?></td>
        </tr>
        <tr>
            <td>Website:</td>
            <td><?php echo ($publisher['website'] === null ? '-' : $publisher['website']); ?></td>
        </tr>
        <tr>
            <td class="upper-left">Description:</td>
            <td><?php echo ($publisher['description'] === null ? '-' : $publisher['description']); ?></td>
        </tr>
    </table>
</fieldset>
<a href="admin/publishers/">&#8656; Back to Publishers</a>
<a href="admin/publishers/update/<?php echo $publisher['publisher_id']; ?>" class="update-btn">Update</a>