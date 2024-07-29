<?php
ob_start();
include('../include/pdoconnect.php');

// Check if notice ID is provided
if (!isset($_GET['id'])) {
    // Redirect to notices.php if notice ID is not provided
    header("Location: notices.php");
    exit();
}

// Get the notice ID from the URL
$notice_id = $_GET['id'];

// Fetch the notice details from the database
$sql = "SELECT * FROM tblnotices WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$notice_id]);
$notice = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if notice exists
if (!$notice) {
    // Redirect to notices.php if notice does not exist
    header("Location: notices.php");
    exit();
}
ob_end_clean();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Notice</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f4f6f9; /* Light gray background */
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 3rem;
        }
        .notice-card {
            background-color: #ffffff; /* White background for the card */
            border: 1px solid #dcdcdc; /* Light gray border */
            border-radius: 0.75rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            max-width: 700px;
            margin: auto;
            text-align: left;
        }
        .notice-card h3 {
            color: #343a40; /* Dark gray for the title */
            margin-bottom: 1rem;
        }
        .notice-card p {
            color: #495057; /* Medium gray for text */
            margin-bottom: 1rem;
        }
        .notice-card p:last-child {
            margin-bottom: 0;
        }
        .btn-custom {
            background-color: #007bff; /* Primary blue */
            color: #ffffff;
            border: none;
            border-radius: 0.3rem;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            text-decoration: none;
            display: inline-block;
            margin-right: 0.5rem;
        }
        .btn-custom:hover {
            background-color: #0056b3; /* Darker blue */
            color: #ffffff;
        }
        .btn-outline-custom {
            border: 1px solid #dc3545; /* Danger red */
            color: #dc3545;
            border-radius: 0.3rem;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            text-decoration: none;
            display: inline-block;
        }
        .btn-outline-custom:hover {
            background-color: #dc3545; /* Danger red background */
            color: #ffffff;
        }
    </style>
</head>
<body>
<div class="position-relative">
    <?php include('../include/dash_header.php'); ?>
    <button class="openbtn position-absolute top-0 start-0" onclick="toggleSidebar()">☰</button>
    <div id="sidebar-container"></div>
    <div class="main">
        <div class="container">
            <div class="notice-card">
                <h3><?php echo htmlspecialchars($notice['title']); ?></h3>
                <p><?php echo nl2br(htmlspecialchars($notice['content'])); ?></p>
                <p><strong>Posted on:</strong> <?php echo htmlspecialchars(date('F j, Y', strtotime($notice['post_date']))); ?></p>
                <a href="notices.php" class="btn btn-secondary">Back to Notices</a>
                <a href="delete_notice.php?id=<?php echo htmlspecialchars($notice_id); ?>" class="btn btn-danger">Delete</a>
            </div>
        </div>
    </div>
</div>
<script src="../assets/js/script.js"></script>
</body>
</html>
