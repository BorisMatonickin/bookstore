<!-- *********************************************************** update product form ********************************************************************** -->
<div id="page" class="order-shell">
    <h1>Update Product</h1>
    <?php if (isset($error)) { echo $error; } ?>
    <form action="" method="post" enctype="multipart/form-data">
        <fieldset>
            <p class="stock">All form fields are optional. Only data which require change should be entered.</p>
            <p><input type="hidden" name="token" id="token" value="<?php echo $token; ?>"></p>
            
            <p><label>Book Title:<strong><?php if (isset($errors['title'])) { echo $errors['title']; } ?></strong></label>
            <input type="text" name="title" id="title" maxlength="40" value="" placeholder="<?php echo $productInfo['title'] ?>" /></p>

            <p><label>Author:<strong><?php if (isset($errors['author'])) { echo $errors['author']; } ?></strong></label>
            <input type="author" name="author" id="author" maxlength="100" value="" placeholder="<?php echo $productInfo['authorName']; ?>" /></p>
            <small>For multiple authors please separate full names with comma (,)</small>
            
            <p><label>Category:<strong><?php if (isset($errors['category'])) { echo $errors['category']; } ?></strong></label>
            <input type="category" name="category" id="category" maxlength="100"  value="" placeholder="<?php echo $productInfo['categories']; ?>" /></p>
            <small>For multiple categories please separate each with comma(,)</small>

            <p><label>Publisher:<strong><?php if (isset($errors['publisher'])) { echo $errors['publisher']; } ?></strong></label>
                <select name="publisher_id">
                    <option value="">SELECT</option>
                    <?php foreach ($publishers as $id => $publisher) : ?>
                    <option value="<?php echo $id; ?>"
                    <?php if ($id == $productInfo['publisher_id']) { echo ' selected="selected"'; } ?>><?php echo $publisher; ?></option>
                    <?php endforeach; ?>
                </select></p>
            
            <p><label>Format:<strong><?php if (isset($errors['format_id'])) { echo $errors['format_id']; } ?></strong></label>
                <select name="format_id">
                    <option value="">SELECT</option>
                    <?php foreach ($formats as $id => $format) : ?>
                    <option value="<?php echo $id; ?>"
                    <?php if ($id == $productInfo['format_id']) { echo ' selected="selected"'; } ?>><?php echo $format; ?></option>
                    <?php endforeach; ?>
                </select></p>
                
            <p><label>Date Published:<strong><?php if (isset($errors['datePublished'])) { echo $errors['datePublished']; } ?></strong></label>
            <input type="text" name="datePublished" id="datePublished" maxlength="60" value="" placeholder="<?php echo $productInfo['datePublished'] ?>" /></p>
            <small>Date should be in YYYY-MM-DD format</small>

             <p><label>ISBN:<strong><?php if (isset($errors['isbn'])) { echo $errors['isbn']; } ?></strong></label>
            <input type="text" name="isbn" id="isbn" maxlength="20" value="" placeholder="<?php echo $productInfo['isbn']; ?>" /></p>

            <p><label>ISBN 13:<strong><?php if (isset($errors['isbn13'])) { echo $errors['isbn13']; } ?></strong></label>
            <input type="text" name="isbn13" id="isbn13" maxlength="40" value="" placeholder="<?php echo $productInfo['isbn13']; ?>" /></p>
            
            <p><label>ASIN:<strong><?php if (isset($errors['asin'])) { echo $errors['asin']; } ?></strong></label>
            <input type="text" name="asin" id="asin" maxlength="40" value="" placeholder="<?php echo $productInfo['asin']; ?>" /></p>
            
            <p><label>Price:<strong><?php if (isset($errors['price'])) { echo $errors['price']; } ?></strong></label>
            <input type="text" name="price" id="price" maxlength="40" value="" placeholder="<?php echo $productInfo['price']; ?>" /></p>
            <small>Price should be in decimal number format even if it's whole number e.g. 6.00</small>
            
            <p><label>Stock:<strong><?php if (isset($errors['stock'])) { echo $errors['stock']; } ?></strong></label>
            <input type="text" name="stock" id="stock" maxlength="5" value="" placeholder="<?php echo $productInfo['stock']; ?>" /></p>
            
            <p><label>Edition:<strong><?php if (isset($errors['edition'])) { echo $errors['edition']; } ?></strong></label>
            <input type="text" name="edition" id="edition" maxlength="40" value="" placeholder="<?php echo $productInfo['edition']; ?>" /></p>
            
            <p><label>Part Of Series:<strong><?php if (isset($errors['series'])) { echo $errors['series']; } ?></strong></label>
            <input type="text" name="series" id="series" maxlength="40" value="" placeholder="<?php $productInfo['series']; ?>" /></p>
            
            <p><label>Book's Front Cover Image:<strong><?php if (isset($errors['image'])) { echo $errors['image']; } ?></strong></label>
                <input type="file" name="image" id="image" /></p>
            
            <p><label>Description:<strong><?php if (isset($errors['description'])) { echo $errors['description']; } ?></strong></label>
            <textarea name="description" id="description" cols="20" rows="15"><?php echo $productInfo['description']; ?></textarea></p>
            
            <p><label>&nbsp;</label>
            <input type="submit" name="updateProduct" id="updateProduct" value="Update" class="submit-btn"/></p>
        </fieldset>
    </form>
</div>
<a href="admin/products/view/<?php echo $productInfo['book_id']; ?>">&#8656; Back to Product</a>
