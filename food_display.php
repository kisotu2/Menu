<?php 
include("connect.php");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Food Menu</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <div class="search-container">
            <input type="text" id="searchBar" onkeyup="searchNames()" placeholder="Search for food...">
        </div>
        <div class="image_container">
            <?php 
            // Query to fetch all food items from the database
            $query = "SELECT * FROM food";
            $result = mysqli_query($conn, $query);

            // Check if any results were returned
            if (mysqli_num_rows($result) > 0) {
                // Loop through each row in the result set
                while ($row = mysqli_fetch_array($result)) {
                    // Retrieve data from each row
                    $name = $row["Name"]; // Ensure "Name" matches your column name in the database
                    $amount = $row["amount"]; // Ensure "amount" matches your column name in the database
                    $fileName = $row["file_name"]; // Ensure "file_name" matches your column name in the database
                    
                    // Construct the image URL path
                    $imageUrl = "Photos/" . $fileName;
                    
                    // Display the food item with its image, name, and price
                    echo "<div class='profile'>";
                    echo "<img src='$imageUrl' alt='$name'>";
                    echo "<h3>$name</h3>";
                    echo "<p>Price: $$amount</p>";
                    echo "</div>";
                }
            } else {
                // If no food items are found, display a message
                echo "<p>No food items found.</p>";
            }
            ?>
        </div>

        <!-- JavaScript to filter food items by name -->
        <script>
            function searchNames() {
                var input, filter, imageContainer, profiles, h3, i, txtValue;
                input = document.getElementById('searchBar');
                filter = input.value.toUpperCase();
                imageContainer = document.getElementsByClassName('image_container')[0];
                profiles = imageContainer.getElementsByClassName('profile');

                for (i = 0; i < profiles.length; i++) {
                    h3 = profiles[i].getElementsByTagName('h3')[0];
                    txtValue = h3.textContent || h3.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        profiles[i].style.display = "";
                    } else {
                        profiles[i].style.display = "none";
                    }
                }
            }
        </script>
    </body>
</html>
