<!-- ********************************************************************** update publisher form ************************************************************* -->
<div id="page" class="order-shell">
    <h1>Update Publisher</h1>
    <form action="" method="post">
        <fieldset>
            <p class="stock">All form fields are optional. Only data which require change should be entered.</p>
            <p><input type="hidden" name="token" id="token" value="<?php echo $token; ?>"></p>
            
            <p><label>Publisher Name:<strong><?php if (isset($errors['name'])) { echo $errors['name']; } ?></strong></label>
            <input type="text" name="name" id="name" maxlength="100" value="" placeholder="<?php echo $publisher['name']; ?>" /></p>
                
            <p><label>Address:<strong><?php if (isset($errors['address'])) { echo $errors['address']; } ?></strong></label>
            <input type="text" name="address" id="address" maxlength="60" value="" placeholder="<?php echo $publisher['address']; ?>" /></p>
            
            <p><label>City:<strong><?php if (isset($errors['city'])) { echo $errors['city']; } ?></strong></label>
            <input type="text" name="city" id="city" maxlength="60" value="" placeholder="<?php echo $publisher['city']; ?>" /></p>
            
            <p><label>Country:<strong><?php if (isset($errors['country'])) { echo $errors['country']; } ?></strong></label>
            <select name="country">
                <option value="">SELECT</option>
                <?php foreach ($countries as $abbrev => $country) : ?>
                <option value="<?php echo $abbrev; ?>"
                <?php if ($abbrev == $publisher['country_abbrev']) { echo ' selected="selected"'; } ?>><?php echo $country; ?></option>
                <?php endforeach; ?>
            </select></p>
            
            <p><label>Phone:<strong><?php if (isset($errors['phone'])) { echo $errors['phone']; } ?></strong></label>
            <input type="text" name="phone" id="phone" maxlength="15" value="" placeholder="<?php echo $publisher['phone']; ?>" /></p>
            <small>Phone should be in format x(xx)-xxx-xxxx</small>
            
            <p><label>Email:<strong><?php if (isset($errors['email'])) { echo $errors['email']; } ?></strong></label>
            <input type="text" name="email" id="email" maxlength="40" value="" placeholder="<?php echo $publisher['email']; ?>" /></p>
            
            <p><label>Website:<strong><?php if (isset($errors['website'])) { echo $errors['website']; } ?></strong></label>
            <input type="text" name="website" id="website" maxlength="40" value="" placeholder="<?php echo $publisher['website']; ?>" /></p>
            
            <p><label>Description:<strong><?php if (isset($errors['description'])) { echo $errors['description']; } ?></strong></label>
            <textarea name="description" id="description" cols="20" rows="15"><?php echo $publisher['description']; ?></textarea></p>
            
            <p><label>&nbsp;</label>
            <input type="submit" name="updatePublisher" id="updatePublisher" value="Update" class="submit-btn"/></p>
        </fieldset>    
    </form>
</div>  
<a href="admin/publishers/view/<?php echo $publisher['publisher_id']; ?>">&#8656; Back to Publisher</a>
