<?php
session_start();
include('../include/connection.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ulogin.php");
    exit();
}

// Check if the complaint ID is provided
if (!isset($_GET['id'])) {
    header("Location: ucomplaints.php");
    exit();
}

// Get the complaint ID from the URL
$complaint_id = $_GET['id'];

// Prepare and execute the deletion query
$stmt = $conn->prepare("DELETE FROM tblcomplaints WHERE id = ?");
$stmt->bind_param("i", $complaint_id);

if ($stmt->execute()) {
    // Deletion successful
    $stmt->close();
    $conn->close();
    header("Location: ucomplaints.php"); // Redirect back to complaints page
    exit();
} else {
    // Deletion failed
    echo "Error: Unable to delete the complaint.";
}
?>
