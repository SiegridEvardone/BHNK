<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment History</title>
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
        <div class="container mt-1">
          <h1 class="mb-2"><i class="fa-solid fa-circle-exclamation"></i> Payment History  </h1>
        </div>
        <div class="container text-center p-0">
          <div class="row border" style="background-color: #D3D3D3;">
            <div class="col p-2">
              <p class="fw-bold m-0">Invoice no.</p>
            </div>
            <div class="col p-2">
              <p class="fw-bold m-0">Amount Paid</p>
            </div>
            <div class="col p-2">
              <p class="fw-bold m-0">Date of Payment</p>
            </div>
            <div class="col p-2">
              <p class="fw-bold m-0">Remarks</p>
            </div>
          </div>
        </div>
        <div class="container text-center p-0 overflow-y-auto mb-4" style="height: 400px; overflow-x: hidden;">
          <div class="row bg-light border">
            <div class="col p-2 border-end">
              <p class="m-0"><span class="fw-normal fst-italic">code</span></p>
            </div>
            <div class="col p-2 border-end">
              <p class="m-0"><span class="fw-normal fst-italic">code</span></p>
            </div>
            <div class="col p-2 border-end">
              <p class="m-0"><span class="fw-normal fst-italic">code</span></p>
            </div>
            <div class="col p-2 border-end">
              <p class="m-0"><span class="fw-normal fst-italic">code</p>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</body>
</html>