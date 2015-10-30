<!-- ***************************************************************** create new author ******************************************************************* -->
<div id="page" class="order-shell">
    <h1>Insert New Discount Code</h1>
    <form action="admin/settings/create-discount" method="post">
        <fieldset>
            <h5>Required fields are marked with <img src="public/css/images/required_star.gif" alt="" /></h5>
            <p><input type="hidden" name="token" id="token" value="<?php echo $token; ?>"></p>
            
            <p><label class="required">Discount Name:<strong><?php if (isset($errors['name']) && !isset($missing['name'])) { echo $errors['name']; } 
                                        if (isset($missing['name'])) { echo $missing['name']; }?></strong></label>
            <input type="text" name="name" id="name" maxlength="25"
                   value="<?php if (isset($input['name'])) { echo $input['name']; } ?>" /></p>
            
            <p><label class="required">Active:<strong><?php if (isset($errors['active']) && !isset($missing['active'])) { echo $errors['active']; } 
                                    if (isset($missing['active'])) { echo $missing['active']; }?></strong></label>
            <select name="active">
                <option value="">SELECT</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select></p>
            
            <p><label class="required">Discount Operation:<strong><?php if (isset($errors['operation']) && !isset($missing['operation'])) { echo $errors['operation']; } 
                                    if (isset($missing['operation'])) { echo $missing['operation']; }?></strong></label>
            <select name="operation">
                <option value="">SELECT</option>
                <option value="-">Fixed Amount Off (-)</option>
                <option value="%">Percentage Off (%)</option>
            </select></p>
            
            <p><label class="required">Discount Amount:<strong><?php if (isset($errors['amount']) && !isset($missing['amount'])) { echo $errors['amount']; } 
                                        if (isset($missing['amount'])) { echo $missing['amount']; }?></strong></label>
            <input type="text" name="amount" id="amount" maxlength="5"
                   value="<?php if (isset($input['amount'])) { echo $input['amount']; } ?>" /></p>
            <small>Discount amount should be in decimal number format even if it's whole number e.g. 6.00</small>
            
            <p><label class="required">Min Basket Amount:<strong><?php if (isset($errors['minBasket']) && !isset($missing['minBasket'])) { echo $errors['minBasket']; } 
                                        if (isset($missing['minBasket'])) { echo $missing['minBasket']; }?></strong></label>
            <input type="text" name="minBasket" id="minBasket" maxlength="5"
                   value="<?php if (isset($input['minBasket'])) { echo $input['minBasket']; } ?>" /></p>
            <small>Minimal basket amount should be in decimal number format even if it's whole number e.g. 6.00</small>
            
            <p><label>Discounts Available:<strong><?php if (isset($errors['available']) && !isset($missing['available'])) { echo $errors['available']; } 
                                        if (isset($missing['available'])) { echo $missing['available']; }?></strong></label>
            <input type="text" name="available" id="available" maxlength="5"
                   value="<?php if (isset($input['available'])) { echo $input['available']; } ?>" /></p>
            <small>Please leave empty if number of codes available is infinite</small>
            
            <p><label class="required">Expiration Date:<strong><?php if (isset($errors['dateExpires']) && !isset($missing['dateExpires'])) { echo $errors['dateExpires']; } 
                                        if (isset($missing['dateExpires'])) { echo $missing['dateExpires']; }?></strong></label>
            <input type="text" name="dateExpires" id="dateExpires" maxlength="60"
            value="<?php if (isset($input['dateExpires'])) { echo $input['dateExpires']; } ?>" /></p>
            <small>Date should be in YYYY-MM-DD format</small>
            
            <p><label>&nbsp;</label>
            <input type="submit" name="createDiscount" id="createDiscount" value="Create" class="submit-btn"/></p>
        </fieldset>    
    </form>
</div>
<a href="admin/settings/">&#8656; Back to Settings</a>
