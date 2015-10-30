    </div>
    <!-- End Content -->
    <div class="cl">&nbsp;</div>
</div>
<!-- End Main -->
<!-- ********************************************************************** footer ************************************************************************ -->
<div id="footer" class="shell">
    <div class="top">
        <div class="cnt">
                <div class="col about">
                    <h4>About BestSellers</h4>
                    <p>Nulla porttitor pretium mattis. Mauris lorem massa, ultricies non mattis bibendum, semper ut erat. 
                        Morbi vulputate placerat ligula. Fusce <br />convallis, nisl a pellentesque viverra, ipsum leo sodales sapien, 
                        vitae egestas dolor nisl eu tortor. Etiam ut elit vitae nisl tempor tincidunt. Nunc sed elementum est. Phasellus 
                        sodales viverra mauris nec dictum. Fusce a leo libero. Cras accumsan enim nec massa semper eu hendrerit nisl faucibus. 
                        Sed lectus ligula, consequat eget bibendum eu, consequat nec nisl. In sed consequat elit. Praesent nec iaculis sapien. <br />
                        Curabitur gravida pretium tincidunt.</p>
                </div>
                <div class="col store">
                    <h4>Store</h4>
                    <ul>
                        <li><a href="">Home</a></li>
                        <li><a href="authors">Authors</a></li>
                        <?php if (isset($loggedIn) && $loggedIn == true) { ?>
                        <li><a href="account/info">Account</a></li>
                        <li><a href="authenticate/logout">Logout</a></li>   
                        <?php } else { ?>
                        <li><a href="authenticate/login">Login</a></li>
                        <li><a href="registration/register">Register</a></li>
                        <?php } ?>
                        <li><a href="basket/view">Basket</a></li>
                        <li><a href="checkout">Checkout</a></li>
                    </ul>
                </div>
                <div class="col" id="newsletter">
                    <h4>Newsletter</h4>
                    <p>Lorem ipsum dolor sit amet  consectetur. </p>
                    <form action="" method="post">
                        <input type="text" class="field" value="Your Name" title="Your Name" />
                        <input type="text" class="field" value="Email" title="Email" />
                        <div class="form-buttons"><input type="submit" value="Submit" class="submit-btn" /></div>
                    </form>
                </div>
                <div class="cl">&nbsp;</div>
                <div class="copy">
                    <p>&copy; <a href="#">BestSeller.com</a>. Design by <a href="http://css-free-templates.com/">CSS-FREE-TEMPLATES.COM</a></p>
                </div>
        </div>
    </div>
</div>
    </body>
</html>