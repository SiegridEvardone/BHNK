<?php
session_start();
include('include/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    // Get username and password from form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL query to fetch user from database
    $query = "SELECT * FROM tbluser WHERE username='$username'";
    $result = mysqli_query($conn, $query);

    // Check if user exists in database
    if (mysqli_num_rows($result) == 1) {
      $row = mysqli_fetch_assoc($result);
      $hashed_password = $row['password'];

      // Verify the password
      if (password_verify($password, $hashed_password)) {
          $_SESSION['username'] = $username;
          header("Location: user/index.php"); // Redirect to user dashboard
      } else {
          echo "<script>alert('Invalid Username or Password');</script>";
          // Redirect back to user login page
          echo "<script>window.location.href='userlogin.php';</script>";
      }
  } else {
      echo "<script>alert('Invalid Username or Password');</script>";
      // Redirect back to user login page
      echo "<script>window.location.href='userlogin.php';</script>";
  }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Login Page</title>
</head>
<body style="background-image: url('assets/images/login_bg.jpg'); background-repeat: no-repeat;background-size:cover">
  <?php include 'include/header.php'; ?>
  <div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-lg-4">
      <div class="card">
        <div class="card-body">
          <h3 class="card-title text-center"><i class="fa-solid fa-users"></i> Tenant</h3>
          <form method="post"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group mb-3">
              <label>Username</label>
              <input type="text" class="form-control" name="username" autocomplete="off" placeholder="Enter your username">
            </div>
            <div class="form-group mb-3">
              <label>Password</label>
              <input type="password" class="form-control" name="password" placeholder="Enter your password">
            </div>
            <input type="submit" name="login" class="btn btn-success " value="Login">
            <hr>
            <div class="justify-content-center text-align-center">
              <a href="forgot_password.php" >Forgot password?</a>
            </div>
            
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>