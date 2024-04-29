<?php
session_start();
include('include/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get username and password from form
    $username = $_POST['uname'];
    $password = $_POST['pass'];

    // SQL query to fetch user from database
    $query = "SELECT * FROM tbladmin WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    // Check if user exists in database
    if (mysqli_num_rows($result) == 1) {
      // User found, set session variable and redirect to admin dashboard
        $_SESSION['tbladmin'] = $username;
        header("Location: admin/index.php"); // Redirect to admin dashboard
    } else {
        echo "<script>alert('Invalid Username or Password');</script>";
        // Redirect back to admin login page
        echo "<script>window.location.href='adminlogin.php';</script>";
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login Page</title>
</head>
<body style="background-image: url('assets/images/login_bg.jpg'); background-repeat: no-repeat;background-size:cover">
  <?php include 'include/header.php'; ?>
  <div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-lg-4">
      <div class="card">
        <div class="card-body">
          <h3 class="card-title text-center"><i class="fa-solid fa-user-gear"></i> Admin</h3>
          <form method="post">
            <div class="form-group mb-3">
              <label>Username</label>
              <input type="text" class="form-control" name="uname" autocomplete="off" placeholder="Enter your username">
            </div>
            <div class="form-group mb-3">
              <label>Password</label>
              <input type="password" class="form-control" name="pass" placeholder="Enter your password">
            </div>
            <input type="submit" name="login" class="btn btn-success" value="Login">
            <hr>
            <button type="button" class="btn btn-secondary btn-block w-auto">Face Recognition Login</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>