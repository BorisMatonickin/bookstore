<!-- ****************************************************************** authors info ************************************************************************** -->
<!-- authors info table -->
<?php if (isset($flashMessage)) { echo $flashMessage; } ?>
<fieldset>
    <legend>Authors</legend>
    <table class="user-info orders">
        <thead>
            <tr>
                <th>Author ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Born In</th>
                <th>Gender</th>
                <th>Category</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($authors as $id => $author) : ?>
            <tr>
                <td><?php echo $author['author_id']; ?></td>
                <td><?php echo $author['first_name']; ?></td>
                <td><?php echo $author['last_name']; ?></td>
                <td><?php echo $author['bornIn']; ?></td>
                <td><?php echo $author['gender']; ?></td>
                <td><?php echo $author['category']; ?></td>
                <td>
                    <a href="admin/authors/view/<?php echo $author['author_id']; ?>">View Details</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>

<!-- **************************************************** number of pages displayed for navigation ********************************************************* -->
<div class="pagination">
<?php foreach ($numbersOfPages as $num) : ?>
    <a href="admin/authors/<?php echo $num; ?>" class="page"><?php echo $num; ?></a>
<?php endforeach; ?>
</div>
<a href="admin/authors/create" class="back-button add-button">Add New Author</a>