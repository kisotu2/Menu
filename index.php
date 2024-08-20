<?php
session_start();
include("connect.php");

// Admin login functionality
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_login'])) {
    $admin_password = $_POST['admin_password'];

    // Hashed password for "kisotu"
    $hashed_password = '$2y$10$E1mFG7md.a0/hgQ6PPlQwe9CQ1Q/3/2K/u9k/U9Oba.yHi9u6Wxy.'; 
    
    if (password_verify($admin_password, $hashed_password)) {
        $_SESSION['admin_logged_in'] = true;
    } else {
        $error_message = "Invalid password!";
    }
}

// Hotel registration functionality
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_hotel'])) {
    $hotel_name = $_POST['hotel_name'];
    $location = $_POST['location'];
    $contact_info = $_POST['contact_info'];

    $query = "INSERT INTO hotels (name, location, contact_info) VALUES ('$hotel_name', '$location', '$contact_info')";
    if (mysqli_query($conn, $query)) {
        header("Location: register_user.php");
    } else {
        $error_message = "Failed to register hotel!";
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

<?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
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

        <?php if (isset($error_message)) { echo "<p>$error_message</p>"; } ?>

        <h3>Registered Hotels</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Location</th>
                <th>Contact Info</th>
            </tr>
            <?php
            $query = "SELECT * FROM hotels";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr><td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['location']}</td><td>{$row['contact_info']}</td></tr>";
            }
            ?>
        </table>
    </div>

<?php else: ?>
    <div class="admin-login">
        <h2>Admin Login</h2>
        <form method="post" action="">
            <label for="admin_password">Admin Password:</label>
            <input type="password" id="admin_password" name="admin_password" required><br><br>

            <button type="submit" name="admin_login">Login</button>
        </form>
        <?php if (isset($error_message)) { echo "<p>$error_message</p>"; } ?>
    </div>
<?php endif; ?>

</body>
</html>
