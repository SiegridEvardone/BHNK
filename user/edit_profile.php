<?php
ob_start();
session_start();

include('../include/pdoconnect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page if not logged in
    header("Location: ../userlogin.php");
    exit();
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Fetch user's information from the database
$sql = "SELECT * FROM tbluser WHERE user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if user data is found
if (!$user) {
    // Handle the situation where user data is not found
    exit("User data not found.");
}

// Define variables with current user details
$first_name = $user['first_name'];
$middle_name = $user['middle_name'];
$last_name = $user['last_name'];
$age = $user['age'];
$email = $user['email'];
$birthdate = $user['birthdate'];
$gender = $user['gender'];
$contact = $user['contact'];
$home_address = $user['home_address'];
$room_number = $user['room_number'];
$image = $user['image'];
$image_filename = !empty($user['image']) ? $user['image'] : 'addphoto.png';

// Fetch room numbers from the tblrooms table
$sql_rooms = "SELECT room_number FROM tblrooms";
$stmt_rooms = $pdo->query($sql_rooms);
$rooms = $stmt_rooms->fetchAll(PDO::FETCH_ASSOC);



// Close the database connection
$pdo = null;
ob_end_clean();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profile</title>
</head>
<body>
  <?php
    include('../include/dash_header.php');
  ?>
  <div class="container-fluid">
    <div class="row">
      <?php
        include('sidenav.php');
      ?> 
      <main class="col-12 col-md-5 ms-sm-auto col-lg-10 px-md-4 py-md-3">
        <div class="container border border-dark mt-1 p-3" style="max-width: 70%;height: 85%;">
          <form action="update_profile.php" method="POST" enctype="multipart/form-data">
            <div class="row mb-4">
                <div class="container border p-0" style="max-width: 20%; height: 150px;">
                    <label for="image" class="btn btn-bg-info p-0" style="width: 100%; height: 100%;">
                        <img src="<?php echo $image_filename; ?>" alt="Profile Image" style="width: 100%; height: 100%;">
                    </label>
                    <input id="image" style="visibility:hidden;" type="file" name="image">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <input type="text" class="form-control" placeholder="First name" aria-label="First name" name="first_name" value="<?php echo $first_name; ?>">
                </div>
                <div class="col">
                    <input type="text" class="form-control" placeholder="Middle name" aria-label="Middle name" name="middle_name" value="<?php echo $middle_name; ?>">
                </div>
                <div class="col">
                    <input type="text" class="form-control" placeholder="Last name" aria-label="Last name" name="last_name" value="<?php echo $last_name; ?>">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <input type="number" class="form-control" placeholder="Age" aria-label="Age" name="age" value="<?php echo $age; ?>">
                </div>
                <div class="col">
                    <label class="visually-hidden" for="autoSizingSelect">Gender</label>
                    <select class="form-select" id="autoSizingSelect" name="gender">
                        <option selected disabled>Select Gender</option>
                        <option value="female" <?php if($gender == "female") echo "selected"; ?>>Female</option>
                        <option value="male" <?php if($gender == "male") echo "selected"; ?>>Male</option>
                        <option value="other" <?php if($gender == "other") echo "selected"; ?>>Other</option>
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <input type="date" class="form-control" placeholder="Birthdate" aria-label="Birthdate" name="birthdate" value="<?php echo $birthdate; ?>">
                </div>
                <div class="col">
                    <input type="text" class="form-control" placeholder="Contact no." aria-label="Contact no." name="contact" value="<?php echo $contact; ?>">
                </div>
            </div>
            <div class="row mb-2">
              <div class="col">
                <input type="email" class="form-control" placeholder="Email" aria-label="Email" name="email" value="<?php echo $email; ?>">
              </div>
              <div class="col">
                <label class="visually-hidden" for="autoSizingSelect">Room Number</label>
                <select class="form-select" id="autoSizingSelect" name="room_number">
                    <option selected disabled>Select Room Number</option>
                    <?php foreach ($rooms as $room): ?>
                        <option value="<?php echo $room['room_number']; ?>" <?php if($room_number == $room['room_number']) echo "selected"; ?>><?php echo $room['room_number']; ?></option>
                    <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="row mb-3 mx-1">
                <input type="text" class="form-control" placeholder="Home Address" aria-label="Home Address" name="home_address" value="<?php echo $home_address; ?>">
            </div>
            <div class="row">
                <div class="col">
                    <a href="uprofile.php" class="btn btn-danger" style="width: 100%;">Cancel</a>
                </div>
                <div class="col">
                    <input type="submit" class="btn btn-primary" value="Save Changes" style="width: 100%;">
                </div>
            </div>
          </form>

        </div>
      </form>
      </main>
    </div>
  </div>
  
</body>
</html>