<?php
session_start();

// Include database connection
include('../include/pdoconnect.php');

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize inputs
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);
    $visibility = $_POST['visibility'];
    $recipient_user_id = ($visibility === 'private') ? $_POST['recipient_user_id'] : null;

    // Insert notice into database
    $sql = "INSERT INTO tblnotices (title, content, visibility, recipient_user_id) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$title, $content, $visibility, $recipient_user_id])) {
        // Redirect to notices page after successful insertion
        $_SESSION['success_message'] = "Notice posted successfully.";
        header("Location: notices.php");
        exit();
    } else {
        // Redirect with error message if insertion fails
        $_SESSION['error_message'] = "Failed to post notice. Please try again.";
        header("Location: post_notice.php");
        exit();
    }
} else {
    // Redirect if the form was not submitted properly
    header("Location: post_notice.php");
    exit();
}
?>
