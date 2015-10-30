<!-- ****************************************************************** categories info ********************************************************************* -->
<!-- categories info table -->
<?php if (isset($flashMessage)) { echo $flashMessage; } ?>
<fieldset>
    <legend>Categories</legend>
    <table class="user-info orders">
        <thead>
            <tr>
                <th>Category</th>
                <th>Number Of Books</th>
                <th>Action</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $id => $cat) : ?>
            <tr>
                <td><?php echo $cat['category']; ?></td>
                <td><?php echo $cat['booksNumber']; ?></td>
                <td>
                    <a href="admin/categories/category-books/<?php echo $cat['categoryId'] ?>">View Books</a>
                </td>
                <td>
                    <a href="admin/categories/view/<?php echo $cat['categoryId']; ?>">View Details</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>

<!-- **************************************************** number of pages displayed for navigation ********************************************************* -->
<div class="pagination">
<?php foreach ($numbersOfPages as $num) : ?>
    <a href="admin/categories/<?php echo $num; ?>" class="page"><?php echo $num; ?></a>
<?php endforeach; ?>
</div>
<a href="admin/categories/create" class="back-button add-button">Add New Category</a>


