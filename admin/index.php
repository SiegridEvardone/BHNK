<?php
  // Include your database connection file
  include('../include/connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <style>
    *{
      box-sizing: border-box;
      color: white;
    }
    .card-container {
      padding: 10px;
    }
    .card-container a {
      color: white;
      text-decoration: none;
    }
  </style>
</head>
<body  style="overflow-x: hidden;">
  <?php
    include('../include/dash_header.php');
  ?>
  <div class="container-fluid">
    <div class="row">
      <?php
        include('sidenav.php');
      ?>  
            <!-- Page Content -->
      <main class="col-12 col-md-5 ms-sm-auto col-lg-10 px-md-3 py-md-3">
        <div class="container mt-3">
          <div class="row g-4">
          <div class="col-12 col-md-6 col-lg-4">
              <div class="card-container border rounded shadow p-0" style="background-color: orange;">
                <div class="row">
                  <div class="col-8 p-3">
                    <h2 class="ps-2">
                    <?php
                      $totalRooms = 'tblrooms';
                      $sql = "SELECT COUNT(*) AS rowCount FROM $totalRooms";
                      $result = mysqli_query($conn, $sql);
                      if ($result) {
                          $row = mysqli_fetch_assoc($result);
                          $rowCount = $row['rowCount'];
                          echo "<p class='mb-0'>$rowCount</p>";
                      } else {
                          echo "<p>Failed to retrieve row count for table: $totalRooms</p>";
                      }
                    ?>
                    </h2>
                    <h4 class="ps-2">Total Rooms</h4>
                  </div>
                  <div class="col-4">
                    <div class="text-white text-end p-3">
                      <i class="fa-solid fa-bed fs-1"></i>
                    </div>
                  </div>
                </div>
                
                <div class="col-12 bg-dark bg-opacity-10">
                  <div class="p-2">
                    <a href="rooms.php" class="fs-6">View Details ></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
              <div class="card-container border rounded shadow p-0" style="background-color: green;">
                <div class="row">
                  <div class="col-8 p-3">
                    <h2 class="ps-2">
                    <?php
                          // Specify the table name for which you want to count the rows
                          $availRooms = 'tblrooms';

                          // SQL query to count the rows in the specified table
                          $sql = "SELECT COUNT(*) AS rowCount FROM $availRooms WHERE status = 'available' ";

                          // Execute the query
                          $result = mysqli_query($conn, $sql);

                          // Check if the query was successful
                          if ($result) {
                              // Fetch the count from the result
                              $row = mysqli_fetch_assoc($result);
                              $rowCount = $row['rowCount'];

                              // Display the row count in your HTML code
                              echo "<p class='mb-0'>$rowCount</p>";
                          } else {
                              // Handle the case where the query fails
                              echo "<p>Failed to retrieve row count for table: $availRooms</p>";
                          }
                        ?>
                    </h2>
                    <h4 class="ps-2">Available Rooms</h4>
                  </div>
                  <div class="col-4">
                    <div class="text-white text-end p-3">
                      <i class="fa-solid fa-bed fs-1"></i>
                    </div>
                  </div>
                </div>
                
                <div class="col-12 bg-dark bg-opacity-10">
                  <div class="p-2">
                    <a href="avail_rooms.php" class="fs-6">View Details ></a>
                  </div>
                </div>
              </div>
            </div>
           
            <div class="col-12 col-md-6 col-lg-4">
              <div class="card-container border rounded shadow p-0" style="background-color: indigo;">
                <div class="row">
                  <div class="col-8 p-3">
                    <h2 class="ps-2">
                    <?php
                          // Specify the table name for which you want to count the rows
                          $totalTenants = 'tenant_leases';

                          // SQL query to count the rows in the specified table
                          $sql = "SELECT COUNT(*) AS rowCount FROM $totalTenants";

                          // Execute the query
                          $result = mysqli_query($conn, $sql);

                          // Check if the query was successful
                          if ($result) {
                              // Fetch the count from the result
                              $row = mysqli_fetch_assoc($result);
                              $rowCount = $row['rowCount'];

                              // Display the row count in your HTML code
                              echo "<p class='mb-0'>$rowCount</p>";
                          } else {
                              // Handle the case where the query fails
                              echo "<p>Failed to retrieve row count for table: $totalTenants</p>";
                          }
                        ?>
                    </h2>
                    <h4 class="ps-2">Total Tenants</h4>
                  </div>
                  <div class="col-4">
                    <div class="text-white text-end p-3">
                      <i class="fa-solid fa-bed fs-1"></i>
                    </div>
                  </div>
                </div>
                <div class="col-12 bg-dark bg-opacity-10">
                  <div class="p-2">
                    <a href="tenants.php" class="fs-6">View Details ></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
              <div class="card-container border rounded shadow p-0" style="background-color: darkblue;">
                <div class="row">
                  <div class="col-8 p-3">
                    <h2 class="ps-2">
                    0
                    </h2>
                    <h4 class="ps-2">Payments</h4>
                  </div>
                  <div class="col-4">
                    <div class="text-white text-end p-3">
                      <i class="fa-solid fa-bed fs-1"></i>
                    </div>
                  </div>
                </div>
                <div class="col-12 bg-dark bg-opacity-10">
                  <div class="p-2">
                    <a href="#" class="fs-6">View Details ></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
              <div class="card-container border rounded shadow p-0" style="background-color: maroon;">
                <div class="row">
                  <div class="col-8 p-3">
                    <h2 class="ps-2">
                     0
                    </h2>
                    <h4 class="ps-2">Invoice</h4>
                  </div>
                  <div class="col-4">
                    <div class="text-white text-end p-3">
                      <i class="fa-solid fa-bed fs-1"></i>
                    </div>
                  </div>
                </div>
                <div class="col-12 bg-dark bg-opacity-10">
                  <div class="p-2">
                    <a href="#" class="fs-6">View Details ></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
              <div class="card-container border rounded shadow p-0" style="background-color: darkblue;">
                <div class="row">
                  <div class="col-8 p-3">
                    <h2 class="ps-2">
                   0
                    </h2>
                    <h4 class="ps-2">Income Report</h4>
                  </div>
                  <div class="col-4">
                    <div class="text-white text-end p-3">
                      <i class="fa-solid fa-bed fs-1"></i>
                    </div>
                  </div>
                </div>
                <div class="col-12 bg-dark bg-opacity-10">
                  <div class="p-2">
                    <a href="#" class="fs-6">View Details ></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
              <div class="card-container border rounded shadow p-0" style="background-color: indigo;">
                <div class="row">
                  <div class="col-8 p-3">
                    <h2 class="ps-2">
                    <?php
                          // Specify the table name for which you want to count the rows
                          $totalLeases = 'tenant_leases';

                          // SQL query to count the rows in the specified table
                          $sql = "SELECT COUNT(*) AS rowCount FROM $totalLeases";

                          // Execute the query
                          $result = mysqli_query($conn, $sql);

                          // Check if the query was successful
                          if ($result) {
                              // Fetch the count from the result
                              $row = mysqli_fetch_assoc($result);
                              $rowCount = $row['rowCount'];

                              // Display the row count in your HTML code
                              echo "<p class='mb-0'>$rowCount</p>";
                          } else {
                              // Handle the case where the query fails
                              echo "<p>Failed to retrieve row count for table: $totalLeases</p>";
                          }
                        ?>
                    </h2>
                    <h4 class="ps-2">Total Leases</h4>
                  </div>
                  <div class="col-4">
                    <div class="text-white text-end p-3">
                      <i class="fa-solid fa-bed fs-1"></i>
                    </div>
                  </div>
                </div>
                <div class="col-12 bg-dark bg-opacity-10">
                  <div class="p-2">
                    <a href="lease_monitor.php" class="fs-6">View Details ></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
              <div class="card-container border rounded shadow p-0" style="background-color: orange;">
                <div class="row">
                  <div class="col-8 p-3">
                    <h2 class="ps-2">
                    <?php
                          // Specify the table name for which you want to count the rows
                          $totalComplaints = 'tblcomplaints';

                          // SQL query to count the rows in the specified table
                          $sql = "SELECT COUNT(*) AS rowCount FROM $totalComplaints";

                          // Execute the query
                          $result = mysqli_query($conn, $sql);

                          // Check if the query was successful
                          if ($result) {
                              // Fetch the count from the result
                              $row = mysqli_fetch_assoc($result);
                              $rowCount = $row['rowCount'];

                              // Display the row count in your HTML code
                              echo "<p class='mb-0'>$rowCount</p>";
                          } else {
                              // Handle the case where the query fails
                              echo "<p>Failed to retrieve row count for table: $totalComplaints</p>";
                          }
                        ?>
                    </h2>
                    <h4 class="ps-2">Total Complaints</h4>
                  </div>
                  <div class="col-4">
                    <div class="text-white text-end p-3">
                      <i class="fa-solid fa-bed fs-1"></i>
                    </div>
                  </div>
                </div>
                <div class="col-12 bg-dark bg-opacity-10">
                  <div class="p-2">
                    <a href="complaints.php" class="fs-6">View Details ></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
              <div class="card-container border rounded shadow p-0" style="background-color: green;">
                <div class="row">
                  <div class="col-8 p-3">
                    <h2 class="ps-2">
                    <?php
                          // Specify the table name for which you want to count the rows
                          $totalNotices = 'tblnotices';

                          // SQL query to count the rows in the specified table
                          $sql = "SELECT COUNT(*) AS rowCount FROM $totalNotices";

                          // Execute the query
                          $result = mysqli_query($conn, $sql);

                          // Check if the query was successful
                          if ($result) {
                              // Fetch the count from the result
                              $row = mysqli_fetch_assoc($result);
                              $rowCount = $row['rowCount'];

                              // Display the row count in your HTML code
                              echo "<p class='mb-0'>$rowCount</p>";
                          } else {
                              // Handle the case where the query fails
                              echo "<p>Failed to retrieve row count for table: $totalNotices</p>";
                          }
                        ?>
                    </h2>
                    <h4 class="ps-2">Total Notices</h4>
                  </div>
                  <div class="col-4">
                    <div class="text-white text-end p-3">
                      <i class="fa-solid fa-bed fs-1"></i>
                    </div>
                  </div>
                </div>
                <div class="col-12 bg-dark bg-opacity-10">
                  <div class="p-2">
                    <a href="notices.php" class="fs-6">View Details ></a>
                  </div>
                </div>
              </div>
            </div>
              
            </div>
          </div>
      </main>
    </div>
  </div>
</body>
</html>