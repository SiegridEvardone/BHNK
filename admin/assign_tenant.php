<?php
include('../include/connection.php');

$pdo = new PDO('mysql:host=localhost;dbname=bhnk_db', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Check if room ID is provided in the URL
if (isset($_GET['id'])) {
    $roomId = $_GET['id'];

    try {
        // Fetch room details
        $query = "SELECT room_number, description, rent_price, beds, image FROM tblrooms WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $roomId, PDO::PARAM_INT);
        $stmt->execute();
        $room = $stmt->fetch(PDO::FETCH_ASSOC);

        // Calculate rent per bed
        $rentPrice = $room['rent_price'];
        $beds = $room['beds'];
        $rentPerBed = $rentPrice / $beds;

        // Fetch users who do not have any room assignments yet
        $queryUsers = "SELECT u.user_id, u.first_name, u.last_name
                       FROM tbluser u
                       WHERE NOT EXISTS (
                           SELECT 1 FROM tbltenant t WHERE t.user_id = u.user_id
                       )";

        $stmtUsers = $pdo->query($queryUsers);
        $users = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit(); // Exit the script if there's an error
    }
} else {
    // If room ID is not provided, redirect to an error page or display an error message
    header('Location: error.php');
    exit(); // Exit the script
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $userId = $_POST['userId'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'] ?: NULL; // Allow end date to be NULL

    try {
        // Begin a transaction
        $pdo->beginTransaction();

        // Insert lease details into tenant_leases table
        $queryLease = "INSERT INTO tenant_leases (RoomID, UserID, StartDate, EndDate) 
                       VALUES (:roomId, :userId, :startDate, :endDate)";
        $stmtLease = $pdo->prepare($queryLease);
        $stmtLease->bindParam(':roomId', $roomId, PDO::PARAM_INT);
        $stmtLease->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmtLease->bindParam(':startDate', $startDate);
        $stmtLease->bindParam(':endDate', $endDate);
        $stmtLease->execute();

        // Insert tenant assignment into tbltenants table
        $queryTenant = "INSERT INTO tbltenant (room_id, user_id) 
                        VALUES (:roomId, :userId)";
        $stmtTenant = $pdo->prepare($queryTenant);
        $stmtTenant->bindParam(':roomId', $roomId, PDO::PARAM_INT);
        $stmtTenant->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmtTenant->execute();

        // Update room status to occupied
        $queryUpdateRoom = "UPDATE tblrooms SET status = 'occupied' WHERE id = :roomId";
        $stmtUpdateRoom = $pdo->prepare($queryUpdateRoom);
        $stmtUpdateRoom->bindParam(':roomId', $roomId, PDO::PARAM_INT);
        $stmtUpdateRoom->execute();

        // Commit the transaction
        $pdo->commit();

        // Redirect after successful assignment
        header('Location: avail_rooms.php');
        exit();
    } catch (PDOException $e) {
        // Rollback the transaction if an error occurs
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
<div class="position-relative">
    <?php include('../include/dash_header.php'); ?>
    <button class="openbtn position-absolute top-0 start-0" onclick="toggleSidebar()">☰</button>
    <div id="sidebar-container"></div>
    <div class="main"> 
    <div class="container bg-light p-3">
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
                    <a href="avail_rooms.php" class="btn btn-danger">Cancel</a>
                    <button type="submit" class="btn btn-primary">Assign Tenant</button>
                </form>
            </div>
    </div>
</div>
<script src="../assets/js/script.js"></script>
</body>
</html>
