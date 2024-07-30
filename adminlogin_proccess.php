<?php
session_start();
include('include/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from form
    $username = mysqli_real_escape_string($conn, $_POST['uname']);
    $password = mysqli_real_escape_string($conn, $_POST['pass']);

    // Prepare and execute SQL query to fetch admin from database
    if ($stmt = $conn->prepare("SELECT admin_id, password, role FROM tbladmin WHERE username = ? AND role = 'admin'")) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($admin_id, $hashed_password, $role);
        $stmt->fetch();
        
        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Admin found and password is correct, set session variables and redirect
            $_SESSION['admin_id'] = $admin_id;
            $_SESSION['role'] = $role;
            header("Location: admin/index.php"); // Redirect to admin dashboard
            exit();
        } else {
            // Invalid password
            echo "<script>alert('Invalid Username or Password'); window.location.href='login.php';</script>";
        }
        
        $stmt->close();
    } else {
        echo "<script>alert('Database query failed'); window.location.href='login.php';</script>";
    }
    
    $conn->close();
}
?>
