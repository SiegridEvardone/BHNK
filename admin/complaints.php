<?php
    // Include database connection
    include('../include/connection.php');

    // Fetch complaints data from the database
    $sql = "SELECT 
            c.id, 
            c.title, 
            c.content, 
            DATE_FORMAT(c.date_submitted, '%m-%d-%Y') AS formatted_date, 
            c.status, 
            COALESCE(c.admin_response, 'N/A') AS reply, 
            u.first_name, 
            u.last_name, 
            u.room_number 
        FROM tblcomplaints c 
        JOIN tbluser u ON c.tenant_id = u.user_id 
        ORDER BY FIELD(c.status, 'Pending', 'Solved'), c.date_submitted DESC";


    $result = $conn->query($sql);
  ?>
  

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Complaints</title>
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
        <div class="container mt-1">
          <h1 class="mb-4"><i class="fa-solid fa-circle-exclamation"></i> Complaints</h1>
        </div>
        <div class="container text-center p-0">
          <div class="row border" style="background-color: #D3D3D3;">
            <!-- Table headers -->
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
              <p class="fw-bold m-0">Date(YY-MM-DD)</p>
            </div>
            <div class="col p-2">
              <p class="fw-bold m-0">Reply from owner</p>
            </div>
            <div class="col p-2">
              <p class="fw-bold m-0">Status</p>
            </div>
            <div class="col-sm-1 p-2">
              <p class="fw-bold m-0">Action</p>
            </div>
          </div>
        </div>
        
        <div class="container text-center p-0 overflow-y-auto mb-4" style="height: 350px; overflow-x: hidden;">
          <?php if ($result->num_rows > 0): ?>
            <!-- Loop through complaints data and display each complaint -->
            <?php while ($row = $result->fetch_assoc()): ?>
              <div class="row bg-light border">
                <!-- Room number -->
                <div class="col-sm-1 p-2 border-end">
                  <p><?php echo htmlspecialchars($row['room_number']); ?></p>
                </div>
                <!-- Tenant name -->
                <div class="col p-2 border-end">
                  <p><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></p>
                </div>
                <!-- Complaint/Suggestions -->
                <div class="col p-2 border-end">
                  <p><?php echo htmlspecialchars($row['title']); ?></p>
                </div>
                <!-- Date -->
                <div class="col p-2 border-end">
                  <p><?php echo htmlspecialchars($row['formatted_date']); ?></p>
                </div>
                <!-- Reply from owner -->
                <div class="col p-2 border-end">
                  <p><?php echo htmlspecialchars($row['reply']); ?></p>
                </div>
                <!-- Status -->
                <div class="col p-2 border-end">
                <p style="background-color: <?php echo ($row['status'] == 'pending') ? '#fc5d5d' : '#8ef078'; ?>"><?php echo htmlspecialchars($row['status']); ?></p>
                </div>
                <!-- Action (View Complaint button) -->
                <div class="col-sm-1 p-2 border-end">
                <a href="complaints_view.php?id=<?php echo $row['id']; ?>" class="btn btn-primary"><i class="fa-solid fa-eye"></i></a>
                </div>
              </div>
            <?php endwhile; ?>
          <?php else: ?>
            <!-- No complaints found -->
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
