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
  <?php
    include('../include/dash_header.php');
  ?>
  <div class="container-fluid">
    <div class="row">
      <?php
        include('sidenav.php');
      ?> 
      <main class="col-12 col-md-5 ms-sm-auto col-lg-10 px-md-4 py-md-3">
        <div class="container bg-light p-3" style="height: 510px;">
          <h1>Payment History</h1>
          <table id="payments-table">
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
      </main>
    </div>
  </div>
</body>
</html>
