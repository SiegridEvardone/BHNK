<div class="sidebar" id="sidebar">
    <button class="closebtn" onclick="toggleSidebar()">×</button>
    <ul class="nav flex-column admin_nav">
        <li class="nav-item py-2 pe-2 ps-3"> 
          <a class="nav-link active" href="index.php"><i class="fa-brands fa-windows"></i> Dashboard</a>
        </li>
        <li class="nav-item dropdown py-2 pe-2 ps-3">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-expanded="false"><i class="fa-solid fa-money-bill-wave"></i> Payments</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item text-dark" href="view_duedate.php">View Due Date</a></li>
            <li><a class="dropdown-item text-dark" href="upayment.php">Pay Rent</a></li>
            <li><a class="dropdown-item text-dark" href="upayment_history.php">Payments History</a></li>
          </ul>
        </li>
        <li class="nav-item py-2 pe-2 ps-3">
          <a class="nav-link" href="ucomplaints.php"><i class="fa-solid fa-circle-exclamation"></i> Complaints</a>
        </li>
        <li class="nav-item py-2 pe-2 ps-3">
          <a class="nav-link" href="unotices.php"><i class="fa-solid fa-bullhorn"></i> Notices</a>
        </li>
        <li class="nav-item dropdown py-2 pe-2 ps-3">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-expanded="false"><i class="fa-solid fa-gear"></i> Settings</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item text-dark" href="uprofile.php">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a href="confirm_delete.php" class="dropdown-item text-dark">Delete Account</a></li>
            <li><a class="dropdown-item text-dark" href="../logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
</div>
