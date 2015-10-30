<!-- ******************************************************************** update user info form ************************************************************** -->
<div id="page" class="order-shell">
    <h1>Update Customer</h1>
    <?php if (isset($doubleEmail)) { echo $doubleEmail; } ?>
    <?php if (isset($activationError)) { echo $activationError; } ?>
    <form action="" method="post">
        <fieldset>
            <p class="stock">All form fields are optional. Only data which require change should be entered.</p>
            <p><input type="hidden" name="token" id="token" value="<?php echo $token; ?>"></p>
            
            <p><label>First Name:<strong><?php if (isset($errors['first_name'])) { echo $errors['first_name']; } ?></strong></label>
            <input type="text" name="first_name" id="first_name" maxlength="20" value="" placeholder="<?php echo $user['first_name']; ?>" /></p>
            
            <p><label>Last Name:<strong><?php if (isset($errors['last_name'])) { echo $errors['last_name']; } ?></strong></label>
            <input type="text" name="last_name" id="lastName" maxlength="40" value="" placeholder="<?php echo $user['last_name']; ?>" /></p>
                
            <p><label>Address:<strong><?php if (isset($errors['address'])) { echo $errors['address']; } ?></strong></label>
            <input type="text" name="address" id="address" maxlength="60" value="" placeholder="<?php echo $user['address']; ?>" /></p>
            
            <p><label>City:<strong><?php if (isset($errors['city'])) { echo $errors['city']; }?></strong></label>
            <input type="text" name="city" id="city" maxlength="60" value="" placeholder="<?php echo $user['city']; ?>" /></p>
            
            <p><label>Country:<strong><?php if (isset($errors['country'])) { echo $errors['country']; } ?></strong></label>
            <select name="country">
                <option value="">SELECT</option>
                <?php foreach ($countries as $abbrev => $country) : ?>
                <option value="<?php echo $abbrev; ?>"
                <?php if ($abbrev == $user['country_abbrev']) { echo ' selected="selected"'; } ?>><?php echo $country; ?></option>
                <?php endforeach; ?>
            </select></p>
            
            <p><label>State:<strong><?php if (isset($errors['state'])) { echo $errors['state']; } ?></strong></label>
            <select name="state">
                <?php foreach ($states as $abbrev => $state) : ?>
                <option value="<?php echo $abbrev; ?>"
                <?php if ($abbrev == $user['state_abbrev']) { echo ' selected="selected"'; } ?>><?php echo $state; ?></option>
                <?php endforeach; ?>
            </select></p>
            
            <p><label>Zip Code:<strong><?php if (isset($errors['zip'])) { echo $errors['zip']; } ?></strong></label>
            <input type="text" name="zip" id="zip" maxlength="5" value="" placeholder="<?php echo $user['zip']; ?>" /></p>
            
            <p><label>Email:<strong><?php if (isset($errors['email'])) { echo $errors['email']; } ?></strong></label>
            <input type="text" name="email" id="email" maxlength="40" value="" placeholder="<?php echo $user['email']; ?>" /></p>
            <small>Upon changing email address, an email with confirmation token is sent to the user.</small>
            
            <p><label>User Level:<strong><?php if (isset($errors['user_level'])) { echo $errors['user_level']; } ?></strong></label>
            <select name="user_level">
                <option value="">SELECT</option>
                <option value="0" <?php if ($user['user_level'] == 0) { echo ' selected="selected"'; } ?>>Regular User</option>
                <option value="1" <?php if ($user['user_level'] == 1) { echo ' selected="selected"'; } ?>>Admin</option>
            </select></p>
            
            <p><label>&nbsp;</label>
            <input type="submit" name="updateUser" id="updateUser" value="Update" class="submit-btn"/></p>
        </fieldset>    
    </form>
</div> 
<a href="admin/customers/view/<?php echo $user['user_id']; ?>">&#8656; Back to Customer</a>