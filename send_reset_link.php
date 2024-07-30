<?php
// Include Composer autoload file
require 'vendor/autoload.php';

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include('include/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    
    // Generate a unique token
    $token = bin2hex(random_bytes(50));
    $expiration_time = date("Y-m-d H:i:s", strtotime("+1 hour"));
    
    // Store the token in the password_reset_requests table
    $stmt_reset = $conn->prepare("INSERT INTO password_reset_requests (email, token, expiration_time) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE token = VALUES(token), expiration_time = VALUES(expiration_time)");
    $stmt_reset->bind_param("sss", $email, $token, $expiration_time);
    $stmt_reset->execute();
    
    if ($stmt_reset->affected_rows > 0) {
        // Send the reset link via email using PHPMailer
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

            // Recipients
            $mail->setFrom('siegridevardone@gmail.com', 'Admin');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body    = 'Click the following link to reset your password: <a href="http://localhost:8080/BHNK/reset_password.php?token=' . $token . '">Reset Password</a>';

            $mail->send();
            echo "<script>alert('A reset link has been sent to your email address.'); window.location.href = 'confirm_account.html';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Failed to send reset link. Error: " . $mail->ErrorInfo . "'); window.location.href = 'confirm_account.html';</script>";
        }
    }
    $stmt_reset->close();
}

$conn->close();
?>
