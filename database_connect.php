<?php

//MySQL database connection details
$host = "localhost";
$database_name = "recipe_login";
$db_username = "root";
$db_password = "";

//Creates an object for the MySQL connection
$sql_object = new mysqli(hostname: $host, database: $database_name, username: $db_username, password: $db_password);

//Checks for a database connection error. Throws an error if it can't connect
if ($sql_object->connect_errno) {
    die("Error when connecting: " . $sql_object->connect_error);
}

return $sql_object;