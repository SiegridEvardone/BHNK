<?php
session_start();

function check_admin_login() {
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        // Redirect to login page if not logged in
        header("Location: ../login.php");
        exit();
    }
}
?>
