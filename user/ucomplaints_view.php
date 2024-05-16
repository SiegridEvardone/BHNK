<?php
session_start();
ob_start();

// Include database connection
include('../include/connection.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ulogin.php");
    exit();
}

// Get the complaint ID from the URL
if (!isset($_GET['id'])) {
    header("Location: ucomplaints.php");
    exit();
}

$complaint_id = $_GET['id'];

// Fetch the complaint details
$sql = "SELECT 
            c.title, 
            c.content,
            c.date_submitted, 
            c.status, 
            COALESCE(c.admin_response, 'N/A') AS reply, 
            u.first_name, 
            u.last_name, 
            u.room_number 
        FROM tblcomplaints c 
        JOIN tbluser u ON c.tenant_id = u.user_id 
        WHERE c.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $complaint_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "No complaint found!";
    exit();
}

$complaint = $result->fetch_assoc();

$stmt->close();
$conn->close();
ob_end_clean();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Complaints view</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <?php include('../include/dash_header.php'); ?>
  <div class="container-fluid">
    <div class="row">
      <?php include('sidenav.php'); ?> 
      <main class="col-12 col-md-5 ms-sm-auto col-lg-10 px-md-4 py-md-3">
        <div class="container mt-3 text-center">
          <div class="border border-dark p-4 mx-auto" style="max-width: 50%;">
            <p>Date: <?php echo htmlspecialchars(date('d/m/Y', strtotime($complaint['date_submitted']))); ?></p>
            <h3>Title: <?php echo htmlspecialchars($complaint['title']); ?></h3>
            <h5>Content: <?php echo htmlspecialchars($complaint['content']); ?></h5>
            <p>Reply from owner: <?php echo htmlspecialchars($complaint['reply']); ?></p>
            <p>Status: <?php echo htmlspecialchars($complaint['status']); ?></p>
            <p>Tenant Name: <?php echo htmlspecialchars($complaint['first_name'] . ' ' . $complaint['last_name']); ?></p>
            <a href="ucomplaints.php" class="btn btn-success">Back to Complaints</a>
            <!-- Add the complaint ID as a query parameter to the Delete button's URL -->
            <a href="delete_complaint.php?id=<?php echo $complaint_id; ?>" class="btn btn-danger">Delete</a>

          </div>
        </div>
      </main>
    </div>
  </div>
</body>
</html>
