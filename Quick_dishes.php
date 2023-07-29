<section class="recipe-grid-container">
<?php
$sql = "SELECT * 
FROM `recipes`
WHERE Cook_time = '10 to 30 minutes' OR Cook_time = '30 minutes to 1 hour'
LIMIT 3;";

$result = $sql_object->query($sql);

// Check if there are any recipes in the result
if ($result->num_rows > 0) {
    // Fetch and display the recipes
    while ($recipe = $result->fetch_assoc()) {
        echo "<div class='small-card'>";
        echo "<a href='Recipe_details.php?recipe_id=" . $recipe['recipe_id'] . "'>";
        echo "<img src='./images/Spaghetti-Bolognese.jpg' alt='Image of Spaghetti Bolognese' style='width:100%'>";
        echo "<div class='small-container'>";
        echo "<h3>" . $recipe['Name'] . "</h3>";
        echo "<p>" . $recipe['Description'] . "</p>";
        echo "<p><b>Preparation time:</b> " . $recipe['Prep_time'] . "</p>";
        echo "<p><b>Cooking time:</b> " . $recipe['Cook_time'] . "</p>";

if (isset($_GET['rate_action']) && $_GET['rate_action'] === 'save_rating') {
    // Check if the user is logged in
    if (isset($_SESSION["user_id"])) {
        $userId = $_SESSION["user_id"];
        $recipeId = $_GET['recipe_id'];

        $query = "INSERT into ratings (recipe_id, rating, user) VALUES ('$recipeId', '1', '$userId')";

        if ($sql_object->query($query) === TRUE) {
            echo "Rating added successfully!";
        } else {
            echo "Error adding rating: " . $sql_object->error;
        }
        exit; // Exit to prevent displaying the entire HTML page again
    } else {
        echo "Please log in to add this rating.";
        exit; // Exit to prevent displaying the entire HTML page again
    }
}

        // Check if the user is logged in and show the "Save" or "Remove" button accordingly
        if (isUserLoggedIn()) {
            // Check if the recipe is saved or not and display the appropriate button
            $isSaved = isRecipeSaved($_SESSION["user_id"], $recipe['recipe_id']);
            if ($isSaved) {
                echo "<button class='remove-button' data-recipe-id='" . $recipe['recipe_id'] . "'>Remove</button>";
            } else {
                echo "<button class='save-button' data-recipe-id='" . $recipe['recipe_id'] . "'>Save</button>";
            }
        } else {
            echo "<p>Please <a href='login_page.php'>log in</a> to save this recipe.</p>";
        }

        echo "</div>";
        echo "</div>";
    }
}
?>
</section>