<?php
ob_start(); // Start output buffering
session_start(); // Start the session

include('../include/pdoconnect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: ../userlogin.php");
    exit();
}

// Check if notice ID is provided
if (!isset($_GET['id'])) {
    // Redirect to notices.php if notice ID is not provided
    header("Location: notices.php");
    exit();
}

// Get the notice ID from the URL
$notice_id = $_GET['id'];

// Prepare SQL statement to delete the notice
$sql = "DELETE FROM tblnotices WHERE id = ?";
$stmt = $pdo->prepare($sql);

// Execute the SQL statement
$stmt->execute([$notice_id]);

// Redirect back to notices.php after deletion
header("Location: notices.php");
exit();

ob_end_flush(); // Flush the output buffer and turn off output buffering
?>
