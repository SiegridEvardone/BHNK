<?php
require_once('../vendor/autoload.php'); // Adjust path to match your installation
require_once('../include/pdoconnect.php'); // Adjust as per your database connection method

use Paymongo\Paymongo;
use Paymongo\PaymentIntent;

// Set your PayMongo API keys
Paymongo::setApiKey('sk_test_pbJTNvbSPCjEV8VVyWdHgdVs');

// Process payment
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST['amount'];  // Amount in PHP cents (100 PHP = 10000 cents)
    $description = $_POST['description'];
    $payment_method = $_POST['payment_method'];  // 'gcash' in this case

    try {
        // Create payment intent
        $payment = PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'PHP',
            'payment_method_allowed' => [$payment_method],
            'description' => $description,
            'statement_descriptor' => 'Your Statement Descriptor',
        ]);

        // Record payment history in your database
        if ($payment->status === 'succeeded') {
            $payment_id = $payment->id;
            $status = $payment->status;

            // Insert into payments table
            $sql = "INSERT INTO tblpayments (payment_id, amount, description, status, payment_method) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$payment_id, $amount, $description, $status, $payment_method]);

            // Redirect to success page
            header("Location: payment_success.php");
            exit();
        } else {
            echo "Payment processing failed. Please try again.";
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>
