<?php
  session_start();
  include('../include/connection.php');

  // Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
  // Redirect to login page
  header("Location: ../login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Dashboard</title>
</head>
<body>
  <div class="position-relative">
    <?php include('../include/dash_header.php'); ?>
    <button class="openbtn position-absolute top-0 start-0" onclick="toggleSidebar()">☰</button>
    <div id="sidebar-container"></div>
    <div class="main text-light">
      <div class="row g-4">
            <div class="col-12 col-md-6 col-lg-4">
              <div class="dashcard card-container border rounded shadow p-0" style="background-color: orange;">
                <div class="row">
                  <div class="col-8 p-3">
                    <h2 class="ps-2">
                    <?php
                            // Specify the table name for which you want to count the rows
                            $totalPayments = 'payments';
                            $user_id = $_SESSION['user_id'];
                            // SQL query to count the rows in the specified table
                            $sql = "SELECT COUNT(*) AS rowCount FROM payments WHERE user_id = '$user_id'";

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
                                echo "<p>Failed to retrieve row count for table: $totalPayments</p>";
                            }
                          ?>
                    </h2>
                    <h4 class="ps-2">Total Payments</h4>
                  </div>
                  <div class="col-4">
                    <div class="text-white text-end p-3">
                      <i class="fa-solid fa-bed fs-1"></i>
                    </div>
                  </div>
                </div>
                <div class="col-12 bg-dark bg-opacity-10">
                  <div class="p-2">
                    <a href="upayment_history.php" class="text-light text-decoration-none fs-6">View Details ></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
              <div class="dashcard card-container border rounded shadow p-0" style="background-color: maroon;">
                <div class="row">
                  <div class="col-8 p-3">
                    <h2 class="ps-2">
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
                    <a href="ucomplaints.php" class="text-light text-decoration-none fs-6">View Details ></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
              <div class="dashcard card-container border rounded shadow p-0" style="background-color: indigo;">
                <div class="row">
                  <div class="col-8 p-3">
                    <h2 class="ps-2">
                    <?php
                          $totalNotices = 'tblnotices';
                          $user_id = $_SESSION['user_id'];

                          // SQL query to count the public notices
                          $sql_public = "SELECT COUNT(*) AS rowCount FROM tblnotices WHERE visibility = 'public'";
                          $result_public = mysqli_query($conn, $sql_public);

                          // SQL query to count the private notices for the current user
                          $sql_private = "SELECT COUNT(*) AS rowCount FROM tblnotices WHERE visibility = 'private' AND recipient_user_id = '$user_id'";
                          $result_private = mysqli_query($conn, $sql_private);

                          if ($result_public && $result_private) {
                              $row_public = mysqli_fetch_assoc($result_public);
                              $row_private = mysqli_fetch_assoc($result_private);

                              $publicCount = $row_public['rowCount'];
                              $privateCount = $row_private['rowCount'];
                              $totalCount = $publicCount + $privateCount;

                              echo "<p class='mb-0'>$totalCount</p>";
                          } else {
                              echo "<p>Failed to retrieve notice counts.</p>";
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
                    <a href="unotices.php" class="text-light text-decoration-none fs-6">View Details ></a>
                  </div>
                </div>
              </div>
            </div> 
            <div class="col-12 col-md-6 col-lg-4">
              <div class="dashcard card-container border rounded shadow p-0" style="background-color: green;">
                <div class="row">
                  <div class="col-8 p-3">
                    <h2 class="ps-2">
                    1
                    </h2>
                    <h4 class="ps-2">Profile</h4>
                  </div>
                  <div class="col-4">
                    <div class="text-white text-end p-3">
                      <i class="fa-solid fa-bed fs-1"></i>
                    </div>
                  </div>
                </div>
                <div class="col-12 bg-dark bg-opacity-10">
                  <div class="p-2">
                    <a href="uprofile.php" class="text-light text-decoration-none fs-6">View Details ></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
    </div>
    </div>
    <script src="../assets/js/script.js"></script>
    
</body>
</html>
