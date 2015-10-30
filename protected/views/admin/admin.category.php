<!-- ******************************************************** info about category ************************************************************************** -->
<?php if (isset($flashMessage)) { echo $flashMessage; } ?>
<fieldset>
    <legend><?php echo $categoryInfo['category']; ?></legend>
    <table class="user-info admin-info">
        <tr>
            <td>Category:</td>
            <td><?php echo $categoryInfo['category']; ?></td>
        </tr>
        <tr>
            <td>Number of Books:</td>
            <td><?php echo $categoryInfo['booksNumber']; ?></td>
        </tr>
        <tr>
            <td class="upper-left">Description:</td>
            <td><?php echo $categoryInfo['description']; ?></td>
        </tr>
    </table>
</fieldset>
<a href="admin/categories/">&#8656; Back to Categories</a>
<a href="admin/categories/update/<?php echo $categoryInfo['cat_id']; ?>" class="update-btn">Update</a>