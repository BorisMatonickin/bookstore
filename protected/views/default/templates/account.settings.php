<!-- ************************************************************** change account settings form *********************************************************** -->
<?php if (isset($settingsError)) { echo $settingsError; } ?>
<form action="account/settings" method="post" class="register">
        <fieldset>
            <input type="hidden" name="token" value="<?php echo $token; ?>" />
            <p><label>First Name:<strong><?php if (isset($errors['first_name'])) { echo $errors['first_name']; } ?></strong></label>
            <input type="text" name="first_name" id="firstName" size="20" maxlength="20"
                   value="" placeholder="<?php echo $userInfo['first_name']; ?>" /></p>

            <p><label>Last Name:<strong><?php if (isset($errors['last_name'])) { echo $errors['last_name']; } ?></strong></label>
            <input type="text" name="last_name" id="lastName" size="20" maxlength="40"
                   value="" placeholder="<?php echo $userInfo['last_name']; ?>" /></p>

            <p><label>Address:<strong><?php if (isset($errors['address'])) { echo $errors['address']; } ?></strong></label>
            <input type="text" name="address" id="address" size="60" maxlength="80"
            value="" placeholder="<?php echo $userInfo['address']; ?>" /></p>

            <p><label>City:<strong><?php if (isset($errors['city'])) { echo $errors['city']; } ?></strong></label>
            <input type="text" name="city" id="city" size="40" maxlength="60"
                   value="" placeholder="<?php echo $userInfo['city']; ?>" /></p>

            <p><label>Country:<strong><?php if (isset($errors['country'])) { echo $errors['country']; } ?></strong></label>
                <select name="country">
                    <option value="">SELECT</option>
                    <?php foreach ($countries as $abbrev => $country) : ?>
                    <option value="<?php echo $abbrev; ?>"
                    <?php if ($abbrev == $userInfo['country_abbrev']) { echo 'selected="selected"'; } ?>><?php echo $country; ?></option>
                    <?php endforeach; ?>
                </select></p>
            
                <p><label>State:<strong><?php if (isset($errors['state'])) { echo $errors['state']; } ?></strong></label>
                <select name="state">
                    <?php foreach ($states as $abbrev => $state) : ?>
                    <option value="<?php echo $abbrev; ?>"
                    <?php if ($abbrev == $userInfo['state_abbrev']) { echo ' selected="selected"'; } ?>><?php echo $state; ?></option>
                    <?php endforeach; ?>
                </select></p>

                <p><label>Zip Code:<strong><?php if (isset($errors['zip'])) { echo $errors['zip']; } ?></strong></label>
            <input type="text" name="zip" id="zipCode" size="5" maxlength="5"
                   value="" placeholder="<?php echo $userInfo['zip']; ?>" /></p>

            <p><label>Email Address:</label><?php echo $userInfo['email']; ?></p>       
            <small>If you need to change your email address please contact system administrator.</small>   

            <p><label>New Password:<strong></strong></label>
            <a href="account/reset-password">Change Password?</a></p>
            <small>If you need to change your password please click link above.</small>

            <p><label>&nbsp;</label>
            <input type="submit" name="save" id="submit" value="Save" class="submit-btn"/></p>
        </fieldset>
    </form>
