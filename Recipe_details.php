<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./global.css">
    <link rel="icon" type="image/x-icon" href="./images/icons8-brezel-50.png">
    <title>
        <?php
        if (isset($_GET['recipe_id'])) {
            $recipe_id = $_GET['recipe_id'];
            // Retrieve the recipe name from the database based on the provided recipe_id
            require_once 'database_connect.php';
            $sql = "SELECT Name FROM recipes WHERE recipe_id = $recipe_id";
            $result = $sql_object->query($sql);
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo $row['Name'];
            } else {
                echo "Recipe Not Found";
            }
        } else {
            echo "Recipe Page";
        }
        ?>
    </title>
</head>
<body>
    <?php include 'primary-navigation.php'?>

    <?php include 'secondary-navigation.php'?>

    <section class="recipe-details">
        <?php
        function isUserLoggedIn()
        {
            return isset($_SESSION["user_id"]);
        }

        require_once 'database_connect.php';

        // Check if a recipe ID is provided in the URL
        if (isset($_GET['recipe_id'])) {
            $recipe_id = $_GET['recipe_id'];

            // Query the database to fetch the recipe information for the provided recipe ID
            $sql = "SELECT r.recipe_id, r.Name, r.Description, r.Rating, GROUP_CONCAT(ri.Ingredient SEPARATOR ', ') AS Ingredients
            FROM recipes r
            LEFT JOIN recipe_ingredients ri ON r.recipe_id = ri.recipe_id
            WHERE r.recipe_id = $recipe_id
            GROUP BY r.recipe_id";

            $result = $sql_object->query($sql);

            if ($result->num_rows > 0) {
                $recipe = $result->fetch_assoc();
                ?>
                <img class="recipe-image" src="./images/Spaghetti-Bolognese.jpg" alt="Recipe Image">
                <h1><?php echo $row['Name']; ?></h1>
                <h3>Rating: <?php echo $recipe['Rating']; ?></h3>
                <p><?php echo $recipe['Description']; ?></p>

                <?php
                // Check if the recipe has any ingredients and display them
                if (isset($recipe['Ingredients'])) {
                    $recipe_ingredients = explode(', ', $recipe['Ingredients']);
                    ?>
                    <section class="ingredients-section">
                        <h3>Ingredients:</h3>
                        <ul>
                            <?php
                            foreach ($recipe_ingredients as $ingredientItem) {
                                echo "<li>$ingredientItem</li>";
                            }
                            ?>
                        </ul>
                    </section>
                <?php } else {
                    echo "<p>No ingredients available for this recipe.</p>";
                } ?>

                <?php
                // Check if the recipe has any steps and display them
                if (isset($recipe['Step_number']) && isset($recipe['Description'])) {
                    ?>
                    <section class="steps-section">
                        <h3>Steps:</h3>
                        <ol>
                            <?php do {
                                echo "<li>" . $recipe['Description'] . "</li>";
                            } while ($recipe = $result->fetch_assoc()); ?>
                        </ol>
                    </section>
                <?php } else {
                    echo "<p>No steps available for this recipe.</p>";
                } ?>

                <?php
                // Check if the user is logged in and show the "Save" or "Remove" button accordingly
                if (isUserLoggedIn()) {
                    $isSaved = isRecipeSaved($_SESSION["user_id"], $recipe['recipe_id']);
                    ?>
                    <div class="save-remove-buttons">
                        <?php if ($isSaved) : ?>
                            <button class="remove-button" data-recipe-id="<?php echo $recipe['recipe_id']; ?>">Remove</button>
                        <?php else : ?>
                            <button class="save-button" data-recipe-id="<?php echo $recipe['recipe_id']; ?>">Save</button>
                        <?php endif; ?>
                    </div>
                <?php } else {
                    echo "<p>Please <a href='login_page.php'>log in</a> to save this recipe.</p>";
                } ?>
                <?php
            } else {
                echo "<p>Recipe not found.</p>";
            }
        } else {
            echo "<p>No recipe ID provided.</p>";
        }
        ?>
    </section>

    <?php include 'Footer.php'?>

</body>
</html>
