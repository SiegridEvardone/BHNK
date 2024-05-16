<?php
session_start();
ob_start();

// Include database connection
include('../include/connection.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if the form has been submitted successfully previously in this session
if(isset($_SESSION['complaint_submitted']) && $_SESSION['complaint_submitted'] === true) {
    // Reset the session variable to prevent repeated alerts
    $_SESSION['complaint_submitted'] = false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tenant_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $conn->prepare("INSERT INTO tblcomplaints (tenant_id, title, content) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $tenant_id, $title, $content);

    if ($stmt->execute()) {
        // Close prepared statement
        $stmt->close();
        
        // Close database connection
        $conn->close();

        // Set session variable to indicate successful form submission
        $_SESSION['complaint_submitted'] = true;

        // Redirect to complaints page with success message
        header("Location: ucomplaints.php?success=1");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

ob_end_clean();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit a Complaint</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
                <h1 class="mb-4"><i class="fa-solid fa-circle-exclamation"></i> Submit a complaint</h1>
                <form action="" method="POST" class="border p-3">
                    <label for="title" class="form-label">Title:</label>
                    <input type="text" id="title" name="title" class="form-control" required><br>
                    <label for="content">Content:</label>
                    <textarea id="content" name="content" rows="4" class="form-control" required></textarea><br>
                    <!-- Include the tenant_id as a hidden field -->
                    <input type="hidden" name="tenant_id" value="<?php echo $_SESSION['user_id']; ?>">
                    <br>
                    <a href="ucomplaints.php" class="btn btn-danger mt-3">Cancel</a>
                    <button class="btn btn-primary mt-3" type="submit">Submit</button>
                </form>
            </div>
        </main>
    </div>
</div>

<script>
// JavaScript code to display an alert after form submission
<?php if(isset($_GET['success']) && $_GET['success'] == 1): ?>
    alert("Complaint submitted successfully.");
<?php endif; ?>
</script>
</body>
</html>
