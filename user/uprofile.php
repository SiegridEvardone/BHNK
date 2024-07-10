<?php
ob_start();
session_start(); // Start the session

include('../include/pdoconnect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page or display an error message
    header("Location: ../userlogin.php");
    exit();
}

// Now that we know the user is logged in, we can safely access their user ID
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

// Now you can safely access array offsets on the $user variable
$name = $user['first_name'] . ' ' . $user['middle_name'] . ' ' . $user['last_name'];
$image_filename = !empty($user['image']) ? $user['image'] : 'addphoto.png'; // Default image filename if no image is provided
$contact = !empty($user['contact']) ? $user['contact'] : 'N/A';
$address = !empty($user['home_address']) ? $user['home_address'] : 'N/A';
ob_end_clean();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
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
      <main class="col-12 col-md-5 ms-sm-auto col-lg-10 px-md-3 py-md-3">
        <div class="container bg-light p-3">
        <div class="container border border-dark mt-1 p-3" style="max-width: 70%;height: 85%;">
          <div class="row mb-2">
            <div class="container border p-0" style="max-width: 20%; height: 150px;">
              <img src="<?php echo $image_filename; ?>" alt="Profile Image" style="width: 100%; height: 100%;">
            </div>
          </div>
          <div class="row border mb-2">
            <p class="m-0 py-2"><strong>Name: </strong> <?php echo $name; ?></p>
          </div>
          <div class="row border mb-2">
            <div class="col">
              <p class="m-0 py-2"><strong>Age: </strong><?php echo $user['age']; ?></p>
            </div>
            <div class="col">
              <p class="m-0 py-2"><strong>Gender: </strong><?php echo $user['gender']; ?></p>
            </div>
          </div>
          <div class="row border mb-2">
              <div class="col">
                <p class="m-0 py-2"><strong>Birthdate: </strong><?php echo $user['birthdate']; ?></p>
              </div>
              <div class="col">
                <p class="m-0 py-2"><strong>Contact: </strong><?php echo $contact; ?></p>
              </div>
            </div>
          <div class="row border mb-2">
            <div class="col">
              <p class="m-0 py-2"><strong>Email: </strong><?php echo $user['email']; ?></p>
            </div>
            <div class="col">
              <p class="m-0 py-2"><strong>Room #: </strong><?php echo sprintf("%02d", $user['room_number']); ?></p>
            </div>
          </div>
          <div class="row border mb-3">
            <p class="m-0 py-2"><strong>Home address: </strong><?php echo $address; ?></p>
          </div>
          <div class="row">
            <a href="edit_profile.php" class="btn btn-primary mx-auto"> Edit info</a>
          </div>
        </div>
        </div>
        
      </main>
    </div>
  </div>
  
</body>
</html>