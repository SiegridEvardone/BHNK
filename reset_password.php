<?php
include('include/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match');</script>";
        exit;
    }

    // Hash the new password securely
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Update the user's password in the database
    $update_query = "UPDATE tbluser SET password='$hashed_password' WHERE email IN (SELECT email FROM password_reset_requests WHERE token='$token' AND expiration_time >= NOW())";
    if (mysqli_query($conn, $update_query)) {
        // Delete the password reset token
        $delete_query = "DELETE FROM password_reset_requests WHERE token='$token'";
        if (mysqli_query($conn, $delete_query)) {
            // Password reset successful
            echo "<script>alert('Password reset successfully');</script>";
            echo "<script>window.location.href='login.php';</script>"; // Redirect to login page
            exit;
        } else {
            // Failed to delete token
            echo "<script>alert('Failed to reset password. Please try again later.');</script>";
        }
    } else {
        // Failed to update password
        echo "<script>alert('Failed to reset password. Please try again later.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password</title>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css"/>
  <link rel="stylesheet" type="text/css" href="assets/css/all.min.css"/>
  <link rel="stylesheet" type="text/css" href="assets/css/stylemainn.css"/>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.2/font/bootstrap-icons.min.css" rel="stylesheet">
  <style>
     body {
      background: linear-gradient(to right,#0F1035,#365486,#7FC7D9,#DCF2F1);
      color: white;
    }
  </style>
</head>
<body>
  <!-- Add your HTML content here -->
  <?php
  include('include/connection.php');

  if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['token'])) {
      $token = $_GET['token'];

      // Check if the token exists and is not expired
      $query = "SELECT * FROM password_reset_requests WHERE token='$token' AND expiration_time >= NOW()";
      $result = mysqli_query($conn, $query);

      if (mysqli_num_rows($result) == 1) {
          // Token is valid, allow password reset
          echo '<div class="container mt-5">';
          echo '<div class="row justify-content-center">';
          echo '<div class="col-lg-4">';
          echo '<div class="card">';
          echo '<div class="card-body">';
          echo '<h3 class="card-title text-center">Reset Password</h3>';
          echo '<form method="post">';
          echo '<input type="hidden" name="token" value="' . $token . '">';
          echo '<input type="password" name="password" class="form-control" placeholder="New Password" required><br>';
          echo '<input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required><br>'; // New input field for confirming password
          echo '<button type="submit" class="btn btn-primary">Reset Password</button>';
          echo '</form>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
      } else {
          // Token is invalid or expired
          echo "<h2>Invalid or Expired Tokennn</h2>";
      }
  }
  ?>
</body>
<!-- Bootstrap JS and dependencies -->
<script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</html>
