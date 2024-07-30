<?php
session_start();
include('../include/pdoconnect.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = intval($_POST['user_id']); // Get user ID from POST data

    // Ensure the user ID matches the logged-in user
    if ($user_id !== $_SESSION['user_id']) {
        die("Unauthorized action.");
    }

    // Prepare the SQL query to delete the user
    $sql = "DELETE FROM tbluser WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        // Log out the user
        session_unset();
        session_destroy();

        // Redirect to the success page with an alert
        echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Account Deleted</title>
            <script>
                alert('You have successfully deleted your account.');
                window.location.href = 'login.php';
            </script>
        </head>
        <body>
        </body>
        </html>";
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Redirect to profile page if accessed directly
    header("Location: profile.php");
    exit();
}
?>
