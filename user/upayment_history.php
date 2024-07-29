<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            margin: 0 auto;
            padding: 20px;
            max-width: 1200px; /* Max width for larger screens */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .table-container {
            max-height: 400px; /* Set the maximum height */
            overflow-y: auto; /* Add vertical scrolling */
            overflow-x: hidden; /* Hide horizontal scrolling */
        }
        .table-responsive {
            overflow-x: auto;
        }
        @media (max-width: 768px) {
            th, td {
                display: block;
                width: 100%;
                box-sizing: border-box;
            }
            th {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }
            td {
                position: relative;
                padding-left: 50%;
            }
            td::before {
                content: attr(data-label);
                position: absolute;
                left: 0;
                width: 45%;
                padding-left: 10px;
                white-space: nowrap;
                font-weight: bold;
            }
        }
    </style>
</head>
<body>
    <div class="position-relative">
        <?php include('../include/dash_header.php'); ?>
        <button class="openbtn btn btn-primary position-absolute top-0 start-0" onclick="toggleSidebar()">☰</button>
        <div id="sidebar-container"></div>
        <div class="main">
            <div class="container bg-light p-3">
                <h1 class="mb-4">Payment History</h1>
                <div class="table-container">
                    <div class="table-responsive">
                        <table id="payments-table" class="table table-striped">
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
                                <!-- Payment records will be inserted here -->
                            </tbody>
                        </table>
                    </div>
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
                                            <td>${payment.created_at}</td>
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
