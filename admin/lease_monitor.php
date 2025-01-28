<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Leases</title>
</head>
<body>
<div class="position-relative">
    <?php include('../include/dash_header.php'); ?>
    <button class="openbtn position-absolute top-0 start-0" onclick="toggleSidebar()">☰</button>
    <div id="sidebar-container"></div>
    <div class="main">  
    <div class="container bg-light p-3">
          <h1 class="mb-2"><i class="fa-solid fa-users"></i> Lease Monitor</h1>
        
        <div class="container p-0 overflow-y-auto mb-4" style="height: 400px; overflow-x: hidden;">
        <div class="row">
        <?php
            // Include your database connection file
            include('../include/connection.php');

            // Fetch lease data from the database
            $sql = "SELECT tl.*, u.first_name, u.last_name, r.room_number
                    FROM tenant_leases tl
                    INNER JOIN tbluser u ON tl.UserID = u.user_id
                    INNER JOIN tblrooms r ON tl.RoomID = r.id";
            $result = mysqli_query($conn, $sql);

            // Check if there are any leases
            if (mysqli_num_rows($result) > 0) {
                // Loop through each lease
                while ($row = mysqli_fetch_assoc($result)) {
                    // Extract lease details
                    $roomNumber = htmlspecialchars($row['room_number']);
                    $fullName = htmlspecialchars($row['first_name'] . " " . $row['last_name']);
                    $startDate = $row['StartDate'] ? htmlspecialchars(date('F d, Y', strtotime($row['StartDate']))) : "";
                    $endDate = $row['EndDate'] ? htmlspecialchars(date('F d, Y', strtotime($row['EndDate']))) : "<em class='italic'>'No specified date'</em>";

                    // Calculate the remaining months
                     $remainingMonths = $row['EndDate'] ? floor((strtotime($row['EndDate']) - time()) / (30 * 86400)) : "<em class='italic'>'undefined'</em>";

                    // Calculate the next due date (Assuming monthly rent)
                    $nextDueDate = $row['StartDate'] ? htmlspecialchars(date('F d, Y', strtotime('+1 month', strtotime($row['StartDate'])))) : "<em class='italic'>'No specified date'</em>";

                    // Determine the card color class based on remaining months
                    if ($remainingMonths > 1) {
                  $cardColor = '#8ef078'; // Green color for more than 1 month remaining
                  } elseif ($remainingMonths == 1 || $remainingMonths < 1) {
                  $cardColor = '#fc5d5d'; // Red color for 1 month remaining
                  } 
                    ?>
  <div class="col-sm-4 mb-3 mb-sm-0">
    <div class="card mb-3">
    <div class="card-body" style="background-color: <?php echo $cardColor; ?>;">
        <p class="text-center"><i><?php echo $remainingMonths; ?> Remaining months...</i></p>
        <h5 class="card-title"><strong>ROOM: </strong><?php echo $roomNumber; ?></h5>
        <p class="card-text"><strong>Name: </strong><i><?php echo $fullName; ?></i></p>
        <p class="card-text"><strong>Start Date: </strong><i><?php echo $startDate; ?></i></p>
        <p class="card-text"><strong>Next Duedate: </strong><i><?php echo $nextDueDate; ?></i></p>
        <p class="card-text"><strong>End Date: </strong><i><?php echo $endDate; ?></i></p>
        <a href='extend_lease.php?lease_id=<?php echo $row['LeaseID']; ?>' class='btn btn-primary text-light'>EDIT</a>
      </div>
    </div>
  </div>
  <?php
}
            } else {
                echo "No leases found.";
            }

            // Close database connection
            mysqli_close($conn);
          ?>
</div>
        </div>
        </div>
    </div>
  </div>
  <script src="../assets/js/script.js"></script>
</body>
</html>