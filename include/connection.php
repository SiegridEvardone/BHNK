<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bhnk_db";

// Establish a connection using mysqli
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
