<?php session_start();
include("connect.php");

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");  //Redirect to the login page if not logged in
    exit();
}

// Hotel registration functionality
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_hotel'])) {
    $hotel_name = $_POST['hotel_name'];
    $location = $_POST['location'];
    $contact_info = $_POST['contact_info'];

    // Check if the hotel already exists
    $check_query = "SELECT * FROM hotels WHERE name = '$hotel_name' AND location = '$location'";
    $result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($result) > 0) {
        $error_message = "Hotel already exists in this location!";
    } else {
        $query = "INSERT INTO hotels (name, location, contact_info) VALUES ('$hotel_name', '$location', '$contact_info')";
        if (mysqli_query($conn, $query)) {
            header("Location: register_user.php"); // Redirect to the user registration page
            exit();
        } else {
            $error_message = "Failed to register hotel!";
        }
    }
}

// Delete hotel functionality
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_hotel'])) {
    $hotel_id = $_POST['hotel_id'];
    $query = "DELETE FROM hotels WHERE id = '$hotel_id'";
    if (mysqli_query($conn, $query)) {
        // Redirect to the same page to refresh the list
        header("Location: admin_dashboard.php"); 
        exit();
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
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="dashboard">
    <h2>Admin Dashboard</h2>

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

    <?php if (isset($error_message)) { echo "<p style='color:red;'>$error_message</p>"; } ?>

    <h3>Registered Hotels</h3>
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
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['name']}</td>";
            echo "<td>{$row['location']}</td>";
            echo "<td>{$row['contact_info']}</td>";
            echo "<td>";
            echo "<form method='post' action='' style='display:inline-block;'>";
            echo "<input type='hidden' name='hotel_id' value='{$row['id']}'>";
            echo "<button type='submit' name='delete_hotel' onclick='return confirm(\"Are you sure you want to delete this hotel?\");'>Delete</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>

</body>
</html>
