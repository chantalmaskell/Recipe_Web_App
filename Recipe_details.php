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

    <section class="Recipe-details">
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
            $sql = "SELECT *
            FROM recipes r
            LEFT JOIN recipe_ingredients ri ON r.recipe_id = ri.recipe_id
            LEFT JOIN recipe_steps rs ON r.recipe_id = rs.recipe_id
            WHERE r.recipe_id = $recipe_id;";

            $result = $sql_object->query($sql);

            if ($result->num_rows > 0) {
                $recipe = $result->fetch_assoc();
                ?>
                        <img class="recipe-image" src="./images/Spaghetti-Bolognese.jpg" alt="Recipe Image">
                <h3><?php echo $recipe['Name']; ?></h3>
                <h3>Rating: <?php echo $recipe['Rating']; ?></h3>
                <p><?php echo $recipe['Description']; ?></p>

                <?php
                // Check if the recipe has any ingredients and display them
                if (isset($recipe['Ingredient'])) {
                    $recipe_ingredients = explode(', ', $recipe['Ingredient']);
                    ?>
                    <p>Ingredients:</p>
                    <ul>
                        <?php
                        foreach ($recipe_ingredients as $ingredientItem) {
                            echo "<li>$ingredientItem</li>";
                        }
                        ?>
                    </ul>
                    <?php
                } else {
                    echo "<p>No ingredients available for this recipe.</p>";
                }

                // Check if the user is logged in and show the "Save" or "Remove" button accordingly
                if (isUserLoggedIn()) {
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
                <?php
            } else {
                echo "<p>Recipe not found.</p>";
            }
        } else {
            echo "<p>No recipe ID provided.</p>";
        }
        ?>
    </section>
</body>
</html>
