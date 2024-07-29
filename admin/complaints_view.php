<?php
session_start();
include('../include/connection.php');

// Get the complaint ID from the URL
if (!isset($_GET['id'])) {
    header("Location: complaints.php");
    exit();
}

$complaint_id = intval($_GET['id']);

// Fetch the complaint details
$sql = "SELECT 
            c.id, 
            c.title, 
            c.content, 
            c.date_submitted, 
            c.status, 
            COALESCE(c.admin_response, 'N/A') AS reply, 
            u.first_name, 
            u.last_name, 
            r.room_number 
        FROM tblcomplaints c 
        LEFT JOIN tbltenant b ON c.tenant_id = b.user_id 
        LEFT JOIN tbluser u ON b.user_id = u.user_id 
        LEFT JOIN tblrooms r ON b.room_id = r.id
        WHERE c.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $complaint_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if complaint exists
if ($result->num_rows === 0) {
    echo "<p class='alert alert-warning'>No complaint found!</p>";
    exit();
}

$complaint = $result->fetch_assoc();
$stmt->close();

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Submit reply form
    if (isset($_POST["submit_reply"])) {
        $reply = $_POST["reply"];

        // Update the complaint with admin's response
        $update_sql = "UPDATE tblcomplaints SET admin_response = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("si", $reply, $complaint_id);
        $update_stmt->execute();
        $update_stmt->close();

        // Redirect back to the same page after update
        header("Location: complaints_view.php?id=" . $complaint_id . "&success=reply");
        exit();
    }

    // Change status form
    if (isset($_POST["submit_status"])) {
        $new_status = $_POST["status"];

        // Update the complaint status
        $update_status_sql = "UPDATE tblcomplaints SET status = ? WHERE id = ?";
        $update_status_stmt = $conn->prepare($update_status_sql);
        $update_status_stmt->bind_param("si", $new_status, $complaint_id);
        $update_status_stmt->execute();
        $update_status_stmt->close();

        // Redirect back to the same page after update
        header("Location: complaints_view.php?id=" . $complaint_id . "&success=status");
        exit();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint View</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 2rem;
        }
        .form-container {
            max-width: 100%;
        }
        .form-group textarea {
            resize: vertical;
        }
        .btn-custom {
            background-color: #007bff;
            color: #fff;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        .highlight {
            background-color: #e9ecef;
            padding: 1rem;
            border-radius: 0.375rem;
        }
    </style>
</head>
<body>
<div class="position-relative">
    <?php include('../include/dash_header.php'); ?>
    <button class="openbtn position-absolute top-0 start-0" onclick="toggleSidebar()">☰</button>
    <div id="sidebar-container"></div>
    <div class="main">
        <div class="container bg-light p-4 border rounded shadow">
            <?php if (isset($_GET['success']) && $_GET['success'] === 'reply'): ?>
                <div class="alert alert-success">Reply submitted successfully.</div>
            <?php elseif (isset($_GET['success']) && $_GET['success'] === 'status'): ?>
                <div class="alert alert-success">Status updated successfully.</div>
            <?php endif; ?>
            <div class="row">
                <div class="col-lg-6">
                    <h4>Complaint Details</h4>
                    <div class="highlight">
                        <p><strong>Date:</strong> <?php echo htmlspecialchars(date('F d, Y', strtotime($complaint['date_submitted']))); ?></p>
                        <p><strong>Title:</strong> <?php echo htmlspecialchars($complaint['title']); ?></p>
                        <p><strong>Content:</strong> <?php echo htmlspecialchars($complaint['content']); ?></p>
                        <p><strong>Tenant Name:</strong> <?php echo htmlspecialchars($complaint['first_name'] . ' ' . $complaint['last_name']); ?></p>
                        <p><strong>Room Number:</strong> <?php echo htmlspecialchars($complaint['room_number']); ?></p>
                        <p><strong>Reply from Owner:</strong> <?php echo htmlspecialchars($complaint['reply']); ?></p>
                        <p><strong>Status:</strong> <?php echo htmlspecialchars($complaint['status']); ?></p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h4>Actions</h4>
                    <!-- Form for submitting reply -->
                    <form method="post" action="" class="form-container">
                        <div class="form-group">
                            <label for="reply">Reply:</label>
                            <textarea class="form-control" id="reply" name="reply" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="submit_reply">Submit Reply</button>
                    </form>
                    <hr>
                    <!-- Form for changing status -->
                    <form method="post" action="" class="form-container">
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="Pending" <?php echo ($complaint['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                <option value="Solved" <?php echo ($complaint['status'] == 'Solved') ? 'selected' : ''; ?>>Solved</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" name="submit_status">Change Status</button>
                    </form>
                </div>
            </div>
            <hr>
            <a href="complaints.php" class="btn btn-success">Back to Complaints</a>
        </div>
    </div>
    <script src="../assets/js/script.js"></script>
</body>
</html>
