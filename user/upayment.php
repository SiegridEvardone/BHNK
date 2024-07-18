<?php
session_start();

// Include database connection and other necessary files
include('../include/connection.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch tenant information (example)
$user_id = $_SESSION['user_id'];
$sql = "SELECT user_id, first_name, last_name FROM tbluser WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $tenant = $result->fetch_assoc();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include('../include/dash_header.php'); ?>
    <div class="container-fluid">
        <div class="row">
            <?php include('sidenav.php'); ?>
            <main class="col-12 col-md-5 ms-sm-auto col-lg-10 px-md-3 py-md-3">
            <div class="container bg-light p-3" style="height: 86vh;">
                <div class="container bg-light p-3">
                    <h1 class="mb-4"><i class="fas fa-money-check-alt"></i> Make Payment (via G-CASH)</h1>
                    <div class="card">
                        <div class="card-body">
                        <form action="upayment_process.php" method="POST">
                            <div class="form-group">
                                <label for="amount">Amount (PHP)</label>
                                <input type="number" class="form-control" id="amount" name="amount" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <input type="text" class="form-control" id="description" name="description" required>
                            </div>
                            <div class="form-group">
                                <label for="payment_method">Payment Method</label>
                                <select class="form-control" id="payment_method" name="payment_method" required>
                                    <option value="gcash">G-Cash</option>
                                    <!-- Add other payment methods if needed -->
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
            </main>
        </div>
    </div>
</body>
</html>
