<section>
    <?php
    $sql = "SELECT * 
    FROM `recipes`
    INNER JOIN recipe_categories
    ON recipes.recipe_id = recipe_categories.recipe_id
    WHERE Prep_time = '30 minutes'
    LIMIT 3;";

    $result = $sql_object->query($sql);

    // Check if there are any recipes in the result
    if ($result->num_rows > 0) {
        // Initialize a counter to keep track of the number of displayed recipes
        $counter = 0;

        // Start the first row
        echo "<div class='row'>";

        // Fetch and display the recipes
        while ($recipe = $result->fetch_assoc()) {
            // Display the recipe information as needed recipe details (description, ingredients, etc.)
            echo "<div class='column recipe'>";
            echo "<div class='recipe-card'>";
            echo "<h3>" . $recipe['Name'] . "</h3>";
            echo "<p>" . $recipe['Description'] . "</p>";
            echo "<p>Preparation time: " . $recipe['Prep_time'] . "</p>";
            echo "<p>Cooking time: " . $recipe['Cook_time'] . "</p>";

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
            echo "</div>"; // Close recipe-card div
            echo "</div>"; // Close column recipe div
        }

        // Close the first row
        echo "</div>"; // Close row div
    }
    ?>

<button class="view-recipe-button">View more pasta dishes</button>
</section>