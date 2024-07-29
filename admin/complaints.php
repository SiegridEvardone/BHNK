<?php
// Start output buffering
ob_start();
session_start();

// Include database connection
include('../include/connection.php');

// Fetch complaints data from the database
$sql = "
    SELECT 
        c.id, 
        c.title, 
        c.content, 
        DATE_FORMAT(c.date_submitted, '%m-%d-%Y') AS formatted_date, 
        c.status, 
        COALESCE(c.admin_response, 'N/A') AS reply,
        u.first_name, 
        u.last_name,
        r.room_number
    FROM tblcomplaints c
    JOIN tbltenant b ON c.tenant_id = b.user_id
    JOIN tbluser u ON b.user_id = u.user_id
    JOIN tblrooms r ON b.room_id = r.id
    ORDER BY FIELD(c.status, 'Pending', 'Solved'), c.date_submitted DESC
";

$result = $conn->query($sql);

if (!$result) {
    // Handle query execution error
    echo "Error executing query: " . $conn->error;
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaints</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 2rem;
        }
        .header-icon {
            margin-right: 0.5rem;
        }
        .status-pending {
            background-color: #fc5d5d;
            color: #fff;
            padding: 3px 8px;
            border-radius: 5px;
        }
        .status-solved {
            background-color: #8ef078;
            color: #fff;
            padding: 3px 8px;
            border-radius: 5px;
        }
        .ellipsis {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .action-btn {
            width: 100%;
        }
        @media (max-width: 768px) {
            .container {
                margin-top: 1rem;
            }
            .header-icon {
                margin-right: 0.25rem;
            }
        }
    </style>
</head>
<body>
<div class="position-relative">
    <?php include('../include/dash_header.php'); ?>
    <button class="openbtn position-absolute top-0 start-0" onclick="toggleSidebar()">☰</button>
    <div id="sidebar-container"></div>
    <div class="main">
        <div class="container bg-light p-3">
            <h1 class="mb-4"><i class="fas fa-circle-exclamation header-icon"></i> Complaints</h1>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Room #</th>
                            <th>Tenant Name</th>
                            <th>Complaint/Suggestions</th>
                            <th>Date</th>
                            <th>Reply from Owner</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <!-- Loop through complaints data and display each complaint -->
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <!-- Room number -->
                                    <td><?php echo htmlspecialchars($row['room_number']); ?></td>
                                    <!-- Tenant name -->
                                    <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                                    <!-- Complaint/Suggestions -->
                                    <td class="ellipsis"><?php echo htmlspecialchars($row['title']); ?></td>
                                    <!-- Date -->
                                    <td><?php echo htmlspecialchars($row['formatted_date']); ?></td>
                                    <!-- Reply from owner -->
                                    <td class="ellipsis"><?php echo htmlspecialchars($row['reply']); ?></td>
                                    <!-- Status -->
                                    <td>
                                        <span class="<?php echo strtolower($row['status']) == 'pending' ? 'status-pending' : 'status-solved'; ?>">
                                            <?php echo htmlspecialchars($row['status']); ?>
                                        </span>
                                    </td>
                                    <!-- Action (View Complaint button) -->
                                    <td>
                                        <a href="complaints_view.php?id=<?php echo $row['id']; ?>" class="btn btn-primary action-btn"><i class="fas fa-eye"></i></a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <!-- No complaints found -->
                            <tr>
                                <td colspan="7" class="text-center">No complaints found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="../assets/js/script.js"></script>
</body>
</html>

<?php
// Close database connection and buffer
$conn->close();
ob_end_flush();
?>
