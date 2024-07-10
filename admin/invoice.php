<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice</title>
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
      <main class="col-12 col-md-5 ms-sm-auto col-lg-10 px-md-3 py-md-3">
        <div class="container mt-1 bg-light p-3">
          <h3 class="mb-4"><i class="fa-solid fa-door-open"></i> Invoice</h3>
          <div class="container border p-4 rounded">
            <div class="row">
              <div class="col-8">
                <h5>Boarding House ni Kuya Management System</h5>
                <div class="row">
                  <div class="col">
                    <p class="m-0">From:</p>
                    <p><strong>Admin</strong></p>
                    <p>96 Avenida Veteranos St. Brgy. 42 Tacloban City Leyte</p>
                  </div>
                  <div class="col">
                    <p class="m-0">To:</p>
                    <input type="text" class="form-control" placeholder="Tenant name">
                  </div>
                  
                </div>
              </div>
              <div class="col-4 text-end">
                <p>Date:</p>
                <div class="container text-start">
                  <label for=""><strong>Invoice: </strong></label>
                  <input type="text" class="form-control" placeholder="#">
                  <label for=""><strong>Due Date: </strong></label>
                  <input type="date" class="form-control" placeholder="#">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="mt-3 ">
                  <div class="container text-center p-0">
                      <div class="row border" style="background-color: #D3D3D3;">
                          <div class="col p-2">
                              <p class="fw-bold m-0">Description</p>
                          </div>
                          <div class="col p-2">
                              <p class="fw-bold m-0">Month</p>
                          </div>
                          <div class="col p-2">
                              <p class="fw-bold m-0">Year</p>
                          </div>
                          <div class="col p-2">
                              <p class="fw-bold m-0">Sub Total</p>
                          </div>
                      </div>
                  </div>
                  <div class="row bg-light border text-center">
                    <div class="col p-2 border-end">
                        <h6>Monthly Rent</h6>
                    </div>
                    <div class="col p-2 border-end">
                        <p></p>
                    </div>
                    <div class="col p-2 border-end">
                        <p></p>
                    </div>
                    <div class="col p-2 border-end">
                        <p></p>
                    </div>
                </div>
            </div>
            <div class="container">
              <div class="row">
                <div class="col">
                  <p>Payment Methods:</p>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                    <label class="form-check-label" for="flexRadioDefault1">
                      CASH
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                    <label class="form-check-label" for="flexRadioDefault2">
                      G-CASH
                    </label>
                  </div>
                </div>
                <div class="col">
                  <P>Amount Due: </P>
                  <hr class="my-1">
                  <div class="row">
                    <div class="col">
                      <p><strong>SubTotal:</strong></p>
                    </div>
                    <div class="col">
                      <p>Php 4400</p>
                    </div>
                  </div>
                <hr class="my-1">
                <div class="row">
                    <div class="col">
                      <p><strong>Total:</strong></p>
                    </div>
                    <div class="col">
                      <p>Php 4400</p>
                    </div>
                  </div>
              </div>
              <input type=button onClick="print()" value="Print">
                <applet id="qz" code="qz.PrintApplet.class" archive="./qz-print.jar" width="100" height="100">
                      <param name="printer" value="zebra">
                </applet>

                <script>
                      function print() {
                      qz.append("PRINTED USING JZEBRA\n");
                      qz.print();
                      }
                </script>
            </div>

        </div>
      </main>
    </div>
  </div>