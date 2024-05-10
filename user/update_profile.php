<?php
session_start(); // Start the session

// Include necessary files and establish database connection
include('../include/pdoconnect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page if not logged in
    header("Location: ../userlogin.php");
    exit();
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];
$current_image_path = $user['image'];
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];
    $contact = $_POST['contact'];
    $home_address = $_POST['home_address'];
    $room_number = $_POST['room_number'];

    // Validate the selected room number
    $sql_validate_room = "SELECT room_number FROM tblrooms WHERE room_number = ?";
    $stmt_validate_room = $pdo->prepare($sql_validate_room);
    $stmt_validate_room->execute([$room_number]);
    $valid_room = $stmt_validate_room->fetch(PDO::FETCH_ASSOC);

    if (!$valid_room) {
        // Invalid room number selected, handle the error as needed
        $_SESSION['error_message'] = "Invalid room number selected.";
        header("Location: uprofile.php");
        exit();
    }

    // Handle image upload
    $image_path = 'profile_images/addphoto.png'; // Default image path
    if ($_FILES['image']['size'] > 0) {
        $target_dir = "profile_images/"; // Specify the directory where images will be stored
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = $target_file; // Set the image path if upload is successful   
        }else {
            // Handle image upload error
            $_SESSION['error_message'] = "Sorry, there was an error uploading your file.";
            header("Location: uprofile.php");
            exit();
        }
    }

    // Update user details in the database
    $sql = "UPDATE tbluser SET first_name = ?, middle_name = ?, last_name = ?, age= ?, email = ?, birthdate = ?, gender = ?, contact = ?, home_address = ?, room_number = ?, image = ? WHERE user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$first_name, $middle_name, $last_name, $age, $email, $birthdate, $gender, $contact, $home_address, $room_number, $image_path, $user_id]);

    // Redirect back to the profile page with a success message
    $_SESSION['success_message'] = "Profile updated successfully.";
    header("Location: uprofile.php");
    exit();
}

// Close the database connection
$pdo = null;
?>
