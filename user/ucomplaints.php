<?php
session_start();
ob_start();

// Include database connection
include('../include/connection.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ulogin.php");
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
        b.room_id
    FROM tblcomplaints c
    JOIN tbltenant b ON c.tenant_id = b.user_id
    JOIN tbluser u ON b.user_id = u.user_id
    WHERE c.tenant_id = ?
    ORDER BY FIELD(c.status, 'Pending', 'Solved'), c.date_submitted DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$complaints = [];
while ($row = $result->fetch_assoc()) {
    // Format the date
    $date = new DateTime($row['date_submitted']);
    $row['formatted_date'] = $date->format('m/d/Y'); // Change format as needed

    // Handle cases where first_name or last_name might be NULL
    $row['first_name'] = isset($row['first_name']) ? $row['first_name'] : 'Unknown';
    $row['last_name'] = isset($row['last_name']) ? $row['last_name'] : '';

    $complaints[] = $row;
}

$stmt->close();
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
    <!-- Add your custom styles here -->
</head>
<body>
    <?php include('../include/dash_header.php'); ?>
    <div class="container-fluid">
        <div class="row">
            <?php include('sidenav.php'); ?> 
            <main class="col-12 col-md-5 ms-sm-auto col-lg-10 px-md- py-md-3">
                <div class="container bg-light p-3">
                    <h1 class="mb-2"><i class="fa-solid fa-circle-exclamation"></i> Complaints</h1>
                
                    <a href="submit_complaint.php" class="btn btn-success m-2"><i class="fa-solid fa-plus"></i> Submit Complaint</a>
                    <div class="container text-center p-0">
                        <div class="row border" style="background-color: #D3D3D3;">
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
                                <p class="fw-bold m-0">Reply from Owner</p>
                            </div>
                            <div class="col p-2">
                                <p class="fw-bold m-0">Status</p>
                            </div>
                            <div class="col-sm-1 p-2">
                                <p class="fw-bold m-0">Action</p>
                            </div>
                        </div>
                    </div>
                    <div class="container text-center p-0 overflow-y-auto" style="height: 330px; overflow-x: hidden;">
                        <?php if (!empty($complaints)): ?>
                            <?php foreach ($complaints as $complaint): ?>
                                <div class="row bg-light border">
                                    <div class="col-sm-1 p-2 border-end">
                                        <p class="mb-0"><?php echo htmlspecialchars($complaint['room_id']); ?></p>
                                    </div>
                                    <div class="col p-2 border-end">
                                        <p class="mb-0"><?php echo htmlspecialchars($complaint['first_name'] . ' ' . $complaint['last_name']); ?></p>
                                    </div>
                                    <div class="col p-2 border-end">
                                        <p class="mb-0"><?php echo htmlspecialchars($complaint['title']); ?></p>
                                    </div>
                                    <div class="col p-2 border-end">
                                        <p class="mb-0"><?php echo htmlspecialchars($complaint['formatted_date']); ?></p>
                                    </div>
                                    <div class="col p-2 border-end" style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        <p class="mb-0"><?php echo htmlspecialchars($complaint['reply']); ?></p>
                                    </div>
                                    <div class="col p-2 border-end">
                                    <p style="background-color: <?php echo ($complaint['status'] == 'pending') ? '#fc5d5d' : '#8ef078'; ?>"><?php echo htmlspecialchars($complaint['status']); ?></p>
                                    </div>
                                    <div class="col-sm-1 p-2 border-end">
                                        <a href="ucomplaints_view.php?id=<?php echo $complaint['id']; ?>" class="btn btn-primary"><i class="fa-solid fa-eye"></i></a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="row bg-light border">
                                <div class="col p-2">
                                    <p class="fw-normal fst-italic">No complaints found.</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>