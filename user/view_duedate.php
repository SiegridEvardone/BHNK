<?php
session_start();
include('../include/connection.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: userlogin.php");
    exit();
}

// Fetch tenant details from the database
$tenant_id = $_SESSION['user_id'];
$sql = "SELECT t.room_id, r.room_number, CONCAT(u.first_name, ' ', u.last_name) AS full_name, t.due_date 
        FROM tbltenants t 
        INNER JOIN tblrooms r ON t.room_id = r.id 
        INNER JOIN tbluser u ON t.user_id = u.user_id 
        WHERE t.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $tenant_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $room_number = $row['room_number'];
    $full_name = $row['full_name'];
    $monthly_due_date = date('m/d/Y', strtotime($row['due_date']));
} else {
    // Handle case where no tenant details are found
    $room_number = "N/A";
    $full_name = "N/A";
    $monthly_due_date = "N/A";
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Due date</title>
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
        <div class="container mt-3">
          <div class="border border-dark p-4 mx-auto" style="max-width: 50%;">
            <h2 class="text-center">Your Details:</h2>
            <div class="container mt-5 p-0">
              <h4>Room #: <?php echo $room_number; ?></h4>
              <h4>Name: <?php echo $full_name; ?></h4>
              <h4>Due Date: <?php echo $monthly_due_date; ?></h4>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</body>
</html>
