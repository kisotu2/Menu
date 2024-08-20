<?php
session_start();
include("connect.php");

// Fetch all hotels for the drop-down menu
$hotel_query = "SELECT id, name FROM hotels";
$hotel_result = mysqli_query($conn, $hotel_query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $id_number = $_POST['id_number'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $hotel_id = $_POST['hotel_id'];
    $role = $_POST['role'];

    // Check if the user already exists
    $check_query = "SELECT * FROM users WHERE email='$email' OR id_number='$id_number'";
    $result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($result) > 0) {
        // User already exists, redirect to login page
        header("Location: user_login.php");
        exit();
    }

    // Handle profile image upload
    $profile_image = $_FILES['profile_image']['name'];
    $target_dir = "profile/";
    $target_file = $target_dir . basename($profile_image);
    move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file);

    // Insert user details into the database
    $query = "INSERT INTO users (name, email, id_number, password, profile_image, hotel_id, role) 
              VALUES ('$name', '$email', '$id_number', '$password', '$profile_image', '$hotel_id', '$role')";

    if (mysqli_query($conn, $query)) {
        // Store user information in session
        $_SESSION['user_name'] = $name;
        $_SESSION['profile_image'] = $profile_image;
        $_SESSION['hotel_id'] = $hotel_id;

        // Redirect based on role
        if ($role === 'chef') {
            header("Location: food_input.php");
        } else {
            header("Location: other_worker_dashboard.php");
        }
        exit();
    } else {
        // Print any SQL error for debugging
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h2>Register User</h2>
<form method="post" action="" enctype="multipart/form-data">
    <label for="hotel_id">Select Hotel:</label>
    <select id="hotel_id" name="hotel_id" required>
        <?php
        while ($row = mysqli_fetch_assoc($hotel_result)) {
            echo "<option value='{$row['id']}'>{$row['name']}</option>";
        }
        ?>
    </select><br><br>

    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="id_number">ID Number:</label>
    <input type="text" id="id_number" name="id_number" required><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>

    <label for="profile_image">Profile Image:</label>
    <input type="file" id="profile_image" name="profile_image" required><br><br>

    <label for="role">Register as:</label><br>
    <input type="radio" id="chef" name="role" value="chef" required>
    <label for="chef">Chef</label><br>
    <input type="radio" id="other_worker" name="role" value="other_worker" required>
    <label for="other_worker">Other Worker</label><br><br>

    <button type="submit">Register</button>
</form>

<p>Already registered? <a href="user_login.php">Login here</a></p>

</body>
</html>
