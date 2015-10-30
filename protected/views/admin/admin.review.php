<!-- ************************************************************ review info **************************************************************************** -->
<?php if (isset($flashMessage)) { echo $flashMessage; } ?>
<fieldset>
    <legend><?php echo 'Review Nr. ' . $review['review_id']; ?></legend>
    <table class="user-info admin-info">
        <tr>
            <td>Review Title:</td>
            <td><?php echo $review['title']; ?></td>
        </tr>
        <tr>
            <td class="upper-left">Review:</td>
            <td><?php echo $review['review']; ?></td>
        </tr>
        <tr>
            <td>Review Author:</td>
            <td><?php echo $review['user']; ?>
                <a href="admin/customers/view/<?php echo $review['user_id']; ?>" class="back-button">View</a>
            </td>
        </tr>
        <tr>
            <td>Book Title:</td>
            <td><?php echo $review['bookTitle']; ?>
                <a href="admin/products/view/<?php echo $review['book_id']; ?>" class="back-button">View</a>
            </td>
        </tr>
        <tr>
            <td>Author:</td>
            <td><?php echo $review['authorName']; ?></td>
        </tr>
        <tr>
            <td>Book Format:</td>
            <td><?php echo $review['format']; ?></td>
        </tr>
        <tr>
            <td>Status:</td>
            <td><?php echo ($review['approved'] == 1 ? 'APPROVED' : 'NOT APPROVED'); ?></td>
        </tr>
        <tr>
            <td>Date Created:</td>
            <td><?php echo $review['dateCreated']; ?></td>
        </tr>
    </table>
</fieldset>
<a href="admin/reviews/">&#8656; Back to Reviews</a>
<a href="admin/reviews/update/<?php echo $review['review_id']; ?>" class="update-btn">Update</a>