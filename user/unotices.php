<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tenant Notices</title>
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
          <h1 class="mb-4"><i class="fa-solid fa-bullhorn"></i> Notices</h1>
          <div class="container text-center">
            <div class="row align-items-start">
              <div class="col">
                <div class="bg-secondary-subtle mt-3">
                  <h5>Public Notices</h5>
                </div>
                <div class="container p-0 overflow-y-auto mt-2" style="height: 400px; overflow-x: hidden;">
                  <?php
                  include ('../include/connection.php'); 

                  $sql = "SELECT * FROM tblnotices ORDER BY post_date DESC";
                  $result = mysqli_query($conn, $sql);

                  if ($result) {
                    // Loop through each room and display it
                    while ($row = mysqli_fetch_assoc($result)) {
                        $date = $row['post_date'];
                        $title = $row['title'];
                        $formattedDate = date('d/m/Y', strtotime($date));
                  ?>
                  <div class="container border border-dark pt-2 mt-1" style="max-width: 100%; height: 86px;">
                    <div class="row">
                      <div class="col">
                        <div class="text-start">
                          <p><strong>Date: </strong><?php echo $formattedDate; ?></p>
                        </div>
                        <div class="text-start">
                          <p><strong>Title: </strong><?php echo $title; ?></p>
                        </div>
                      </div>
                      <div class="col">
                        <div class="text-end">
                          <p class="fs-5 mb-2"><strong><i class="fa-solid fa-circle-exclamation"></i></strong></p>
                        </div>
                        <div class="text-end">
                          <p><a class="text-decoration-none text-dark" href="unotice_view.php?id=<?php echo $row['id']; ?>">view >></a></p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php
                              }
                          } else {
                              // No notices found
                              echo "<p>No notices found.</p>";
                          }
                  ?>
                </div>
              </div>
              <div class="col">
                <div class="bg-secondary-subtle mt-3">
                  <h5>Private Notices</h5>
                </div>
                <div class="container p-0 overflow-y-auto mt-2" style="height: 400px; overflow-x: hidden;">
                  <?php
                  include ('../include/connection.php'); 

                  $sql = "SELECT * FROM tblnotices ORDER BY post_date DESC";
                  $result = mysqli_query($conn, $sql);

                  if ($result) {
                    // Loop through each room and display it
                    while ($row = mysqli_fetch_assoc($result)) {
                        $date = $row['post_date'];
                        $title = $row['title'];
                        $formattedDate = date('d/m/Y', strtotime($date));
                  ?>
                  <div class="container border border-dark pt-2  mt-1" style="max-width: 100%; height: 86px;">
                    <div class="row">
                      <div class="col">
                        <div class="text-start">
                          <p><strong>Date: </strong><?php echo $formattedDate; ?></p>
                        </div>
                        <div class="text-start">
                          <p><strong>Title: </strong><?php echo $title; ?></p>
                        </div>
                      </div>
                      <div class="col">
                        <div class="text-end">
                          <p class="fs-5 mb-2"><strong><i class="fa-solid fa-circle-exclamation"></i></strong></p>
                        </div>
                        <div class="text-end">
                          <p><a class="text-decoration-none text-dark" href="notice_view.php?id=<?php echo $row['id']; ?>">view >></a></p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php
                              }
                          } else {
                              // No notices found
                              echo "<p>No notices found.</p>";
                          }
                  ?>
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