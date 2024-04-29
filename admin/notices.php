<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notices</title>
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
          <a href="post_notice.php" class="btn btn-success"><i class="fa-solid fa-plus"></i> Post a notice</a>
          <div class="container p-0 overflow-y-auto mt-4" style="height: 400px; overflow-x: hidden;">
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
            <div class="container border border-dark pt-2">
              <div class="row">
                <div class="col">
                  <div>
                    <p><strong>Date: </strong><?php echo $formattedDate; ?></p>
                  </div>
                  <div>
                    <p><strong>Title: </strong><?php echo $title; ?></p>
                  </div>
                </div>
                <div class="col">
                  <div>
                    <p><strong><i class="fa-solid fa-bullhorn"></i></strong></p>
                  </div>
                  <div>
                  <a class="text-decoration-none text-dark" href="notice_view.php?id=<?php echo $row['id']; ?>">view >></a>

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
      </main>
    </div>
  </div>
</body>
</html>