<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment History</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="position-relative">
        <?php include('../include/dash_header.php'); ?>
        <button class="openbtn btn btn-primary position-absolute top-0 start-0" onclick="toggleSidebar()">☰</button>
        <div id="sidebar-container"></div>
        <div class="main container">
            <div class="bg-light p-3" style="min-height: 510px;">
                <h1 class="mb-4">Payment History</h1>
                <div class="table-responsive">
                    <table id="payments-table" class="table table-striped">
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
                            <!-- Payment records will be inserted here -->
                        </tbody>
                    </table>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        fetch('fetch_payments.php')
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    const tableBody = document.querySelector('#payments-table tbody');
                                    data.payments.forEach(payment => {
                                        const row = document.createElement('tr');
                                        row.innerHTML = `
                                            <td>${payment.transaction_id}</td>
                                            <td>${payment.payer_name}</td>
                                            <td>${payment.payer_email}</td>
                                            <td>PHP ${payment.amount}</td>
                                            <td>${payment.payment_status}</td>
                                            <td>${payment.payment_date}</td>
                                        `;
                                        tableBody.appendChild(row);
                                    });
                                } else {
                                    alert('Failed to fetch payment history: ' + data.message);
                                }
                            })
                            .catch(error => console.error('Error:', error));
                    });
                </script>
            </div>
        </div>
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/script.js"></script>
</body>
</html>
