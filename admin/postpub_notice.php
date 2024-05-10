<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Post a notice</title>
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
          <h1 class="mb-4"><i class="fa-solid fa-bullhorn"></i> Post a notice</h1>
          <form action="post_notice_process.php" method="post" enctype="multipart/form-data" class="border border-1 border-dark rounded p-4 ">
              <div class="mb-2">
                  <label for="title" class="form-label">Title: </label>
                  <input type="text" class="form-control" id="title" name="title" required>
              </div>
              <div class="mb-2">
                  <label for="content" class="form-label">Content: </label>
                  <textarea class="form-control" id="content" name="content" rows="2" required></textarea>
              </div>
              <a href="notices.php" class="btn btn-danger">Cancel</a>
              <button type="submit" class="btn btn-primary">Post</button>
          </form>
        </div>
      </main>
    </div>
  </div> 
</body>
</html>
