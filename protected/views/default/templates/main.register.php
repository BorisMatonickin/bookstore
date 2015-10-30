<!-- ********************************************************************* registration form *************************************************************** -->
<h1>Register</h1>
<?php if (isset($error)) { echo $error; } ?>
<?php if (isset($doubleEmailError)) { echo $doubleEmailError; } ?>
<form action="registration/register" method="post" class="register">
    <fieldset>
        <p><input type="hidden" name="token" id="token" value="<?php echo $token; ?>"></p>
        <p><label>First Name:<strong><?php if (isset($errors['firstName']) && !isset($missing['firstName'])) { echo $errors['firstName']; } 
                                    if (isset($missing['firstName'])) { echo $missing['firstName']; }?></strong></label>
        <input type="text" name="firstName" id="firstName" maxlength="20"
               value="<?php if (isset($input['firstName'])) { echo $input['firstName']; } ?>" /></p>

        <p><label>Last Name:<strong><?php if (isset($errors['lastName']) && !isset($missing['lastName'])) { echo $errors['lastName']; } 
                                    if (isset($missing['lastName'])) { echo $missing['lastName']; }?></strong></label>
        <input type="text" name="lastName" id="lastName" maxlength="40"
               value="<?php if (isset($input['lastName'])) { echo $input['lastName']; } ?>" /></p>

        <p><label>Address:<strong><?php if (isset($errors['address']) && !isset($missing['address'])) { echo $errors['address']; } 
                                    if (isset($missing['address'])) { echo $missing['address']; }?></strong></label>
        <input type="text" name="address" id="address" maxlength="80"
        value="<?php if (isset($input['address'])) { echo $input['address']; } ?>" /></p>

        <p><label>City:<strong><?php if (isset($errors['city']) && !isset($missing['city'])) { echo $errors['city']; } 
                                    if (isset($missing['city'])) { echo $missing['city']; }?></strong></label>
        <input type="text" name="city" id="city" maxlength="60"
        value="<?php if (isset($input['city'])) { echo $input['city']; } ?>" /></p>

        <p><label>Country:<strong><?php if (isset($errors['country']) && !isset($missing['country'])) { echo $errors['country']; } 
                                    if (isset($missing['country'])) { echo $missing['country']; }?></strong></label>
            <select name="country">
                <option value="">SELECT</option>
                <?php foreach ($countries as $abbrev => $country) : ?>
                <option value="<?php echo $abbrev; ?>"
                <?php if (isset($_POST['country']) && $_POST['country'] == $abbrev) { echo ' selected="selected"'; } ?>><?php echo $country; ?></option>
                <?php endforeach; ?>
            </select></p>

            <p><label>State:<strong><?php if (isset($errors['state']) && !isset($missing['state'])) { echo $errors['state']; } 
                                    if (isset($missing['state'])) { echo $missing['state']; }?></strong></label>
            <select name="state">
                <?php foreach ($states as $abbrev => $state) : ?>
                <option value="<?php echo $abbrev; ?>"
                <?php if (isset($_POST['state']) && $_POST['state'] == $abbrev) { echo ' selected="selected"'; } ?>><?php echo $state; ?></option>
                <?php endforeach; ?>
            </select></p>
            <small>Please choose if you live in United States.</small>

            <p><label>Zip Code:<strong><?php if (isset($errors['zipCode']) && !isset($missing['zipCode'])) { echo $errors['zipCode']; } 
                                    if (isset($missing['zipCode'])) { echo $missing['zipCode']; }?></strong></label>
        <input type="text" name="zipCode" id="zipCode" maxlength="5"
        value="<?php if (isset($input['zipCode'])) { echo $input['zipCode']; } ?>" /></p>

            <p><label>Email Address:<strong><?php if (isset($errors['email']) && !isset($missing['email'])) { echo $errors['email']; } 
                                    if (isset($missing['email'])) { echo $missing['email']; }?></strong></label>
        <input type="email" name="email" id="email" maxlength="60"
        value="<?php if (isset($input['email'])) { echo $input['email']; } ?>" /></p>

            <p><label>Password:<strong><?php if (isset($errors['password1']) && !isset($missing['password1'])) { echo $errors['password1']; } 
                                    if (isset($missing['password1'])) { echo $missing['password1']; }?></strong></label>
        <input type="password" name="password1" id="password1" maxlength="20"
        value="<?php if (isset($input['password1'])) { echo $input['password1']; } ?>" /></p>
        <small>Use only letters, numbers, and the underscore. Must be between 4 and 20 characters long.</small>

        <p><label>Confirm Password:<strong><?php if (isset($errors['password2']) && !isset($missing['password2'])) { echo $errors['password2']; } 
                                    if (isset($missing['password2'])) { echo $missing['password2']; }?></strong></label>
        <input type="password" name="password2" id="password2" maxlength="20"
        value="<?php if (isset($input['password2'])) { echo $input['password2']; } ?>" /></p>

        <p><label><span class="captcha-img"><?php echo $captcha; ?></span><strong><?php if (isset($errors['captcha'])) { echo $errors['captcha']; } ?></strong></label>
        <input type="text" maxlength="6" name="captcha" id="captcha" class="captcha" /></p>

        <p><label>&nbsp;</label>
        <input type="submit" name="register" id="submit" value="Register" class="submit-btn"/></p>
    </fieldset>
</form>