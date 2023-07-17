<?php

//Creates or resumes a session via cookies
session_start();

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
    <?php if (isset($_SESSION["user_id"])): ?>

        <p>You are now logged in</p>
        <!--Allows the user to log out-->
        <p><a href="logout.php">Log out</a></p>
        <section>
            <!-- HTML and other content for the account page -->
            <h2>Saved Recipes</h2>
            <ul>
                <?php if (isset($savedRecipes) && count($savedRecipes) > 0) : ?>
                    <?php foreach ($savedRecipes as $recipe) : ?>
                        <li><?php echo $recipe['recipe_name']; ?></li>
                    <?php endforeach; ?>
                <?php else : ?>
                    <li>No saved recipes found.</li>
                <?php endif; ?>
            </ul>
        </section>

    <!--Gives the user links to log in or sign up-->
    <?php else: ?>

        <p>Please <a href="login_page.php">log in</a> or <a href="signup_form.html">sign up</a></p>
    
    <?php endif; ?>


</body>
</head>