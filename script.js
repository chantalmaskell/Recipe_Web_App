// JS file to handle the save and remove buttons while calling the backend and storing the necessary information.

// Function to handle the "Save" or "Remove" button click
async function handleSaveButtonClick(recipeId, userId, isSaved) {
    // Check if the user is logged in
    if (isLoggedIn) {
        var action = isSaved ? "remove_recipe" : "save_recipe";
        var buttonText = isSaved ? "Save" : "Remove";

        try {
            // Send a request to the server to save or remove the recipe
            const response = await fetch(`index.php?action=${action}&recipe_id=${recipeId}`);
            const data = await response.text();

            // Handle the response
            if (response.ok) {
                alert(data);

                // If successful, update the button text and toggle isSaved value
                var button = document.querySelector(`.save-button[data-recipe-id='${recipeId}']`);
                if (!button) {
                    button = document.querySelector(`.remove-button[data-recipe-id='${recipeId}']`);
                }

                if (button) {
                    button.textContent = buttonText;
                    button.classList.toggle("save-button");
                    button.classList.toggle("remove-button");
                } else {
                    throw new Error(`Button not found for recipeId ${recipeId}`);
                }
            } else {
                throw new Error(data);
            }
        } catch (error) {
            alert(`An error occurred: ${error.message}`);
        }
    } else {
        // If the user is not logged in, show a login message
        alert("Please log in to save or remove this recipe.");
    }
}

// Attach click event listeners to all "Save" and "Remove" buttons
var buttons = document.querySelectorAll(".save-button, .remove-button");
buttons.forEach(function (button) {
    button.addEventListener("click", function () {
        var recipeId = button.dataset.recipeId;
        var userId = button.dataset.userId;
        var isSaved = button.classList.contains("remove-button");
        handleSaveButtonClick(recipeId, userId, isSaved);
    });
});
