<?php
$localhost = "localhost";
$user = "root";
$password = "";
$db_name = "restaurant";

// $conn = mysqli_connect($localhost, $user, $pass, $db_name);

try {
    $connection = mysqli_connect($localhost, $user, $password, $db_name);
   // echo "Successfully connected to $db_name database";
} catch(Exception $e ) {
    echo "Failed to connect: ".mysqli_connect_error();
}
