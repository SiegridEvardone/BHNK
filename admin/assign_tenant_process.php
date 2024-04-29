<?php
include('../include/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $roomId = $_POST['roomId'];
    $firstName = $_POST['firstName'];
    $middleInitial = $_POST['middleInitial'];
    $lastName = $_POST['lastName'];
    $dueDate = $_POST['dueDate'];

    // Insert tenant information into tbltenants table
    $insertTenantQuery = "INSERT INTO tbltenants (room_id, first_name, middle_initial, last_name, due_date) VALUES ('$roomId', '$firstName', '$middleInitial', '$lastName', '$dueDate')";
    mysqli_query($conn, $insertTenantQuery);

    // Update room status to occupied
    $updateRoomStatusQuery = "UPDATE tblrooms SET status = 'occupied' WHERE id = '$roomId'";
    mysqli_query($conn, $updateRoomStatusQuery);

    // Redirect to the page displaying available and occupied rooms
    header('Location: available_occupied_rooms.php');
    exit();
}
?>