<?php

//Creates a session via cookies
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>

    <h1>Home</h1>

    <!--Checks if session data is stored-->
    <?php if (isset($_SESSION["user_id"])): ?>

        <p>You are now logged in</p>

    <!--Gives the user links to log in or sign up-->
    <?php else: ?>

        <p>Please <a href="login_page.php">log in</a> or <a href="signup_form.html">sign up</a></p>
    
    <?php endif; ?>


</body>
</head>