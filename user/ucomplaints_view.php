<?php
session_start();
ob_start();

// Include database connection
include('../include/connection.php');


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
<div class="position-relative">
    <?php include('../include/dash_header.php'); ?>
    <button class="openbtn position-absolute top-0 start-0" onclick="toggleSidebar()">☰</button>
    <div id="sidebar-container"></div>
    <div class="main">
    <div class="container bg-light p-3" style="min-height: 86vh;">
          <div class="border border-dark p-4 mx-auto" style="max-width: 100%; width: 100%;">
            <div class="row">
              <div class="col-12 col-md-6 mb-3">
                <p><strong>Date: </strong><?php echo htmlspecialchars(date('F d, Y', strtotime($complaint['date_submitted']))); ?></p>
              </div>
              <div class="col-12 col-md-6 mb-3">
                <p><strong>Name: </strong><i><?php echo htmlspecialchars($complaint['first_name'] . ' ' . $complaint['last_name']); ?></i></p>
              </div>
              <div class="col-12 mb-3">
                <h4><strong>Title: </strong><div class="bg-light-subtle text-light-emphasis border rounded p-2"><?php echo htmlspecialchars($complaint['title']); ?></div></h4>
              </div>
              <div class="col-12 mb-3">
                <h5><strong>Content: </strong><div class="bg-light-subtle text-light-emphasis border rounded p-2"><?php echo htmlspecialchars($complaint['content']); ?></div></h5>
              </div>
              <div class="col-12 mb-3">
                <p><strong>Reply from owner: </strong><div class="bg-light-subtle text-light-emphasis border rounded p-2"><?php echo htmlspecialchars($complaint['reply']); ?></div></p>
              </div>
              <div class="col-12 mb-3">
                <p><strong>Status: </strong><?php echo htmlspecialchars($complaint['status']); ?></p>
              </div>
              <div class="col-12 d-flex justify-content-between">
                <a href="ucomplaints.php" class="btn btn-success">Back to Complaints</a>
                <a href="delete_complaint.php?id=<?php echo $complaint_id; ?>" class="btn btn-danger">Delete</a>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
  <script src="../assets/js/script.js"></script>
</body>
</html>
