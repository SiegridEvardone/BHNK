<?php
header('Content-Type: application/json');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../include/connection.php');

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

// Read the input data from the request
$data = json_decode(file_get_contents('php://input'), true);

// Log the received data for debugging
file_put_contents('debug.log', print_r($data, true), FILE_APPEND);

// Check for missing data
if (empty($data['payer_name']) || empty($data['payer_email']) || empty($data['amount']) || empty($data['transaction_id']) || empty($data['payment_status']) || empty($data['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Missing required data']);
    exit();
}

// Assign the received data to variables
$payer_name = $data['payer_name'];
$payer_email = $data['payer_email'];
$amount = $data['amount'];
$transaction_id = $data['transaction_id'];
$payment_status = $data['payment_status'];
$user_id = $data['user_id'];

// Log the variables for debugging
file_put_contents('debug.log', print_r(compact('payer_name', 'payer_email', 'amount', 'transaction_id', 'payment_status', 'user_id'), true), FILE_APPEND);

// Prepare the SQL statement and bind parameters
$stmt = $conn->prepare("INSERT INTO payments (payer_name, payer_email, amount, transaction_id, payment_status, user_id, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");

if (!$stmt) {
    echo json_encode(['success' => false, 'error' => 'Prepare statement failed: ' . $conn->error]);
    exit();
}

$stmt->bind_param("ssdsis", $payer_name, $payer_email, $amount, $transaction_id, $payment_status, $user_id);

$response = array();

if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['success'] = false;
    $response['error'] = 'Execute failed: ' . $stmt->error;
}

// Log the execution response
file_put_contents('debug.log', print_r($response, true), FILE_APPEND);

$stmt->close();
$conn->close();

echo json_encode($response);
?>
