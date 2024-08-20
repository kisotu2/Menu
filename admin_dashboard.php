<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard">
        <h2>Admin Dashboard</h2>

        <button onclick="window.location.href='register_hotel.php'">Register a Hotel</button>
        <button onclick="window.location.href='view_hotels.php'">View Registered Hotels</button>
    </div>
</body>
</html>
