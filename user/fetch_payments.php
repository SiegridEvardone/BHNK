<?php
session_start();

include('../include/connection.php');

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

// Ensure the user is authenticated
if (!isset($_SESSION['user_id'])) {
    die(json_encode(['success' => false, 'message' => 'User not logged in']));
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM payments WHERE user_id = '$user_id'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $payments = [];
    while($row = $result->fetch_assoc()) {
        $payments[] = $row;
    }
    echo json_encode(['success' => true, 'payments' => $payments]);
} else {
    echo json_encode(['success' => true, 'payments' => []]);
}

$conn->close();
?>
