<!-- ************************************************************** publishers info ************************************************************************ -->
<!-- publishers info table -->
<?php if (isset($flashMessage)) { echo $flashMessage; } ?>
<fieldset>
    <legend>Publishers</legend>
    <table class="user-info orders">
        <thead>
            <tr>
                <th>Publisher ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>City</th>
                <th>Country</th>
                <th>Phone</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($publishers as $id => $publisher) : ?>
            <tr>
                <td><?php echo $publisher['publisher_id']; ?></td>
                <td><?php echo $publisher['name']; ?></td>
                <td><?php echo $publisher['address']; ?></td>
                <td><?php echo $publisher['city']; ?></td>
                <td><?php echo $publisher['country']; ?></td>
                <td><?php echo $publisher['phone']; ?></td>
                <td>
                    <a href="admin/publishers/view/<?php echo $publisher['publisher_id']; ?>">View Details</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>

<!-- **************************************************** number of pages displayed for navigation ********************************************************* -->
<div class="pagination">
<?php foreach ($numbersOfPages as $num) : ?>
    <a href="admin/publishers/<?php echo $num; ?>" class="page"><?php echo $num; ?></a>
<?php endforeach; ?>
</div>
<a href="admin/publishers/create" class="back-button add-button">Add New Publisher</a>