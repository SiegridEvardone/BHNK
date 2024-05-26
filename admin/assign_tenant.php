<?php
include ('../include/connection.php');

$pdo = new PDO('mysql:host=localhost;dbname=bhnk_db', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Check if the room ID is provided in the URL
if(isset($_GET['id'])) {
    // Query to fetch the current values from the database
    $query = "SELECT room_number, description, rent_price, beds, image FROM tblrooms WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $_GET['id']);
    $stmt->execute();
    $room = $stmt->fetch(PDO::FETCH_ASSOC);

    // Assign the fetched values to variables
    $roomNumber = $room['room_number'];
    $description = $room['description'];
    $rentPrice = $room['rent_price'];
    $beds = $room['beds'];
    $image = $room['image'];

    // Calculate rent per bed
    $rentPerBed = $rentPrice / $beds;

    // Store room ID in a variable for later use
    $roomId = $_GET['id'];
} else {
    // If room ID is not provided, redirect to an error page or display an error message
    header('Location: error.php');
    exit(); // Exit the script
}

// Fetch users from tbluser table
$queryUsers = "SELECT user_id, first_name, last_name FROM tbluser";
$stmtUsers = $pdo->query($queryUsers);
$users = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $roomId = $_POST['roomId'];
    $userId = $_POST['userId'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'] ?: NULL; // Allow end date to be NULL

    try {
        // Begin a transaction
        $pdo->beginTransaction();

        // Insert lease details into the database
        $query = "INSERT INTO tenant_leases (RoomID, UserID, StartDate, EndDate) 
                  VALUES (:roomId, :userId, :startDate, :endDate)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':roomId', $roomId);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':startDate', $startDate);
        $stmt->bindParam(':endDate', $endDate);
        $stmt->execute();

        // Update the room status to occupied
        $updateQuery = "UPDATE tblrooms SET status = 'occupied' WHERE id = :roomId";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->bindParam(':roomId', $roomId);
        $updateStmt->execute();

        // Commit the transaction
        $pdo->commit();

        // Redirect to the available rooms page after successful assignment
        header('Location: avail_rooms.php');
        exit();
    } catch (Exception $e) {
        // Rollback the transaction if something went wrong
        $pdo->rollBack();
        echo "Failed to assign tenant: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Tenant</title>
    <!-- Include Bootstrap CSS and other required CSS files -->
    <link rel="stylesheet" href="path/to/bootstrap.css">
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
                    <input type="hidden" name="roomId" value="<?php echo htmlspecialchars($roomId); ?>">
                    <div class="mb-2">
                        <label for="userId" class="form-label">Select User:</label><br>
                        <select id="userId" name="userId" class="form-control pb-0" required>
                            <option value="">Select User</option>
                            <?php foreach ($users as $user): ?>
                                <option value="<?php echo htmlspecialchars($user['user_id']); ?>"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-0">
                        <label for="startDate" class="form-label">Start Date:</label>
                        <input type="date" id="startDate" name="startDate" class="form-control pb-0" required><br>
                    </div>
                    <div class="mb-0">
                        <label for="endDate" class="form-label">End Date:</label>
                        <input type="date" id="endDate" name="endDate" class="form-control pb-0"><br>
                    </div>
                    <div class="mb-2">
                        <label for="rentPrice" class="form-label">Rent Price (Per Bed)</label>
                        <input type="number" class="form-control pb-0" id="rentPrice" name="rentPrice" value="<?php echo htmlspecialchars($rentPerBed); ?>" readonly>
                    </div>
                    <button type="submit" class="btn btn-success">Assign Tenant</button>
                    <a href="avail_rooms.php" class="btn btn-danger">Cancel</a>
                </form>
            </div>
        </main>
    </div>
</div>
</body>
</html>
