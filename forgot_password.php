<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

include('include/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if email exists in the database
    $check_email_query = "SELECT * FROM tbluser WHERE email='$email'";
    $result = mysqli_query($conn, $check_email_query);

    if (mysqli_num_rows($result) > 0) {
        // Rate limit password reset requests
        $time_limit = 3600; // 1 hour
        $check_time_query = "SELECT * FROM password_reset_requests WHERE email='$email' AND request_time >= NOW() - INTERVAL 1 HOUR";
        $time_result = mysqli_query($conn, $check_time_query);

        if (mysqli_num_rows($time_result) == 0) {
            // Generate a unique token
            $token = bin2hex(random_bytes(16));
            
            // Calculate the expiration time (1 hour from now)
            $expiration_time = date("Y-m-d H:i:s", strtotime('+7 hour'));

            // Insert the token into the database
            $query = "INSERT INTO password_reset_requests (email, token, expiration_time) VALUES ('$email', '$token', '$expiration_time')";
            if (mysqli_query($conn, $query)) {
                // Send password reset email
                $mail = new PHPMailer(true);
                try {
                    //Server settings
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com'; // SMTP server
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'siegridevardone@gmail.com'; // SMTP username
                    $mail->Password   =  'dvqz zpol woxy ydms';   // SMTP password
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
                    echo "<script>window.location.href='login.php';</script>";
                } catch (Exception $e) {
                    error_log('Mailer Error: ' . $mail->ErrorInfo);
                    echo "<script>alert('Failed to send password reset link');</script>";
                    // Redirect back to forgot password page
                    echo "<script>window.location.href='forgot_password.php';</script>";
                }
            } else {
                error_log('Database Error: ' . mysqli_error($conn));
                echo "<script>alert('Failed to send password reset link');</script>";
                // Redirect back to forgot password page
                echo "<script>window.location.href='forgot_password.php';</script>";
            }
        } else {
            echo "<script>alert('Password reset link already sent. Please check your email.');</script>";
            // Redirect back to forgot password page
            echo "<script>window.location.href='forgot_password.php';</script>";
        }
    } else {
        echo "<script>alert('No existing account with this email');</script>";
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
  
  <div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-lg-4">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title text-center">Find your account</h4>
          <hr>
          <p>Please enter your email address to search for your account</p>
          <form method="post">
          <div class="form-group mb-3">
              <input type="email" class="form-control" name="email" placeholder="Enter email address" required>
            </div>
          <br>
          <a href="login.php" class="btn btn-secondary">Cancel</a>
          <button type="submit" name="submit" class="btn btn-primary">Send reset link</button>
            
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
  <!-- Bootstrap JS and dependencies -->
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</html>
