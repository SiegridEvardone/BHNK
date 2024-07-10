<?php
session_start();
include('include/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    // Get username and password from form
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // SQL query to fetch user from database
    $query = "SELECT * FROM tbluser WHERE username=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if user exists in database
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];

        // Verify the password  
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $row['user_id'];
            header("Location: user/index.php"); // Redirect to user dashboard
            exit();
        } else {
            echo "<script>alert('Incorrect password');</script>";
            echo "<script>window.location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('User not found');</script>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>