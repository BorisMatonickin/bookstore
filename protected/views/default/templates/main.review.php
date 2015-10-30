<!-- *********************************************************** review form ********************************************************************************* -->
<h3><?php echo $product['title']; ?></h3>
<h1>Review</h1>
<?php if(isset($error)) { echo $error; } ?>
<form action="" method="post" class="review">
    <fieldset>
        <input type="hidden" name="token" value="<?php echo $token; ?>" />
        <p><label>Title:<strong><?php if(isset($errors['title']) && !isset($missing['title'])) { echo $errors['title']; } 
                                    if (isset($missing['title'])) { echo $missing['title']; } ?></strong></label>
            <input type="text" name="title" id="title" size="20" maxlength="100" value="<?php if (isset($input['title'])) { echo $input['title']; } ?>" /></p>
        <p><label>Review:<strong><?php if (isset($errors['review']) && !isset($missing['review'])) { echo $errors['review']; } 
                                      if (isset($missing['review'])) { echo $missing['review']; } ?></strong></label>
            <textarea name="review" id="review" cols="20" rows="20"><?php if (isset($input['review'])) { echo $input['review']; } ?></textarea></p>
        <p><label><span class="captcha-img"><?php echo $captcha; ?></span><strong><?php if (isset($errors['captcha'])) { echo $errors['captcha']; } ?></strong></label>
            <input type="text" maxlength="6" name="captcha" id="captcha" class="captcha" /></p>
        <p><label>&nbsp;</label>
            <input type="submit" name="submitReview" id="submitReview" value="Submit" class="submit-btn" />
    </fieldset>    
</form>
