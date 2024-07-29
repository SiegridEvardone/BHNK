<?php
header('Content-Type: application/json');
include('../include/pdoconnect.php');

$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $payer_name = $data['payer_name'];
    $payer_email = $data['payer_email'];
    $amount = $data['amount'];
    $transaction_id = $data['transaction_id'];
    $payment_status = $data['payment_status'];
    $user_id = isset($data['user_id']) ? $data['user_id'] : null; // Handle user_id if provided

    $sql = "INSERT INTO payments (payer_name, payer_email, amount, transaction_id, payment_status, created_at, user_id) 
            VALUES (?, ?, ?, ?, ?, NOW(), ?)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([$payer_name, $payer_email, $amount, $transaction_id, $payment_status, $user_id]);
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'No data received']);
}
?>
