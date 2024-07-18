<?php
include ('../include/connection.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roomNumber = $_POST['roomNumber'];
    $beds = $_POST['beds'];
    $description = $_POST['description'];
    $rentPrice = $_POST['rentPrice'];

    // Upload image
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);

    // Insert room into database
    $sql = "INSERT INTO tblrooms (room_number, beds, description, rent_price, image) VALUES ('$roomNumber', '$beds', '$description', '$rentPrice', '$targetFile')";
    if (mysqli_query($conn, $sql)) {
      echo "<script>alert('Room added successfully');</script>";
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
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    .form-group {
      margin-bottom: 1.5rem; /* Increase spacing between form groups */
    }
    .form-control {
      font-size: 0.9rem; /* Adjust font size for all form controls */
    }
    .btn {
      font-size: 0.9rem; /* Adjust font size for buttons */
    }
    @media (max-width: 768px) {
      .form-control {
        font-size: 0.8rem; /* Decrease font size for smaller screens */
      }
      .btn {
        font-size: 0.8rem; /* Decrease font size for buttons on smaller screens */
      }
    }
  </style>
</head>
<body>
<?php
    include('../include/dash_header.php');
?>
<div class="container-fluid">
  <div class="row">
    <?php include('sidenav.php'); ?>  
    <main class="col-12 col-md-9 ml-sm-auto col-lg-10 px-md-4 py-md-3">
      <div class="container mt-1 bg-light p-3">
        <h3 class="mb-4"><i class="fa-solid fa-door-open"></i> Add Room</h3>
        <!-- Add Room Form -->
        <form method="post" enctype="multipart/form-data">
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="roomNumber">Room Number</label>
                        <input type="text" class="form-control" id="roomNumber" name="roomNumber" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="beds">No. Beds</label>
                        <input type="number" class="form-control" id="beds" name="beds" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="2" required></textarea>
            </div>
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="rentPrice">Rent Price</label>
                        <input type="number" class="form-control" id="rentPrice" name="rentPrice" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col">
                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                </div>
                <div class="col">
                    <a href="rooms.php" class="btn btn-danger btn-block">Cancel</a>
                </div>
            </div>
        </form>
      </div>
    </main>
  </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
