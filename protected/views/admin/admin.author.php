<!-- **************************************************************** author info table ********************************************************************* -->
<?php if (isset($flashMessage)) { echo $flashMessage; } ?>
<fieldset>
    <legend><?php echo $authorInfo['first_name'] . ' ' . $authorInfo['last_name']; ?></legend>
    <table class="user-info admin-info">
        <tr>
            <td>First Name:</td>
            <td><?php echo $authorInfo['first_name']; ?></td>
        </tr>
        <tr>
            <td>Last Name:</td>
            <td><?php echo $authorInfo['last_name']; ?></td>
        </tr>
        <tr>
            <td>Gender:</td>
            <td><?php echo $authorInfo['gender']; ?></td>
        </tr>
        <tr>
            <td>Address:</td>
            <td><?php echo ($authorInfo['address'] === null ? '-' : $authorInfo['address']); ?></td>
        </tr>
        <tr>
            <td>Place of Birth:</td>
            <td><?php echo $authorInfo['place_of_birth']; ?></td>
        </tr>
        <tr>
            <td>Country:</td>
            <td><?php echo $authorInfo['country_name']; ?></td>
        </tr>
        <tr>
            <td>Zip:</td>
            <td><?php echo ($authorInfo['zip'] === null ? '-' : $authorInfo['zip']); ?>
        </tr>
        <tr>
            <td>Phone:</td>
            <td><?php echo ($authorInfo['phone'] === null ? '-' : $authorInfo['phone']); ?></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><?php echo ($authorInfo['email'] === null ? '-' : $authorInfo['email']); ?></td>
        </tr>
        <tr>
            <td>Website:</td>
            <td><?php echo ($authorInfo['website'] === null ? '-' : $authorInfo['website']); ?></td>
        </tr>
        <tr>
            <td>Category:</td>
            <td><?php echo $authorInfo['category']; ?></td>
        </tr>
        <tr>
            <td class="upper-left">Image:</td>
            <td><img src="protected/uploads/author-images/<?php echo $authorInfo['image']; ?>" alt="" /></td>
        </tr>       
        <tr>
            <td class="upper-left">About:</td>
            <td><?php echo ($authorInfo['about'] === null ? '-' : $authorInfo['about']); ?></td>
        </tr>
    </table>
</fieldset>
<a href="admin/authors/">&#8656; Back to Authors</a>
<a href="admin/authors/update/<?php echo $authorInfo['author_id']; ?>" class="update-btn">Update</a>