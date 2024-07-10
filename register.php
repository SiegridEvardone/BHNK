<?php
include('include/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['first_name'];
    $middlename = $_POST['middle_name'];
    $lastname = $_POST['last_name'];
    $contact = $_POST['contact'];
    $gender = $_POST['gender'];
    $birthdate = $_POST['birthdate'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match.');</script>";
        exit;
    }

    // Check if the email already exists in the database
    $check_query = "SELECT * FROM tbluser WHERE email = '$email'";
    $check_result = mysqli_query($conn, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Email already exists. Please use a different email.');</script>";
        echo "<script>window.location.href='register.php';</script>";
        exit;
    }

    // Calculate the age
    $birthDate = new DateTime($birthdate);
    $currentDate = new DateTime();
    $age = $currentDate->diff($birthDate)->y;

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data into the database
    $query = "INSERT INTO tbluser (first_name, middle_name, last_name, contact, gender, birthdate, age, email, username, password) 
              VALUES ('$firstname', '$middlename', '$lastname', '$contact', '$gender', '$birthdate', '$age', '$email', '$username', '$hashed_password')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Registration Successful');</script>";
        // Redirect to user login page
        echo "<script>window.location.href='login.php';</script>";
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
  <title>Boarding House Management</title>
  <!-- Bootstrap CSS -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <style>
    .bg-container {
      background: linear-gradient(to top, #3931af, #00c6ff);
      height: auto;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }
    /* Custom styles for left-column */
    .left-column {
      padding: 0px 20px 20px;
      text-align: center;
      max-height: auto;
    }
    /* Custom styles for right-column */
    .right-column {
      border-bottom-left-radius: 10% 30%;
      border-top-left-radius: 10% 30%;
      background-color: white;
      padding: 20px 20px 20px 40px;
    }
    /* Centering h2 element */
    #registration-heading, #login-heading {
      text-align: center;
      margin-bottom: 2%;
      color: #495057;
    }
    /* Custom styles for form container */
    .form-container {
      padding: 20px;
      border-radius: 10px;
    }
    /* Custom styles for navigation links */
    .nav-link {
      background-color: #007bff; /* Default background color */
      color: #fff; /* Default text color */
      padding: 5px 10px; /* Add padding for better click area */
      height: 40px;
      border: 2px solid #0062cc;
    }
    .nav-link.active {
      background-color: #fff !important; /* Blue background for active links */
      color: #0062cc !important; /* White text color for active links */
      border: 2px solid #0062cc;
      font-weight: 600;
    }
    /* Custom styles for buttons */
    .btn-custom {
      background-color: #007bff;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      width: 100%; /* Full width */
      display: block; /* Ensures the button takes the width specified */
      margin: 0 auto; /* Center the button horizontally */
    }
    .btn-custom:hover {
      background-color: #0056b3;
    }
    /* Custom styles for logo */
    .logo {
      text-align: center; /* Center the logo */
      margin-bottom: 20px;
    }
    /* Custom styles for logo image */
    .logo img {
      width: 100%;
      max-width: 25rem;
      margin-top: -40px;
      animation: mover 7s ease-in-out infinite; /* Adjust the duration as needed */
    }
    /* Custom styles for logo details */
    .logo-details {
      color: white; /* Set text color to white */
      text-align: center; /* Center the text */
      margin-top: -40px;
    }
    #first-details {
      font-weight: bold;
      padding-bottom: 10px;
    }
    #second-details {
      font-weight: light;
    }
    /* Custom keyframes for animation */
    @keyframes mover {
      0% {
        transform: translateY(0);
      }
      50% {
        transform: translateY(50px); /* Move 50 pixels to the right */
      }
      100% {
        transform: translateY(0);
      }
    }
  </style>
</head>
<body>
  <div class="container-fluid bg-container">
    <div class="row w-100">
      <!-- Left Column -->
      <div class="col-md-4 left-column">
        <!-- Left Column for Logo and Details -->
        <div class="logo">
          <img src="assets/images/BH_logo_nobg.png" alt="Logo">
        </div>
        <div class="logo-details">
          <h2 id="first-details">Welcome to Boarding House ni Kuya!</h2>
          <p id="second-details">We look forward to providing you with the best experience possible. Please let us know if we can do anything to make your stay even better!</p>
        </div>
        <!-- Login Button with 50% Width -->
        <div class="btn-container">
          <a href="login.php" id="login-btn" class="btn btn-custom">Login</a>
        </div>
      </div>
      <!-- Right Column -->
      <div class="col-md-8 right-column">
        <!-- Registration Form Container -->
        <div class="container-md form-container">
          <h2 id="registration-heading" class="text-center">Create Account</h2>
          <!-- Form Row -->
          <form method="post">
            <div class="row">
              <!-- First Column -->
              <div class="col-md-6 first-column">
                <div class="form-group mb-2">
                  <label for="first_name">First Name:</label>
                  <input type="text" class="form-control" name="first_name" placeholder="First Name" required>
                </div>
                <div class="form-group mb-2">
                  <label for="middle_name">Middle Name:</label>
                  <input type="text" class="form-control" name="middle_name" placeholder="Middle Name" required>
                </div>
                <div class="form-group mb-2">
                  <label for="last_name">Last Name:</label>
                  <input type="text" class="form-control" name="last_name" placeholder="Last Name" required>
                </div>
                <div class="form-group mb-2">
                  <label>Gender:</label>
                  <select  class="form-control" name="gender"  required>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
                </div>
                <div class="form-group mb-2">
                    <label for="birthdate">Birthdate:</label>
                    <input type="date" class="form-control" id="birthdate" name="birthdate" required>
                  </div>
                
              </div>
              <!-- Second Column -->
              <div class="col-md-6 second-column">
                <div class="form-group mb-2">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                  </div>
                  <div class="form-group mb-2">
                  <label for="contact">Contact Number:</label>
                  <input type="text" class="form-control" id="contact" name="contact" placeholder="Contact Number">
                </div>
                <div class="form-group mb-2">
                  <label for="username">Username:</label>
                  <input type="text" class="form-control" name="username" placeholder="Username" required>
                </div>
                <div class="form-group mb-2">
                  <label for="password">Password:</label>
                  <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
                <div class="form-grou mb-2">
                  <label for="confirm_password">Confirm Password:</label>
                  <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required>
                </div>
               
              </div>
              <div class="col-md-12 btn-container mt-2">
                <button type="submit" class="btn btn-custom">Register</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS and dependencies -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

