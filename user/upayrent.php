<?php
session_start(); // Start the session to access session variables
include('../include/connection.php');
// Check if user is logged in and user ID is available
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if user is not logged in
    header("Location: ../login.php");
    exit();
}

$userId = $_SESSION['user_id']; // Get the logged-in user ID
$sql = "SELECT u.first_name, u.middle_name, u.last_name, tl.StartDate, DATE_ADD(tl.StartDate, INTERVAL 1 MONTH) AS due_date
       FROM tbluser u
        JOIN tbltenant t ON u.user_id = t.user_id
        JOIN tblrooms r ON t.room_id = r.id
        JOIN tenant_leases tl ON t.user_id = tl.UserID
        WHERE u.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $first_name = htmlspecialchars($row['first_name']);
    $middle_name = htmlspecialchars($row['middle_name']);
    $last_name = htmlspecialchars($row['last_name']);
    $due_date = htmlspecialchars(date('F d, Y', strtotime($row['due_date'])));

} else {
    // Handle case where no data is found (though it should not happen if user_id is correctly set)
    $first_name = '';
    $middle_name = '';
    $last_name = '';
    $due_date = '';
  
}

$currentDate = date("m/d/Y");
$currentMonth = date("F"); // Full month name (e.g., August)
$currentYear = date("Y");  // Year in 4 digits (e.g., 2024)

?>
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
        <div class="container bg-light p-3">
            <div class="border border-dark p-4 mx-auto" style="max-width: 90%; min-width: 300px">
              <div class="row">
                <div class="col-8">
                  <h3 class="mb-3"><i class="fa-solid fa-receipt"></i> Boarding House Management System</h3>
                </div>
                <div class="col-4 text-end">
                  <p>Date:  <?php echo $currentDate; ?></p>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <p class="m-0">From:</p>
                  <strong>Admin</strong>
                  <p class="m-0">96,Avenida Veteranos Street,Brgy. 42 Tacloban City</p>
                  <p class="m-0">Contact: xxx-xxx-xxxx</p>
                  <p class="m-0">Email: boardinghousenikuya@gmail.com</p>
                </div>
                <div class="col">
                  <p class="m-0">To:</p>
                  <strong>Tanant name:</strong>
                  <div class="border rounded p-2"><?php echo "{$first_name} {$middle_name} {$last_name}"; ?></div>
                </div>
                <div class="col">
                  <p class="mb-4"></p>
                  <strong>Due Date:</strong>
                  <div class="border rounded p-2"> <?php echo $due_date; ?></div>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col">
                  <p><strong>Description:</strong> Monthly Rent</p>
                  <p><strong>Month:</strong> <?php echo date("F"); ?></p>
                  <p><strong>Year:</strong> <?php echo date("Y"); ?></p>
                </div>
                <div class="col">
                <form id="payment-form">
                    <label for="amount" class="form-label">Enter Amount (PHP):</label>
                    <input class="form-control mb-2" type="number" id="amount" name="amount" min="1" step="0.01" required>
                    <div id="transaction-fee"></div>
                    <div id="fixed-fee"></div>
                    <div id="total-amount" class="mt-0 mb-3"></div>
                    <hr>
                    <div id="paypal-button-container" class="paypal-button-container"></div>
                </form>
                </div>
              </div>  
                
                <script src="https://www.paypal.com/sdk/js?client-id=Aak3zB3-x8fyGMq4NRSZ4X3NvdPH1uS4gggiuIf0mZ13B7stKASAnTQXFvv0YhVi9l_us5wjEJlGl93Q&currency=PHP"></script>
                <script>
                    const transactionFeeRate = 0.044; // 4.4% transaction fee
                    const fixedFee = 15.00; // Fixed fee in PHP
                    const userId = <?php echo json_encode($userId); ?>; // PHP to JS variable

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
            console.log('PayPal response details:', details); // Log details for debugging
            fetch('record-payment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    payer_name: details.payer.name.given_name + ' ' + details.payer.name.surname,
                    payer_email: details.payer.email_address,
                    amount: details.purchase_units[0].amount.value,
                    transaction_id: details.id,
                    payment_status: details.status, // Ensure this is correct
                    user_id: userId
                })
            }).then(response => response.json())
              .then(data => {
                  console.log('Backend response:', data); // Log backend response for debugging
                  if (data.success) {
                      window.location.href = 'success.php';
                  } else {
                      alert('Transaction recording failed: ' + data.error);
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
