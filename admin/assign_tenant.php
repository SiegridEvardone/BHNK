
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
<?php
// Include your database connection file
include('../include/connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $roomId = $_POST['roomId'];
    $firstname = $_POST['firstname'];
    $middleInitial = $_POST['middleInitial'];
    $lastname = $_POST['lastname'];
    $dueDate = $_POST['dueDate'];
    $email = $_POST['email'];
    
    // Insert tenant details into the database
    $query = "INSERT INTO tbltenants (room_id, first_name, middle_initial, last_name, due_date, email) 
              VALUES (:roomId, :firstname, :middleInitial, :lastname, :dueDate, :email)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':roomId', $roomId);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':middleInitial', $middleInitial);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':dueDate', $dueDate);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Update the room status to occupied
    $updateQuery = "UPDATE tblrooms SET status = 'occupied' WHERE id = :roomId";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->bindParam(':roomId', $roomId);
    $updateStmt->execute();

    // Redirect to the available rooms page after successful assignment
    header('Location: avail_rooms.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Tenant</title>
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
        <div class="container">
          <h1 class="mb-2"><i class="fa-solid fa-door-open"></i> Assign Tenant to Room</h1>
          <!-- Add Room Form -->
          <form method="post" enctype="multipart/form-data" class="border border-1 border-dark rounded p-4 ">
            <input type="hidden" name="roomId" value="<?php echo $_GET['id']; ?>">
              <div class="mb-0">
                <label for="firstname" class="form-label">First name:</label><br>
                <input type="text" id="firstname" name="firstname" class="form-control pb-0" required><br>
              </div>
              <div class="mb-0">
                <label for="middleInitial" class="form-label">Middle Initial:</label><br>
                <input type="text" id="middleInitial" name="middleInitial" class="form-control pb-0" required><br>
              </div>
              <div class="mb-0">
                <label for="lastname" class="form-label">Last Name:</label><br>
                <input type="text" id="lastname" name="lastname" class="form-control pb-0" required><br>
              </div>
              <div class="mb-0">
                <label for="email" class="form-label">Email:</label><br>
                <input type="email" id="email" name="email" class="form-control pb-0" required><br>
              </div>
              <div class="mb-0">
                  <label for="dueDate" class="form-label">Due Date:</label>
                  <input type="date" id="dueDate" name="dueDate" class="form-control pb-0" required><br>
              </div>
              <div class="mb-2">
                  <label for="rentPrice" class="form-label">Rent Price</label>
                  <input type="number" class="form-control pb-0" id="rentPrice" name="rentPrice" value="<?php echo $rentPrice; ?>" required>
              </div>
              <button type="submit"  class="btn btn-success">Assign Tenant</button>
              <a href="avail_rooms.php" class="btn btn-danger">Cancel</a>
          </form>
        </div>
      </main> 
    </div>
  </div>
    
   
</body>
</html>
