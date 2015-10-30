<!-- ************************************************************ reset password form for logged users ****************************************************** -->
<h1>Change Your Password</h1>
<?php if (isset($changeError)) { echo $changeError; } ?>
<form action="" method="post">
    <fieldset>
        <input type="hidden" name="token" value="<?php echo $token; ?>" />
        <p><label>Current Password:<strong><?php if (isset($errors['password1']) && !isset($missing['password1'])) { echo $errors['password1']; } 
                                                if (isset($missing['password1'])) { echo $missing['password1']; } ?></strong></label>
            <input type="password" name="password1" id="password1" size="20" maxlength="20" 
                   value="<?php if (isset($input['password1'])) { echo $input['password1']; } ?>"/></p>
        <p><label>New Password:<strong><?php if (isset($errors['password2']) && !isset($missing['password2'])) { echo $errors['password2']; } 
                                                if (isset($missing['password2'])) { echo $missing['password2']; } ?></strong></label>
            <input type="password" name="password2" id="password2" size="20" maxlength="20" 
                   value="<?php if (isset($input['password2'])) { echo $input['password2']; } ?>"/></p>
        <small>Use only letters, numbers, and the underscore. Must be between 4 and 20 characters long.</small>
        <p><label>Confirm New Password:<strong><?php if (isset($errors['password3']) && !isset($missing['password3'])) { echo $errors['password3']; } 
                                                if (isset($missing['password3'])) { echo $missing['password3']; } ?></strong></label>
            <input type="password" name="password3" id="password3" size="20" maxlength="20" 
                   value="<?php if (isset($input['password3'])) { echo $input['password3']; } ?>"/></p>
        <p><label>&nbsp;</label>
            <input type="submit" name="resetPass" id="resetPass" value="Change Password" class="submit-btn" /></p>
    </fieldset>    
</form>