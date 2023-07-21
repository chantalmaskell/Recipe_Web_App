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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>

<body>

    <h1>Home</h1>
    <!-- search box for texting finding the recipes -->
    <section>
        <form action="search.php" method="GET">
            <input type="text" name="search" placeholder="Search for recipes">
            <button type="submit">Search</button>
        </form>
    </section>

    <!--Checks if session data is stored-->
    <?php if (isset($_SESSION["user_id"])) : ?>

        <p>You are now logged in</p>
        <!--Allows the user to log out-->
        <p><a href="logout.php">Log out</a></p>
        <!--Gives the user links to log in or sign up-->
    <?php else : ?>
        <p>Please <a href="login_page.php">log in</a> or <a href="signup_form.html">sign up</a></p>
    <?php endif; ?>

    <div>
        <?php
        // Include the database connection file (MySQLi version)
        require_once 'database_connect.php';
        // Assuming you have a $sql_object representing the database connection
        // Retrieve recipes from the database
        $sql = "SELECT * FROM recipes"; // Modify this query according to your database structure
        $result = $sql_object->query($sql);
        // Check if there are any recipes in the result
        if ($result->num_rows > 0) {
            // Fetch and display the recipes
            while ($recipe = $result->fetch_assoc()) {
                // Display the recipe information as needed
                // Add other recipe details (description, ingredients, etc.)
                echo "<div class='recipe-card'>";
                echo "<h3>" . $recipe['Name'] . "</h3>";
                echo "<p>" . $recipe['Description'] . "</p>";
                echo "<p>" . $recipe['Prep_time'] . "</p>";
                echo "<p>" . $recipe['Cook_time'] . "</p>";

                // Check if the user is logged in and show the "Save" button accordingly
                if (isUserLoggedIn()) {
                    echo "<button class='save-button' data-recipe-id='" . $recipe['recipe_id'] . "'>Save</button>";
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


    <!-- JavaScript code to handle the "Save" button click -->
    <script>
        // Function to handle the "Save" button click
        function handleSaveButtonClick(recipeId, userId) {
            // Check if the user is logged in
            var isLoggedIn = <?php echo isset($_SESSION["user_id"]) ? "true" : "false"; ?>;

            // If the user is logged in, save the recipe
            if (isLoggedIn) {
                // Send a request to the server to save the recipe
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        alert(this.responseText);
                    }
                };
                xhttp.open("GET", "index.php?action=save_recipe&recipe_id=" + recipeId, true);
                xhttp.send();
            } else {
                // If the user is not logged in, show a login message
                alert("Please log in to save this recipe.");
            }
        }

        // Attach click event listeners to all "Save" buttons
        var saveButtons = document.querySelectorAll(".save-button");
        saveButtons.forEach(function(button) {
            button.addEventListener("click", function() {
                var recipeId = button.dataset.recipeId;
                var userId = button.dataset.userId;
                handleSaveButtonClick(recipeId, userId);
            });
        });
    </script>

</body>
</head>