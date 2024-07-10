<?php
include('../include/pdoconnect.php');

// Check if room ID is provided
if (isset($_GET['id'])) {
    $roomId = $_GET['id'];

    try {
        // Start transaction
        $pdo->beginTransaction();

        // Delete records from tenant_leases associated with the room
        $deleteLeasesQuery = "DELETE FROM tenant_leases WHERE RoomID = :roomId";
        $stmtDeleteLeases = $pdo->prepare($deleteLeasesQuery);
        $stmtDeleteLeases->bindParam(':roomId', $roomId, PDO::PARAM_INT);
        $stmtDeleteLeases->execute();

        // Check if there are any tenants assigned to the room
        $query = "SELECT COUNT(*) AS num_tenants FROM tbltenant WHERE room_id = :room_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':room_id', $roomId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $numTenants = $row['num_tenants'];

        // If there are tenants, display an alert and rollback the transaction
        if ($numTenants > 0) {
            echo "<script>
                    alert('Cannot delete this room. There are tenants assigned to it.');
                    window.location.href = 'rooms.php';
                  </script>";
            $pdo->rollBack();
            exit();
        }

        // If no tenants, proceed with room deletion
        $deleteRoomQuery = "DELETE FROM tblrooms WHERE id = :id";
        $stmtDeleteRoom = $pdo->prepare($deleteRoomQuery);
        $stmtDeleteRoom->bindParam(':id', $roomId, PDO::PARAM_INT);
        $stmtDeleteRoom->execute();

        // Commit transaction
        $pdo->commit();

        // Redirect to rooms.php after successful deletion
        header('Location: rooms.php');
        exit();
    } catch (PDOException $e) {
        // Handle any PDO exceptions
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
        exit(); // Exit the script if there's an error
    }
} else {
    // If room ID is not provided, handle the error (e.g., redirect to an error page)
    header('Location: error.php');
    exit(); // Exit the script
}
?>
