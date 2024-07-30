<?php
ob_start();
session_start();
include('../include/pdoconnect.php');

// Fetch payment history
$sql = "SELECT transaction_id, payer_name, payer_email, amount, payment_status, created_at 
        FROM payments 
        ORDER BY created_at DESC";
$stmt = $pdo->query($sql);
$payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
ob_end_clean();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa; /* Light background color */
        }
        .container {
            margin-top: 2rem;
        }
        .table-container {
            background-color: #ffffff; /* White background for the table */
            border-radius: 0.5rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 1rem;
            max-height: 450px; /* Adjust this value to your preferred height */
            overflow-y: auto; /* Enable vertical scrolling if content overflows */
        }

        .table thead th {
            background-color: transparent; /* Remove background color */
            color: #343a40; /* Darker text color for better readability */
            border-bottom: 2px solid #dee2e6; /* Subtle border for separation */
        }
        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2; /* Alternating row colors */
        }
        .btn-custom {
            background-color: #007bff; /* Primary blue */
            color: #ffffff;
            border: none;
            border-radius: 0.3rem;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            text-decoration: none;
            display: inline-block;
            margin-top: 1rem;
        }
        .btn-custom:hover {
            background-color: #0056b3; /* Darker blue */
            color: #ffffff;
        }
        @media (max-width: 768px) {
            .table-container {
                padding: 0;
            }
            .table {
                font-size: 0.875rem; /* Smaller font size for smaller screens */
            }
            .table thead th {
                font-size: 0.875rem; /* Smaller font size for header on small screens */
            }
        }
    </style>
</head>
<body>
<div class="position-relative">
    <?php include('../include/dash_header.php'); ?>
    <button class="openbtn position-absolute top-0 start-0" onclick="toggleSidebar()">☰</button>
    <div id="sidebar-container"></div>
    <div class="main">
        <div class="container">
            <div class="table-container p-2">
                <h2 class="mb-4">Payments</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Transaction ID</th>
                                <th>Payer Name</th>
                                <th>Payer Email</th>
                                <th>Amount</th>
                                <th>Payment Status</th>
                                <th>Payment Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($payments): ?>
                                <?php foreach ($payments as $payment): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($payment['transaction_id']); ?></td>
                                        <td><?php echo htmlspecialchars($payment['payer_name']); ?></td>
                                        <td><?php echo htmlspecialchars($payment['payer_email']); ?></td>
                                        <td><?php echo htmlspecialchars(number_format($payment['amount'], 2)); ?></td>
                                        <td><?php echo htmlspecialchars($payment['payment_status']); ?></td>
                                        <td><?php echo htmlspecialchars(date('F j, Y, g:i a', strtotime($payment['created_at']))); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">No payment records found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../assets/js/script.js"></script>
</body>
</html>
