<!-- ************************************************************* account navigation ************************************************************************ -->
<nav class="cf">
    <ul>
        <li><a href="account/info" <?php if ($title == 'My Account') { ?>class="current" <?php } ?>>Info</a></li>
        <li><a href="account/my-orders" <?php if ($title == 'My Orders') { ?>class="current" <?php } ?>>My Orders</a></li>
        <li><a href="account/wish-list" <?php if ($title == 'Wish List') { ?>class="current" <?php } ?>>Wish List</a></li>
        <li><a href="account/my-reviews" <?php if ($title == 'My Reviews') { ?>class="current" <?php } ?>>My Reviews</a></li>
        <li><a href="account/settings"<?php if ($title == 'Settings') { ?>class="current" <?php } ?> >Settings</a></li>
    </ul>
</nav>
