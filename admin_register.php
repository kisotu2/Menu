<?php
session_start();
include("connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_admin'])) {
    $admin_name = $_POST['admin_name'];
    $admin_password = $_POST['admin_password'];

    // Check if the admin is already registered
    $check_query = "SELECT * FROM admin WHERE name = '$admin_name'";
    $result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($result) > 0) {
        // Admin is already registered
        $error_message = "Admin already registered! Please log in.";
    } else {
        // Hash the password before storing it
        $hashed_password = password_hash($admin_password, PASSWORD_BCRYPT);

        // Insert the admin details into the admin table
        $query = "INSERT INTO admin (name, password) VALUES ('$admin_name', '$hashed_password')";
        if (mysqli_query($conn, $query)) {
            // Redirect to the next page after successful admin registration
            header("Location: index.php");
            exit();
        } else {
            $error_message = "Failed to register admin!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="admin-register">
        <h2>Admin Registration</h2>
        <form method="post" action="">
            <label for="admin_name">Admin Name:</label>
            <input type="text" id="admin_name" name="admin_name" required><br><br>

            <label for="admin_password">Password:</label>
            <input type="password" id="admin_password" name="admin_password" required><br><br>

            <button type="submit" name="register_admin">Register Admin</button>
        </form>

        <?php 
        if (isset($error_message)) { echo "<p>$error_message</p>"; } 
        ?>

        <!-- Add a login button for already registered admins -->
        <p>Already registered? <a href="admin_login.php">Login here</a></p>
    </div>
</body>
</html>
