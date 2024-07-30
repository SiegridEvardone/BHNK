<div class="sidebar" id="sidebar">
    <button class="closebtn" onclick="toggleSidebar()">×</button>
<ul class="nav flex-column admin_nav">
        <li class="nav-item py-2 pe-2 ps-3"> 
          <a class="nav-link active" href="index.php"><i class="fa-brands fa-windows"></i> Dashboard</a>
        </li>
        <li class="nav-item dropdown py-2 pe-2 ps-3">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-expanded="false"><i class="fa-solid fa-bed"></i> Rooms</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item text-dark" href="rooms.php">Add Rooms</a></li>
            <li><a class="dropdown-item text-dark" href="avail_rooms.php">Available Rooms</a></li>
          </ul>
        </li>
        <li class="nav-item py-2 pe-2 ps-3">
          <a class="nav-link" href="tenants.php"><i class="fa-solid fa-users"></i> Tenants</a>
        </li>
        <li class="nav-item dropdown py-2 pe-2 ps-3">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-expanded="false"><i class="fa-solid fa-money-bill-wave"></i> Payments</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item text-dark" href="payments.php">Payments</a></li>
            <hr>
            <li><a class="dropdown-item text-dark" href="payment_history.php">Payments History</a></li>

          </ul>
        </li>
        <li class="nav-item py-2 pe-2 ps-3">
          <a class="nav-link" href="lease_monitor.php"><i class="fa-solid fa-tv"></i> Lease Monitor</a>
        </li>
        <li class="nav-item py-2 pe-2 ps-3">
          <a class="nav-link" href="complaints.php"><i class="fa-solid fa-circle-exclamation"></i> Complaints</a>
        </li>
        <li class="nav-item py-2 pe-2 ps-3">
          <a class="nav-link" href="notices.php"><i class="fa-solid fa-bullhorn"></i> Notices</a>
        </li>
        <li class="nav-item dropdown py-2 pe-2 ps-3">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-expanded="false"><i class="fa-solid fa-gear"></i> Settings</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item text-dark" href="../logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
</div>