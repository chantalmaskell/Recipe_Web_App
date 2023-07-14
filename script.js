//Recipe Date
const recipes = [
    {
      name: 'Spaghetti Bolognese',
      description: 'Once you \’ve got this grown-up spag bol going the hob will do the rest. Any leftovers will taste even better the next day.',
      ingredients: ['2 tbsp olive oil or sun-dried tomato oil from the jar', '6 rashers of smoked streaky bacon, chopped', '2 large onions, chopped', 'onion', 'garlic', 'olive oil', 'salt', 'pepper'],
      instructions: 'Boil the spaghetti. In a separate pan, saute the onion and garlic in olive oil. Add the ground beef and cook until browned. Add the tomato sauce, salt, and pepper, and simmer for 15 minutes. Serve the sauce over the spaghetti.',
      categories: ['pasta', 'meat', 'main']
      
    },
    {
      name: 'Chicken Alfredo',
      description: 'A creamy pasta dish with grilled chicken.',
      ingredients: ['fettuccine','chicken breast', 'heavy cream', 'butter', 'garlic', 'Parmesan cheese', 'salt', 'pepper'],
      instructions: 'Grill the chicken and cut it into strips. Boil the fettuccine. In a separate pan, melt the butter and saute the garlic. Add the heavy cream and simmer for a few minutes. Add the Parmesan cheese, salt, and pepper, and stir until the sauce is creamy. Serve the sauce and chicken over the fettuccine.',
      categories:['main', 'meat']
    }
    // add more recipes here
  ];
  
// Populate category select options
const categorySelect = document.getElementById('categorySelect');
const uniqueCategories = [...new Set(recipes.flatMap(recipe => recipe.categories))];
uniqueCategories.forEach(category => {
  const option = document.createElement('option');
  option.value = category;
  option.text = category;
  categorySelect.appendChild(option);
});

document.getElementById('recipeForm').addEventListener('submit', function(event) {
  event.preventDefault(); // Prevent the form from submitting normally
  const searchType = document.getElementById('searchType').value;
  const keyword = (searchType !== 'category') ? document.getElementById('searchInput').value.toLowerCase() : document.getElementById('categorySelect').value;
  searchRecipes(keyword, searchType);
});

function searchRecipes(keyword, type) { // This function searches the recipes based on the keyword and type.
  let results;
  switch (type) {
    case 'name':
        //If type is 'name', filter the recipes that include the keyword in the name.
        results = recipes.filter(recipe => recipe.name.toLowerCase().includes(keyword));
        break;
    case 'ingredient':
        // If type is 'ingredient', filter the recipes that include the keyword in the ingredients.
        results = recipes.filter(recipe => recipe.ingredients.some(ingredient => ingredient.toLowerCase().includes(keyword)));
        break;
    case 'category':
         // If type is 'category', filter the recipes that include the keyword in the categories.
        results = recipes.filter(recipe => recipe.categories.includes(keyword));
        break;
    default:
        // If type is not 'name', 'ingredient', or 'category', return an empty array.
        results = [];
  }

// sorting results by name in alphabetical order
results.sort((a, b) => a.name.localeCompare(b.name));

// Grabbing the recipeContainer element from the DOM.
const recipeContainer = document.getElementById('recipeContainer'); 
recipeContainer.innerHTML = ''; // Clear previous search results
  
// Checking if there are results and displaying them, otherwise show 'No recipes found'.
  if (results.length > 0) {
    results.forEach(recipe => {
      const recipeElement = document.createElement('div'); // Creating new div for each recipe.
      // Adding the details of the recipe to the div.
      recipeElement.innerHTML = `
        <h2>${recipe.name}</h2>
        <h3>Categories</h3>
        <p>${recipe.categories.join(', ')}</p>
        <h3>Description</h3>
        <p>${recipe.description}</p>
        <h3>Ingredients</h3>
        <p>${recipe.ingredients.join(', ')}</p>
        <h3>Instructions</h3>
        <p>${recipe.instructions}</p>
        <hr>
      `;
      recipeContainer.appendChild(recipeElement); // Adding the div to the recipeContainer.
    });
  } else {
    recipeContainer.innerText = 'No recipes found.';
  }
}

function updateSearchInput(value) {  // This function is used to toggle the visibility of the search input and category select based on the search type selected by the user.
    const searchInput = document.getElementById('searchInput');
    const categorySelect = document.getElementById('categorySelect');
    if (value === 'category') {
        // If the selected search type is 'category', hide the search input and show the category select.
        searchInput.style.display = 'none';
        categorySelect.style.display = '';
    } else {
        // If the selected search type is not 'category', show the search input and hide the category select.
        searchInput.style.display = '';
        categorySelect.style.display = 'none';
    }
}
// Initially calling the function to set the visibility of the search input and category select based on the initially selected search type.
updateSearchInput(document.getElementById('searchType').value);
