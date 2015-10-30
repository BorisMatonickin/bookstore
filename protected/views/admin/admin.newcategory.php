<!-- ***************************************************************** create new category ******************************************************************* -->
<div id="page" class="order-shell">
    <h1>Insert New Category</h1>
    <form action="admin/categories/create" method="post">
        <fieldset>
            <h5>Required fields are marked with <img src="public/css/images/required_star.gif" alt="" /></h5>
            <p><input type="hidden" name="token" id="token" value="<?php echo $token; ?>"></p>
            
            <p><label class="required">Category Name:<strong><?php if (isset($errors['category']) && !isset($missing['category'])) { echo $errors['category']; } 
                                        if (isset($missing['category'])) { echo $missing['category']; }?></strong></label>
            <input type="text" name="category" id="category" maxlength="40"
                   value="<?php if (isset($input['category'])) { echo $input['category']; } ?>" /></p>
            
            <p><label class="required">Description:<strong><?php if (isset($errors['description']) && !isset($missing['description'])) { echo $errors['description']; } 
                                      if (isset($missing['description'])) { echo $missing['description']; } ?></strong></label>
            <textarea name="description" id="description" cols="20" rows="15"><?php if (isset($input['description'])) { echo $input['description']; } ?></textarea></p>
            
            <p><label>&nbsp;</label>
            <input type="submit" name="createCategory" id="createCategory" value="Create" class="submit-btn"/></p>
        </fieldset>    
    </form>
</div>
<a href="admin/categories/">&#8656; Back to Categories</a>