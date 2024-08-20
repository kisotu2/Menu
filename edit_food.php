<?php
include("connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $food_name = $_POST['food_name'];
    $ingredients = $_POST['ingredients'];
    $amount = $_POST['amount'];
    $category = $_POST['category'];
    $food_image = $_FILES['food_image']['name'];
    
    // Check if a new image is uploaded
    if ($food_image) {
        $target_dir = "Photos/";
        $target_file = $target_dir . basename($food_image);
        move_uploaded_file($_FILES['food_image']['tmp_name'], $target_file);
        
        // Update food data including the new image
        $query = "UPDATE food SET Name='$food_name', Ingredients='$ingredients', amount='$amount', category='$category', file_name='$food_image' WHERE id='$id'";
    } else {
        // Update food data without changing the image
        $query = "UPDATE food SET Name='$food_name', Ingredients='$ingredients', amount='$amount', category='$category' WHERE id='$id'";
    }

    if (mysqli_query($conn, $query)) {
        echo "Food item updated successfully!";
    } else {
        echo "Failed to update food item!";
    }
} else {
    // Fetch the current food details
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "SELECT * FROM food WHERE id='$id'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $food_name = $row['Name'];
            $ingredients = $row['Ingredients'];
            $amount = $row['amount'];
            $category = $row['category'];
            $file_name = $row['file_name'];
        } else {
            echo "Food item not found!";
            exit();
        }
    } else {
        echo "Invalid food ID!";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Food Item</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h2>Edit Food Item</h2>
<form method="post" action="" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $id; ?>">

    <label for="food_name">Food Name:</label>
    <input type="text" id="food_name" name="food_name" value="<?php echo $food_name; ?>" required><br><br>

    <label for="ingredients">Ingredients:</label>
    <input type="text" id="ingredients" name="ingredients" value="<?php echo $ingredients; ?>" required><br><br>

    <label for="amount">Amount:</label>
    <input type="text" id="amount" name="amount" value="<?php echo $amount; ?>" required><br><br>

    <label for="category">Category:</label>
    <input type="text" id="category" name="category" value="<?php echo $category; ?>" required><br><br>

    <label for="food_image">Food Image:</label>
    <input type="file" id="food_image" name="food_image"><br><br>
    <img src="Photos/<?php echo $file_name; ?>" alt="<?php echo $food_name; ?>" style="width:100px;height:100px;"><br><br>

    <button type="submit">Update Food</button>
</form>

</body>
</html>
