<?php
session_start();
ob_start();

// Include database connection
include('../include/connection.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch tenant information including room number and due date
$user_id = $_SESSION['user_id'];

$sql = "SELECT u.first_name, u.last_name, r.room_number, tl.StartDate, DATE_ADD(tl.StartDate, INTERVAL 1 MONTH) AS due_date
        FROM tbluser u
        JOIN tbltenant t ON u.user_id = t.user_id
        JOIN tblrooms r ON t.room_id = r.id
        JOIN tenant_leases tl ON t.user_id = tl.UserID
        WHERE u.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $first_name = htmlspecialchars($row['first_name']);
    $last_name = htmlspecialchars($row['last_name']);
    $room_number = htmlspecialchars($row['room_number']);
    $start_date = htmlspecialchars(date('F d, Y', strtotime($row['StartDate'])));
    $due_date = htmlspecialchars(date('F d, Y', strtotime($row['due_date'])));
} else {
    // Handle case where no data is found (though it should not happen if user_id is correctly set)
    $first_name = '';
    $last_name = '';
    $room_number = '';
    $start_date = '';
    $due_date = '';
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Due Date</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="position-relative">
    <?php include('../include/dash_header.php'); ?>
    <button class="openbtn position-absolute top-0 start-0" onclick="toggleSidebar()">☰</button>
    <div id="sidebar-container"></div>
    <div class="main">
      <div class="container bg-light p-3" style="height: 86vh;">
        <div class="container bg-light p-3">
          <h1 class="mb-4"><i class="fas fa-calendar-alt"></i> View Due Date</h1>
          <div class="row">
            <div class="col">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Tenant Information</h5>
                  <p class="card-text"><strong>Name:</strong> <?php echo "{$first_name} {$last_name}"; ?></p>
                  <p class="card-text"><strong>Room Number:</strong> <?php echo $room_number; ?></p>
                  <p class="card-text"><strong>Start Date:</strong> <?php echo $start_date; ?></p>
                  <p class="card-text"><strong>Due Date:</strong> <?php echo $due_date; ?></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../assets/js/script.js"></script>
</body>
</html>

<?php
ob_end_flush();
?>
