<?php
include ('../include/pdoconnect.php');

// Check if the room ID is provided
if(isset($_GET['id'])) {
    $roomId = $_GET['id'];
    echo "<script>alert('Are you sure You want to remove the tenant?');</script>";
    // Delete the tenant record associated with the room
    $deleteTenantQuery = "DELETE FROM tenant_leases WHERE RoomID = :roomId";
    $stmt = $pdo->prepare($deleteTenantQuery);
    $stmt->bindParam(':roomId', $roomId);
    $stmt->execute();

    // Update the status of the room to "available"
    $updateRoomQuery = "UPDATE tblrooms SET status = 'available' WHERE id = :roomId";
    $stmt = $pdo->prepare($updateRoomQuery);
    $stmt->bindParam(':roomId', $roomId);
    $stmt->execute();

    // Redirect back to the available rooms page after successful removal
    header('Location: avail_rooms.php');
    exit();
} else {
    // If room ID is not provided, handle the error (e.g., redirect to an error page)
    header('Location: error.php');
    exit();
}
?>
