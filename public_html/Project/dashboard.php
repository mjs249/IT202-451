<?php
require(__DIR__ . "/../../partials/nav.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css"> 
<body>
    <h1>Welcome to Your Dashboard</h1>
    <?php if (is_logged_in(true)) : ?>
        <?php //echo "Welcome home, " . get_username(); ?>
        <?php //comment this out if you don't want to see the session variables ?>
        <?php error_log("Session data: " . var_export($_SESSION, true)); ?>
    <?php endif; ?>

    <nav>
        <ul>
        <li><a href="<?php echo get_url('newAccount.php'); ?>">Create Account</a></li>
            <li><a href="#">My Accounts</a></li>
            <li><a href="#">Deposit</a></li>
            <li><a href="#">Withdraw</a></li>
            <li><a href="#">Transfer</a></li>
            <li><a href="#">Profile</a></li>
        </ul>
    </nav>

    <?php require(__DIR__ . "/../../partials/flash.php"); ?>
</body>
</html>