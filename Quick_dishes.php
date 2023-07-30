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
            ?>
            <div class="small-card">
                <a href="Recipe_details.php?recipe_id=<?php echo $recipe['recipe_id']; ?>">
                    <img src="<?php echo $recipe['image_link'] ?>" alt="<?php echo $recipe['alt_text'] ?>" style="width:100%">
                </a>
                <div class="small-container">
                    <h3><?php echo $recipe['Name']; ?></h3>
                    <p><?php echo $recipe['Description']; ?></p>
                    <p><b>Preparation time:</b> <?php echo $recipe['Prep_time']; ?></p>
                    <p><b>Cooking time:</b> <?php echo $recipe['Cook_time']; ?></p>
                    <a href="Recipe_details.php?recipe_id=<?php echo $recipe['recipe_id']; ?>">
                        <button class="details-button-white">View recipe for <?php echo $recipe['Name']; ?></button>
                    </a>
                    <?php
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
                    ?>
                </div>
            </div>
        <?php
        }
    } else {
        echo "<p>No recipes found.</p>";
    }
    ?>
</section>