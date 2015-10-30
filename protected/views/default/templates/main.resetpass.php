<!-- ***************************************************** reset password form for not logged users ********************************************************** -->
<h1>Change Password</h1>
<form action="" method="post">
    <fieldset>
        <input type="hidden" name="token" value="<?php echo $token; ?>" />
        <p><label>New Password:<strong><?php if (isset($resetErrors['password1']) && !isset($missing['password1'])) { echo $resetErrors['password1']; }
                                        if (isset($missing['password1'])) { echo $missing['password1']; } ?></strong></label>
            <input type="password" name="password1" id="password1" size="20" maxlength="20" 
                   value="<?php if(isset($input['password1'])) { echo $input['password1']; } ?>"/></p>
        <small>Use only letters, numbers, and the underscore. Must be between 4 and 20 characters long.</small>
        
        <p><label>Confirm Password:<strong><?php if (isset($resetErrors['password2']) && !isset($missing['password2'])) { echo $resetErrors['password2']; } 
                                            if (isset($missing['password2'])) { echo $missing['password2']; } ?></strong></label>
            <input type="password" name="password2" id="password2" size="20" maxlength="20" 
                   value="<?php if (isset($input['password2'])) { echo $input['password2']; } ?>"/></p>
        <input type="submit" name="resetPassword" id="submit" value="Change Password" class="submit-btn" />
    </fieldset>    
</form>
