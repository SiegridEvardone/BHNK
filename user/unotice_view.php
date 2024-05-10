<?php
ob_start();
include('../include/pdoconnect.php');

// Check if notice ID is provided
if (!isset($_GET['id'])) {
    // Redirect to notices.php if notice ID is not provided
    header("Location: notices.php");
    exit();
}

// Get the notice ID from the URL
$notice_id = $_GET['id'];

// Fetch the notice details from the database
$sql = "SELECT * FROM tblnotices WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$notice_id]);
$notice = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if notice exists
if (!$notice) {
    // Redirect to notices.php if notice does not exist
    header("Location: notices.php");
    exit();
}
ob_end_clean();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant View Notice</title>
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
        <div class="container mt-3 text-center">
          <div class="border border-dark p-4 mx-auto" style="max-width: 50%;">
            <h3><?php echo $notice['title']; ?></h3>
            <p><?php echo $notice['content']; ?></p>
            <p>Posted on: <?php echo $notice['post_date']; ?></p>
            <a href="unotices.php" class="btn btn-success">Back to Notices</a>
          </div>
        </div>
      </main>
    </div>
  </div>

</body>
</html>