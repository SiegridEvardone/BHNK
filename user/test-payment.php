<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: /login.php");
    exit();
}

$userId = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Payment</title>
</head>
<body>
    <h2>Test Payment</h2>
    <form id="test-payment-form">
        <label for="amount">Amount (PHP):</label>
        <input type="number" id="amount" name="amount" min="1" step="0.01" required>
        <button type="button" onclick="simulatePayment()">Simulate Payment</button>
    </form>
    <div id="result"></div>

    <script>
        function simulatePayment() {
            const userId = <?php echo json_encode($userId); ?>;
            const amount = parseFloat(document.getElementById('amount').value);

            const paymentDetails = {
                payer_name: 'John Doe',
                payer_email: 'johndoe@example.com',
                amount: amount,
                transaction_id: 'TEST123456',
                payment_status: 'COMPLETED',
                user_id: userId
            };

            fetch('record-payment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(paymentDetails)
            }).then(response => response.json())
              .then(data => {
                  document.getElementById('result').innerHTML = JSON.stringify(data);
                  if (data.success) {
                      window.location.href = 'success.php';
                  } else {
                      alert('Transaction recording failed: ' + data.error);
                  }
              }).catch(error => {
                  console.error('Error:', error);
              });
        }
    </script>
</body>
</html>
