<?php
include ('../include/connection.php');

// Get the lease ID from the URL
$lease_id = $_GET['lease_id'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lease_id = $_POST['lease_id'];
    $new_end_date = $_POST['new_end_date'];
    
    // Update the lease end date
    $sql = "UPDATE tenant_leases SET EndDate = '$new_end_date' WHERE LeaseID = '$lease_id'";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Lease extended successfully');
                window.location.href = 'lease_monitor.php';
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Extend Lease</title>
</head>
<body>
<div class="position-relative">
    <?php include('../include/dash_header.php'); ?>
    <button class="openbtn position-absolute top-0 start-0" onclick="toggleSidebar()">☰</button>
    <div id="sidebar-container"></div>
    <div class="main">  
      <main class="col-12 col-md-5 ms-sm-auto col-lg-10 px-md-4 py-md-3">
        <div class="container bg-light p-3" style="height: 510px;">
          <h1 class="mb-2"><i class="fa-solid fa-users"></i> Extend Lease</h1>
        
        <div class="border border-dark p-4 mx-auto" style="max-width: 50%;">
        <form method="post">
            <label for="lease_id" class="form-label">Lease ID:</label>
            <input type="text" id="lease_id" name="lease_id" class="form-control pb-0" value="<?php echo htmlspecialchars($lease_id); ?>" readonly><br>
            <input type="hidden" name="lease_id" value="<?php echo htmlspecialchars($lease_id); ?>">
            
            <label for="new_end_date" class="form-label">New End Date:</label>
            <input type="date" id="new_end_date" name="new_end_date" class="form-control pb-0" required><br>
            <a href="lease_monitor.php" class="btn btn-danger">Cancel</a>
            <button type="submit" class="btn btn-primary">Extend Lease</button>
        </form>
        </div>
        </div>
      </main>
    </div>
  </div>
  <script src="../assets/js/script.js"></script>
</body>
</html>
