<?php
session_start();

// Function to establish a database connection
function connectToDatabase()
{
    $host = 'localhost';
    $dbname = 'recipe_login';
    $db_username = 'root';
    $db_password = "";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $db_username, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        // Handle database connection errors
        echo "Connection failed: " . $e->getMessage();
        die();
    }
}

// Include the necessary files and establish the database connection
require_once 'database_connect.php';
$pdo = connectToDatabase();

// Function to check if the user is logged in
function isUserLoggedIn()
{
    return isset($_SESSION["user_id"]);
}

// Check if the search form has been submitted
if (isset($_GET['search'])) {
    // Get the search query from the form
    $searchQuery = $_GET['search'];

    // Prepare the SQL statement to search for recipes matching the query
    $sql = "SELECT r.recipe_id, r.Name, r.Description, GROUP_CONCAT(ri.Ingredient SEPARATOR ', ') AS Ingredients
        FROM recipes r
        LEFT JOIN recipe_ingredients ri ON r.recipe_id = ri.recipe_id
        WHERE r.Name LIKE :searchQuery OR ri.Ingredient LIKE :searchQuery
        GROUP BY r.recipe_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':searchQuery', '%' . $searchQuery . '%');
    $stmt->execute();

    // Fetch the matching recipes from the database
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
</head>

<body>
    <form action="search.php" method="GET">
        <input type="text" name="search" placeholder="Search for recipes">
        <button type="submit">Search</button>
    </form>

    <!--Checks if session data is stored-->
    <?php if (isset($_SESSION["user_id"])) : ?>

        <p>You are now logged in</p>
        <!--Allows the user to log out-->
        <p><a href="logout.php">Log out</a></p>
        <!--Gives the user links to log in or sign up-->
    <?php else : ?>
        <p>Please <a href="login_page.php">Log In</a> or <a href="signup_form.html">Sign Up</a></p>
    <?php endif; ?>

    <!-- Display the search results -->
    <div class="search-results">
        <?php if (isset($recipes) && !empty($recipes)) : ?>
            <?php foreach ($recipes as $recipe) : ?>
                <div class="recipe-card">
                    <h3><?php echo $recipe['Name']; ?></h3>
                    <p><?php echo $recipe['Description']; ?></p>
                    <?php if (isset($recipe['Ingredients'])) : ?>
                        <p>Ingredients: <?php echo $recipe['Ingredients']; ?></p>
                    <?php else : ?>
                        <p>No ingredients available for this recipe.</p>
                    <?php endif; ?>

                    <!-- Display the "Save" button with the recipe ID and user ID as data attributes -->
                    <?php
                    // Check if the user is logged in and show the "Save" button accordingly
                    if (isUserLoggedIn()) {
                        echo "<button class='save-button' data-recipe-id='" . $recipe['recipe_id'] . "' data-user-id='" . $_SESSION["user_id"] . "'>Save</button>";
                    } else {
                        echo "<p>Please <a href='login_page.php'>log in</a> to save this recipe.</p>";
                    }
                    ?>

                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No recipes found. Please try a different search query.</p>
        <?php endif; ?>
    </div>

    <!-- Assign the login status to a JavaScript variable -->
    <script>
        var isLoggedIn = <?php echo isset($_SESSION["user_id"]) ? "true" : "false"; ?>;
    </script>
    <!-- Include the external script.js file -->
    <script src="script.js"></script>
</body>

</html>