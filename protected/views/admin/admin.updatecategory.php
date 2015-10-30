<!-- ********************************************************** update category form ************************************************************************* -->
<div id="page" class="order-shell">
    <h1>Update Category</h1>
    <form action="" method="post">
        <fieldset>
            <p class="stock">All form fields are optional. Only data which require change should be entered.</p>
            <p><input type="hidden" name="token" id="token" value="<?php echo $token; ?>"></p>
            
            <p><label>Category Name:<strong><?php if (isset($errors['category'])) { echo $errors['category']; } ?></strong></label>
            <input type="text" name="category" id="category" maxlength="40" value="" placeholder="<?php echo $category['category']; ?>" /></p>
            
            <p><label>Description:<strong><?php if (isset($errors['description'])) { echo $errors['description']; } ?></strong></label>
            <textarea name="description" id="description" cols="20" rows="15"><?php echo $category['description']; ?></textarea></p>
            
            <p><label>&nbsp;</label>
            <input type="submit" name="updateCategory" id="updateCategory" value="Update" class="submit-btn"/></p>
        </fieldset>    
    </form>
</div>
<a href="admin/categories/view/<?php echo $category['cat_id']; ?>">&#8656; Back to Category</a>
