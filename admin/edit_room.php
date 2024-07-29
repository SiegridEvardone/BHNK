<?php
include ('../include/connection.php');

$pdo = new PDO('mysql:host=localhost;dbname=bhnk_db', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Check if the room ID is provided in the URL
if(isset($_GET['id'])) {
    // Query to fetch the current values from the database
    $query = "SELECT room_number, description, rent_price, image FROM tblrooms WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $_GET['id']);
    $stmt->execute();
    $room = $stmt->fetch(PDO::FETCH_ASSOC);

    // Assign the fetched values to variables
    $roomNumber = $room['room_number'];
    $description = $room['description'];
    $rentPrice = $room['rent_price'];
    $image = $room['image'];

    // Store room ID in a variable for later use
    $roomId = $_GET['id'];
} else {
    // If room ID is not provided, redirect to an error page or display an error message
    header('Location: error.php');
    exit(); // Exit the script
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Room</title>
</head>
<body>
<div class="position-relative">
    <?php include('../include/dash_header.php'); ?>
    <button class="openbtn position-absolute top-0 start-0" onclick="toggleSidebar()">☰</button>
    <div id="sidebar-container"></div>
    <div class="main"> 
    <div class="container bg-light p-3">
          <h3 class="mb-4"><i class="fa-solid fa-door-open"></i> Edit Room</h3>
          <!-- Edit Room Form -->
          <form action="update_room.php" method="post" enctype="multipart/form-data" class="border border-1 border-dark rounded p-4 ">
              <div class="mb-3">
                  <label for="roomNumber" class="form-label">Room Number</label>
                  <input type="text" class="form-control" id="roomNumber" name="roomNumber" value="<?php echo $roomNumber; ?>" required>
              </div>
              <div class="mb-3">
                  <label for="description" class="form-label">Description</label>
                  <textarea class="form-control" id="description" name="description" rows="1" required><?php echo $description; ?></textarea>
              </div>
              <div class="mb-3">
                  <label for="rentPrice" class="form-label">Rent Price</label>
                  <input type="number" class="form-control" id="rentPrice" name="rentPrice" value="<?php echo $rentPrice; ?>" required>
              </div>
              <div class="mb-3">
                  <label for="image" class="form-label">Image</label>
                  <input type="file" class="form-control" id="image" name="image" accept="image/*">
              </div>
              <input type="hidden" name="roomId" value="<?php echo $roomId; ?>">
              <a href="rooms.php" class="btn btn-danger">Cancel</a>
              <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want to update this room?')">Update</button>
              
          </form>
        </div>
    </div>
  </div>
  <script src="../assets/js/script.js"></script>
</body>
</html>
