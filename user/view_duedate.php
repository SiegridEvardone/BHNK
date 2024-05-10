<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Due date</title>
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
        <div class="container mt-3">
          <div class="border border-dark p-4 mx-auto" style="max-width: 50%;">
            <h2 class="text-center">Your Details:</h2>
            <div class="container mt-5 p-0">
              <h4>Room #: </h4>
              <h4>Name: </h4>
              <h4>DuaDate: </h4>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

</body>
</html>