<?php

//Check that a name is entered
if (empty($_POST["name"])) {
    die("name requrired");
}

//Checks that the email is a valid email format
if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Email must be valid");
}

//Checks that a password has been entered and that it is at least 6 characters long
if (strlen($_POST["password"]) < 6) {
    die("Password must be 6 characters or more");
}

//Checks that both entered passwords match
if ($_POST["password"] !== $_POST["confirm_password"]) {
    die("Passwords do not match");
}

$hashed_password = password_hash($_POST["password"], PASSWORD_DEFAULT);

$sql_var = require __DIR__ . "/database_connect.php";

print_r($_POST);
var_dump($hashed_password);
