<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rooms</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="path/to/fontawesome/css/all.css">
  <style>
    .table-container {
      overflow-x: auto;
    }
    .table-wrapper {
      max-height: 320px; /* Adjust the height as needed */
      overflow-y: auto;
    }
    .table th, .table td {
      white-space: nowrap;
    }
    .img-fluid {
      max-width: 100px;
      max-height: 100px;
      height: auto;
    }
  </style>
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
            <div class="table-container mt-3">
                <div class="table-wrapper">
                    <table class="table table-bordered table-striped">
                        <thead style="background-color: #D3D3D3;">
                            <tr>
                                <th scope="col">Room #</th>
                                <th scope="col">Description</th>
                                <th scope="col">Rent /month</th>
                                <th scope="col">Image</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Include your database connection file
                            include ('../include/connection.php');  

                            // Fetch rooms from the database
                            $sql = "SELECT * FROM tblrooms";
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
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($roomNumber); ?></td>
                                <td><?php echo htmlspecialchars($description); ?></td>
                                <td><i class="fa-solid fa-peso-sign"></i> <?php echo htmlspecialchars($rentPrice); ?></td>
                                <td><img src="<?php echo htmlspecialchars($image); ?>" class="img-fluid rounded-start" alt="Room Image"></td>
                                <td>
                                    <a href="edit_room.php?id=<?php echo $roomId; ?>" class="btn btn-primary mb-1">Edit</a>
                                    <script>
                                        function confirmRemoval() {
                                            return confirm("Are you sure you want to delete this room?");
                                        }
                                    </script>
                                    <button onclick="if (confirmRemoval()) location.href='delete_room.php?id=<?php echo $roomId; ?>';" class="btn btn-danger">Delete</button>
                                </td>
                            </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center fst-italic'>No rooms found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../assets/js/script.js"></script>
</body>
</html>
