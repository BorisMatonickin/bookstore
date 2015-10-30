<!-- ******************************************************************* update review form ****************************************************************** -->
<div id="page" class="order-shell">
    <h1>Update Review</h1>
    <form action="" method="post">
        <fieldset>
            <p><input type="hidden" name="token" id="token" value="<?php echo $token; ?>"></p>
            
            <p><label>Review Status:<strong><?php if (isset($errors['approved'])) { echo $errors['approved']; } ?></strong></label>
            <select name="approved">
                <option value="1" <?php if ($review['approved'] == 1) { echo ' selected="selected"'; } ?>>Approved</option>
                <option value="0" <?php if ($review['approved'] == 0) { echo ' selected="selected"'; } ?>>Not Approved</option>
            </select></p>
            
            <p><label>&nbsp;</label>
            <input type="submit" name="updateReview" id="updateReview" value="Update" class="submit-btn"/></p>
        </fieldset>
    </form>
</div>
<a href="admin/reviews/view/<?php echo $review['review_id']; ?>">&#8656; Back to Review</a>
