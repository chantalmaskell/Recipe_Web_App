<?php
// Include the necessary files and establish the database connection
require_once 'includes/header.php';
require_once 'database/database_connect.php';

// Check if the search form has been submitted
if (isset($_GET['search'])) {
    // Get the search query from the form
    $searchQuery = $_GET['search'];

    // Prepare the SQL statement to search for recipes matching the query
    $sql = "SELECT * FROM recipes WHERE recipe_name LIKE :searchQuery OR ingredients LIKE :searchQuery";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':searchQuery', '%' . $searchQuery . '%');
    $stmt->execute();

    // Fetch the matching recipes from the database
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
 <!-- header.php file to be added  -->
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

<!-- Display the search results -->
<div class="search-results">
    <?php if (isset($recipes) && !empty($recipes)) : ?>
        <?php foreach ($recipes as $recipe) : ?>
            <div class="recipe-card">
                <h3><?php echo $recipe['recipe_name']; ?></h3>
                <p><?php echo $recipe['description']; ?></p>
                <!-- Display other recipe information like categories, ratings, etc. -->
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p>No recipes found. Please try a different search query.</p>
    <?php endif; ?>
</div>

<!-- Additional HTML and CSS for the search results page to be added -->


<?php
// Include the necessary files and footer " Footer file to be added " 
require_once 'includes/footer.php';
?>
</body>
</html>