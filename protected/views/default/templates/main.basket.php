<!-- ********************************************************** main shopping basket ************************************************************************ -->
<form action="basket/update" method="post">
    <div id="w">
      <h3>Shopping Basket</h3>
      <?php if (isset($flashMessage)) { echo $flashMessage; } ?>
    <div id="page">
      <table id="cart">
        <thead>
          <tr>
            <th class="first">Photo</th>
            <th class="second">Qty</th>
            <th class="third">Product</th>
            <th class="midd">Price</th>
            <th class="fourth">Line Total</th>
            <th class="fifth">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          <!-- shopping cart contents -->
          <?php foreach($basketProducts as $product => $data) : ?>
          <tr class="productitm">
            <td><img src="protected/uploads/product-images/<?php echo $data['image']; ?>" width="50" height="66" class="thumb" alt="" 
                     title="<?php echo $data['name']; ?>" /></td>
            <td><input type="number" id="qty_" name="qty_<?php echo $data['basket']; ?>" value="<?php echo $data['quantity']; ?>" min="0" max="99" class="qtyinput"></td>
            <td><a href="products/view/<?php echo $urlProducts[$data['product']]; ?>"><?php echo $data['name']; ?></a></td>
            <td><?php echo $data['unitcost']; ?></td>
            <td><?php echo $data['subtotal']; ?></td>
            <td><a href="basket/remove-product/<?php echo $data['basket']; ?>"><span class="remove">
                        <img src="public/css/images/trash.png" alt="X" title="Remove" /></span></a></td>
          </tr>
          <?php endforeach; ?>
          <!-- discount + subtotal + total -->
          <tr class="extracosts">
            <td class="light">Subtotal</td>
            <td colspan="2" class="light"></td>
            <td>&nbsp;</td>
            <td><?php echo $total; ?></td>
            <td>&nbsp;</td>
          </tr>
          <?php if (isset($discount)) { ?>
          <tr class="extracosts">
            <td class="light">Discount</td>
            <td colspan="2" class="light"></td>
            <td>&nbsp;</td>
            <td><?php echo $discount; ?></td>
            <td>&nbsp;</td>
          </tr>
          <?php } ?>
          <tr class="totalprice">
            <td class="light">Total:</td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2"><span class="thick">$<?php echo $total; ?></span></td>
          </tr>
        </tbody>
      </table>
        <input type="submit" name="update" class="submitbtn" value="Update Basket" />
        <a href="<?php if(isset($loggedIn) && $loggedIn == true) { echo 'checkout/order-details'; } else { echo 'authenticate/login'; } ?>" 
           id="checkout-btn" name="checkout" class="submitbtn">Order Now</a>
    </div>
  </div>
</form>
