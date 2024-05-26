<?php
session_start();
include('../include/connection.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../adminlogin.php");
    exit();
}

// Get the complaint ID from the URL
if (!isset($_GET['id'])) {
    header("Location: complaints.php");
    exit();
}

$complaint_id = intval($_GET['id']);

// Fetch the complaint details
$sql = "SELECT 
            c.id, 
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

// Check if form is submitted for reply
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["reply"])) {
    $reply = $_POST["reply"];

    // Update the complaint with admin's response
    $update_sql = "UPDATE tblcomplaints SET admin_response = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("si", $reply, $complaint_id);
    $update_stmt->execute();
    $update_stmt->close();

    header("Location: complaints_view.php?id=" . $complaint_id);
    exit();
}

// Check if form is submitted for status change
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["status"])) {
    $new_status = $_POST["status"];

    // Update the complaint status
    $update_status_sql = "UPDATE tblcomplaints SET status = ? WHERE id = ?";
    $update_status_stmt = $conn->prepare($update_status_sql);
    $update_status_stmt->bind_param("si", $new_status, $complaint_id);
    $update_status_stmt->execute();
    $update_status_stmt->close();

    header("Location: complaints_view.php?id=" . $complaint_id);
    exit();
}

$conn->close();
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
          <div class="row">
            <div class="col">
            <p>Date: <?php echo htmlspecialchars(date('d/m/Y', strtotime($complaint['date_submitted']))); ?></p>
            <h3>Title: <?php echo htmlspecialchars($complaint['title']); ?></h3>
            <h5>Content: <?php echo htmlspecialchars($complaint['content']); ?></h5>
            <p>Tenant Name: <?php echo htmlspecialchars($complaint['first_name'] . ' ' . $complaint['last_name']); ?></p>
            <p>Reply from owner: <?php echo htmlspecialchars($complaint['reply']); ?></p>
            <p>Status: <?php echo htmlspecialchars($complaint['status']); ?></p>
            </div>
            <div class="col">
            <!-- Form for submitting reply -->
            <form method="post" action="">
              <div class="form-group">
                <label for="reply">Reply:</label>
                <textarea class="form-control" id="reply" name="reply" rows="2"></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Submit Reply</button>
            </form>
            <hr>
            <!-- Form for changing status -->
            <form method="post" action="">
              <div class="form-group">
                <label for="status">Change Status:</label>
                <select class="form-control" id="status" name="status">
                  <option value="Pending">Pending</option>
                  <option value="Solved">Solved</option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary">Change Status</button>
            </form>
            </div>
          </div>
            
            <hr>
            <a href="complaints.php" class="btn btn-success">Back to Complaints</a>
          </div>
        </div>
      </main>
    </div>
  </div>
</body>
</html>
