<?php
session_start();
include("connect.php");

// Admin login functionality
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_login'])) {
    $admin_name = $_POST['admin_name'];
    $admin_password = $_POST['admin_password'];

    // Fetch the hashed password from the database
    $query = "SELECT password FROM admin WHERE name = '$admin_name'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];

        if (password_verify($admin_password, $hashed_password)) {
            $_SESSION['admin_logged_in'] = true;
            header("Location: dashboard.php"); // Redirect to the admin dashboard
            exit();
        } else {
            $error_message = "Invalid password!";
        }
    } else {
        $error_message = "Admin not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="admin-login">
        <h2>Admin Login</h2>
        <form method="post" action="">
            <label for="admin_name">Admin Name:</label>
            <input type="text" id="admin_name" name="admin_name" required><br><br>

            <label for="admin_password">Password:</label>
            <input type="password" id="admin_password" name="admin_password" required><br><br>

            <button type="submit" name="admin_login">Login</button>
        </form>
        <?php if (isset($error_message)) { echo "<p>$error_message</p>"; } ?>
    </div>
</body>
</html>
