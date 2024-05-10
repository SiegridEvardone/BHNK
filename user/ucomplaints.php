<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Complaints</title>
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
          <h1 class="mb-2"><i class="fa-solid fa-circle-exclamation"></i> Complaints  </h1>
        </div>
        <a href="3" class="btn btn-success m-2"><i class="fa-solid fa-plus"></i> Submit Complaint</a>
        <div class="container text-center p-0">
          <div class="row border" style="background-color: #D3D3D3;">
            <div class="col p-2">
              <p class="fw-bold m-0">Room number</p>
            </div>
            <div class="col p-2">
              <p class="fw-bold m-0">Tenant Name</p>
            </div>
            <div class="col p-2">
              <p class="fw-bold m-0">Complaint/Suggestions</p>
            </div>
            <div class="col p-2">
              <p class="fw-bold m-0">Date(YY-MM-DD)</p>
            </div>
            <div class="col p-2">
              <p class="fw-bold m-0">Reply from owner</p>
            </div>
            <div class="col p-2">
              <p class="fw-bold m-0">Status</p>
            </div>
            <div class="col p-2">
              <p class="fw-bold m-0">Action</p>
            </div>
          </div>
        </div>
        <div class="container text-center p-0 overflow-y-auto mb-4" style="height: 150px; overflow-x: hidden;">
          <div class="row bg-light border">
            <div class="col p-2 border-end">
              <p><span class="fw-normal fst-italic">code</span></p>
            </div>
            <div class="col p-2 border-end">
              <p><span class="fw-normal fst-italic">code</span></p>
            </div>
            <div class="col p-2 border-end">
              <p><span class="fw-normal fst-italic">code</span></p>
            </div>
            <div class="col p-2 border-end">
              <p><span class="fw-normal fst-italic">code</p>
            </div>
            <div class="col p-2 border-end">
              <p><span class="fw-normal fst-italic">code</span></p>
            </div>
            <div class="col p-2 border-end">
              <p><span class="fw-normal fst-italic">code</span></p>
            </div>
            <div class="col p-2 border-end">
              <p><i class="fw-normal fst-italic"></i>code</p>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</body>
</html>