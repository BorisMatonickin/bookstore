<!-- ******************************************************* confirm order details ************************************************************************* -->
<div id="page" class="order-shell">   
    <h3>Confirm Your Order</h3>
    <p class="stock"><?php if (isset($flashMessage)) { echo $flashMessage; } ?></p>
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
            <td><?php echo $data['name']; ?></td>
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
            <td><?php echo $totalAndDiscount['subtotal']; ?></td>
          </tr>
          <?php if (isset($totalAndDiscount['discount'])) { ?>
          <tr class="extracosts">
            <td class="light">Discount</td>
            <td colspan="1" class="light"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>$<?php echo $totalAndDiscount['discount']; ?></td>
          </tr>
          <?php } ?>
          <tr class="totalprice">
            <td class="light">Total:</td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="1"><span class="thick">$<?php echo $totalAndDiscount['total']; ?></span></td>
          </tr>
        </tbody>
    </table>
<!-- *************************************************************** discount code and delivery address details ******************************************** -->    
    <?php if (isset($totalAndDiscount['discountCode'])) { ?>
    <div class="element-list confirm-order">
        <h4>Discount Code</h4>
        <p><?php echo $totalAndDiscount['discountCode']; ?></p>
    </div>
    <?php } ?>
    <div class="element-list confirm-order">
        <h4>Payment Method</h4>
        <p><?php echo $deliveryAddress['paymentMethod']; ?></p>
    </div>
    <div class="element-list confirm-order">
        <h4>Delivery Address</h4>
        <p><?php echo $deliveryAddress['name'] . ', ' . $deliveryAddress['address'] . ', ' . $deliveryAddress['zip'] . ' ' . $deliveryAddress['city'] . ', ' .
                ((isset($deliveryAdddress['state'])) ? $deliveryAddress['state'] . ', ' . $deliveryAddress['country'] : $deliveryAddress['country']); ?></p>
    </div>

<!-- ********************************************************* confirm or cancel order buttons *********************************************************** -->
    <div class="order-buttons">
        <a href="checkout/cancel-order" name="saveOrder" class="submitbtn order-btn-1">Cancel Order</a>
        <a href="checkout/save-order" name="cancelOrder" class="submitbtn order-btn-2">Confirm Order</a>
    </div>
</div>    
<div class="cl">&nbsp;</div>
    