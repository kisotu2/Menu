<?php
session_start();
include("connect.php");

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit;
}

// Handle hotel deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $query = "DELETE FROM hotels WHERE id = $delete_id";
    if (mysqli_query($conn, $query)) {
        $success_message = "Hotel deleted successfully!";
    } else {
        $error_message = "Failed to delete hotel!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Registered Hotels</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h3>Registered Hotels</h3>
    <?php if (isset($success_message)) { echo "<p>$success_message</p>"; } ?>
    <?php if (isset($error_message)) { echo "<p>$error_message</p>"; } ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Location</th>
            <th>Contact Info</th>
            <th>Actions</th>
        </tr>
        <?php
        $query = "SELECT * FROM hotels";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['location']}</td>
                    <td>{$row['contact_info']}</td>
                    <td>
                        <button onclick=\"window.location.href='view_workers.php?hotel_id={$row['id']}'\">Details</button>
                        <button onclick=\"window.location.href='view_hotels.php?delete_id={$row['id']}'\" 
                        onclick=\"return confirm('Are you sure you want to delete this hotel?');\">Delete</button>
                    </td>
                  </tr>";
        }
        ?>
    </table>
</body>
</html>
