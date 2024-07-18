<?php
session_start();
ob_start();

// Include database connection
include('../include/connection.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the complaint ID from the URL
if (!isset($_GET['id'])) {
    header("Location: ucomplaints.php");
    exit();
}

$complaint_id = $_GET['id'];

// Fetch the user's complaint details
$sql = "
    SELECT 
        c.id, 
        c.title, 
        c.content, 
        c.date_submitted, 
        c.status, 
        COALESCE(c.admin_response, 'N/A') AS reply,
        u.first_name, 
        u.last_name,
        b.room_id
    FROM tblcomplaints c
    JOIN tbltenant b ON c.tenant_id = b.user_id
    JOIN tbluser u ON b.user_id = u.user_id
    WHERE c.id = ?
";


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
  <title>Complaint View</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <?php include('../include/dash_header.php'); ?>
  <div class="container-fluid">
    <div class="row">
      <?php include('sidenav.php'); ?> 
      <main class="col-12 col-md-5 ms-sm-auto col-lg-10 px-md-3 py-md-3">
        <div class="container bg-light p-3" style="height: 86vh;">
          <div class="border border-dark p-4 mx-auto " style="max-width: 50%;">
            <div class="row align-items-start">
              <p><strong>Date: </strong><?php echo htmlspecialchars(date('F d, Y', strtotime($complaint['date_submitted']))); ?></p>
              <div class="col-5">
              <h4>Title: </h4>
              <h5>Content: </h5>
              <p><strong>Reply from owner:</strong></p>
              <p><strong>Status:</strong></p>
              <p><strong>Name:</strong></p>
              </div>
              <div class="col-7">
                <h4><?php echo htmlspecialchars($complaint['title']); ?></h4>
                <h5><?php echo htmlspecialchars($complaint['content']); ?></h5>
                <p><?php echo htmlspecialchars($complaint['reply']); ?></p>
                <p><?php echo htmlspecialchars($complaint['status']); ?></p>
                <p> <i><?php echo htmlspecialchars($complaint['first_name'] . ' ' . $complaint['last_name']); ?></i></p>
              </div>
            </div>
            <a href="ucomplaints.php" class="btn btn-success">Back to Complaints</a>
            <a href="delete_complaint.php?id=<?php echo $complaint_id; ?>" class="btn btn-danger">Delete</a>
          </div>
        </div>
      </main>
    </div>
  </div>
</body>
</html>
