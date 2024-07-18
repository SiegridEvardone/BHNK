<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tenants</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" />
</head>
<body>
  <?php include('../include/dash_header.php'); ?>
  <div class="container-fluid">
    <div class="row">
      <?php include('sidenav.php'); ?>  
      <main class="col-12 col-md-5 ms-sm-auto col-lg-10 px-md-3 py-md-3">
        <div class="container bg-light p-3">
          <h1 class="mb-2"><i class="fa-solid fa-users"></i> Tenants</h1>
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
              <div class="col p-2">
                <p class="fw-bold m-0">Action</p>
              </div>
            </div>
          </div>
          <div class="container text-center p-0 overflow-y-auto mb-4" style="height: 350px; overflow-x: hidden;">
            <?php
              include('../include/connection.php'); // Include your database connection script here

              // Query to fetch all tenant and room details
              $sql = "SELECT u.user_id, u.first_name, u.middle_name, u.last_name, u.email, DATE_ADD(t.startDate, INTERVAL 1 MONTH) AS next_due_date, r.room_number, r.rent_price, r.beds
                      FROM tenant_leases t
                      INNER JOIN tbluser u ON t.UserID = u.user_id
                      INNER JOIN tblrooms r ON t.RoomID = r.id
                      ORDER BY r.room_number ASC";
              
              // Execute the query
              $result = mysqli_query($conn, $sql);

              // Check if there are any tenants
              if (mysqli_num_rows($result) > 0) {
                  // Loop through each tenant and display their summarized details
                  while ($row = mysqli_fetch_assoc($result)) {
                      $fullName = htmlspecialchars($row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name']);
                      $email = htmlspecialchars($row['email']);
                      $nextDueDate = htmlspecialchars($row['next_due_date']);
                      $roomNumber = htmlspecialchars($row['room_number']);
                      $rentPrice = htmlspecialchars($row['rent_price']);
                      $beds = intval($row['beds']);
                      
                      // Calculate rent per bed
                      $rentPerBed = $rentPrice / $beds;
            ?>
            <div class="row bg-light border">
              <div class="col p-2 border-end">
                <p class="m-0"><span class="fw-normal fst-italic"><?php echo $roomNumber; ?></span></p>
              </div>
              <div class="col p-2 border-end">
                <p class="m-0"><span href="tenant_info.php?tenant_id=<?php echo $row['user_id']; ?>" class="text-decoration-none"><span class="fw-normal fst-italic"><?php echo $fullName; ?></span></a></p>
              </div>
              <div class="col p-2 border-end">
                <p class="m-0"><span class="fw-normal fst-italic"><?php echo $email; ?></span></p>
              </div>
              <div class="col p-2 border-end">
                <p class="m-0"><span class="fw-normal fst-italic"><?php echo $nextDueDate; ?></span></p>
              </div>
              <div class="col p-2 border-end">
                <p class="m-0"><span class="fw-normal fst-italic"><?php echo $rentPerBed; ?>.00</span></p>
              </div>
              <div class="col p-2">
                <a href="tenant_info.php?tenant_id=<?php echo $row['user_id']; ?>" class="btn btn-primary"><i class="fa-solid fa-eye"></i></a>
              </div>
              
            </div>
            <?php
                  }
              } else {
                  // No tenants found
                  echo "<p>No tenants found.</p>";
              }

              // Close the database connection
              mysqli_close($conn);
            ?>   
          </div>
        </div>
      </main>
    </div>
  </div>
</body>
</html>
