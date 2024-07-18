<?php
ob_start();
require_once('../include/pdoconnect.php'); // Include your database connection script

// Fetch payment history
$sql = "SELECT * FROM tblpayments ORDER BY created_at DESC";
$stmt = $pdo->query($sql);
$payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
ob_end_clean();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment History</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Payment History</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Payment ID</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Payment Method</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payments as $payment): ?>
                    <tr>
                        <td><?php echo $payment['payment_id']; ?></td>
                        <td><?php echo $payment['amount']; ?></td>
                        <td><?php echo $payment['description']; ?></td>
                        <td><?php echo $payment['status']; ?></td>
                        <td><?php echo $payment['payment_method']; ?></td>
                        <td><?php echo $payment['created_at']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
