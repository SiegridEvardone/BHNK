<?php
include('../include/connection.php');

// Get the lease ID from the URL
$lease_id = $_GET['lease_id'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lease_id = $_POST['lease_id'];
    $new_end_date = $_POST['new_end_date'];
    
    // Update the lease end date
    $sql = "UPDATE tenant_leases SET EndDate = ? WHERE LeaseID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_end_date, $lease_id);

    if ($stmt->execute()) {
        echo "<script>
                alert('Lease extended successfully');
                window.location.href = 'lease_monitor.php';
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Extend Lease</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .container {
      max-width: 600px;
      margin-top: 2rem;
    }
    .form-container {
      padding: 2rem;
      border: 1px solid #ced4da;
      border-radius: 0.25rem;
      background-color: #ffffff;
    }
    .btn-back {
      margin-right: 1rem;
    }
  </style>
</head>
<body>
<div class="position-relative">
    <?php include('../include/dash_header.php'); ?>
    <button class="openbtn position-absolute top-0 start-0" onclick="toggleSidebar()">☰</button>
    <div id="sidebar-container"></div>
    <div class="main">
      <main class="container">
        <div class="form-container">
          <h1 class="mb-4"><i class="fa-solid fa-calendar-plus"></i> Extend Lease</h1>
          <form method="post">
            <div class="form-group">
              <label for="lease_id">Lease ID:</label>
              <input type="text" id="lease_id" name="lease_id" class="form-control" value="<?php echo htmlspecialchars($lease_id); ?>" readonly>
              <input type="hidden" name="lease_id" value="<?php echo htmlspecialchars($lease_id); ?>">
            </div>
            <div class="form-group">
              <label for="new_end_date">New End Date:</label>
              <input type="date" id="new_end_date" name="new_end_date" class="form-control" required>
            </div>
            <div class="form-group">
              <a href="lease_monitor.php" class="btn btn-danger btn-back">Cancel</a>
              <button type="submit" class="btn btn-primary">Extend Lease</button>
            </div>
          </form>
        </div>
      </main>
    </div>
</div>
<script src="../assets/js/script.js"></script>
</body>
</html>
