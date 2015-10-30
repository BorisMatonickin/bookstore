<!-- **************************************************************** reviews info *********************************************************************** -->
<!-- table with reviews info -->
<fieldset class="review-table">
    <legend>Lates Reviews</legend>
    <table class="user-info orders">
        <thead>
            <tr>
                <th>Book</th>
                <th>Book Authors</th>
                <th>Review Author</th>
                <th>Status</th>
                <th>Date Reviewed</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reviews as $id => $review) : ?>
            <tr>
                <td><?php echo $review['title']; ?></td>
                <td><?php echo $review['bookAuthors']; ?></td>
                <td><?php echo $review['reviewAuthor']; ?></td>
                <?php if ($review['approved'] == 1) { ?>
                <td><img src="public/css/images/enabled.png" alt="" title="Approved" /></td>
                <?php } else { ?>
                <td><img src="public/css/images/disabled.png" alt="" title="Not Approved" /></td>
                <?php } ?>
                <td><?php echo $review['reviewDate']; ?></td>
                <td>
                    <a href="admin/reviews/view/<?php echo $review['review_id']; ?>">Review Details</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>

<!-- **************************************************** number of pages displayed for navigation ********************************************************* -->
<div class="pagination">
<?php foreach ($numbersOfPages as $num) : ?>
    <a href="admin/reviews/<?php echo $num; ?>" class="page"><?php echo $num; ?></a>
<?php endforeach; ?>
</div>
