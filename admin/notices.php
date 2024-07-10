<?php
ob_start();
session_start();

// Include database connection
include('../include/pdoconnect.php');

// Retrieve all public notices
$sql = "SELECT * FROM tblnotices WHERE visibility = 'public' ORDER BY post_date DESC";
$stmt = $pdo->query($sql);
$public_notices = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retrieve all private notices
$sql = "SELECT * FROM tblnotices WHERE visibility = 'private' ORDER BY post_date DESC";
$stmt = $pdo->query($sql);
$private_notices = $stmt->fetchAll(PDO::FETCH_ASSOC);
ob_end_clean();
?>

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
      <main class="col-12 col-md-5 ms-sm-auto col-lg-10 px-md-3 py-md-3">
        <div class="container bg-light p-3">
          <h1 class="mb-4"><i class="fa-solid fa-bullhorn"></i> Notices</h1>
          <a href="post_notice.php" class="btn btn-success"><i class="fa-solid fa-plus"></i> Post a Notice</a>
          
          <div class="container text-center">
            <div class="row align-items-start">
              <div class="col">
                <div class="bg-secondary-subtle mt-3">
                  <h5>Public Notices</h5>
                </div>
                <div class="container overflow-y-auto mt-1" style="height: 320px; overflow-x: hidden;">
                  <?php if ($public_notices): ?>
                    <?php foreach ($public_notices as $notice): ?>
                      <div class="container border border-dark pt-2 mb-1" style="max-width: 100%; height: 86px;">
                        <div class="row">
                          <div class="col">
                            <div class="text-start">
                              <p><strong>Date: </strong><?php echo date('d/m/Y', strtotime($notice['post_date'])); ?></p>
                            </div>
                            <div class="text-start">
                              <p><strong>Title: </strong><?php echo $notice['title']; ?></p>
                            </div>
                          </div>
                          <div class="col">
                            <div class="text-end">
                              <p class="fs-5 mb-2"><strong><i class="fa-solid fa-circle-exclamation"></i></strong></p>
                            </div>
                            <div class="text-end">
                              <p><a class="text-decoration-none text-dark" href="notice_view.php?id=<?php echo $notice['id']; ?>">view >></a></p>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <p>No public notices found.</p>
                  <?php endif; ?>
                </div>
              </div>
              <div class="col">
                <div class="bg-secondary-subtle mt-3">
                  <h5>Private Notices</h5>
                </div>
                <div class="container p-0 overflow-y-auto mt-2" style="height: 320px; overflow-x: hidden;">
                  <?php if ($private_notices): ?>
                    <?php foreach ($private_notices as $notice): ?>
                      <div class="container border border-dark pt-2 mb-1" style="max-width: 100%; height: 86px;">
                        <div class="row">
                          <div class="col">
                            <div class="text-start">
                              <p><strong>Date: </strong><?php echo date('d/m/Y', strtotime($notice['post_date'])); ?></p>
                            </div>
                            <div class="text-start">
                              <p><strong>Title: </strong><?php echo $notice['title']; ?></p>
                            </div>
                          </div>
                          <div class="col">
                            <div class="text-end">
                              <p class="fs-5 mb-2"><strong><i class="fa-solid fa-circle-exclamation"></i></strong></p>
                            </div>
                            <div class="text-end">
                              <p><a class="text-decoration-none text-dark" href="notice_view.php?id=<?php echo $notice['id']; ?>">view >></a></p>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <p>No private notices found.</p>
                  <?php endif; ?>
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
