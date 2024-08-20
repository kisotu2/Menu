<?php
session_start();
include("connect.php");

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_hotel'])) {
    $hotel_name = $_POST['hotel_name'];
    $location = $_POST['location'];
    $contact_info = $_POST['contact_info'];

    // Check if the hotel with the same name and location already exists
    $query = "SELECT * FROM hotels WHERE name = '$hotel_name' AND location = '$location'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $error_message = "Hotel with the same name and location already registered!";
    } else {
        $query = "INSERT INTO hotels (name, location, contact_info) VALUES ('$hotel_name', '$location', '$contact_info')";
        if (mysqli_query($conn, $query)) {
            header("Location: view_hotels.php");
        } else {
            $error_message = "Failed to register hotel!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Hotel</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h3>Register a Hotel</h3>
    <form method="post" action="">
        <label for="hotel_name">Hotel Name:</label>
        <input type="text" id="hotel_name" name="hotel_name" required><br><br>

        <label for="location">Location:</label>
        <input type="text" id="location" name="location" required><br><br>

        <label for="contact_info">Contact Information:</label>
        <input type="text" id="contact_info" name="contact_info" required><br><br>

        <button type="submit" name="register_hotel">Register Hotel</button>
    </form>
    <?php if (isset($error_message)) { echo "<p>$error_message</p>"; } ?>
</body>
</html>
