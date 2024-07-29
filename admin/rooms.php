<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rooms</title>
</head>
<body>
<div class="position-relative">
    <?php include('../include/dash_header.php'); ?>
    <button class="openbtn position-absolute top-0 start-0" onclick="toggleSidebar()">☰</button>
    <div id="sidebar-container"></div>
    <div class="main"> 
    <div class="container bg-light p-4">
            <h1 class="mb-2"><i class="fa-solid fa-door-open"></i> Rooms</h1>
            <a href="add_room.php" class="btn btn-success"><i class="fa-solid fa-plus"></i> Add room</a>

            <!-- List of Rooms -->
            <div class="mt-3">
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
                            <p class="fw-bold m-0">Image</p>
                        </div>
                        <div class="col p-2">
                            <p class="fw-bold m-0">Action</p>
                        </div>
                    </div>
                </div>
            
                <div class="container text-center p-0 overflow-y-auto" style="max-height: 320px; overflow-x: hidden;">
                    <!-- Fetch and display rooms from the database -->
                    <?php
                        // Include your database connection file
                        include ('../include/connection.php');  

                        // Fetch rooms from the database
                        $sql = "SELECT * FROM tblrooms";
                        $result = mysqli_query($conn, $sql);

                        // Check if there are any rooms
                        if ($result) {
                            // Loop through each room and display it
                            while ($row = mysqli_fetch_assoc($result)) {
                                $roomId = $row['id'];
                                $roomNumber = $row['room_number'];
                                $description = $row['description'];
                                $rentPrice = $row['rent_price'];
                                $image = $row['image'];
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
                            <img src="<?php echo $image; ?>" class="img-fluid rounded-start" alt="Room Image" style="max-width: 100px">
                        </div>
                        <div class="col p-2 border-end pt-4">
                            <a href="edit_room.php?id=<?php echo $roomId; ?>" class="btn btn-primary">
                                Edit
                            </a>
                            <script>
                                function confirmRemoval() {
                                    return confirm("Are you sure you want to delete this room?");
                                }
                            </script>
                            <button onclick="if (confirmRemoval()) location.href='delete_room.php?id=<?php echo $roomId; ?>';" class="btn btn-danger">Delete</button>
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
</div>
<script src="../assets/js/script.js"></script>
</body>
</html>
