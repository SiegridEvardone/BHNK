<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

include('include/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Generate a unique token
    $token = bin2hex(random_bytes(16));

    // Insert the token into the database
    $query = "INSERT INTO password_reset_requests (email, token) VALUES ('$email', '$token')";
    if (mysqli_query($conn, $query)) {
        // Send password reset email
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // SMTP server
            $mail->SMTPAuth   = true;
            $mail->Username   = 'siegridevardone@gmail.com'; // SMTP username
            $mail->Password   = 'dvqz zpol woxy ydms';   // SMTP password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            //Recipients
            $mail->setFrom('siegridevardone@gmail.com', 'Admin');
            $mail->addAddress($email);     // Add a recipient

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset';
            $reset_link = "http://localhost/BHNK/reset_password.php?token=$token";
            $mail->Body    = "Click the following link to reset your password: <a href='$reset_link'>$reset_link</a>";
            $mail->AltBody = "Click the following link to reset your password: $reset_link";

            $mail->send();
            echo "<script>alert('Password reset link sent to your email');</script>";
            // Redirect to login page
            echo "<script>window.location.href='userlogin.php';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Failed to send password reset link');</script>";
            // Redirect back to forgot password page
            echo "<script>window.location.href='forgot_password.php';</script>";
        }
    } else {
        echo "<script>alert('Failed to send password reset link');</script>";
        // Redirect back to forgot password page
        echo "<script>window.location.href='forgot_password.php';</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot password</title>
</head>
<body style="background-image: url('assets/images/login_bg.jpg'); background-repeat: no-repeat;background-size:cover">
  <?php include 'include/header.php'; ?>
  <div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-lg-4">
      <div class="card">
        <div class="card-body">
          <h3 class="card-title text-center"><i class="fa-solid fa-users"></i> Tenant</h3>
          <form method="post">
          <div class="form-group mb-3">
              <label>Email</label>
              <input type="email" class="form-control" name="email" placeholder="Enter Email" required>
            </div>
          <br>
          <button type="submit" name="submit">Reset Password</button>
            
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>