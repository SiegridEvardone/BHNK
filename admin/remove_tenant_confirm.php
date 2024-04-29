<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove Tenant</title>
</head>
<body>
<?php
include('../include/dash_header.php');
include('../include/connection.php');

// Check if the tenant ID is provided in the URL
if(isset($_GET['id'])) {
    $tenantId = $_GET['id'];
} else {
    // If tenant ID is not provided, redirect to an error page or display an error message
    header('Location: error.php');
    exit(); // Exit the script
}
?>

<div class="container-fluid">
    <div class="row">
    <?php include('sidenav.php'); ?> 
        <main class="col-12 col-md-5 ms-sm-auto col-lg-10 px-md-4 py-md-3">
            <div class="container">
                <h1 class="mb-2"><i class="fa-solid fa-door-open"></i> Remove Tenant</h1>
                <!-- Custom confirmation dialog with "Cancel" and "Confirm" buttons -->
                <script>
                    function confirmRemoval() {
                        return confirm("Are you sure you want to remove the tenant?\n\n" +
                                      "Press 'Cancel' to keep the tenant, or 'Confirm' to remove the tenant.");
                    }
                </script>
                <!-- Button to trigger confirmation dialog -->
                <button onclick="if (confirmRemoval()) location.href='remove_tenant.php?id=<?php echo $tenantId; ?>';" class="btn btn-danger">Remove Tenant</button>
                <a href="avail_rooms.php" class="btn btn-secondary">Cancel</a>
            </div>
        </main>
    </div>
</div>
</body>
</html>
