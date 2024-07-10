<?php
  session_start();
  include('../include/connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tenant Dashboard</title>
</head>
<body style="overflow-x: hidden;">
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
        <div class="container mt-3" style="height: 90vh;">
          <div class="row g-4">
            <div class="col-4">
            <div class="px-1 pt-1 border rounded shadow" style="background-color: orange;">
                <div class="container p-0">
                  <div class="row g-2">
                    <div class="col-md-8">
                      <div class="p-2 text-white">
                        <h2>

                        </h2>
                        <h4>Payments</h4>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="text-white text-end p-3">
                        <i class="fa-solid fa-money-bill-wave fs-1"></i>
                      </div>
                    </div>
                    <div class="col-12 bg-dark bg-opacity-10">
                      <div class="p-2">
                        <a href="" class="text-light text-decoration-none fs-6">
                          View Details > 
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
              <div class="col-4">
              <div class="px-1 pt-1 border rounded shadow " style="background-color: maroon;">
                  <div class="container p-0">
                    <div class="row g-2">
                      <div class="col-md-8">
                        <div class="p-2 text-white">
                          <h2>
                          <?php
                          // Specify the table name for which you want to count the rows
                          $totalComplaints = 'tblcomplaints';
                          $user_id = $_SESSION['user_id'];
                          // SQL query to count the rows in the specified table
                          $sql = "SELECT COUNT(*) AS rowCount FROM tblcomplaints WHERE tenant_id = '$user_id'";

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
                          <h4>Total Complaints</h4>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="text-white text-end p-3">
                          <i class="fa-solid fa-circle-exclamation fs-1"></i>
                        </div>
                      </div>
                      <div class="col-12 bg-dark bg-opacity-10">
                        <div class="p-2">
                          <a href="ucomplaints.php" class="text-light text-decoration-none fs-6">
                            View Details > 
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-4">
              <div class="px-1 pt-1 border rounded shadow" style="background-color: indigo;">
                  <div class="container p-0">
                    <div class="row g-2">
                      <div class="col-md-8">
                        <div class="p-2 text-white">
                          <h2>
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
                          <h4>Total Notices</h4>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="text-white text-end p-3">
                        <i class="fa-solid fa-bullhorn fs-1"></i>
                        </div>
                      </div>
                      <div class="col-12 bg-dark bg-opacity-10">
                        <div class="p-2">
                          <a href="unotices.php" class="text-light text-decoration-none fs-6">
                            View Details > 
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-4">
              <div class="px-1 pt-1 border rounded shadow" style="background-color: darkblue;">
                  <div class="container p-0">
                    <div class="row g-2">
                      <div class="col-md-8">
                        <div class="p-2 text-white">
                          <h2>0</h2>
                          <h4>Settings</h4>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="text-white text-end p-3">
                          <i class="fa-solid fa-gear fs-1"></i>
                        </div>
                      </div>
                      <div class="col-12 bg-dark bg-opacity-10">
                        <div class="p-2">
                          <a href="" class="text-light text-decoration-none fs-6">
                            View Details > 
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-4">
              <div class="px-1 pt-1 border rounded shadow" style="background-color: green;">
                  <div class="container p-0">
                    <div class="row g-2">
                      <div class="col-md-8">
                        <div class="p-2 text-white">
                          <h2>0</h2>
                          <h4>Profile</h4>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="text-white text-end p-3">
                        <i class="fa-solid fa-user-gear fs-1"></i>
                        </div>
                      </div>
                      <div class="col-12 bg-dark bg-opacity-10">
                        <div class="p-2">
                          <a href="uprofile.php" class="text-light text-decoration-none fs-6">
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