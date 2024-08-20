<?php
include("connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    
    // Handle image upload
    $file_name = $_FILES['file_name']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($file_name);
    move_uploaded_file($_FILES['file_name']['tmp_name'], $target_file);

    $query = "INSERT INTO images (name, file_name) VALUES ('$name', '$file_name')";
    if (mysqli_query($conn, $query)) {
        echo "Image uploaded successfully!";
    } else {
        echo "Failed to upload image!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Food Image</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h2>Upload Food Image</h2>
<form method="post" action="" enctype="multipart/form-data">
    <label for="name">Food Name:</label>
    <input type="text" id="name" name="name" required><br><br>

    <label for="file_name">Food Image:</label>
    <input type="file" id="file_name" name="file_name" required><br><br>

    <button type="submit">Upload</button>
</form>

</body>
</html>
