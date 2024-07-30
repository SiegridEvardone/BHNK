<?php
// Include the database connection
include('include/connection.php');

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["token"])) {
    $token = $_GET["token"];
    
    // Prepare and bind
    if ($stmt = $conn->prepare("SELECT email, expiration_time FROM password_reset_requests WHERE token = ?")) {
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $stmt->bind_result($email, $expiration_time);
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->fetch();
            
            // Check if token is expired
            if (new DateTime() > new DateTime($expiration_time)) {
                echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="assets/css/stylemainn.css"/>
    <style>
        body {
            background: linear-gradient(to right, #0F1035, #365486, #7FC7D9, #DCF2F1);
            color: white;
        }
    </style>
</head>
<body>
    <script>
        alert("Reset link has expired. Please request a new one.");
        window.location.href = "forgot_password.html";
    </script>
</body>
</html>';
            } else {
                echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="assets/css/stylemainn.css"/>
    <style>
        body {
            background: linear-gradient(to right, #0F1035, #365486, #7FC7D9, #DCF2F1);
            color: white;
        }
        .card-body {
            background: #ffffff;
            color: #000000;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center">Reset Password</h4>
                        <form action="reset_password.php" method="POST">
                            <input type="hidden" name="token" value="' . htmlspecialchars($token) . '">
                            <div class="form-group">
                                <label for="password">New Password:</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password:</label>
                                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
                ';
            }
        } else {
            echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invalid Reset Link</title>
    <style>
        body {
            background: linear-gradient(to right, #0F1035, #365486, #7FC7D9, #DCF2F1);
            color: white;
        }
    </style>
</head>
<body>
    <script>
        alert("Invalid reset link.");
        window.location.href = "forgot_password.html";
    </script>
</body>
</html>';
        }
        
        $stmt->close();
    } else {
        echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Error</title>
    <style>
        body {
            background: linear-gradient(to right, #0F1035, #365486, #7FC7D9, #DCF2F1);
            color: white;
        }
    </style>
</head>
<body>
    <script>
        alert("Failed to prepare the SQL statement.");
        window.location.href = "forgot_password.html";
    </script>
</body>
</html>';
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["token"]) && isset($_POST["password"]) && isset($_POST["confirm_password"])) {
    $token = $_POST["token"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    
    // Check if passwords match
    if ($password !== $confirm_password) {
        echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passwords Mismatch</title>
    <style>
        body {
            background: linear-gradient(to right, #0F1035, #365486, #7FC7D9, #DCF2F1);
            color: white;
        }
    </style>
</head>
<body>
    <script>
        alert("Passwords do not match. Please try again.");
        window.location.href = "reset_password.php?token=' . urlencode($token) . '";
    </script>
</body>
</html>';
    } else {
        // Hash the new password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Get the email associated with the token
        if ($stmt = $conn->prepare("SELECT email FROM password_reset_requests WHERE token = ?")) {
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $stmt->bind_result($email);
            $stmt->store_result();
            
            if ($stmt->num_rows > 0) {
                $stmt->fetch();
                
                // Update the user's password
                if ($stmt_user = $conn->prepare("UPDATE tbluser SET password = ? WHERE email = ?")) {
                    $stmt_user->bind_param("ss", $hashed_password, $email);
                    $stmt_user->execute();
                    
                    if ($stmt_user->affected_rows > 0) {
                        echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Success</title>
    <style>
        body {
            background: linear-gradient(to right, #0F1035, #365486, #7FC7D9, #DCF2F1);
            color: white;
        }
    </style>
</head>
<body>
    <script>
        alert("Password has been reset successfully. You can now login.");
        window.location.href = "login.php";
    </script>
</body>
</html>';
                    } else {
                        echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Failed</title>
    <style>
        body {
            background: linear-gradient(to right, #0F1035, #365486, #7FC7D9, #DCF2F1);
            color: white;
        }
    </style>
</head>
<body>
    <script>
        alert("Failed to reset password. Please try again later.");
        window.location.href = "reset_password.php?token=' . urlencode($token) . '";
    </script>
</body>
</html>';
                    }
                    
                    $stmt_user->close();
                } else {
                    echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Error</title>
    <style>
        body {
            background: linear-gradient(to right, #0F1035, #365486, #7FC7D9, #DCF2F1);
            color: white;
        }
    </style>
</head>
<body>
    <script>
        alert("Failed to prepare the SQL statement for updating password.");
        window.location.href = "reset_password.php?token=' . urlencode($token) . '";
    </script>
</body>
</html>';
                }
                
                $stmt_user->close();
                
                // Delete the reset request
                if ($stmt_delete = $conn->prepare("DELETE FROM password_reset_requests WHERE token = ?")) {
                    $stmt_delete->bind_param("s", $token);
                    $stmt_delete->execute();
                    $stmt_delete->close();
                } else {
                    echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Error</title>
    <style>
        body {
            background: linear-gradient(to right, #0F1035, #365486, #7FC7D9, #DCF2F1);
            color: white;
        }
    </style>
</head>
<body>
    <script>
        alert("Failed to prepare the SQL statement for deleting the reset request.");
        window.location.href = "reset_password.php?token=' . urlencode($token) . '";
    </script>
</body>
</html>';
                }
            } else {
                echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invalid Token</title>
    <style>
        body {
            background: linear-gradient(to right, #0F1035, #365486, #7FC7D9, #DCF2F1);
            color: white;
        }
    </style>
</head>
<body>
    <script>
        alert("Invalid token.");
        window.location.href = "forgot_password.html";
    </script>
</body>
</html>';
            }
            
            $stmt->close();
        } else {
            echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Error</title>
    <style>
        body {
            background: linear-gradient(to right, #0F1035, #365486, #7FC7D9, #DCF2F1);
            color: white;
        }
    </style>
</head>
<body>
    <script>
        alert("Failed to prepare the SQL statement for fetching email.");
        window.location.href = "forgot_password.html";
    </script>
</body>
</html>';
        }
    }
}
?>
