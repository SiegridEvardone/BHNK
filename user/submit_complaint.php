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

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input (example, adapt as per your requirements)
    $title = $_POST['title'];
    $content = $_POST['content'];
    
    // Insert complaint into tblcomplaints
    $sql = "INSERT INTO tblcomplaints (tenant_id, title, content, date_submitted, status)
            VALUES (?, ?, ?, NOW(), 'Pending')";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $user_id, $title, $content);
    
    if ($stmt->execute()) {
        // Successful insertion
        header("Location: ucomplaints.php");
        exit();
    } else {
        // Error handling
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
ob_end_clean();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit a Complaint</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="position-relative">
    <?php include('../include/dash_header.php'); ?>
    <button class="openbtn position-absolute top-0 start-0" onclick="toggleSidebar()">☰</button>
    <div id="sidebar-container"></div>
    <div class="main">
      <div class="container border bg-light p-3" style="height: 86vh;">
        <h1 class="mb-4"><i class="fa-solid fa-circle-exclamation"></i> Submit a complaint</h1>
        <form action="" method="POST" class="border p-3">
          <label for="title" class="form-label">Title:</label>
          <input type="text" id="title" name="title" class="form-control" required><br>
          <label for="content">Content:</label>
          <textarea id="content" name="content" rows="4" class="form-control" required></textarea><br>
                <!-- Include the tenant_id as a hidden field -->
          <input type="hidden" name="tenant_id" value="<?php echo $_SESSION['user_id']; ?>">
          <br>
          <a href="ucomplaints.php" class="btn btn-danger mt-3">Cancel</a>
          <button class="btn btn-primary mt-3" type="submit">Submit</button>
        </form>
      </div>
    </div>
  </div>
<script src="../assets/js/script.js"></script>
<script>
// JavaScript code to display an alert after form submission
<?php if(isset($_GET['success']) && $_GET['success'] == 1): ?>
    alert("Complaint submitted successfully.");
<?php endif; ?>
</script>
</body>
</html>
