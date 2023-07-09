<?php

$host = "localhost";
$database_name = "recipe_login";
$db_username = "root";
$db_password = "";

$sql_object = new mysqli(hostname: $host, database: $database_name, username: $db_username, password: $db_password);

if ($sql_object->connect_errno) {
    die("Error when connecting: " . $sql_object->connect_error);
}

return $sql_object;