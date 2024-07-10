<?php
session_start();
include('include/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get username and password from form
    $username = mysqli_real_escape_string($conn, $_POST['uname']);
    $password = mysqli_real_escape_string($conn, $_POST['pass']);

    // SQL query to fetch admin from database
    $query = "SELECT * FROM tbladmin WHERE username='$username' AND password='$password' AND role='admin'";
    $result = mysqli_query($conn, $query);

    // Check if admin exists in database
    if (mysqli_num_rows($result) == 1) {
        // Admin found, set session variable and redirect to admin dashboard
        $admin = mysqli_fetch_assoc($result);
        $_SESSION['admin_id'] = $admin['admin_id']; 
        $_SESSION['role'] = $admin['role'];
        header("Location: admin/index.php"); // Redirect to admin dashboard
        exit();
    } else {
        echo "<script>alert('Invalid Username or Password');</script>";
        // Redirect back to admin login page
        echo "<script>window.location.href='login.php';</script>";
    }
    mysqli_close($conn);
}