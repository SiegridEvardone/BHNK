
<?php
ob_start();
session_start();

// Include database connection
include('../include/pdoconnect.php');

// Retrieve list of tenants
$sql = "SELECT user_id, CONCAT(first_name, ' ', last_name) AS full_name FROM tbluser";
$stmt = $pdo->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

ob_end_clean();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Post a notice</title>
</head>
<body>
<div class="position-relative">
    <?php include('../include/dash_header.php'); ?>
    <button class="openbtn position-absolute top-0 start-0" onclick="toggleSidebar()">☰</button>
    <div id="sidebar-container"></div>
    <div class="main">  
    <div class="container bg-light p-3" style="height: 510px;">
          <h1 class="mb-4"><i class="fa-solid fa-bullhorn"></i> Post a notice</h1>
          <?php
            if (isset($_SESSION['error_message'])) {
              echo "<p style='color: red;'>{$_SESSION['error_message']}</p>";
              unset($_SESSION['error_message']);
            }
          ?>
          <form action="post_notice_backend.php" method="POST" class="border p-3">
            <label for="title" class="form-label">Title:</label>
            <input type="text" id="title" name="title" class="form-control" required><br>
            <label for="content">Content:</label>
            <textarea id="content" name="content" rows="4" class="form-control" required></textarea><br>
            
            <label for="visibility">Visibility:</label>
            <select id="visibility" name="visibility">
                <option value="public">Public</option>
                <option value="private">Private</option>
            </select><br>

            <div id="recipient_user_id_input" style="display: none;">
            <label for="recipient_user_id">Recipient User:</label>
                <select id="recipient_user_id" name="recipient_user_id">
                    <?php foreach ($users as $user): ?>
                        <option value="<?php echo $user['user_id']; ?>"><?php echo $user['full_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <a href="notices.php" class="btn btn-danger mt-3">Cancel</a>
            <button class="btn btn-primary mt-3"  type="submit">Post Notice</button>
          </form>

          <script>
          document.getElementById('visibility').addEventListener('change', function() {
              if (this.value === 'private') {
                  document.getElementById('recipient_user_id_input').style.display = 'block';
              } else {
                  document.getElementById('recipient_user_id_input').style.display = 'none';
              }
          });
          </script>

        </div>
    </div>
  </div> 
  <script src="../assets/js/script.js"></script>
</body>
</html>
