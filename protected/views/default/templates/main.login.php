<!-- **************************************************************** login form *************************************************************************** -->
<h1>Login</h1>
<?php if (isset($loginError)) { echo $loginError; } ?>
<form action="authenticate/login" method="post">
	<fieldset>
        <input type="hidden" name="token" value="<?php echo $token; ?>" />
        <p><label>Email Address:<strong><?php if (isset($loginErrors['email']) && !isset($missing['email'])) { echo $loginErrors['email']; } 
                                        if (isset($missing['email'])) { echo $missing['email']; }?></strong></label>
		<input class="field" type="email" name="email" id="email" size="20" maxlength="60" 
               value="<?php if (isset($input['email'])) { echo $input['email']; }?>" />

        <p><label>Password:<strong><?php if (isset($loginErrors['password']) && !isset($missing['password'])) { echo $loginErrors['password']; } 
                                    if (isset($missing['password'])) { echo $missing['password']; }?></strong></label>
		<input class="field" type="password" name="password" id="password" size="20" maxlength="20"
        value="<?php if (isset($input['password'])) { echo $input['password']; } ?>" />
        
		<p><label>&nbsp;</label>
		<input class="submit-btn" type="submit" name="login" value="Login" />
		<a href="authenticate/password" class="forgot">Forgot Password?</a>
	</fieldset>
</form>
<p>Don't have account? We offer registration to our store by which you get special offers and discounts.
	<a href="registration/register">Register Now!</a></p>
