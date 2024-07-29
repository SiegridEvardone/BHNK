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
</head>
<body>
<div class="position-relative">
    <?php include('../include/dash_header.php'); ?>
    <button class="openbtn position-absolute top-0 start-0" onclick="toggleSidebar()">☰</button>
    <div id="sidebar-container"></div>
    <div class="main"> 
    <div class="container bg-light p-3">
                    <h1 class="mb-4"><i class="fas fa-circle-exclamation"></i> Complaints</h1>

                    <div class="container text-center p-0">
                        <div class="row border" style="background-color: #D3D3D3;">
                            <!-- Table headers -->
                            <div class="col-sm-1 p-2">
                                <p class="fw-bold m-0">Room #</p>
                            </div>
                            <div class="col p-2">
                                <p class="fw-bold m-0">Tenant Name</p>
                            </div>
                            <div class="col p-2">
                                <p class="fw-bold m-0">Complaint/Suggestions</p>
                            </div>
                            <div class="col p-2">
                                <p class="fw-bold m-0">Date</p>
                            </div>
                            <div class="col p-2">
                                <p class="fw-bold m-0">Reply from owner</p>
                            </div>
                            <div class="col p-2">
                                <p class="fw-bold m-0">Status</p>
                            </div>
                            <div class="col-sm-1 p-2">
                                <p class="fw-bold m-0">Action</p>
                            </div>
                        </div>
                    </div>

                    <div class="container text-center p-0 overflow-y-auto mb-4" style="height: 350px; overflow-x: hidden;">
                        <?php if ($result->num_rows > 0): ?>
                            <!-- Loop through complaints data and display each complaint -->
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <div class="row bg-light border">
                                    <!-- Room number -->
                                    <div class="col-sm-1 p-2 border-end">
                                        <p><?php echo htmlspecialchars($row['room_number']); ?></p>
                                    </div>
                                    <!-- Tenant name -->
                                    <div class="col p-2 border-end">
                                        <p><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></p>
                                    </div>
                                    <!-- Complaint/Suggestions -->
                                    <div class="col p-2 border-end">
                                        <p><?php echo htmlspecialchars($row['title']); ?></p>
                                    </div>
                                    <!-- Date -->
                                    <div class="col p-2 border-end">
                                        <p><?php echo htmlspecialchars($row['formatted_date']); ?></p>
                                    </div>
                                    <!-- Reply from owner -->
                                    <div class="col p-2 border-end" style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        <p><?php echo htmlspecialchars($row['reply']); ?></p>
                                    </div>
                                    <!-- Status -->
                                    <div class="col p-2 border-end">
                                      <p class="p-0" style="background-color: <?php echo (strtolower($row['status']) == 'pending') ? '#fc5d5d' : '#8ef078'; ?>; padding: 5px; border-radius: 5px;">
                                          <?php echo htmlspecialchars($row['status']); ?>
                                      </p>
                                    </div>


                                    <!-- Action (View Complaint button) -->
                                    <div class="col-sm-1 p-2 border-end">
                                        <a href="complaints_view.php?id=<?php echo $row['id']; ?>" class="btn btn-primary"><i class="fas fa-eye"></i></a>
                                    </div>

                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <!-- No complaints found -->
                            <div class="row bg-light border">
                                <div class="col p-2">
                                    <p class="fw-normal fst-italic">No complaints found.</p>
                                </div>
                            </div>
                        <?php endif; ?>
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
