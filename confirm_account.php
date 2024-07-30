<?php
// Include Composer autoload file
require 'vendor/autoload.php';

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include('include/connection.php');

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    
    // Check if email exists in tbluser
    if ($stmt = $conn->prepare("SELECT first_name, middle_name, last_name FROM tbluser WHERE email = ?")) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($first_name, $middle_name, $last_name);
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->fetch();
            $full_name = trim($first_name . ' ' . $middle_name . ' ' . $last_name);
            
            // Display account found message
            echo '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Found</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="assets/css/all.min.css"/>
    <link rel="stylesheet" type="text/css" href="assets/css/stylemainn.css"/>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.2/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #0F1035, #365486, #7FC7D9, #DCF2F1);
            color: white;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center">Account Found</h4>
                        <hr>
                        <p class="text-center">Account Name: ' . htmlspecialchars($full_name) . '</p>
                        <p class="text-center">Is this you?</p>
                        <form action="send_reset_link.php" method="POST" class="text-center">
                            <input type="hidden" name="email" value="' . htmlspecialchars($email) . '">
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </form>
                        <br>
                        <a href="confirm_account.html" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
            ';
        } else {
            // Display no account found message
            echo '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>No Account Found</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="assets/css/all.min.css"/>
    <link rel="stylesheet" type="text/css" href="assets/css/stylemainn.css"/>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.2/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #0F1035, #365486, #7FC7D9, #DCF2F1);
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
                        <h4 class="card-title text-center">No Account Found</h4>
                        <hr>
                        <p class="text-center">No account is linked to this email address.</p>
                        <a href="confirm_account.html"  class="btn btn-secondary btn-block">Try Again</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
            ';
        }
        
        $stmt->close();
    } else {
        echo "<p>Failed to prepare the SQL statement.</p>";
    }
}

$conn->close();
?>
