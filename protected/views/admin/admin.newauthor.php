<!-- ***************************************************************** create new author ******************************************************************* -->
<div id="page" class="order-shell">
    <h1>Insert New Author</h1>
    <form action="admin/authors/create" method="post" enctype="multipart/form-data">
        <fieldset>
            <h5>Required fields are marked with <img src="public/css/images/required_star.gif" alt="" /></h5>
            <p><input type="hidden" name="token" id="token" value="<?php echo $token; ?>"></p>
            
            <p><label class="required">First Name:<strong><?php if (isset($errors['firstName']) && !isset($missing['firstName'])) { echo $errors['firstName']; } 
                                        if (isset($missing['firstName'])) { echo $missing['firstName']; }?></strong></label>
            <input type="text" name="firstName" id="firstName" maxlength="20"
                   value="<?php if (isset($input['firstName'])) { echo $input['firstName']; } ?>" /></p>
            
            <p><label class="required">Last Name:<strong><?php if (isset($errors['lastName']) && !isset($missing['lastName'])) { echo $errors['lastName']; } 
                                        if (isset($missing['lastName'])) { echo $missing['lastName']; }?></strong></label>
            <input type="text" name="lastName" id="lastName" maxlength="40"
                   value="<?php if (isset($input['lastName'])) { echo $input['lastName']; } ?>" /></p>
            
            <p><label class="required">Gender:<strong><?php if (isset($errors['gender']) && !isset($missing['gender'])) { echo $errors['gender']; } 
                                                        if (isset($missing['gender'])) { echo $missing['gender']; } ?></strong></label>
                <select name="gender">
                    <option value="">SELECT</option>
                    <option value="female">Female</option>
                    <option value="male">Male</option>
                </select></p>
                
            <p><label>Address:<strong><?php if (isset($errors['address'])) { echo $errors['address']; } ?></strong></label>
            <input type="text" name="address" id="address" maxlength="60"
                   value="<?php if (isset($input['address'])) { echo $input['address']; } ?>" /></p>
            
            <p><label class="required">Place of birth:<strong><?php if (isset($errors['birthPlace']) && !isset($missing['birthPlace'])) { echo $errors['birthPlace']; } 
                                        if (isset($missing['birthPlace'])) { echo $missing['birthPlace']; }?></strong></label>
            <input type="text" name="birthPlace" id="birthPlace" maxlength="60"
                   value="<?php if (isset($input['birthPlace'])) { echo $input['birthPlace']; } ?>" /></p>
            
            <p><label class="required">Country:<strong><?php if (isset($errors['country']) && !isset($missing['country'])) { echo $errors['country']; } 
                                    if (isset($missing['country'])) { echo $missing['country']; }?></strong></label>
            <select name="country">
                <option value="">SELECT</option>
                <?php foreach ($countries as $abbrev => $country) : ?>
                <option value="<?php echo $abbrev; ?>"
                <?php if (isset($_POST['country']) && $_POST['country'] == $abbrev) { echo ' selected="selected"'; } ?>><?php echo $country; ?></option>
                <?php endforeach; ?>
            </select></p>
            
            <p><label>Zip Code:<strong><?php if (isset($errors['zipCode'])) { echo $errors['zipCode']; } ?></strong></label>
            <input type="text" name="zipCode" id="zipCode" maxlength="5"
                   value="<?php if (isset($input['zipCode'])) { echo $input['zipCode']; } ?>" /></p>
            
            <p><label>Phone:<strong><?php if (isset($errors['phone'])) { echo $errors['phone']; } ?></strong></label>
            <input type="text" name="phone" id="phone" maxlength="15"
                   value="<?php if (isset($input['phone'])) { echo $input['phone']; } ?>" /></p>
            <small>Phone should be in format x(xx)-xxx-xxxx</small>
            
            <p><label>Email:<strong><?php if (isset($errors['email'])) { echo $errors['email']; } ?></strong></label>
            <input type="text" name="email" id="email" maxlength="40"
                   value="<?php if (isset($input['email'])) { echo $input['email']; } ?>" /></p>
            
            <p><label>Website:<strong><?php if (isset($errors['website'])) { echo $errors['website']; } ?></strong></label>
            <input type="text" name="website" id="website" maxlength="40"
                   value="<?php if (isset($input['website'])) { echo $input['website']; } ?>" /></p>
            
            <p><label class="required">Category:<strong><?php if (isset($errors['category']) && !isset($missing['category'])) { echo $errors['category']; } 
                                        if (isset($missing['category'])) { echo $missing['category']; }?></strong></label>
            <input type="text" name="category" id="category" maxlength="60"
                   value="<?php if (isset($input['category'])) { echo $input['category']; } ?>" /></p>
                
            <p><label class="required">Profile Image:<strong><?php if (isset($errors['image'])) { echo $errors['image']; } ?></strong></label>
               <input type="file" name="image" id="image" /></p>
            
            <p><label>About:<strong><?php if (isset($errors['about'])) { echo $errors['about']; } ?></strong></label>
            <textarea name="about" id="about" cols="20" rows="15"><?php if (isset($input['about'])) { echo $input['about']; } ?></textarea></p>
            
            <p><label>&nbsp;</label>
            <input type="submit" name="createAuthor" id="createAuthor" value="Create" class="submit-btn"/></p>
        </fieldset>    
    </form>
</div>
<a href="admin/authors/">&#8656; Back to Authors</a>
