<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bhnk_db";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set PDO to throw exceptions on errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // If connection fails, display an error message
    die("PDO connection failed: " . $e->getMessage());
}
?>
s