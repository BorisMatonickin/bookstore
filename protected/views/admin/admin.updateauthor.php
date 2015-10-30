<!-- ************************************************************* update axuthor form ********************************************************************** -->
<!-- ***************************************************************** create new author ******************************************************************* -->
<div id="page" class="order-shell">
    <h1>Update Author</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <fieldset>
            <p class="stock">All form fields are optional. Only data which require change should be entered.</p>
            <p><input type="hidden" name="token" id="token" value="<?php echo $token; ?>"></p>
            
            <p><label>First Name:<strong><?php if (isset($errors['first_name'])) { echo $errors['first_name']; } ?></strong></label>
            <input type="text" name="first_name" id="first_name" maxlength="20" value="" placeholder="<?php echo $author['first_name']; ?>" /></p>
            
            <p><label>Last Name:<strong><?php if (isset($errors['last_name'])) { echo $errors['last_name']; } ?></strong></label>
            <input type="text" name="last_name" id="last_name" maxlength="40" value="" placeholder="<?php echo $author['last_name']; ?>" /></p>
            
            <p><label>Gender:<strong><?php if (isset($errors['gender'])) { echo $errors['gender']; } ?></strong></label>
                <select name="gender">
                    <option value="">SELECT</option>
                    <option value="female" <?php if ($author['gender'] == 'female') { echo ' selected="selected"'; } ?>>Female</option>
                    <option value="male" <?php if ($author['gender'] == 'male') { echo ' selected="selected"'; } ?>>Male</option>
                </select></p>
                
            <p><label>Address:<strong><?php if (isset($errors['address'])) { echo $errors['address']; } ?></strong></label>
            <input type="text" name="address" id="address" maxlength="60" value="" placeholder="<?php echo $author['address']; ?>" /></p>
            
            <p><label>Place of birth:<strong><?php if (isset($errors['place_of_birth'])) { echo $errors['place_of_birth']; } ?></strong></label>
            <input type="text" name="place_of_birth" id="place_of_birth" maxlength="60" value="<?php echo $author['place_of_birth']; ?>" /></p>
            
            <p><label>Country:<strong><?php if (isset($errors['country'])) { echo $errors['country']; } ?></strong></label>
            <select name="country">
                <option value="">SELECT</option>
                <?php foreach ($countries as $abbrev => $country) : ?>
                <option value="<?php echo $abbrev; ?>"
                <?php if ($abbrev == $author['country_abbrev']) { echo ' selected="selected"'; } ?>><?php echo $country; ?></option>
                <?php endforeach; ?>
            </select></p>
            
            <p><label>Zip Code:<strong><?php if (isset($errors['zip'])) { echo $errors['zip']; } ?></strong></label>
            <input type="text" name="zip" id="zip" maxlength="5" value="" placeholder="<?php echo $author['zip']; ?>" /></p>
            
            <p><label>Phone:<strong><?php if (isset($errors['phone'])) { echo $errors['phone']; } ?></strong></label>
            <input type="text" name="phone" id="phone" maxlength="15" value="" placeholder="<?php echo $author['phone']; ?>" /></p>
            <small>Phone should be in format x(xx)-xxx-xxxx</small>
            
            <p><label>Email:<strong><?php if (isset($errors['email'])) { echo $errors['email']; } ?></strong></label>
            <input type="text" name="email" id="email" maxlength="40" value="" placeholder="<?php echo $author['email']; ?>" /></p>
            
            <p><label>Website:<strong><?php if (isset($errors['website'])) { echo $errors['website']; } ?></strong></label>
            <input type="text" name="website" id="website" maxlength="40" value="" placeholder="<?php echo $author['website']; ?>" /></p>
            
            <p><label>Category:<strong><?php if (isset($errors['category'])) { echo $errors['category']; } ?></strong></label>
            <input type="text" name="category" id="category" maxlength="60" value="" placeholder="<?php echo $author['category']; ?>" /></p>
                
            <p><label>Profile Image:<strong><?php if (isset($errors['image'])) { echo $errors['image']; } ?></strong></label>
            <input type="file" name="image" id="image" /></p>
            
            <p><label>About:<strong><?php if (isset($errors['about'])) { echo $errors['about']; } ?></strong></label>
            <textarea name="about" id="about" cols="20" rows="15"><?php echo $author['about']; ?></textarea></p>
            
            <p><label>&nbsp;</label>
            <input type="submit" name="updateAuthor" id="updateAuthor" value="Update" class="submit-btn"/></p>
        </fieldset>    
    </form>
</div>
<a href="admin/authors/view/<?php echo $author['author_id']; ?>">&#8656; Back to Author</a>
