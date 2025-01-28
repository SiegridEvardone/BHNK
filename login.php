
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css"/>
  <link rel="stylesheet" type="text/css" href="assets/css/all.min.css"/>
  <link rel="stylesheet" type="text/css" href="assets/css/main.css"/>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.2/font/bootstrap-icons.min.css" rel="stylesheet">

  <style>
    .bg-container {
      background: linear-gradient(to top, #3931af, #00c6ff);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .left-column {
      padding-right: 50px;
    }
    .right-column {
      background-color: white;
      border-bottom-left-radius: 10% 30%;
      border-top-left-radius: 10% 30%;
      padding: 20px;
    }
    .form-container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100%;
    }
    .form-content {
      width: 100%;
      max-width: 400px;
    }
    .nav-link {
      background-color: #fff;
      color: #0062cc;
      padding: 5px 10px;
      height: 40px;
      border: 2px solid #0062cc;
    }
    .nav-link.active {
      background-color: #007bff !important;
      color: #fff !important;
      border: 2px solid #0062cc;
      font-weight: 600;
      width: 100px;
    }
    .nav-right {
      margin-top: 20px;
      text-align: right;
    }
    .btnIcon-container {
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 2% 0;
    }
    .text-center {
      text-align: center;
      color: #495057;
    }
    .logo-details {
      color: white;
      text-align: center;
      margin-top: -20px;
    }
    .img-container {
      margin-top: -80px;
      display: flex;
      justify-content: center;
    }
    .logo img {
      
      width: 25rem;
      animation: mover 7s ease-in-out infinite;
    }
    .btn-custom {
      background-color: #007bff;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      width: 100%;
      max-width: 100%;
      display: block;
      margin: 10% auto;
    }
    .btn-custom:hover {
      background-color: #0056b3;
    }
    .img-container img {
      width: 100%;
      max-width: 200%;
      animation: mover 3s ease-in-out infinite alternate;
    }
    @keyframes mover {
      0% { transform: translateY(0); }
      100% { transform: translateY(20px); }
    }
  </style>
</head>
<body>
  <div class="bg-container">
    <div class="container">
      <div class="row align-items-center">
        <!-- Left Column -->
        <div class="col-md-4 left-column">
          <!-- Logo -->
          <div class="img-container">
            <img src="assets/images/BH_logo_nobg.png" alt="card">
          </div>
          <!-- Details -->
          <div class="logo-details">
            <h2>Welcome Back!</h2>
            <p>There is nothing more important than a good, safe, secure home.</p>
          </div>
        </div>
        <!-- Right Column -->
        <div class="col-md-8 right-column">
          <div class="nav-right">
            <a href="index.php" class="nav justify-content-start ms-4"><i class="fa-solid fa-circle-arrow-left"></i></a>
            <ul class="nav justify-content-end" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="tenant-tab" data-toggle="tab" href="#tenant" role="tab" aria-controls="tenant" aria-selected="false">Tenant</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="admin-tab" data-toggle="tab" href="#admin" role="tab" aria-controls="admin" aria-selected="true">Admin</a>
              </li>
            </ul>
          </div>
          <div class="tab-content" id="myTabContent">
            <!-- Tenant Form -->
            <div class="tab-pane fade show active" id="tenant" role="tabpanel" aria-labelledby="tenant-tab">
              <div class="btnIcon-container">
                <i class="fa-solid fa-user-large" style="font-size: 50px;"></i>
              </div>
              <div class="container form-container">
                <div class="form-content">
                  <h2 class="text-center">Tenant Login</h2>
                  <form action="userlogin_proccess.php" method="post">
                    <div class="form-group">
                      <label for="tenantUsername">Username:</label>
                      <input type="text" class="form-control" name="username" autocomplete="off" placeholder="Enter your username" required>
                    </div>
                    <div class="form-group">
                      <label for="tenantPassword">Password:</label>
                      <input type="password" class="form-control" name="password" placeholder="Enter your password" required>
                    </div>
                    <div class="btn-container d-grid">
                      <input type="submit" name="login" class="btn btn-primary" value="Login">
                      <hr>
                      <div class="">
                        <a href="confirm_account.html" >Forgot password?</a>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- Admin Form -->
            <div class="tab-pane fade " id="admin" role="tabpanel" aria-labelledby="admin-tab">
              <div class="btnIcon-container">
               <i class="fa-solid fa-user-gear" style="font-size: 50px;"></i>
              </div>
              <div class="container form-container">
                <div class="form-content">
                  <h2 class="text-center">Admin Login</h2>
                  <form action="adminlogin_proccess.php" method="post">
                    <div class="form-group">
                      <label for="adminUsername">Username:</label>
                      <input type="text" class="form-control" name="uname" autocomplete="off" placeholder="Enter your username" required>
                    </div>
                    <div class="form-group">
                      <label for="adminPassword">Password:</label>
                      <input type="password" class="form-control" name="pass" placeholder="Enter your password" required>
                    </div>
                    <div class="btn-container d-grid">
                      <input type="submit" name="login" class="btn btn-primary" value="Login">
                      <hr>
                      <a href="face_login.html" class="btn btn-secondary">Face Login</a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS and dependencies -->
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#myTab a').on('click', function(e) {
        e.preventDefault();
        var target = $(this).attr('href');
        $('.tab-pane').removeClass('show active');
        $(target).addClass('show active');
        $('#myTab a').removeClass('active');
        $(this).addClass('active');
      });

      $('#loginBtn').on('click', function() {
        $('#tenant-tab').click();
      });
    });
  </script>
</body>
</html>
