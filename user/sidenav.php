<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title></title>
</head>
<body>
  <!-- Sidebar -->
  <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidenav p-0">
    <div class="position-sticky  pt-3">
      <ul class="nav flex-column admin_nav">
        <li class="nav-item py-2 pe-2 ps-3"> 
          <a class="nav-link active" href="index.php"><i class="fa-brands fa-windows"></i> Dashboard</a>
        </li>
        <li class="nav-item dropdown py-2 pe-2 ps-3">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-expanded="false"><i class="fa-solid fa-money-bill-wave"></i> Payments</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item text-dark" href="">View Due Date</a></li>
            <li><a class="dropdown-item text-dark" href="">Pay Rent</a></li>
            <li><a class="dropdown-item text-dark" href="">Payments History</a></li>
          </ul>
        </li>
        <li class="nav-item py-2 pe-2 ps-3">
          <a class="nav-link" href="#"><i class="fa-solid fa-circle-exclamation"></i> Complaints</a>
        </li>
        <li class="nav-item py-2 pe-2 ps-3">
          <a class="nav-link" href="#"><i class="fa-solid fa-bullhorn"></i> Notices</a>
        </li>
        <li class="nav-item dropdown py-2 pe-2 ps-3">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-expanded="false"><i class="fa-solid fa-gear"></i> Settings</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item text-dark" href="">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-dark" href="../logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</body>
</html>
