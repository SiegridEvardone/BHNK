<?php
ob_start();
session_start();

include('../include/pdoconnect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page if not logged in
    header("Location: ../login.php");
    exit();
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Fetch user's information from the database
$sql_user = "SELECT u.*, r.room_number
             FROM tbluser u
             JOIN tbltenant t ON u.user_id = t.user_id
             JOIN tblrooms r ON t.room_id = r.id
             WHERE u.user_id = ?";
$stmt_user = $pdo->prepare($sql_user);
$stmt_user->execute([$user_id]);
$user = $stmt_user->fetch(PDO::FETCH_ASSOC);

// Check if user data is found
if (!$user) {
    // Handle the situation where user data is not found
    exit("User data not found.");
}

// Fetch room numbers from the tblrooms table (if needed for other purposes)
$sql_rooms = "SELECT id, room_number FROM tblrooms";
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
  <script>
    // JavaScript function to handle image preview
    function previewImage(event) {
      var reader = new FileReader();
      reader.onload = function(){
        var output = document.getElementById('profileImage');
        output.src = reader.result;
      };
      reader.readAsDataURL(event.target.files[0]);
    };

  </script>
</head>
<body>
  <div class="position-relative">
    <?php include('../include/dash_header.php'); ?>
    <button class="openbtn position-absolute top-0 start-0" onclick="toggleSidebar()">☰</button>
    <div id="sidebar-container"></div>
    <div class="main">
    <div class="container bg-light p-3">
          <div class="container border border-dark mt-1 p-3" style="max-width: 70%;height: 85%;">
            <form action="update_profile.php" method="POST" enctype="multipart/form-data">
              <div class="row mb-4">
                <div class="container border p-0" style="max-width: 20%; height: 150px;">
                  <label for="image" class="btn btn-bg-info p-0" style="width: 100%; height: 100%;">
                    <img id="profileImage" src="<?php echo $user['image'] ? $user['image'] : 'profile_images/addphoto.png'; ?>" alt="Profile Image" style="width: 100%; height: 100%;">
                  </label>
                  <input id="image" style="visibility:hidden;" type="file" name="image" onchange="previewImage(event)">
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <input type="text" class="form-control" placeholder="First name" aria-label="First name" name="first_name" value="<?php echo $user['first_name']; ?>">
                </div>
                <div class="col">
                  <input type="text" class="form-control" placeholder="Middle name" aria-label="Middle name" name="middle_name" value="<?php echo $user['middle_name']; ?>">
                </div>
                <div class="col">
                  <input type="text" class="form-control" placeholder="Last name" aria-label="Last name" name="last_name" value="<?php echo $user['last_name']; ?>">
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <input type="number" class="form-control" placeholder="Age" aria-label="Age" name="age" value="<?php echo $user['age']; ?>" readonly>
                </div>
                <div class="col">
                  <label class="visually-hidden" for="autoSizingSelect">Gender</label>
                  <select class="form-select" id="autoSizingSelect" name="gender">
                    <option selected disabled>Select Gender</option>
                    <option value="female" <?php if($user['gender'] == "female") echo "selected"; ?>>Female</option>
                    <option value="male" <?php if($user['gender'] == "male") echo "selected"; ?>>Male</option>
                    <option value="other" <?php if($user['gender'] == "other") echo "selected"; ?>>Other</option>
                  </select>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <input type="date" class="form-control" placeholder="Birthdate" aria-label="Birthdate" name="birthdate" value="<?php echo $user['birthdate']; ?>">
                </div>
                <div class="col">
                  <input type="text" class="form-control" placeholder="Contact no." aria-label="Contact no." name="contact" value="<?php echo $user['contact']; ?>">
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <input type="email" class="form-control" placeholder="Email" aria-label="Email" name="email" value="<?php echo $user['email']; ?>">
                </div>
                <div class="col">
                  <input type="text" class="form-control" placeholder="Room Number" aria-label="Room Number" name="room_number" value="<?php echo $user['room_number']; ?>" readonly>
                </div>
              </div>
              <div class="row mb-3 mx-1">
                <input type="text" class="form-control" placeholder="Home Address" aria-label="Home Address" name="home_address" value="<?php echo $user['home_address']; ?>">
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
        </div>
    </div>
  </div>
  <script src="../assets/js/script.js"></script>
</body>
</html>
