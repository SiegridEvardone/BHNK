<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayPal Payment</title>
    <style>
        #total-amount {
            font-weight: bold;
            margin-top: 10px;
        }
        .paypal-button-container {
            width: 100%; /* Ensures the container takes full width */
            display: flex;
            justify-content: center;
        }
        .paypal-button-container iframe {
            width: 100% !important;
            min-width: 100% !important;
        }
    </style>
</head>
<body>
<div class="position-relative">
    <?php include('../include/dash_header.php'); ?>
    <button class="openbtn position-absolute top-0 start-0" onclick="toggleSidebar()">☰</button>
    <div id="sidebar-container"></div>
    <div class="main">
        <div class="container bg-light p-3" style="height: 510px;">
            <div class="border border-dark p-4 mx-auto" style="max-width: 50%; min-width: 300px">
                <h2 class="text-center mb-3">Pay Rent with PayPal</h2>
                <form id="payment-form">
                    <label for="amount" class="form-label">Enter Amount (PHP):</label>
                    <input class="form-control mb-2" type="number" id="amount" name="amount" min="1" step="0.01" required>
                    <div id="transaction-fee"></div>
                    <div id="fixed-fee"></div>
                    <div id="total-amount" class="mt-0 mb-3"></div>
                    <hr>
                    <div id="paypal-button-container" class="paypal-button-container"></div>
                </form>
                <script src="https://www.paypal.com/sdk/js?client-id=Aak3zB3-x8fyGMq4NRSZ4X3NvdPH1uS4gggiuIf0mZ13B7stKASAnTQXFvv0YhVi9l_us5wjEJlGl93Q&currency=PHP"></script>
                <script>
                    const transactionFeeRate = 0.044; // 4.4% transaction fee
                    const fixedFee = 15.00; // Fixed fee in PHP
                    const userId = 123; // Replace with actual user ID retrieval logic

                    document.getElementById('amount').addEventListener('input', function() {
                        var amount = parseFloat(document.getElementById('amount').value);
                        if (!isNaN(amount)) {
                            var transactionFee = amount * transactionFeeRate;
                            var totalFee = transactionFee + fixedFee;
                            var totalAmount = amount + totalFee;

                            document.getElementById('transaction-fee').innerHTML = 'Transaction Fee (4.4%): PHP ' + transactionFee.toFixed(2);
                            document.getElementById('fixed-fee').innerHTML = 'Fixed Fee: PHP ' + fixedFee.toFixed(2);
                            document.getElementById('total-amount').innerHTML = 'Total Amount: PHP ' + totalAmount.toFixed(2);
                        } else {
                            document.getElementById('transaction-fee').innerHTML = '';
                            document.getElementById('fixed-fee').innerHTML = '';
                            document.getElementById('total-amount').innerHTML = '';
                        }
                    });

                    paypal.Buttons({
                        createOrder: function(data, actions) {
                            var amount = parseFloat(document.getElementById('amount').value);
                            if (!isNaN(amount)) {
                                var transactionFee = amount * transactionFeeRate;
                                var totalFee = transactionFee + fixedFee;
                                var totalAmount = amount + totalFee;

                                return actions.order.create({
                                    purchase_units: [{
                                        amount: {
                                            value: totalAmount.toFixed(2) // Use the total amount including transaction fee and fixed fee
                                        }
                                    }]
                                });
                            }
                        },
                        onApprove: function(data, actions) {
                            return actions.order.capture().then(function(details) {
                                fetch('/record-payment.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        payer_name: details.payer.name.given_name + ' ' + details.payer.name.surname,
                                        payer_email: details.payer.email_address,
                                        amount: details.purchase_units[0].amount.value,
                                        transaction_id: details.id,
                                        payment_status: details.status,
                                        user_id: userId
                                    })
                                }).then(response => response.json())
                                  .then(data => {
                                      if (data.success) {
                                          alert('Transaction completed successfully!');
                                      } else {
                                          alert('Transaction recording failed.');
                                      }
                                  }).catch(error => {
                                      console.error('Error:', error);
                                  });
                            });
                        }
                    }).render('#paypal-button-container');
                </script>
            </div>
        </div>
    </div>
</div>
<script src="../assets/js/script.js"></script>
</body>
</html>
