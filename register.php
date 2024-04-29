<?php

include('include/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['first_name'];
    $middlename = $_POST['middle_name'];
    $lastname = $_POST['last_name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $birthdate = $_POST['birthdate'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data into the database
    $query = "INSERT INTO tbluser (first_name,middle_name,last_name,age,gender,birthdate,email,username,password) VALUES ('$firstname','$middlename','$lastname','$age','$gender','$birthdate','$email','$username', '$hashed_password')";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Registration Successful');</script>";
        // Redirect to user login page
        echo "<script>window.location.href='userlogin.php';</script>";
    } else {
        echo "<script>alert('Registration Failed');</script>";
        // Redirect back to registration page
        echo "<script>window.location.href='register.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Registration</title>
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
            <div class="form-group mb-2">
              <label>First Name:</label>
              <input type="text" class="form-control" name="first_name" placeholder="First Name" required>
            </div>
            <div class="form-group mb-2">
              <label>Middle Name:</label>
              <input type="text" class="form-control" name="middle_name" placeholder="Middle Name">
            </div>
            <div class="form-group mb-2">
              <label>Last Name:</label>
              <input type="text" class="form-control" name="last_name" placeholder="Last Name" required>
            </div>
            <div class="form-group mb-2">
              <label>Age:</label>
              <input type="number" class="form-control" name="age" placeholder="Age" required>
            </div>
            <div class="form-group mb-2">
              <label>Gender:</label>
              <select name="gender"  required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
            </div>
            <div class="form-group mb-2">
              <label>Birthdate:</label>
              <input type="date" class="form-control" name="birthdate" placeholder="Birthdate" required>
            </div>
            <div class="form-group mb-2">
              <label>Email:</label>
              <input type="email" class="form-control" name="email" placeholder="Email" required>
            </div>
            <div class="form-group mb-2">
              <label>Username:</label>
              <input type="text" class="form-control" name="username" placeholder="Username" required>
            </div>
            <div class="form-group mb-2">
              <label>Password</label>
              <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <div class="form-group mb-2">
              <label>Confirm Password</label>
              <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required>
            </div>
            <button type="submit">Register</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>