<?php
ob_start();
session_start();

include('../include/pdoconnect.php'); // Include your database connection

function calculate_age($birthdate) {
    $birthdate = new DateTime($birthdate);
    $today = new DateTime('today');
    $age = $birthdate->diff($today)->y;
    return $age;
}

// Fetch tenant ID from URL parameter
$tenant_id = isset($_GET['tenant_id']) ? $_GET['tenant_id'] : null;

if ($tenant_id) {
    // Fetch tenant information from the database
    $sql = "SELECT u.*, r.room_number
            FROM tbluser u
            JOIN tbltenant t ON u.user_id = t.user_id
            JOIN tblrooms r ON t.room_id = r.id
            WHERE u.user_id = :tenant_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['tenant_id' => $tenant_id]);
    $tenant = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$tenant) {
        echo "Tenant not found.";
        exit;
    }
} else {
    echo "No tenant ID provided.";
    exit;
}

ob_end_clean();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tenant Information</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="position-relative">
    <?php include('../include/dash_header.php'); ?>
    <button class="openbtn position-absolute top-0 start-0" onclick="toggleSidebar()">☰</button>
    <div id="sidebar-container"></div>
    <div class="main">  
    <div class="container bg-light p-3">
          <h2 class="mb-3">Tenant Information</h2>
          <div class="container border border-dark mt-1 p-3" style="max-width: 70%;height: 85%;">
            <div class="row mb-2">
              <div class="container border p-0" style="max-width: 20%; height: 150px;">
              <?php 
                // Construct the correct path to the image
                $imagePath = !empty($tenant['image']) ? '../user/' . $tenant['image'] : '../user/profile_images/noprofile.jfif';
                ?>
                <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Profile Image" style="width: 100%; height: 100%;">
              </div>
            </div>
            <div class="row border mb-2">
              <p class="m-0 py-2"><strong>Name: </strong><?php echo htmlspecialchars($tenant['first_name'] . ' ' . $tenant['middle_name'] . ' ' . $tenant['last_name']); ?></p>
            </div>
            <div class="row border mb-2">
              <div class="col">
                <p class="m-0 py-2"><strong>Age: </strong><?php echo htmlspecialchars(calculate_age($tenant['birthdate'])); ?></p>
              </div>
              <div class="col">
                <p class="m-0 py-2"><strong>Gender: </strong><?php echo htmlspecialchars($tenant['gender']); ?></p>
              </div>
            </div>
            <div class="row border mb-2">
              <div class="col">
                <p class="m-0 py-2"><strong>Birthdate: </strong><?php echo htmlspecialchars(date('M d, Y', strtotime($tenant['birthdate']))); ?></p>
              </div>
              <div class="col">
                <p class="m-0 py-2"><strong>Contact: </strong><?php echo htmlspecialchars(!empty($tenant['contact']) ? $tenant['contact'] : 'N/A'); ?></p>
              </div>
            </div>
            <div class="row border mb-2">
              <div class="col">
                <p class="m-0 py-2"><strong>Email: </strong><?php echo htmlspecialchars($tenant['email']); ?></p>
              </div>
              <div class="col">
                <p class="m-0 py-2"><strong>Room #: </strong><?php echo htmlspecialchars(sprintf("%02d", $tenant['room_number'])); ?></p>
              </div>
            </div>
            <div class="row border mb-3">
              <p class="m-0 py-2"><strong>Home address: </strong><?php echo htmlspecialchars(!empty($tenant['home_address']) ? $tenant['home_address'] : 'N/A'); ?></p>
            </div>
            <div class="row">
            <a href="tenants.php" class="btn btn-primary mx-auto"> Back to Tenants</a>
          </div>
          </div>
          
        </div>
    </div>
  </div>
  <script src="../assets/js/script.js"></script>
</body>
</html>
