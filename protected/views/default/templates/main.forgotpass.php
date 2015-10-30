<!-- ************************************************************* forgot password form ********************************************************************* -->
<h1>Forgot Your Password?</h1>
<?php if (isset($forgotError)) { echo $forgotError; } ?>
<form action="authenticate/password" method="post">
    <fieldset>
        <p>Please enter your email address:</p>
        <input type="hidden" name="token" value="<?php echo $token; ?>" />
        <p><label><strong class="forgot_error"><?php if (isset($errors['email']) && !isset($missing['email'])) { echo $errors['email']; }
                                                if (isset($missing['email'])) { echo $missing['email']; } ?></strong></label>
        <input class="field" name="email" id="email" size="20" maxlength="60"
        value="" /></p>
        <input class="submit-btn" type="submit" name="forgotPassword" value="Reset Password" />
    </fieldset>    
</form>

