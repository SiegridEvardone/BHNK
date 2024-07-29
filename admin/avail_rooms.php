<?php
include('../include/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $roomId = $_POST['roomId'];
    $userId = $_POST['userId']; // Changed from individual first name, middle initial, and last name fields to a single user ID field
    $startDate = $_POST['startDate'];

    // Insert tenant information into tbltenants table
    $insertTenantQuery = "INSERT INTO tenant_leases (RoomID, UserID, StartDate) VALUES ('$roomId', '$userId', '$startDate')";
    mysqli_query($conn, $insertTenantQuery);

    // Update room status to occupied
    $updateRoomStatusQuery = "UPDATE tblrooms SET status = 'occupied' WHERE id = '$roomId'";
    mysqli_query($conn, $updateRoomStatusQuery);

    // Redirect to the page displaying available and occupied rooms
    header('Location: available_occupied_rooms.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Available Rooms</title>
</head>
<body style="background-color: #f4f6f9;">
<div class="position-relative">
    <?php include('../include/dash_header.php'); ?>
    <button class="openbtn position-absolute top-0 start-0" onclick="toggleSidebar()">☰</button>
    <div id="sidebar-container"></div>
    <div class="main">  
    <div class="container border bg-light p-3">
            <h1 class="mb-2"><i class="fa-solid fa-door-open"></i> Available Rooms</h1>

            <!-- List of Rooms -->
            <div class="mt-3 ">
                <div class="container text-center p-0">
                    <div class="row border" style="background-color: #D3D3D3;">
                        <div class="col p-2">
                            <p class="fw-bold m-0">Room Number</p>
                        </div>
                        <div class="col p-2">
                            <p class="fw-bold m-0">Description</p>
                        </div>
                        <div class="col p-2">
                            <p class="fw-bold m-0">Rent /month</p>
                        </div>
                        <div class="col p-2">
                            <p class="fw-bold m-0">Status</p>
                        </div>
                        <div class="col p-2">
                            <p class="fw-bold m-0">Tenants</p>
                        </div>
                        <div class="col p-2">
                            <p class="fw-bold m-0">Action</p>
                        </div>
                    </div>
                </div>
            
                <div class="container text-center p-0 overflow-y-auto" style="max-height: 380px; overflow-x: hidden;">
                <?php
                // Fetch rooms and their assigned tenants from the database
                $sql = "SELECT r.*, GROUP_CONCAT(CONCAT(u.first_name, ' ', u.last_name) SEPARATOR ', ') AS tenant_names
                        FROM tblrooms r 
                        LEFT JOIN tenant_leases t ON r.id = t.RoomID
                        LEFT JOIN tbluser u ON t.UserID = u.user_id
                        GROUP BY r.id";
                $result = mysqli_query($conn, $sql);

                // Check if there are any rooms
                if ($result && mysqli_num_rows($result) > 0) {
                    // Loop through each room and display it
                    while ($row = mysqli_fetch_assoc($result)) {
                        $roomId = $row['id'];
                        $roomNumber = $row['room_number'];
                        $description = $row['description'];
                        $rentPrice = $row['rent_price'];
                        $image = $row['image'];
                        $status = $row['status'];
                        $tenantNames = $row['tenant_names'];
                ?>
                <div class="row bg-light border">
                    <div class="col p-2 border-end">
                        <h6><?php echo $roomNumber; ?></h6>
                    </div>
                    <div class="col p-2 border-end">
                        <p><?php echo $description; ?></p>
                    </div>
                    <div class="col p-2 border-end">
                        <p><i class="fa-solid fa-peso-sign"></i> <?php echo $rentPrice; ?></p>
                    </div>
                    <div class="col p-2 border-end">
                        <p style="background-color: <?php echo ($status == 'available') ? '#8ef078' : '#fc5d5d'; ?>;"><?php echo $status; ?></p>
                    </div>
                    <div class="col p-1 border-end">
                        <p class="mb-0"><?php echo $tenantNames; ?></p>
                    </div>
                    <div class="col p-2 border-end">
                        <a href="assign_tenant.php?id=<?php echo $roomId; ?>" class="btn btn-primary mb-2">
                            Add Tenant
                        </a> <br>
                        <script>
                            function confirmRemoval() {
                                return confirm("Are you sure you want to remove the tenant?");
                            }
                        </script>
                        <button onclick="if (confirmRemoval()) location.href='remove_tenant.php?id=<?php echo $roomId; ?>';" class="btn btn-danger">Remove Tenant</button>
                    </div>
                </div>
                <?php
                        }
                    } else {
                        // No rooms found
                        echo "<p>No rooms found.</p>";
                    }
                ?>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/script.js"></script>
</div>
</body>
</html>
