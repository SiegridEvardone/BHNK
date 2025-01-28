<?php 
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>BHNK Home page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link fs-2 rel="stylesheet" type="text/css" href="./assets/css/bootstrap.min.css"/>
  <link rel="stylesheet" type="text/css" href="./assets/css/all.min.css"/>
  <link rel="stylesheet" type="text/css" href="./assets/css/main.css"/>
  <style>
    body {
      background: linear-gradient(to right,#0F1035,#365486,#7FC7D9,#DCF2F1);
      color: white;
    }
    .container-fluid {
      padding: 20px;
      max-width: 1900px; /* Adjust the max-width according to your preference */
      margin: 0 auto;
    }
    .round {
      width: 60px;
      height: 60px;
      overflow: hidden;
      border-radius: 50%;
    }
    .round img {
      width: 100%;
      height: auto;
      object-fit: cover;
    }
    .header-text {
      font-size: 2.5rem;
      font-weight: bold;
    }
    .sub-text {
      font-size: 1.5rem;
    }
    .location {
      margin-bottom: 1rem;
    }
    .btn-custom {
      width: 110px;
    }
    @media (max-width: 992px) {
      .round {
        width: 40px;
        height: 40px;
      }
    }
    @media (max-width: 768px) {
      .header-text {
        font-size: 2rem;
      }
      .sub-text {
        font-size: 1.25rem;
      }
      .location {
        font-size: 0.9rem;
      }
      .btn-custom {
        width: 90px;
      }
    }
  </style>
</head>
<body>
  <div class="container-fluid p-4">
    <div class="container text-light">
      <div class="row">
        <div class="col-md-6 p-4">
          <div class="row">
            <div class="col-2 mb-3">
              <div class="round">
                <img src="assets/images/BH_logo.png" class="rounded-circle">
              </div>
            </div>
            <div class="col-10">
              <p class="m-0 pt-3">
                <strong>BHNK Management System</strong>
              </p>
            </div>
            <div class="container mt-5">
              <h1 class="mb-3 header-text">Welcome to Boarding House ni Kuya!</h1>
              <p class="sub-text mt-3"><i>“There is nothing more important than a good, safe, secure home.”</i></p>
              <p class="location mt-4"><i class="fa-solid fa-location-dot"></i> <i>Avenida Veteranos St. Brgy. 42 Tacloban City</i></p>
              <div class="mt-5">
                <a href="register.php" class="btn btn-custom text-light me-2" style="background-color: #F8BD0D;">Register</a>
                <a href="login.php" class="btn btn-custom text-light" style="background-color: #0F1035;">Login</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <img src="assets/images/BH_logo_nobg.png" style="width: 100%;">
        </div>
      </div>
    </div>
  </div>
  <script src="./assets/js/bootstrap.min.js"></script>
  <script src="./assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
