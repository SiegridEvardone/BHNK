<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tenant Dashboard</title>
</head>
<body style="overflow-x: hidden;">
  <?php
    include('../include/dash_header.php');
    include('../include/connection.php');
  ?>
  <div class="container-fluid">
    <div class="row">
      <?php
        include('sidenav.php');
      ?> 
       <!-- Page Content -->
       <main class="col-12 col-md-5 ms-sm-auto col-lg-10 px-md-4 py-md-3">
        <div class="container mt-3">
          <div class="row g-4">
            <div class="col-4">
              <div class="px-1 pt-1 border" style="background-color: #00446B;">
                <div class="container p-0">
                  <div class="row g-2">
                    <div class="col-md-8">
                      <div class="p-2 text-white">
                        <h2>0</h2>
                        <h4>Payments</h4>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="text-white text-end p-3">
                        <i class="fa-solid fa-money-bill-wave fs-1"></i>
                      </div>
                    </div>
                    <div class="col-12" style="background-color: #DCDCDC;">
                      <div class="p-2">
                        <a href="" class="text-dark text-decoration-none fs-6">
                          View Details > 
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
              <div class="col-4">
                <div class="px-1 pt-1 border" style="background-color: #00446B;">
                  <div class="container p-0">
                    <div class="row g-2">
                      <div class="col-md-8">
                        <div class="p-2 text-white">
                          <h2>0</h2>
                          <h4>Total Complaints</h4>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="text-white text-end p-3">
                          <i class="fa-solid fa-circle-exclamation fs-1"></i>
                        </div>
                      </div>
                      <div class="col-12" style="background-color: #DCDCDC;">
                        <div class="p-2">
                          <a href="" class="text-dark text-decoration-none fs-6">
                            View Details > 
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-4">
                <div class="px-1 pt-1 border" style="background-color: #00446B;">
                  <div class="container p-0">
                    <div class="row g-2">
                      <div class="col-md-8">
                        <div class="p-2 text-white">
                          <h2>0</h2>
                          <h4>Total Notices</h4>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="text-white text-end p-3">
                        <i class="fa-solid fa-bullhorn fs-1"></i>
                        </div>
                      </div>
                      <div class="col-12" style="background-color: #DCDCDC;">
                        <div class="p-2">
                          <a href="" class="text-dark text-decoration-none fs-6">
                            View Details > 
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-4">
                <div class="px-1 pt-1 border" style="background-color: #00446B;">
                  <div class="container p-0">
                    <div class="row g-2">
                      <div class="col-md-8">
                        <div class="p-2 text-white">
                          <h2>0</h2>
                          <h4>Settings</h4>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="text-white text-end p-3">
                          <i class="fa-solid fa-gear fs-1"></i>
                        </div>
                      </div>
                      <div class="col-12" style="background-color: #DCDCDC;">
                        <div class="p-2">
                          <a href="" class="text-dark text-decoration-none fs-6">
                            View Details > 
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-4">
                <div class="px-1 pt-1 border" style="background-color: #00446B;">
                  <div class="container p-0">
                    <div class="row g-2">
                      <div class="col-md-8">
                        <div class="p-2 text-white">
                          <h2>0</h2>
                          <h4>Profile</h4>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="text-white text-end p-3">
                        <i class="fa-solid fa-user-gear fs-1"></i>
                        </div>
                      </div>
                      <div class="col-12" style="background-color: #DCDCDC;">
                        <div class="p-2">
                          <a href="" class="text-dark text-decoration-none fs-6">
                            View Details > 
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </main>
    </div>
  </div>
</body>
</html>