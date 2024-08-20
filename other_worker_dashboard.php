<?php
session_start();

// Ensure the user is logged in and is not a chef
if (!isset($_SESSION['user_name']) || $_SESSION['role'] === 'cheff') {
    header("Location: user_login.php");
    exit();
}

// Include database connection
include("connect.php");

// Fetch user details
$user_name = $_SESSION['user_name'];
$profile_image = $_SESSION['profile_image'];
$hotel_id = $_SESSION['hotel_id'];

// Fetch hotel details
$hotel_query = "SELECT name FROM hotels WHERE id='$hotel_id'";
$hotel_result = mysqli_query($conn, $hotel_query);
$hotel = mysqli_fetch_assoc($hotel_result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Other Worker Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h2>Welcome, <?php echo $user_name; ?></h2>

<div class="profile-section">
    <h3>Your Profile</h3>
    <img src="profile/<?php echo $profile_image; ?>" alt="Profile Image" width="150" height="150"><br><br>
    <p><strong>Name:</strong> <?php echo $user_name; ?></p>
    <p><strong>Hotel:</strong> <?php echo $hotel['name']; ?></p>
</div>

<div class="actions-section">
    <h3>Your Dashboard</h3>
    <ul>
        <li><a href="update_profile.php">Update Profile</a></li>
        <li><a href="view_tasks.php">View Tasks</a></li>
        <!-- Add more features or links as needed -->
    </ul>
</div>

<p><a href="logout.php">Logout</a></p>

</body>
</html>
