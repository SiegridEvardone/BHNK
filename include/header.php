<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BHNK Home page</title>
  <link fs-2 rel="stylesheet" type="text/css" href="./assets/css/bootstrap.min.css"/>
  <link rel="stylesheet" type="text/css" href="./assets/css/all.min.css"/>
  <link rel="stylesheet" type="text/css" href="./assets/css/stylemain.css"/>
</head>
<body>
  <nav class="navbar navbar-expand-lg px-3" style="background-color: #294C52;">
    <div class="container-fluid ">
      <h5 class="text-white mb-0">BHNK Management System</h5>
      <ul class="navbar-nav">
        <li class="nav-item">
          <a href="index.php" class="nav-link fs-6 me-2">Home</a>
        </li>
        <li class="nav-item dropdown me-2">
          <a class="nav-link fs-6 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Login
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="userlogin.php">Tenant</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="adminlogin.php">Admin</a></li>
          </ul>
        </li>
        <a href="register.php">
          <button type="button" class="btn btn-light mx-auto reg_btn">Register</button>
        </a>
        
      </ul> 
    </div>
  </nav>

  <script src="./assets/js/bootstrap.min.js"></script>
  <script src="./assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
