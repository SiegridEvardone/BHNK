<?php
ob_start();
include('../include/pdoconnect.php');

// Get the selected month and year from the URL or default to the current month
$selected_month = isset($_GET['month']) ? $_GET['month'] : date('m');
$selected_year = isset($_GET['year']) ? $_GET['year'] : date('Y');

// Debug: Check the values of selected_month and selected_year
error_log("Selected month: $selected_month");
error_log("Selected year: $selected_year");

// Validate month and year
if (!ctype_digit($selected_month) || !ctype_digit($selected_year)) {
    die("Invalid month or year");
}

// Fetch the available months and years for filtering
$sql_month_year = "SELECT DISTINCT MONTH(created_at) AS month, YEAR(created_at) AS year 
                   FROM payments 
                   ORDER BY YEAR(created_at) DESC, MONTH(created_at) DESC";
$months_years_stmt = $pdo->query($sql_month_year);
$months_years = $months_years_stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch payment history for the selected month and year
$sql = "SELECT transaction_id, payer_name, payer_email, amount, payment_status, created_at 
        FROM payments 
        WHERE MONTH(created_at) = :month AND YEAR(created_at) = :year
        ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);

// Debug: Check if month and year are numeric and valid
error_log("Month and year for SQL query: $selected_month, $selected_year");

try {
    $stmt->bindParam(':month', $selected_month, PDO::PARAM_INT);
    $stmt->bindParam(':year', $selected_year, PDO::PARAM_INT);
    $stmt->execute();
    $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("SQL Error: " . $e->getMessage());
    $payments = []; // Ensure $payments is defined even if an error occurs
}

ob_end_clean();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment History by Month</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 2rem;
        }
        .table-container {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 1rem;
            max-height: 500px; /* Adjust as needed */
            overflow-y: auto; /* Enable vertical scrolling if content exceeds max-height */
        }
        .table thead th {
            background-color: transparent;
            color: #343a40;
            border-bottom: 2px solid #dee2e6;
        }
        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .btn-custom {
            background-color: #007bff;
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
            background-color: #0056b3;
            color: #ffffff;
        }
        @media (max-width: 768px) {
            .table-container {
                padding: 0;
            }
            .table {
                font-size: 0.875rem;
            }
            .table thead th {
                font-size: 0.875rem;
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
            <div class="table-container">
                <h2 class="mb-4">Payment History by Month</h2>
                <!-- Form for selecting month and year -->
                <form method="get" action="">
                    <div class="form-row">
                        <div class="col">
                            <select class="form-control" name="month" id="month">
                                <option value="">Select Month</option>
                                <?php for ($m = 1; $m <= 12; $m++): ?>
                                    <option value="<?php echo str_pad($m, 2, '0', STR_PAD_LEFT); ?>" <?php echo ($selected_month == str_pad($m, 2, '0', STR_PAD_LEFT)) ? 'selected' : ''; ?>>
                                        <?php echo date('F', mktime(0, 0, 0, $m, 1)); ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col">
                            <select class="form-control" name="year" id="year">
                                <option value="">Select Year</option>
                                <?php foreach ($months_years as $my): ?>
                                    <option value="<?php echo $my['year']; ?>" <?php echo ($selected_year == $my['year']) ? 'selected' : ''; ?>>
                                        <?php echo $my['year']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-custom">Filter</button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive mt-4">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Transaction ID</th>
                                <th>Payer Name</th>
                                <th>Payer Email</th>
                                <th>Amount</th>
                                <th>Payment Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($payments)): ?>
                                <?php foreach ($payments as $payment): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($payment['transaction_id']); ?></td>
                                        <td><?php echo htmlspecialchars($payment['payer_name']); ?></td>
                                        <td><?php echo htmlspecialchars($payment['payer_email']); ?></td>
                                        <td><?php echo htmlspecialchars(number_format($payment['amount'], 2)); ?></td>
                                        <td><?php echo htmlspecialchars(date('F j, Y, g:i a', strtotime($payment['created_at']))); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">No transactions found for the selected month.</td>
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
