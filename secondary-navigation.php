<nav class="secondary-navigation">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="recipes.php">Recipes</a></li>
            <li><a href="favorites.php">Favorites</a></li>
            <?php if (isset($_SESSION["user_id"])) : ?>
                <li><a href="logout.php">Log out</a></li>
            <?php else : ?>
                <li><a href="login_page.php">Log In</a></li>
                <li><a href="signup_form.html">Sign Up</a></li>
            <?php endif; ?>
        </ul>
    </nav>