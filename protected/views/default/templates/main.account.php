<!-- ************************************************************** user info in account section ********************************************************** -->
<?php if (isset($flashMessage)) { echo $flashMessage; } ?>
<table class="user-info">
    <tr>
        <td>First Name:</td>
        <td><?php echo $userInfo['first_name']; ?></td>
    </tr>
    <tr>
        <td>Last Name:</td>
        <td><?php echo $userInfo['last_name']; ?></td>
    </tr>
    <tr>
        <td>Address:</td>
        <td><?php echo $userInfo['address']; ?></td>
    </tr>
    <tr>
        <td>City:</td>
        <td><?php echo $userInfo['city']; ?></td>
    </tr>
    <tr>
        <td>Country:</td>
        <td><?php echo $userInfo['country_name']; ?></td>
    </tr>
    <tr>
        <td>State:</td>
        <td><?php echo ($userInfo['state_name'] === null || $userInfo['state_name'] === 'SELECT' ? '-' : $userInfo['state_name']); ?></td>
    </tr>
    <tr>
        <td>Zip:</td>
        <td><?php echo $userInfo['zip']; ?>
    </tr>
    <tr>
        <td>Email Address:</td>
        <td><?php echo $userInfo['email']; ?></td>
    </tr>
</table>