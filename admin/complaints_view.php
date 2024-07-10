<?php
session_start();
include('../include/connection.php');

// Check if the admin is logged in and has the correct role
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../adminlogin.php");
    exit();
}

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
            b.room_id 
        FROM tblcomplaints c 
        JOIN tbltenant b ON c.tenant_id = b.user_id 
        JOIN tbluser u ON b.user_id = u.user_id 
        WHERE c.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $complaint_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if complaint exists
if ($result->num_rows === 0) {
    echo "No complaint found!";
    exit();
}

$complaint = $result->fetch_assoc();
$stmt->close();

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Submit reply form
    if (isset($_POST["reply"])) {
        $reply = $_POST["reply"];

        // Update the complaint with admin's response
        $update_sql = "UPDATE tblcomplaints SET admin_response = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("si", $reply, $complaint_id);
        $update_stmt->execute();
        $update_stmt->close();

        // Redirect back to the same page after update
        header("Location: complaints_view.php?id=" . $complaint_id);
        exit();
    }

    // Change status form
    if (isset($_POST["status"])) {
        $new_status = $_POST["status"];

        // Update the complaint status
        $update_status_sql = "UPDATE tblcomplaints SET status = ? WHERE id = ?";
        $update_status_stmt = $conn->prepare($update_status_sql);
        $update_status_stmt->bind_param("si", $new_status, $complaint_id);
        $update_status_stmt->execute();
        $update_status_stmt->close();

        // Redirect back to the same page after update
        header("Location: complaints_view.php?id=" . $complaint_id);
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
</head>
<body>
    <?php include('../include/dash_header.php'); ?>
    <div class="container-fluid">
        <div class="row">
            <?php include('sidenav.php'); ?> 
            <main class="col-12 col-md-5 ms-sm-auto col-lg-10 px-md-3 py-md-3">
                <div class="container bg-light p-3" style="height: 510px;">
                    <div class="border border-dark p-4 mx-auto" style="max-width: 80%;">
                        <div class="row">
                            <div class="col">
                                <p><strong>Date:</strong> <?php echo htmlspecialchars(date('F d, Y', strtotime($complaint['date_submitted']))); ?></p>
                                <h4>Title: <?php echo htmlspecialchars($complaint['title']); ?></h4>
                                <h5>Content: <?php echo htmlspecialchars($complaint['content']); ?></h5>
                                <p><strong>Tenant Name:</strong> <?php echo htmlspecialchars($complaint['first_name'] . ' ' . $complaint['last_name']); ?></p>
                                <p><strong>Room Number:</strong> <?php echo htmlspecialchars($complaint['room_id']); ?></p>
                                <p><strong>Reply from owner:</strong> <?php echo htmlspecialchars($complaint['reply']); ?></p>
                                <p><strong>Status:</strong> <?php echo htmlspecialchars($complaint['status']); ?></p>
                            </div>
                            <div class="col">
                                <!-- Form for submitting reply -->
                                <form method="post" action="">
                                    <div class="form-group">
                                        <label for="reply">Reply:</label>
                                        <textarea class="form-control" id="reply" name="reply" rows="2"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="submit_reply">Submit Reply</button>
                                </form>
                                <hr>
                                <!-- Form for changing status -->
                                <form method="post" action="">
                                    <div class="form-group">
                                        <label for="status">Change Status:</label>
                                        <select class="form-control" id="status" name="status">
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
            </main>
        </div>
    </div>
</body>
</html>
