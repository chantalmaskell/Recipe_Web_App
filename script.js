// Function to handle the "Save" button click
function handleSaveButtonClick(recipeId, userId) {
    // Check if the user is logged in
    var isLoggedIn = false;

    // If the variable from index.php is defined, use its value
    if (typeof window.isLoggedIn !== 'undefined') {
        isLoggedIn = window.isLoggedIn;
    }

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
