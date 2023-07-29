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
<div class="recipe-container">

    <?php include 'primary-navigation.php'?>

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
            $sql = "SELECT r.recipe_id, r.Name, r.Description AS RecipeDescription, r.Rating, r.Prep_time, r.Cook_time, GROUP_CONCAT(ri.Ingredient SEPARATOR ', ') AS Ingredients, rs.Step_number, rs.Description AS StepDescription
            FROM recipes r
            LEFT JOIN recipe_ingredients ri ON r.recipe_id = ri.recipe_id
            LEFT JOIN recipe_steps rs ON r.recipe_id = rs.recipe_id
            WHERE r.recipe_id = $recipe_id
            GROUP BY r.recipe_id, rs.Step_number
            ORDER BY rs.Step_number";

            $result = $sql_object->query($sql);

            if ($result->num_rows > 0) {
                $recipe = $result->fetch_assoc();
                ?>
                <img class="recipe-image" src="./images/Spaghetti-Bolognese.jpg" alt="Recipe Image">
                <h1><?php echo $recipe['Name']; ?></h1>
                <h2>Rating: <?php echo $recipe['Rating']; ?></h2>
                <p><b>Preparation time:</b> <?php echo $recipe['Prep_time']; ?></p>
                <p><b>Cooking time:</b> <?php echo $recipe['Cook_time']; ?></p>

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

<section class="steps-section">
<?php
// Check if the recipe has any steps and display them
if (isset($recipe['Step_number']) && isset($recipe['StepDescription'])) {
    ?>
    <h3>Steps:</h3>
    <ol>
        <?php foreach ($result as $step) {
            echo "<li>" . $step['StepDescription'] . "</li>";
        } ?>
    </ol>
<?php } else {
    echo "<p>No steps available for this recipe.</p>";
} ?>
</section>

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
</div>
    <?php include 'Footer.php'?>

</body>
</html>
