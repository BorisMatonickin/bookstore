<!-- ************************************************************** contact us form ************************************************************************* -->
<h1>Contact Us</h1>
<?php if(isset($error)) { echo $error; } ?>
<form action="contact" method="post">
	<fieldset>
        <p><input type="hidden" name="token" value="<?php echo $token; ?>" /></p>
        <p><label>Name:<strong><?php if(isset($errors['name']) && !isset($missing['name'])) { echo $errors['name']; } 
                                        if (isset($missing['name'])) { echo $missing['name']; } ?></strong></label>
		<input type="text" name="name" id="name" size="40" maxlength="80" 
        value="<?php if (isset($input['name'])) { echo $input['name']; } ?>" /></p>
        <p><label>Email Address:<strong><?php if(isset($errors['email']) && !isset($missing['email'])) { echo $errors['email']; } 
                                                if (isset($missing['email'])) { echo $missing['email']; } ?></strong></label>
		<input type="email" name="email" id="email" size="20" maxlength="60" 
        value="<?php if (isset($input['email'])) { echo $input['email']; } ?>" /></p>
        <p><label>Message:<strong><?php if(isset($errors['message']) && !isset($missing['message'])) { echo $errors['message']; } 
                                        if (isset($missing['message'])) { echo $missing['message']; } ?></strong></label>
        <textarea name="message" rows="15" cols="33"><?php if (isset($input['message'])) { echo $input['message']; } ?></textarea></p>
        <p><label><span class="captcha-img"><?php echo $captcha; ?></span><strong><?php if (isset($errors['captcha'])) { echo $errors['captcha']; } ?></strong></label>
            <input type="text" maxlength="6" name="captcha" id="captcha" class="captcha" /></p>
		<p><label>&nbsp;</label><input type="submit" name="send" value="Send" class="submit-btn"/></p>
	</fieldset>
</form>

