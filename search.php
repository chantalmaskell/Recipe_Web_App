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
    <link rel="stylesheet" href="./global.css">
    <title>Recipe Central | Explore our range of mouth-watering recipes</title>
</head>

<body>

    <?php include 'primary-navigation.php'?>

<div class="card">
  <img src="./images/Spaghetti-Bolognese.jpg" alt="Image of Spaghetti Bolognese" style="width:100%">
  <div class="container">
    <h1>Our current favourite: <b>Garlic and Parmesan Spaghetti Bolognese</b></h1>
    <p>Get all five of your five-a-day with this spaghetti Bolognese. The hidden veg in the sauce makes it ideal for kids and you can freeze any leftovers</p>
  </div>
</div>

<?php include 'secondary-navigation.php'?>



    <!-- Display the search results -->
    <div class="search-results">
        <?php if (isset($recipes) && !empty($recipes)) : ?>
            <?php foreach ($recipes as $recipe) : ?>
                <div class="recipe-full-page">
                    <h3><?php echo $recipe['Name']; ?></h3>
                    <img class="recipe-image" src="./images/Healthy-pizza.jpg" alt="Recipe Image">
                    <p><?php echo $recipe['Description']; ?></p>
                    <?php if (isset($recipe['Ingredients'])) : ?>
                        <p>Ingredients:</p>
                        <ul>
                        <?php
                        $ingredients = explode(', ', $recipe['Ingredients']);
                        foreach ($ingredients as $ingredient) {
                        echo "<li>$ingredient</li>";
                        }
                        ?>
                        </ul>
                        <?php else : ?>
                        <p>No ingredients available for this recipe.</p>
                        <?php endif; ?>
                    <!-- Display the "Save" or "Remove" button with the recipe ID as a data attribute -->
                    <?php
                    // Check if the user is logged in
                    if (isUserLoggedIn()) {
                        // Check if the recipe is saved for the logged-in user
                        $isSaved = false;
                        if (isset($_SESSION["user_id"])) {
                            $userId = $_SESSION["user_id"];
                            $recipeId = $recipe['recipe_id'];

                            $sql = "SELECT COUNT(*) FROM saved_recipes WHERE user_id = ? AND recipe_id = ?";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([$userId, $recipeId]);
                            $isSaved = $stmt->fetchColumn() > 0;
                        }

                        // Display the "Save" or "Remove" button accordingly
                        if ($isSaved) {
                            echo "<button class='remove-button' data-recipe-id='" . $recipe['recipe_id'] . "' data-user-id='" . $_SESSION["user_id"] . "'>Remove</button>";
                        } else {
                            echo "<button class='save-button' data-recipe-id='" . $recipe['recipe_id'] . "' data-user-id='" . $_SESSION["user_id"] . "'>Save</button>";
                        }
                    } else {
                        echo "<p>Please <a href='login_page.php'>log in</a> to save or remove this recipe.</p>";
                    }
                    ?>

                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No recipes found. Please try a different search query.</p>
        <?php endif; ?>
    </div>

    <?php include 'Footer.php'?>

    <!-- Assign the login status to a JavaScript variable -->
    <script>
        var isLoggedIn = <?php echo isset($_SESSION["user_id"]) ? "true" : "false"; ?>;
    </script>
    <!-- Include the external script.js file -->
    <script src="script.js"></script>
</body>
</html>
