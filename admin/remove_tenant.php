<?php
include('../include/pdoconnect.php');

// Check if the room ID is provided
if(isset($_GET['id'])) {
    $roomId = $_GET['id'];

    try {
        // Begin a transaction
        $pdo->beginTransaction();

        // Delete tenant lease record associated with the room
        $deleteLeaseQuery = "DELETE FROM tenant_leases WHERE RoomID = :roomId";
        $stmtDeleteLease = $pdo->prepare($deleteLeaseQuery);
        $stmtDeleteLease->bindParam(':roomId', $roomId, PDO::PARAM_INT);
        $stmtDeleteLease->execute();

        // Delete tenant record associated with the room in tbltenants
        $deleteTenantQuery = "DELETE FROM tbltenant WHERE room_id = :roomId";
        $stmtDeleteTenant = $pdo->prepare($deleteTenantQuery);
        $stmtDeleteTenant->bindParam(':roomId', $roomId, PDO::PARAM_INT);
        $stmtDeleteTenant->execute();

        // Update the status of the room to "available"
        $updateRoomQuery = "UPDATE tblrooms SET status = 'available' WHERE id = :roomId";
        $stmtUpdateRoom = $pdo->prepare($updateRoomQuery);
        $stmtUpdateRoom->bindParam(':roomId', $roomId, PDO::PARAM_INT);
        $stmtUpdateRoom->execute();

        // Commit the transaction
        $pdo->commit();

        // Redirect back to the available rooms page after successful removal
        header('Location: avail_rooms.php');
        exit();
    } catch (PDOException $e) {
        // Rollback the transaction if there's an error
        $pdo->rollBack();
        echo "Failed to remove tenant: " . $e->getMessage();
    }
} else {
    // If room ID is not provided, handle the error (e.g., redirect to an error page)
    header('Location: error.php');
    exit();
}
?>

