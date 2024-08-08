<?php
session_start();
ob_start();

// Include database connection
include('../include/connection.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Fetch the user's complaints
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
    WHERE c.tenant_id = ?
    ORDER BY FIELD(c.status, 'Pending', 'Solved'), c.date_submitted DESC
";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $complaints = [];
    while ($row = $result->fetch_assoc()) {
        // Handle cases where first_name or last_name might be NULL
        $row['first_name'] = $row['first_name'] ?? 'Unknown';
        $row['last_name'] = $row['last_name'] ?? '';

        $complaints[] = $row;
    }

    $stmt->close();
} else {
    die("Error preparing statement: " . $conn->error);
}

$conn->close();
ob_end_clean();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Complaints</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="path/to/fontawesome/css/all.css"> <!-- Ensure FontAwesome CSS is included -->
    <!-- Add your custom styles here -->
     <style>
      .table-container {
            overflow-x: auto;
        }
        .table th, .table td {
            white-space: nowrap;
        }
        .status-pending {
            background-color: #fc5d5d;
            color: white;
            padding: 5px;
            border-radius: 3px;
        }
        .status-resolved {
            background-color: #8ef078;
            color: black;
            padding: 5px;
            border-radius: 3px;
        }
     </style>
</head>
<body>
  <div class="position-relative">
    <?php include('../include/dash_header.php'); ?>
    <button class="openbtn position-absolute top-0 start-0" onclick="toggleSidebar()">☰</button>
    <div id="sidebar-container"></div>
    <div class="main">
        <div class="container border bg-light p-3">
            <h1 class="mb-2"><i class="fa-solid fa-circle-exclamation"></i> Complaints</h1>
            <a href="submit_complaint.php" class="btn btn-success m-2"><i class="fa-solid fa-plus"></i> Submit Complaint</a>
            <div class="table-container">
                <table class="table table-bordered table-striped">
                    <thead style="background-color: #D3D3D3;">
                        <tr>
                            <th scope="col">Room #</th>
                            <th scope="col">Tenant Name</th>
                            <th scope="col">Complaint/Suggestions</th>
                            <th scope="col">Date</th>
                            <th scope="col">Reply from Owner</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($complaints)): ?>
                        <?php foreach ($complaints as $complaint): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($complaint['room_number']); ?></td>
                            <td><?php echo htmlspecialchars($complaint['first_name'] . ' ' . $complaint['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($complaint['title']); ?></td>
                            <td><?php echo htmlspecialchars($complaint['formatted_date']); ?></td>
                            <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;"><?php echo htmlspecialchars($complaint['reply']); ?></td>
                            <td><span class="<?php echo ($complaint['status'] == 'pending') ? 'status-pending' : 'status-resolved'; ?>"><?php echo htmlspecialchars($complaint['status']); ?></span></td>
                            <td><a href="ucomplaints_view.php?id=<?php echo $complaint['id']; ?>" class="btn btn-primary"><i class="fa-solid fa-eye"></i></a></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center fst-italic">No complaints found.</td>
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
