<!-- ***************************************************************** create new product ******************************************************************* -->
<div id="page" class="order-shell">
    <h1>Insert New Product</h1>
    <?php if (isset($error)) { echo $error; } ?>
    <p class="stock">Before inserting new product author, publisher and category must be entered if they don't exists in the database!</p>
    <a href="" class="create-btn">New Author</a>
    <a href="" class="create-btn">New Publisher</a>
    <form action="admin/products/create" method="post" enctype="multipart/form-data">
        <fieldset>
            <h5>Required fields are marked with <img src="public/css/images/required_star.gif" alt="" /></h5>
            <p><input type="hidden" name="token" id="token" value="<?php echo $token; ?>"></p>
            
            <p><label class="required">Book Title:<strong><?php if (isset($errors['title']) && !isset($missing['title'])) { echo $errors['title']; } 
                                        if (isset($missing['title'])) { echo $missing['title']; }?></strong></label>
            <input type="text" name="title" id="title" maxlength="40"
                   value="<?php if (isset($input['title'])) { echo $input['title']; } ?>" /></p>

            <p><label class="required">Author:<strong><?php if (isset($errors['author']) && !isset($missing['author'])) { echo $errors['author']; } 
                                                        if (isset($missing['author'])) { echo $missing['author']; } ?></strong></label>
            <input type="author" name="author" id="author" maxlength="100"
                   value="<?php if (isset($input['author'])) { echo $input['author']; } ?>" /></p>
            <small>For multiple authors please separate full names with comma (,)</small>
            
            <p><label class="required">Category:<strong><?php if (isset($errors['category']) && !isset($missing['category'])) { echo $errors['category']; } 
                                                        if (isset($missing['category'])) { echo $missing['category']; } ?></strong></label>
            <input type="category" name="category" id="category" maxlength="100"
                   value="<?php if (isset($input['category'])) { echo $input['category']; } ?>" /></p>
            <small>For multiple categories please separate each with comma(,)</small>

            <p><label class="required">Publisher:<strong><?php if (isset($errors['publisher']) && !isset($missing['publisher'])) { echo $errors['publisher']; } 
                                                        if (isset($missing['publisher'])) { echo $missing['publisher']; } ?></strong></label>
                <select name="publisher">
                    <option value="">SELECT</option>
                    <?php foreach ($publishers as $id => $publisher) : ?>
                    <option value="<?php echo $id; ?>"
                    <?php if (isset($_POST['publisher']) && $_POST['publisher'] == $id) { echo ' selected="selected"'; } ?>><?php echo $publisher; ?></option>
                    <?php endforeach; ?>
                </select></p>
            
            <p><label class="required">Format:<strong><?php if (isset($errors['format_id']) && !isset($missing['format_id'])) { echo $errors['format_id']; } 
                                                        if (isset($missing['format_id'])) { echo $missing['format_id']; }?></strong></label>
                <select name="format_id">
                    <option value="">SELECT</option>
                    <?php foreach ($formats as $id => $format) : ?>
                    <option value="<?php echo $id; ?>"
                    <?php if (isset($_POST['format_id']) && $_POST['format_id'] == $id) { echo ' selected="selected"'; } ?>><?php echo $format; ?></option>
                    <?php endforeach; ?>
                </select></p>
                
            <p><label class="required">Date Published:<strong><?php if (isset($errors['datePublished']) && !isset($missing['datePublished'])) { echo $errors['datePublished']; } 
                                        if (isset($missing['datePublished'])) { echo $missing['datePublished']; }?></strong></label>
            <input type="text" name="datePublished" id="datePublished" maxlength="60"
            value="<?php if (isset($input['datePublished'])) { echo $input['datePublished']; } ?>" /></p>
            <small>Date should be in YYYY-MM-DD format</small>

             <p><label>ISBN:<strong><?php if (isset($errors['isbn'])) { echo $errors['isbn']; } ?></strong></label>
            <input type="text" name="isbn" id="isbn" maxlength="20"
                   value="<?php if (isset($input['isbn'])) { echo $input['isbn']; } ?>" /></p>

            <p><label>ISBN 13:<strong><?php if (isset($errors['isbn13'])) { echo $errors['isbn13']; } ?></strong></label>
            <input type="text" name="isbn13" id="isbn13" maxlength="40"
                   value="<?php if (isset($input['isbn13'])) { echo $input['isbn13']; } ?>" /></p>
            
            <p><label>ASIN:<strong><?php if (isset($errors['asin'])) { echo $errors['asin']; } ?></strong></label>
            <input type="text" name="asin" id="asin" maxlength="40"
                   value="<?php if (isset($input['asin'])) { echo $input['asin']; } ?>" /></p>
            
            <p><label class="required">Price:<strong><?php if (isset($errors['price']) && !isset($missing['price'])) { echo $errors['price']; } 
                                        if (isset($missing['price'])) { echo $missing['price']; }?></strong></label>
            <input type="text" name="price" id="price" maxlength="40"
                   value="<?php if (isset($input['price'])) { echo $input['price']; } ?>" /></p>
            <small>Price should be in decimal number format even if it's whole number e.g. 6.00</small>
            
            <p><label class="required">Stock:<strong><?php if (isset($errors['stock']) && !isset($missing['stock'])) { echo $errors['stock']; } 
                                        if (isset($missing['stock'])) { echo $missing['stock']; }?></strong></label>
            <input type="text" name="stock" id="stock" maxlength="5"
                   value="<?php if (isset($input['stock'])) { echo $input['stock']; } ?>" /></p>
            
            <p><label class="required">Edition:<strong><?php if (isset($errors['edition']) && !isset($missing['edition'])) { echo $errors['edition']; } 
                                        if (isset($missing['edition'])) { echo $missing['edition']; }?></strong></label>
            <input type="text" name="edition" id="edition" maxlength="40"
                   value="<?php if (isset($input['edition'])) { echo $input['edition']; } ?>" /></p>
            
            <p><label>Part Of Series:<strong><?php if (isset($errors['series'])) { echo $errors['series']; } ?></strong></label>
            <input type="text" name="series" id="series" maxlength="40"
                   value="<?php if (isset($input['series'])) { echo $input['series']; } ?>" /></p>
            
            <p><label class="required">Book's Front Cover Image:<strong><?php if (isset($errors['image'])) { echo $errors['image']; } ?></strong></label>
                <input type="file" name="image" id="image" /></p>
            
            <p><label>Description:<strong><?php if (isset($errors['description'])) { echo $errors['description']; } ?></strong></label>
            <textarea name="description" id="description" cols="20" rows="15"><?php if (isset($input['description'])) { echo $input['description']; } ?></textarea></p>
            
            <p><label>&nbsp;</label>
            <input type="submit" name="create" id="create" value="Create" class="submit-btn"/></p>
        </fieldset>
    </form>
</div>
<a href="admin/products/">&#8656; Back to Products</a>