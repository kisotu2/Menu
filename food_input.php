<?php
session_start();
include("connect.php");

// Ensure the user is logged in
if (!isset($_SESSION['user_name']) || !isset($_SESSION['profile_image']) || !isset($_SESSION['hotel_id'])) {
    header("Location: user_login.php"); // Redirect to login if not logged in
    exit();
}

// Handle food item addition
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_food'])) {
        $food_name = $_POST['food_name'];
        $ingredients = $_POST['ingredients'];
        $amount = $_POST['amount'];
        $category = $_POST['category'];
        $hotel_id = $_SESSION['hotel_id']; 

        // Handle food image upload
        $food_image = $_FILES['food_image']['name'];
        $target_dir = "Photos/";
        $target_file = $target_dir . basename($food_image);
        move_uploaded_file($_FILES['food_image']['tmp_name'], $target_file);

        // Insert the food item into the database
        $query = "INSERT INTO food (Name, Ingredients, amount, category, file_name, hotel_id) 
                  VALUES ('$food_name', '$ingredients', '$amount', '$category', '$food_image', '$hotel_id')";
        
        if (mysqli_query($conn, $query)) {
            echo "Food item added successfully!";
        } else {
            echo "Failed to add food item!";
        }
    } elseif (isset($_POST['delete_food'])) {
        $id = $_POST['id'];
        $query = "DELETE FROM food WHERE id='$id' AND hotel_id='{$_SESSION['hotel_id']}'";
        if (mysqli_query($conn, $query)) {
            echo "Food item deleted successfully!";
        } else {
            echo "Failed to delete food item!";
        }
    } elseif (isset($_POST['edit_food'])) {
        $id = $_POST['id'];
        $food_name = $_POST['food_name'];
        $ingredients = $_POST['ingredients'];
        $amount = $_POST['amount'];
        $category = $_POST['category'];

        $query = "UPDATE food SET Name='$food_name', Ingredients='$ingredients', amount='$amount', category='$category' 
                  WHERE id='$id' AND hotel_id='{$_SESSION['hotel_id']}'";
        if (mysqli_query($conn, $query)) {
            echo "Food item updated successfully!";
        } else {
            echo "Failed to update food item!";
        }
    }
}

// Fetch food data from the database, only for the logged-in user's hotel
$hotel_id = $_SESSION['hotel_id'];
$query = "SELECT * FROM food WHERE hotel_id='$hotel_id'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Food Item</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
    <div class="user-info">
        <img src="profile/<?php echo $_SESSION['profile_image']; ?>" alt="Profile Image" width="50">
        <p>Welcome, <?php echo $_SESSION['user_name']; ?></p>
        <a class="logout" href="logout.php" style="color: red;">Logout</a>
    </div>
</header>

<h2>Add Food Item</h2>
<form method="post" action="" enctype="multipart/form-data">
    <label for="food_name">Food Name:</label>
    <input type="text" id="food_name" name="food_name" required><br><br>

    <label for="ingredients">Ingredients:</label>
    <input type="text" id="ingredients" name="ingredients" required><br><br>

    <label for="amount">Amount:</label>
    <input type="text" id="amount" name="amount" required><br><br>

    <label for="category">Category:</label>
    <input type="text" id="category" name="category" required><br><br>

    <label for="food_image">Food Image:</label>
    <input type="file" id="food_image" name="food_image" required><br><br>

    <button type="submit" name="add_food">Add Food</button>
</form>

<h2>Food Items</h2>
<table border="1">
    <tr>
        <th>Name</th>
        <th>Ingredients</th>
        <th>Amount</th>
        <th>Category</th>
        <th>Image</th>
        <th>Actions</th>
    </tr>
    <?php 
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $name = $row['Name'];
            $ingredients = $row['Ingredients'];
            $amount = $row['amount'];
            $category = $row['category'];
            $file_name = $row['file_name'];
            $image_url = "Photos/" . $file_name;
            
            echo "<tr>";
            echo "<td>$name</td>";
            echo "<td>$ingredients</td>";
            echo "<td>$$amount</td>";
            echo "<td>$category</td>";
            echo "<td><img src='$image_url' alt='$name' style='width:100px;height:100px;'></td>";
            echo "<td>
                    <form method='post' action='' style='display:inline-block;'>
                        <input type='hidden' name='id' value='$id'>
                        <button type='submit' name='delete_food'>Delete</button>
                    </form>
                    <form method='post' action='edit_food.php' style='display:inline-block;'>
                        <input type='hidden' name='id' value='$id'>
                        <input type='hidden' name='food_name' value='$name'>
                        <input type='hidden' name='ingredients' value='$ingredients'>
                        <input type='hidden' name='amount' value='$amount'>
                        <input type='hidden' name='category' value='$category'>
                        <button type='submit' name='edit_food'>Edit</button>
                    </form>
                  </td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No food items found.</td></tr>";
    }
    ?>
</table>

</body>
</html>
