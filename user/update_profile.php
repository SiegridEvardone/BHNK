<?php
ob_start();
session_start();

include('../include/pdoconnect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page if not logged in
    header("Location: ../userlogin.php");
    exit();
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Fetch user's information from the database
$sql_user = "SELECT u.*, r.room_number
             FROM tbluser u
             JOIN tbltenant t ON u.user_id = t.user_id
             JOIN tblrooms r ON t.room_id = r.id
             WHERE u.user_id = ?";
$stmt_user = $pdo->prepare($sql_user);
$stmt_user->execute([$user_id]);
$user = $stmt_user->fetch(PDO::FETCH_ASSOC);

// Check if user data is found
if (!$user) {
    // Handle the situation where user data is not found
    exit("User data not found.");
}

// Fetch room numbers from the tblrooms table (if needed for other purposes)
$sql_rooms = "SELECT id, room_number FROM tblrooms";
$stmt_rooms = $pdo->query($sql_rooms);
$rooms = $stmt_rooms->fetchAll(PDO::FETCH_ASSOC);

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];
    $contact = $_POST['contact'];
    $home_address = $_POST['home_address'];
    $room_number = $_POST['room_number']; // Room number is assigned, not chosen

    // Calculate age based on birthdate
    $birthdateObj = new DateTime($birthdate);
    $today = new DateTime();
    $age = $birthdateObj->diff($today)->y;

    // Handle image upload
    $image_path = $user['image']; // Default to current image path
    if ($_FILES['image']['size'] > 0) {
        $target_dir = "profile_images/"; // Specify the directory where images will be stored
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = $target_file; // Set the image path if upload is successful   
        } else {
            // Handle image upload error
            $_SESSION['error_message'] = "Sorry, there was an error uploading your file.";
            header("Location: uprofile.php");
            exit();
        }
    }

    // Update user details in the database
    $sql = "UPDATE tbluser SET 
                first_name = ?, 
                middle_name = ?, 
                last_name = ?, 
                email = ?, 
                birthdate = ?, 
                age = ?, 
                gender = ?, 
                contact = ?, 
                home_address = ?, 
                image = ?
            WHERE user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$first_name, $middle_name, $last_name, $email, $birthdate, $age, $gender, $contact, $home_address, $image_path, $user_id]);

    // Redirect back to the profile page with a success message
    $_SESSION['success_message'] = "Profile updated successfully.";
    header("Location: uprofile.php");
    exit();
}

// Close the database connection
$pdo = null;
ob_end_clean();
?>
