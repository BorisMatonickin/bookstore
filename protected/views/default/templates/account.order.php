<!-- ***************************************************************** info about user order ******************************************************************* -->
<div id="page">
    <h4>Order Nr.<?php echo $order['order_id']; ?></h4>
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
          <?php foreach($books as $bookId => $data) : ?>
          <tr class="productitm">
            <td><img src="protected/uploads/product-images/<?php echo $data['image']; ?>" width="50" height="66" class="thumb" alt="" 
                     title="<?php echo $data['title']; ?>" /></td>
            <td><?php echo $data['quantity']; ?></td>
            <td><?php echo $data['title']; ?></td>
            <td><?php echo $data['price_per']; ?></td>
            <td><?php echo $data['lineTotal']; ?></td>
          </tr>
          <?php endforeach; ?>
          
          <!-- discount + subtotal + total-->
          <tr class="extracosts">
            <td class="light">Subtotal</td>
            <td colspan="1" class="light"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo $order['subtotal']; ?></td>
          </tr>
          <?php if (isset($order['discount'])) { ?>
          <tr class="extracosts">
            <td class="light">Discount</td>
            <td colspan="1" class="light"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo $order['discount']; ?></td>
          </tr>
          <?php } ?>
          <tr class="totalprice">
            <td class="light">Total:</td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="1"><span class="thick">$<?php echo $order['total']; ?></span></td>
          </tr>
        </tbody>
    </table>
</div>

<!-- ************************************************************** discount code and order delivery address info ***************************************** -->
<?php if (isset($order['voucher_code'])) { ?>
<div class="element-list confirm-order">
    <h4>Discount Code</h4>
    <p><?php echo $order['voucher_code']; ?></p>
</div>
<?php } ?>
<div class="element-list confirm-order">
    <h4>Delivery Address</h4>
    <p><?php echo $order['delivery_name'] . ', ' . $order['delivery_address'] . ', ' . $order['delivery_zip'] . ' ' . $order['delivery_city'] . ', ' . 
            (($order['delivery_state'] == null) ? $order['delivery_country'] : $order['delivery_state'] . ', ' . $order['delivery_country']); ?></p>
</div>
<div class="cl">&nbsp;</div>
<a href="account/my-orders">&#8656; Back to Orders</a>
