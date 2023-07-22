<?php

//Creates or resumes a session via cookies
session_start();

// Include the database connection file (MySQLi version)
require_once 'database_connect.php';

// Function to check if the user is logged in
function isUserLoggedIn()
{
    return isset($_SESSION["user_id"]);
}

// Handle the request to save a recipe
if (isset($_GET['action']) && $_GET['action'] === 'save_recipe') {
    // Check if the user is logged in
    if (isset($_SESSION["user_id"])) {
        $userId = $_SESSION["user_id"];
        $recipeId = $_GET['recipe_id'];

        // Insert the saved recipe into the database
        $sql = "INSERT INTO saved_recipes (user_id, recipe_id) VALUES ('$userId', '$recipeId')";
        if ($sql_object->query($sql) === TRUE) {
            echo "Recipe saved successfully!";
        } else {
            echo "Error saving recipe: " . $sql_object->error;
        }
        exit; // Exit to prevent displaying the entire HTML page again
    } else {
        echo "Please log in to save this recipe.";
        exit; // Exit to prevent displaying the entire HTML page again
    }
}

// Handle the request to remove a recipe from favorites
if (isset($_GET['action']) && $_GET['action'] === 'remove_recipe') {
    // Check if the user is logged in
    if (isset($_SESSION["user_id"])) {
        $userId = $_SESSION["user_id"];
        $recipeId = $_GET['recipe_id'];

        // Remove the recipe from the database
        $sql = "DELETE FROM saved_recipes WHERE user_id = '$userId' AND recipe_id = '$recipeId'";
        if ($sql_object->query($sql) === TRUE) {
            echo "Recipe removed successfully!";
        } else {
            echo "Error removing recipe: " . $sql_object->error;
        }
        exit; // Exit to prevent displaying the entire HTML page again
    } else {
        echo "Please log in to remove this recipe.";
        exit; // Exit to prevent displaying the entire HTML page again
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./global.css">
    <title>Welcome to Recipe Central | All the taste in one place</title>
</head>


<body>

    <?php include 'primary-navigation.php'?>


    <section class="Welcome">
        <h1>Welcome to Recipe Central</h1>
        <p>From family favorites to timeless classics. Store and explore 5+ recipes all from one place.</p>
    <!-- search box for finding the recipes -->
    <section class="search-bar">
        <form action="search.php" method="GET">
            <input type="text" name="search" placeholder="Search for recipes">
            <button type="submit">Search</button>
        </form>
    </section>
    </section>

<?php include 'secondary-navigation.php'?>

    <!--Checks if session data is stored-->
    <?php if (isset($_SESSION["user_id"])) : ?>

        <p>You are now logged in</p>
        <!--Allows the user to log out-->
        <p><a href="logout.php">Log out</a></p>
        <!--Gives the user links to log in or sign up-->
    <?php else : ?>
        <p>Please <a href="login_page.php">Log In</a> or <a href="signup_form.html">Sign Up</a></p>
    <?php endif; ?>

    <div>
        <?php
        // Include the database connection file (MySQLi version)
        require_once 'database_connect.php';

        // Retrieve recipes from the database
        $sql = "SELECT * FROM recipes"; // Modify this query according to your database structure
        $result = $sql_object->query($sql);
        // Check if there are any recipes in the result
        if ($result->num_rows > 0) {
            // Fetch and display the recipes
            while ($recipe = $result->fetch_assoc()) {
                // Display the recipe information as needed recipe details (description, ingredients, etc.)
                echo "<div class='recipe-card'>";
                echo "<h3>" . $recipe['Name'] . "</h3>";
                echo "<p>" . $recipe['Description'] . "</p>";
                echo "<p>" . $recipe['Prep_time'] . "</p>";
                echo "<p>" . $recipe['Cook_time'] . "</p>";

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
            }
        } else {
            echo "No recipes found.";
        }
        // Close the database connection
        $sql_object->close();
        ?>
    </div>


    <!-- Assign the login status to a JavaScript variable -->
    <script>
        var isLoggedIn = <?php echo isset($_SESSION["user_id"]) ? "true" : "false"; ?>;
    </script>

    <!-- Include the external script.js file -->
    <script src="script.js"></script>

</body>
</html>
