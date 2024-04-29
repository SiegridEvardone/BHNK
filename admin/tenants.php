

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tenants</title>
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
          <h1 class="mb-2"><i class="fa-solid fa-users"></i> Tenants</h1>
        </div>
        <div class="container text-center p-0">
          <div class="row border" style="background-color: #D3D3D3;">
            <div class="col p-2">
              <p class="fw-bold m-0">Room Number</p>
            </div>
            <div class="col p-2">
              <p class="fw-bold m-0">Name</p>
            </div>
            <div class="col p-2">
              <p class="fw-bold m-0">Email</p>
            </div>
            <div class="col p-2">
              <p class="fw-bold m-0">Due Date(YY-MM-DD)</p>
            </div>
            <div class="col p-2">
              <p class="fw-bold m-0">Rent /month</p>
            </div>
          </div>
        </div>
        <div class="container text-center p-0 overflow-y-auto mb-4" style="height: 150px; overflow-x: hidden;">
          <?php
            include('../include/connection.php');

            // Query to fetch the required data
            $sql = "SELECT r.room_number, r.rent_price, t.first_name, t.last_name, t.email, t.due_date
                    FROM tblrooms r
                    INNER JOIN tbltenants t ON r.id = t.room_id";
            $result = mysqli_query($conn, $sql);


            if ($result) {
              // Loop through each tenant and display it
              while ($row = mysqli_fetch_assoc($result)) {
                  $roomNumber = $row['room_number'];
                  $rentPrice =  $row['rent_price'];
                  $firstname = $row['first_name'];
                  $lastname = $row['last_name'];
                  $email = $row['email'];
                  $dueDate = $row['due_date'];       
          ?>
          <div class="row bg-light border">
            <div class="col p-2 border-end">
              <p><span class="fw-normal fst-italic"><?php echo $roomNumber; ?></span></p>
            </div>
            <div class="col p-2 border-end">
              <p><span class="fw-normal fst-italic"><?php echo $firstname. " " .$lastname; ?></span></p>
            </div>
            <div class="col p-2 border-end">
              <p><span class="fw-normal fst-italic"><?php echo $email; ?></span></p>
            </div>
            <div class="col p-2 border-end">
              <p><span class="fw-normal fst-italic"><?php echo $dueDate; ?></span></p>
            </div>
            <div class="col p-2 border-end">
              <p><i class="fa-solid fa-peso-sign"></i> <?php echo $rentPrice; ?></p>
            </div>
          </div>
          <?php
            }
            } else {
              // No tenant found
              echo "<p>No tenants found.</p>";
            }
          ?>   
        </div>
        <div class="container mt-1">
          <h1 class="mb-2"><i class="fa-solid fa-users"></i> Web users</h1>
        </div>
        <div class="container text-center p-0">
          <div class="row border" style="background-color: #D3D3D3;">
            <div class="col p-2">
              <p class="fw-bold m-0">Room Number</p>
            </div>
            <div class="col p-2">
              <p class="fw-bold m-0">Name</p>
            </div>
            <div class="col p-2">
              <p class="fw-bold m-0">Email</p>
            </div>
            <div class="col p-2">
              <p class="fw-bold m-0">Gender</p>
            </div>
            <div class="col p-2">
              <p class="fw-bold m-0">Action</p>
            </div>
          </div>
        </div>
        <div class="container text-center p-0 overflow-y-auto" style="max-height: 150px; overflow-x: hidden;">
          <div class="row bg-light border">
            <div class="col p-2 border-end">
              <p><span class="fw-normal fst-italic"><?php echo $roomNumber; ?></span></p>
            </div>
            <div class="col p-2 border-end">
              <p><span class="fw-normal fst-italic"><?php echo $firstname. " " .$lastname; ?></span></p>
            </div>
            <div class="col p-2 border-end">
              <p><span class="fw-normal fst-italic"><?php echo $email; ?></span></p>
            </div>
            <div class="col p-2 border-end">
              <p><span class="fw-normal fst-italic"><?php echo $dueDate; ?></span></p>
            </div>
            <div class="col p-2 border-end">
              <p><i class="fa-solid fa-peso-sign"></i> <?php echo $rentPrice; ?></p>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

</body>
</html>