<?php
include ('../include/connection.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roomNumber = $_POST['roomNumber'];
    $description = $_POST['description'];
    $rentPrice = $_POST['rentPrice'];

    // Upload image
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);

    // Insert room into database
    $sql = "INSERT INTO tblrooms (room_number, description, rent_price, image) VALUES ('$roomNumber', '$description', '$rentPrice', '$targetFile')";
    if (mysqli_query($conn, $sql)) {
      echo "<script>alert('Room added succesfully');</script>";
      echo "<script>window.location.href='rooms.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Room</title>
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
      <main class="col-12 col-md-5 ms-sm-auto col-lg-10 px-md-3 py-md-3">
        <div class="container mt-1 bg-light p-3">
          <h3 class="mb-4"><i class="fa-solid fa-door-open"></i> Add Room</h3>
          <!-- Add Room Form -->
          <form method="post" enctype="multipart/form-data" class="border border-1 border-dark rounded p-4 ">
              <div class="mb-2">
                  <label for="roomNumber" class="form-label">Room Number</label>
                  <input type="text" class="form-control" id="roomNumber" name="roomNumber" required>
              </div>
              <div class="mb-2">
                  <label for="description" class="form-label">Description</label>
                  <textarea class="form-control" id="description" name="description" rows="2" required></textarea>
              </div>
              <div class="mb-2">
                  <label for="rentPrice" class="form-label">Rent Price</label>
                  <input type="number" class="form-control" id="rentPrice" name="rentPrice" required>
              </div>
              <div class="mb-2">
                  <label for="image" class="form-label">Image</label>
                  <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
              </div>
              <a href="rooms.php" class="btn btn-danger">Cancel</a>
              <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </main>
    </div>
  </div>
</body>
</html>