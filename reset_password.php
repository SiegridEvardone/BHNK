<?php
include('include/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $password = $_POST['password'];

    // Hash the new password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Update the user's password in the database
    $query = "UPDATE tbluser SET password='$hashed_password' WHERE email IN (SELECT email FROM password_reset_requests WHERE token='$token')";
    if (mysqli_query($conn, $query)) {
        // Delete the password reset token
        $delete_query = "DELETE FROM password_reset_requests WHERE token='$token'";
        mysqli_query($conn, $delete_query);

        echo "<script>alert('Password reset successfully');</script>";
        // Redirect to login page
        echo "<script>window.location.href='userlogin.php';</script>";
    } else {
        echo "<script>alert('Failed to reset password');</script>";
        // Redirect back to reset password page
        echo "<script>window.location.href='reset_password.php?token=$token';</script>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Login Page</title>
</head>
<body style="background-image: url('assets/images/login_bg.jpg'); background-repeat: no-repeat; background-size:cover">
  <?php include 'include/header.php'; ?>
  <?php
    include('include/connection.php');

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['token'])) {
        $token = $_GET['token'];

        // Check if the token exists in the database and is not expired (e.g., within the last hour)
        $query = "SELECT * FROM password_reset_requests WHERE token='$token' AND timestamp >= NOW() - INTERVAL 1 HOUR";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            // Token is valid, allow user to reset password
            echo '<div class="container mt-5">';
            echo '<div class="row justify-content-center">';
            echo '<div class="col-lg-4">';
            echo '<div class="card">';
            echo '<div class="card-body">';
            echo '<h3 class="card-title text-center"><i class="fa-solid fa-users"></i> Tenant</h3>';
            echo "<h2>Reset Your Password</h2>";
            echo "<form method='post'>";
            echo "<input type='hidden' name='token' value='$token'>";
            echo "<input type='password' name='password' placeholder='New Password' required><br>";
            echo "<button type='submit'>Reset Password</button>";
            echo "</form>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        } else {
            echo "<h2>Invalid or Expired Token</h2>";
        }
    }
    ?>
</body>
</html>
