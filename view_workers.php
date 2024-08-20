<?php
session_start();
include("connect.php");

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit;
}

$hotel_id = $_GET['hotel_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Workers</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h3>Workers of Hotel ID: <?php echo $hotel_id; ?></h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>ID Number</th>
            <th>Profile Image</th>
        </tr>
        <?php
        $query = "SELECT * FROM users WHERE hotel_id = $hotel_id";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['id_number']}</td>
                    <td><img src='{$row['profile_image']}' alt='Profile Image' width='50'></td>
                  </tr>";
        }
        ?>
    </table>
</body>
</html>
