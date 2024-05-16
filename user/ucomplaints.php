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

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Fetch the user's complaints
$sql = "SELECT 
            c.id, 
            c.title, 
            c.date_submitted, 
            c.status, 
            COALESCE(c.admin_response, 'N/A') AS reply, 
            u.first_name, 
            u.last_name, 
            u.room_number 
        FROM tblcomplaints c 
        JOIN tbluser u ON c.tenant_id = u.user_id 
        WHERE c.tenant_id = ?";
        
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$complaints = [];
while ($row = $result->fetch_assoc()) {
    // Format the date
    $date = new DateTime($row['date_submitted']);
    $row['formatted_date'] = $date->format('m/d/Y'); // Change format as needed
    $complaints[] = $row;
}

$stmt->close();
$conn->close();
ob_end_clean();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Complaints</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <?php include('../include/dash_header.php'); ?>
  <div class="container-fluid">
    <div class="row">
      <?php include('sidenav.php'); ?> 
      <main class="col-12 col-md-5 ms-sm-auto col-lg-10 px-md-4 py-md-3">
        <div class="container mt-1">
          <h1 class="mb-2"><i class="fa-solid fa-circle-exclamation"></i> Complaints</h1>
        </div>
        <a href="submit_complaint.php" class="btn btn-success m-2"><i class="fa-solid fa-plus"></i> Submit Complaint</a>
        <div class="container text-center p-0">
          <div class="row border" style="background-color: #D3D3D3;">
            <div class="col-sm-1 p-2">
              <p class="fw-bold m-0">Room #</p>
            </div>
            <div class="col p-2">
              <p class="fw-bold m-0">Tenant Name</p>
            </div>
            <div class="col p-2">
              <p class="fw-bold m-0">Complaint/Suggestions</p>
            </div>
            <div class="col p-2">
              <p class="fw-bold m-0">Date</p>
            </div>
            <div class="col p-2">
              <p class="fw-bold m-0">Reply from Owner</p>
            </div>
            <div class="col p-2">
              <p class="fw-bold m-0">Status</p>
            </div>
            <div class="col-sm-1 p-2">
              <p class="fw-bold m-0">Action</p>
            </div>
          </div>
        </div>
        <div class="container text-center p-0 overflow-y-auto" style="height: 350px; overflow-x: hidden;">
          <?php if (!empty($complaints)): ?>
              <?php foreach ($complaints as $complaint): ?>
                  <div class="row bg-light border">
                    <div class="col-sm-1 p-2 border-end">
                      <p class="mb-0"><span class="fw-normal fst-italic">0<?php echo htmlspecialchars($complaint['room_number']); ?></span></p>
                    </div>
                    <div class="col p-2 border-end">
                      <p class="mb-0"><span class="fw-normal fst-italic"><?php echo htmlspecialchars($complaint['first_name'] . ' ' . $complaint['last_name']); ?></span></p>
                    </div>
                    <div class="col p-2 border-end">
                      <p class="mb-0"><span class="fw-normal fst-italic"><?php echo htmlspecialchars($complaint['title']); ?></span></p>
                    </div>
                    <div class="col p-2 border-end">
                      <p class="mb-0"><span class="fw-normal fst-italic"><?php echo htmlspecialchars($complaint['formatted_date']); ?></span></p>
                    </div>
                    <div class="col p-2 border-end">
                      <p class="mb-0"><span class="fw-normal fst-italic"><?php echo htmlspecialchars($complaint['reply']); ?></span></p>
                    </div>
                    <div class="col p-2 border-end">
                    <p style="background-color: <?php echo ($complaint['status'] == 'pending') ? '#fc5d5d' : '#8ef078'; ?>"><?php echo htmlspecialchars($complaint['status']); ?></p>
                    </div>
                    <div class="col-sm-1 p-2 border-end">
                      <a href="ucomplaints_view.php?id=<?php echo $complaint['id']; ?>" class="btn btn-primary"><i class="fa-solid fa-eye"></i></a>
                    </div>
                  </div>
              <?php endforeach; ?>
          <?php else: ?>
              <div class="row bg-light border">
                  <div class="col p-2">
                      <p class="fw-normal fst-italic">No complaints found.</p>
                  </div>
              </div>
          <?php endif; ?>
        </div>
      </main>
    </div>
  </div>
</body>
</html>
