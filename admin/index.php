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
</head>
<body  style="overflow-x: hidden;">
  <?php
    include('../include/dash_header.php');
    include('../include/connection.php');
  ?>
  <div class="container-fluid">
    <div class="row">
      <?php
        include('sidenav.php');
      ?>  
            <!-- Page Content -->
      <main class="col-12 col-md-5 ms-sm-auto col-lg-10 px-md-4 py-md-3">
        <div class="container mt-3">
          <div class="row g-4">
            <div class="col-4">
              <div class="px-1 pt-1 border" style="background-color: #00446B;">
                <div class="container p-0">
                  <div class="row g-2">
                    <div class="col-md-8">
                      <div class="p-2 text-white">
                        <h2>
                        <?php
                          // Specify the table name for which you want to count the rows
                          $tableName = 'tblrooms';

                          // SQL query to count the rows in the specified table
                          $sql = "SELECT COUNT(*) AS rowCount FROM $tableName";

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
                              echo "<p>Failed to retrieve row count for table: $tableName</p>";
                          }
                        ?>
                        </h2>
                        <h4>Total Rooms</h4>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="text-white text-end p-3">
                        <i class="fa-solid fa-bed fs-1"></i>
                      </div>
                    </div>
                    <div class="col-12" style="background-color: #DCDCDC;">
                      <div class="p-2">
                        <a href="rooms.php" class="text-dark text-decoration-none fs-6">
                          View Details > 
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-4">
              <div class="px-1 pt-1 border" style="background-color: #00446B;">
                <div class="container p-0">
                  <div class="row g-2">
                    <div class="col-md-8">
                      <div class="p-2 text-white">
                        <h2>
                        <?php
                          // Specify the table name for which you want to count the rows
                          $tableName = 'tblrooms';

                          // SQL query to count the rows in the specified table
                          $sql = "SELECT COUNT(*) AS rowCount FROM $tableName WHERE status = 'available' ";

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
                              echo "<p>Failed to retrieve row count for table: $tableName</p>";
                          }
                        ?>
                        </h2>
                        <h4>Available Rooms</h4>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="text-white text-end p-3">
                        <i class="fa-solid fa-bed fs-1"></i>
                      </div>
                    </div>
                    <div class="col-12" style="background-color: #DCDCDC;">
                      <div class="p-2">
                        <a href="avail_rooms.php" class="text-dark text-decoration-none fs-6">
                          View Details > 
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-4">
              <div class="px-1 pt-1 border" style="background-color: #00446B;">
                <div class="container p-0">
                  <div class="row g-2">
                    <div class="col-md-8">
                      <div class="p-2 text-white">
                        <h2>
                        <?php
                          // Specify the table name for which you want to count the rows
                          $tableName = 'tbltenants';

                          // SQL query to count the rows in the specified table
                          $sql = "SELECT COUNT(*) AS rowCount FROM $tableName";

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
                              echo "<p>Failed to retrieve row count for table: $tableName</p>";
                          }
                        ?>
                        </h2>
                        <h4>Total Tenants</h4>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="text-white text-end p-3">
                        <i class="fa-solid fa-users fs-1"></i>
                      </div>
                    </div>
                    <div class="col-12" style="background-color: #DCDCDC;">
                      <div class="p-2">
                        <a href="tenants.php" class="text-dark text-decoration-none fs-6">
                          View Details > 
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-4">
              <div class="px-1 pt-1 border" style="background-color: #00446B;">
                <div class="container p-0">
                  <div class="row g-2">
                    <div class="col-md-8">
                      <div class="p-2 text-white">
                        <h2>0</h2>
                        <h4>Payments</h4>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="text-white text-end p-3">
                        <i class="fa-solid fa-money-bill-wave fs-1"></i>
                      </div>
                    </div>
                    <div class="col-12" style="background-color: #DCDCDC;">
                      <div class="p-2">
                        <a href="" class="text-dark text-decoration-none fs-6">
                          View Details > 
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-4">
              <div class="px-1 pt-1 border" style="background-color: #00446B;">
                 <div class="container p-0">
                    <div class="row g-2">
                      <div class="col-md-8">
                        <div class="p-2 text-white">
                          <h2>1</h2>
                          <h4>Invoice</h4>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="text-white text-end p-3">
                        <i class="fa-solid fa-file-invoice fs-1"></i>
                        </div>
                      </div>
                      <div class="col-12" style="background-color: #DCDCDC;">
                        <div class="p-2">
                          <a href="" class="text-dark text-decoration-none fs-6">
                            View Details > 
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-4">
                <div class="px-1 pt-1 border" style="background-color: #00446B;">
                  <div class="container p-0">
                    <div class="row g-2">
                      <div class="col-md-8">
                        <div class="p-2 text-white">
                          <h2>0</h2>
                          <h4>Income Report</h4>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="text-white text-end p-3">
                        
                        <i class="fa-solid fa-chart-column fs-1"></i>
                        </div>
                      </div>
                      <div class="col-12" style="background-color: #DCDCDC;">
                        <div class="p-2">
                          <a href="complaints.php" class="text-dark text-decoration-none fs-6">
                            View Details > 
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-4">
                <div class="px-1 pt-1 border" style="background-color: #00446B;">
                  <div class="container p-0">
                    <div class="row g-2">
                      <div class="col-md-8">
                        <div class="p-2 text-white">
                          <h2>0</h2>
                          <h4>Total Lease</h4>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="text-white text-end p-3">
                        <i class="fa-solid fa-tv fs-1"></i>
                        </div>
                      </div>
                      <div class="col-12" style="background-color: #DCDCDC;">
                        <div class="p-2">
                          <a href="notices.php" class="text-dark text-decoration-none fs-6">
                            View Details > 
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-4">
                <div class="px-1 pt-1 border" style="background-color: #00446B;">
                  <div class="container p-0">
                    <div class="row g-2">
                      <div class="col-md-8">
                        <div class="p-2 text-white">
                          <h2>0</h2>
                          <h4>Total Complaints</h4>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="text-white text-end p-3">
                        <i class="fa-solid fa-circle-exclamation fs-1"></i>
                        </div>
                      </div>
                      <div class="col-12" style="background-color: #DCDCDC;">
                        <div class="p-2">
                          <a href="" class="text-dark text-decoration-none fs-6">
                            View Details > 
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-4">
                <div class="px-1 pt-1 border" style="background-color: #00446B;">
                  <div class="container p-0">
                    <div class="row g-2">
                      <div class="col-md-8">
                        <div class="p-2 text-white">
                          <h2>
                          <?php
                          // Specify the table name for which you want to count the rows
                          $tableName = 'tblnotices';

                          // SQL query to count the rows in the specified table
                          $sql = "SELECT COUNT(*) AS rowCount FROM $tableName";

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
                              echo "<p>Failed to retrieve row count for table: $tableName</p>";
                          }
                        ?>
                          </h2>
                          <h4>Total Notices</h4>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="text-white text-end p-3">
                        <i class="fa-solid fa-bullhorn fs-1"></i>
                        </div>
                      </div>
                      <div class="col-12" style="background-color: #DCDCDC;">
                        <div class="p-2">
                          <a href="" class="text-dark text-decoration-none fs-6">
                            View Details > 
                          </a>
                        </div>
                      </div>
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