<?php
ob_start();
session_start();

// Include database connection
include('../include/pdoconnect.php');

// Retrieve all public notices
$sql = "SELECT * FROM tblnotices WHERE visibility = 'public' ORDER BY post_date DESC";
$stmt = $pdo->query($sql);
$public_notices = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retrieve all private notices
$sql = "SELECT * FROM tblnotices WHERE visibility = 'private' ORDER BY post_date DESC";
$stmt = $pdo->query($sql);
$private_notices = $stmt->fetchAll(PDO::FETCH_ASSOC);
ob_end_clean();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notices</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #6c757d;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 2rem;
        }
        .notice-container {
            height: 320px; /* Fixed height for the notice container */
            overflow-y: auto; /* Enable vertical scrolling */
        }
        .notice-row {
            border: 1px solid #ddd;
            margin-bottom: 1rem;
            border-radius: 0.5rem;
            background-color: #fff;
            display: flex;
            flex-direction: column;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }
        .notice-row:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }
        .notice-header {
            background-color: #0056b3;
            color: #fff;
            padding: 0.75rem;
            border-radius: 0.5rem 0.5rem 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .notice-header h5 {
            margin: 0;
            font-size: 1.25rem;
        }
        .notice-content {
            padding: 1rem;
            flex: 1;
            color: #333;
        }
        .notice-footer {
            padding: 0.75rem;
            text-align: right;
            background-color: #f8f9fa;
            border-radius: 0 0 0.5rem 0.5rem;
        }
        .btn-custom {
            background-color: #0056b3;
            color: #fff;
        }
        .btn-custom:hover {
            background-color: #003d7a;
        }
        .btn-outline-custom {
            color: #0056b3;
            border-color: #0056b3;
        }
        .btn-outline-custom:hover {
            background-color: #0056b3;
            color: #fff;
        }
        .no-notices {
            text-align: center;
            padding: 2rem;
            color: #6c757d;
        }
        .date {
            font-size: 0.875rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
<div class="position-relative" style="background-color: #3333;">
    <?php include('../include/dash_header.php'); ?>
    <button class="openbtn position-absolute top-0 start-0" onclick="toggleSidebar()">☰</button>
    <div id="sidebar-container"></div>
    <div class="main">
        <div class="container bg-light p-4 rounded shadow border mt-2">
            <h1 class="mb-2"><i class="fas fa-bullhorn"></i> Notices</h1>
            <a href="post_notice.php" class="btn btn-secondary mb-3"><i class="fas fa-plus"></i> Post a Notice</a>
            
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <h4 class="mb-3">Public Notices</h4>
                    <div class="notice-container">
                        <?php if ($public_notices): ?>
                            <?php foreach ($public_notices as $notice): ?>
                                <div class="notice-row">
                                    <div class="notice-header">
                                        <h5><?php echo htmlspecialchars($notice['title']); ?></h5>
                                        <p class="date text-light"><?php echo date('d/m/Y', strtotime($notice['post_date'])); ?></p>
                                    </div>
                                    <div class="notice-content">
                                        <p><?php echo htmlspecialchars($notice['content']); ?></p>
                                    </div>
                                    <div class="notice-footer">
                                        <a href="notice_view.php?id=<?php echo $notice['id']; ?>" class="btn btn-outline-custom">View</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="no-notices">
                                <p>No public notices found.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <h4 class="mb-3">Private Notices</h4>
                    <div class="notice-container">
                        <?php if ($private_notices): ?>
                            <?php foreach ($private_notices as $notice): ?>
                                <div class="notice-row">
                                    <div class="notice-header">
                                        <h5><?php echo htmlspecialchars($notice['title']); ?></h5>
                                        <p class="date text-light"><?php echo date('d/m/Y', strtotime($notice['post_date'])); ?></p>
                                    </div>
                                    <div class="notice-content">
                                        <p><?php echo htmlspecialchars($notice['content']); ?></p>
                                    </div>
                                    <div class="notice-footer">
                                        <a href="notice_view.php?id=<?php echo $notice['id']; ?>" class="btn btn-outline-custom">View</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="no-notices">
                                <p>No private notices found.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/script.js"></script>
</body>
</html>
