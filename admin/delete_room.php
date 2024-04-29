<?php
    include('../include/pdoconnect.php');

    // Check if room ID is provided
    if(isset($_GET['id'])) {
        $roomId = $_GET['id'];

        // Check if there are any tenants assigned to the room
        $query = "SELECT COUNT(*) AS num_tenants FROM tbltenants WHERE room_id = :room_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':room_id', $roomId);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $numTenants = $row['num_tenants'];

        // If there are tenants, display an alert and redirect back
        if($numTenants > 0) {
            echo "<script>alert('Cannot delete this room. There are tenants assigned to it.'); window.location.href = 'rooms.php';</script>";
            exit();
        }

        // If no tenants, proceed with room deletion
        $query = "DELETE FROM tblrooms WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $roomId);
        $stmt->execute();

        // Redirect to avail_rooms.php after deletion
        header('Location: rooms.php');
        exit();
    } else {
        // If room ID is not provided, redirect to an error page or display an error message
        header('Location: error.php');
        exit(); // Exit the script
    }
?>
