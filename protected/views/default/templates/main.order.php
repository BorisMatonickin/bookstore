<!-- ************************************************************ set delivery address with order details ************************************************* -->
<div id="page" class="order-shell">
    <h3>Order Details</h3>
    <table id="cart">
      <thead>
        <tr>
          <th class="first">Photo</th>
          <th class="second">Qty</th>
          <th class="third">Product</th>
          <th class="midd">Price</th>
          <th class="fourth">Line Total</th>
        </tr>
      </thead>
      <tbody>
        <!-- shopping cart contents -->
        <?php foreach($orderDetails as $product => $data) : ?>
        <tr class="productitm">
          <td><img src="protected/uploads/product-images/<?php echo $data['image']; ?>" width="50" height="66" class="thumb" alt="" 
                   title="<?php echo $data['name']; ?>" /></td>
          <td><?php echo $data['quantity']; ?></td>
          <td><a href="products/view/<?php echo $urlProducts[$data['product']]; ?>"><?php echo $data['name']; ?></a></td>
          <td><?php echo $data['unitcost']; ?></td>
          <td><?php echo $data['subtotal']; ?></td>
        </tr>
        <?php endforeach; ?>
        
        <!-- discount + subtotal + total -->
        <tr class="extracosts">
          <td class="light">Subtotal</td>
          <td colspan="1" class="light"></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><?php echo $total; ?></td>
        </tr>
        <?php if (isset($discount)) { ?>
        <tr class="extracosts">
          <td class="light">Discount</td>
          <td colspan="1" class="light"></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><?php echo $discount; ?></td>
        </tr>
        <?php } ?>
        <tr class="totalprice">
          <td class="light">Total:</td>
          <td colspan="2">&nbsp;</td>
          <td>&nbsp;</td>
          <td colspan="1"><span class="thick">$<?php echo $total; ?></span></td>
        </tr>
      </tbody>
    </table>
    
<!-- ********************************************************* set delivery address form ***************************************************************** -->
    <form action="checkout/order-details" method="post">
        <div class="voucher">
            <p class="stock"><?php if (isset($flashMessage)) { echo $flashMessage; } ?></p>
            <h4>Have a discount code? Please enter it below:</h4>
            <input type="text" name="voucher" id="voucher" value="<?php if(isset($_POST['voucher'])) { echo htmlspecialchars($_POST['voucher']); } ?>"/>
            <p class="stock"><?php if(isset($voucherNotice)) { echo $voucherNotice; } ?></p>
        </div>
        <?php if(isset($error)) { echo $error; } ?>    
        <fieldset>
            <p><input type="hidden" name="token" value="<?php echo $token; ?>" /></p>
            <p><label>Payment Method:<strong><?php if (isset($errors['paymentMethod']) && !isset($missing['paymentMethod'])) { echo $errors['paymentMethod']; } 
                                                if (isset($missing['paymentMethod'])) { echo $missing['paymentMethod']; } ?></strong></label>
                <select name="paymentMethod" id="paymentMethod">
                    <option value="">SELECT</option>
                    <?php foreach ($paymentMethods as $id => $paymentMethod) : ?>
                    <option value="<?php echo $id; ?>"
                    <?php if (isset($_POST['paymentMethod']) && $_POST['paymentMethod'] == $id) { echo 'selected="selected"'; } ?>><?php echo $paymentMethod['name']; ?></option>
                    <?php endforeach; ?>
                </select></p>
            <p><label>Full Name:<strong><?php if (isset($errors['name']) && !isset($missing['name'])) { echo $errors['name']; } 
                                                if (isset($missing['name'])) { echo $missing['name']; } ?></strong></label>
            <input type="text" name="name" id="name" maxlength="80"
                   value="<?php if (isset($input['name'])) { echo $input['name']; } ?>" /></p>
            <p><label>Address:<strong><?php if (isset($errors['address']) && !isset($missing['address'])) { echo $errors['address']; } 
                                                if (isset($missing['address'])) { echo $missing['address']; } ?></strong></label>
            <input type="text" name="address" id="address" maxlength="80"
                   value="<?php if (isset($input['address'])) { echo $input['address']; } ?>" /></p>
            <p><label>City:<strong><?php if (isset($errors['city']) && !isset($missing['city'])) { echo $errors['city']; } 
                                                if (isset($missing['city'])) { echo $missing['city']; } ?></strong></label>
            <input type="text" name="city" id="city" maxlength="80"
                   value="<?php if (isset($input['city'])) { echo $input['city']; } ?>" /></p>
            <p><label>Country:<strong><?php if (isset($errors['country']) && !isset($missing['country'])) { echo $errors['country']; } 
                                                if (isset($missing['country'])) { echo $missing['country']; } ?></strong></label>
                <select name="country" id="country">
                    <option value="">SELECT</option>
                    <?php foreach ($countries as $abbrev => $country) : ?>
                    <option value="<?php echo $abbrev; ?>"
                    <?php if (isset($_POST['country']) && $_POST['country'] == $abbrev) { echo 'selected="selected"'; } ?>><?php echo $country; ?></option>        
                    <?php endforeach; ?>
                </select></p>
            <p><label>State:<strong><?php if (isset($errors['state']) && !isset($missing['state'])) { echo $errors['state']; } 
                                                if (isset($missing['state'])) { echo $missing['state']; } ?></strong></label>
                <select name="state" id="state">
                    <?php foreach ($states as $abbrev => $state) : ?>
                    <option value="<?php echo $abbrev; ?>"
                    <?php if (isset($_POST['state']) && $_POST['state'] == $abbrev) { echo 'selected="selected"'; } ?>><?php echo $state; ?></option>        
                    <?php endforeach; ?>
                </select></p>
                <small>Please choose if you live in United States.</small>
            <p><label>Zip:<strong><?php if (isset($errors['zip']) && !isset($missing['zip'])) { echo $errors['zip']; } 
                                                if (isset($missing['name'])) { echo $missing['name']; } ?></strong></label>
            <input type="text" name="zip" id="zip" maxlength="5"
                   value="<?php if (isset($input['zip'])) { echo $input['zip']; }?>" /></p>
            <p><label>&nbsp;</label>
            <input type="submit" name="submitAddress" id="submit" value="Submit" class="submit-btn"/></p>
        </fieldset>    
    </form>
</div>    
<div class="cl">&nbsp;</div>