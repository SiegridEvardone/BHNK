<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Available Rooms</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    body {
      background-color: #f4f6f9;
    }
    .table-container {
      overflow-x: auto; /* Allows horizontal scrolling */
      overflow-y: auto; /* Prevents vertical scrolling if not needed */
      max-height: 420px; /* Sets the maximum height */
      padding-bottom: 10px;
    }
    .table {
      min-width: 1000px; /* Ensures the table doesn’t wrap on larger screens */
      white-space: nowrap;
       /* Prevents text from wrapping */
    }
    .table td img {
      max-width: 100px; /* Restrict maximum width of images */
      max-height: 100px; /* Restrict maximum height of images */
      height: auto;
    }
    @media (max-width: 768px) {
      .table {
        min-width: 600px; /* Adjust width for smaller screens */
      }
    }
  </style>
</head>
<body>
  <div class="position-relative">
    <?php include('../include/dash_header.php'); ?>
    <button class="openbtn position-absolute top-0 start-0" onclick="toggleSidebar()">☰</button>
    <div id="sidebar-container"></div>
    <div class="main">  
      <div class="container border bg-light p-3">
        <h1 class="mb-2"><i class="fa-solid fa-door-open"></i> Available Rooms</h1>
        <div class="table-container mt-3">
          <table class="table table-bordered table-striped">
            <thead style="background-color: #D3D3D3;">
              <tr>
                <th scope="col">Room Number</th>
                <th scope="col">Description</th>
                <th scope="col">Rent /month</th>
                <th scope="col">Status</th>
                <th scope="col">Tenants</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              include('../include/connection.php');  
              // Fetch rooms and their assigned tenants from the database
              $sql = "SELECT r.*, GROUP_CONCAT(CONCAT(u.first_name, ' ', u.last_name) SEPARATOR ', ') AS tenant_names
                      FROM tblrooms r 
                      LEFT JOIN tenant_leases t ON r.id = t.RoomID
                      LEFT JOIN tbluser u ON t.UserID = u.user_id
                      GROUP BY r.id";
              $result = mysqli_query($conn, $sql);

              // Check if there are any rooms
              if ($result && mysqli_num_rows($result) > 0) {
                  // Loop through each room and display it
                  while ($row = mysqli_fetch_assoc($result)) {
                      $roomId = $row['id'];
                      $roomNumber = $row['room_number'];
                      $description = $row['description'];
                      $rentPrice = $row['rent_price'];
                      $status = $row['status'];
                      $tenantNames = $row['tenant_names'];
              ?>
              <tr class="bg-light border">
                <td><?php echo htmlspecialchars($roomNumber); ?></td>
                <td><?php echo htmlspecialchars($description); ?></td>
                <td><i class="fa-solid fa-peso-sign"></i> <?php echo htmlspecialchars($rentPrice); ?></td>
                <td><p style="background-color: <?php echo ($status == 'available') ? '#8ef078' : '#fc5d5d'; ?>;"><?php echo htmlspecialchars($status); ?></p></td>
                <td><p class="mb-0"><?php echo htmlspecialchars($tenantNames); ?></p></td>
                <td>
                  <a href="assign_tenant.php?id=<?php echo $roomId; ?>" class="btn btn-primary mb-2">Add Tenant</a> <br>
                  <script>
                    function confirmRemoval() {
                      return confirm("Are you sure you want to remove the tenant?");
                    }
                  </script>
                  <button onclick="if (confirmRemoval()) location.href='remove_tenant.php?id=<?php echo $roomId; ?>';" class="btn btn-danger">Remove Tenant</button>
                </td>
              </tr>
              <?php
                  }
              } else {
                  // No rooms found
                  echo "<tr><td colspan='6' class='text-center fst-italic'>No rooms found.</td></tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <script src="../assets/js/script.js"></script>
  </div>
</body>
</html>
