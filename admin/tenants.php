<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tenants</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" />
  <style>
    body {
      background-color: #f4f6f9;
    }
    .table-wrapper {
      overflow-x: auto; /* Allows horizontal scrolling */
      max-height: 350px; /* Sets the maximum height */
      background-color: #f4f6f9; /* Matches the body background color */
    }
    .table thead {
      background-color: #D3D3D3; /* Header background color */
    }
    .table tbody tr:nth-child(even) {
      background-color: #f8f9fa; /* Alternating row background color */
    }
    .table tbody tr:hover {
      background-color: #e9ecef; /* Hover color */
    }
    .table td, .table th {
      white-space: nowrap; /* Prevent text wrapping */
    }
    .table td, .table th {
      padding: 0.75rem; /* Adjust padding for better spacing */
    }
    .table td a {
      text-decoration: none; /* Remove underline from links */
    }
  </style>
</head>
<body>
  <div class="position-relative">
    <?php include('../include/dash_header.php'); ?>
    <button class="openbtn position-absolute top-0 start-0" onclick="toggleSidebar()">☰</button>
    <div id="sidebar-container"></div>
    <div class="main">  
      <div class="container bg-light p-3">
        <h1 class="mb-2"><i class="fa-solid fa-users"></i> Tenants</h1>
        <div class="table-wrapper mb-4">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th scope="col">Room Number</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Due Date (YY-MM-DD)</th>
                <th scope="col">Rent /month</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
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
              <tr>
                <td><?php echo $roomNumber; ?></td>
                <td><?php echo $fullName; ?></td>
                <td><?php echo $email; ?></td>
                <td><?php echo $nextDueDate; ?></td>
                <td><?php echo $rentPerBed; ?>.00</td>
                <td>
                  <a href="tenant_info.php?tenant_id=<?php echo $row['user_id']; ?>" class="btn btn-primary"><i class="fa-solid fa-eye"></i></a>
                </td>
              </tr>
              <?php
                    }
                } else {
                    // No tenants found
                    echo "<tr><td colspan='6' class='text-center fst-italic'>No tenants found.</td></tr>";
                }

                // Close the database connection
                mysqli_close($conn);
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <script src="../assets/js/script.js"></script>
</body>
</html>
