<!-- ***************************************************************** create new publisher ******************************************************************* -->
<div id="page" class="order-shell">
    <h1>Insert New Publisher</h1>
    <form action="admin/publishers/create" method="post">
        <fieldset>
            <h5>Required fields are marked with <img src="public/css/images/required_star.gif" alt="" /></h5>
            <p><input type="hidden" name="token" id="token" value="<?php echo $token; ?>"></p>
            
            <p><label class="required">Publisher Name:<strong><?php if (isset($errors['name']) && !isset($missing['name'])) { echo $errors['name']; } 
                                        if (isset($missing['name'])) { echo $missing['name']; }?></strong></label>
            <input type="text" name="name" id="name" maxlength="100"
                   value="<?php if (isset($input['name'])) { echo $input['name']; } ?>" /></p>
                
            <p><label class="required">Address:<strong><?php if (isset($errors['address']) && !isset($missing['address'])) { echo $errors['address']; } 
                                            if (isset($missing['address'])) { echo $missing['address']; } ?></strong></label>
            <input type="text" name="address" id="address" maxlength="60"
                   value="<?php if (isset($input['address'])) { echo $input['address']; } ?>" /></p>
            
            <p><label class="required">City:<strong><?php if (isset($errors['city']) && !isset($missing['city'])) { echo $errors['city']; } 
                                        if (isset($missing['city'])) { echo $missing['city']; }?></strong></label>
            <input type="text" name="city" id="city" maxlength="60"
                   value="<?php if (isset($input['city'])) { echo $input['city']; } ?>" /></p>
            
            <p><label class="required">Country:<strong><?php if (isset($errors['country']) && !isset($missing['country'])) { echo $errors['country']; } 
                                    if (isset($missing['country'])) { echo $missing['country']; }?></strong></label>
            <select name="country">
                <option value="">SELECT</option>
                <?php foreach ($countries as $abbrev => $country) : ?>
                <option value="<?php echo $abbrev; ?>"
                <?php if (isset($_POST['country']) && $_POST['country'] == $abbrev) { echo ' selected="selected"'; } ?>><?php echo $country; ?></option>
                <?php endforeach; ?>
            </select></p>
            
            <p><label class="required">Phone:<strong><?php if (isset($errors['phone'])) { echo $errors['phone']; } ?></strong></label>
            <input type="text" name="phone" id="phone" maxlength="15"
                   value="<?php if (isset($input['phone'])) { echo $input['phone']; } ?>" /></p>
            <small>Phone should be in format x(xx)-xxx-xxxx</small>
            
            <p><label>Email:<strong><?php if (isset($errors['email'])) { echo $errors['email']; } ?></strong></label>
            <input type="text" name="email" id="email" maxlength="40"
                   value="<?php if (isset($input['email'])) { echo $input['email']; } ?>" /></p>
            
            <p><label>Website:<strong><?php if (isset($errors['website'])) { echo $errors['website']; } ?></strong></label>
            <input type="text" name="website" id="website" maxlength="40"
                   value="<?php if (isset($input['website'])) { echo $input['website']; } ?>" /></p>
            
            <p><label>Description:<strong><?php if (isset($errors['description'])) { echo $errors['description']; } ?></strong></label>
            <textarea name="description" id="description" cols="20" rows="15"><?php if (isset($input['description'])) { echo $input['description']; } ?></textarea></p>
            
            <p><label>&nbsp;</label>
            <input type="submit" name="createPublisher" id="createPublisher" value="Create" class="submit-btn"/></p>
        </fieldset>    
    </form>
</div>
<a href="admin/publishers/">&#8656; Back to Publishers</a>
