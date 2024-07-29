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
  <style>
    body {
      background-color: #f8f9fa;
    }
    .profile-img {
      width: 100%;
      max-width: 150px;
      height: auto;
      border-radius: 50%;
    }
    .card-body p {
      margin-bottom: 0.5rem;
    }
    .card {
      margin-bottom: 1rem;
    }
    .btn-back {
      display: block;
      width: 100%;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="position-relative">
    <?php include('../include/dash_header.php'); ?>
    <button class="openbtn position-absolute top-0 start-0" onclick="toggleSidebar()">☰</button>
    <div id="sidebar-container"></div>
    <div class="main">  
      <div class="container bg-light p-3">
        <h2 class="mb-4"><i class="fa-solid fa-user"></i> Tenant Information</h2>
        <div class="row">
          <div class="col-md-4 text-center">
            <?php 
              // Construct the correct path to the image
              $imagePath = !empty($tenant['image']) ? '../user/' . $tenant['image'] : '../user/profile_images/noprofile.jfif';
            ?>
            <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Profile Image" class="profile-img img-fluid">
          </div>
          <div class="col-md-8">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Personal Details</h5>
                <p><strong>Name: </strong><?php echo htmlspecialchars($tenant['first_name'] . ' ' . $tenant['middle_name'] . ' ' . $tenant['last_name']); ?></p>
                <p><strong>Age: </strong><?php echo htmlspecialchars(calculate_age($tenant['birthdate'])); ?></p>
                <p><strong>Gender: </strong><?php echo htmlspecialchars($tenant['gender']); ?></p>
                <p><strong>Birthdate: </strong><?php echo htmlspecialchars(date('M d, Y', strtotime($tenant['birthdate']))); ?></p>
                <p><strong>Contact: </strong><?php echo htmlspecialchars(!empty($tenant['contact']) ? $tenant['contact'] : 'N/A'); ?></p>
                <p><strong>Email: </strong><?php echo htmlspecialchars($tenant['email']); ?></p>
                <p><strong>Room #: </strong><?php echo htmlspecialchars(sprintf("%02d", $tenant['room_number'])); ?></p>
                <p><strong>Home address: </strong><?php echo htmlspecialchars(!empty($tenant['home_address']) ? $tenant['home_address'] : 'N/A'); ?></p>
              </div>
            </div>
          </div>
        </div>
        <a href="tenants.php" class="btn btn-primary btn-back mt-3"><i class="fa-solid fa-arrow-left"></i> Back to Tenants</a>
      </div>
    </div>
  </div>
  <script src="../assets/js/script.js"></script>
</body>
</html>
