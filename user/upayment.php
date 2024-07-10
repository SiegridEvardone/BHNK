<?php
// Process the payment here (integration with GCash APIs)

// Retrieve payment information from the form
$amount = $_POST['amount'];
$reference = $_POST['reference'];

// Placeholder for payment processing logic
// In a real application, you would integrate with GCash APIs or a payment gateway
// For demonstration purposes, we'll simply simulate a successful payment
$success = true;

if ($success) {
    // Payment successful
    $message = "Payment successful! Amount: $amount, Reference: $reference";
} else {
    // Payment failed
    $message = "Payment failed! Please try again.";
}

// Redirect the user to a payment status page along with the message
header("Location: payment_status.php?message=" . urlencode($message));
exit;
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GCash Payment</title>
</head>
<body>
    <h1>GCash Payment</h1>
    <form action="" method="POST">
        <label for="amount">Amount:</label>
        <input type="text" id="amount" name="amount" required><br><br>
        <label for="reference">Reference Number:</label>
        <input type="text" id="reference" name="reference" required><br><br>
        <button type="submit">Pay with GCash</button>
    </form>
</body>
</html>
