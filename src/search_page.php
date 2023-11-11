<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Page</title>
    <link rel="stylesheet" href="./style/style.css" />
</head>
<body>
    <div class="height__screen bg__img">
        <div class="darken__mask"></div>
        <nav>
            <a href="index.html">RECIPES</a>
            <div>
                <a href="contact.php">Contact</a>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
                <a href="search_page.php">Search</a>
            </div>
        </nav>
        <div class="main__content" style="z-index: 10;">
            <h1>Smart Recipes</h1>
            <p>"Unlock the flavors of inspiration, one recipe at a time!"</p>
            <div class="custom__form">
                <h2>Search Recipes</h2>
                <form id="searchForm">
                    <input type="text" id="searchInput" placeholder="Search recipes...">
                    <button type="submit">Search</button>
                </form>
            </div>
            <div id="searchResults" class="recipe__container"></div>
            <div id="errorMessage"></div>
        </div>
    </div>

    <script>
     const searchForm = document.getElementById('searchForm');
     const searchInput = document.getElementById('searchInput');
     const searchResults = document.getElementById('searchResults');
     const errorMessage = document.getElementById('errorMessage');

// Adding event listener for form submission
document.addEventListener('submit', function (e) {
    if (e.target === searchForm) {
        e.preventDefault(); // Prevent form submission

        // Get the search query
        const query = searchInput.value;

        // Validate the search query
        if (query.trim() === '') {
            errorMessage.textContent = 'Please enter a search query.';
            searchResults.innerHTML = ''; // Clear previous search results
            return; // Exit the function
        }

        // Perform the search using AJAX
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Display the search results
                    const response = xhr.responseText;
                    searchResults.innerHTML = response;
                    errorMessage.textContent = ''; // Clear any previous error message
                } else {
                    // Show the appropriate error message
                    searchResults.innerHTML = '';
                    errorMessage.textContent = 'An error occurred while searching.';
                }
            }
        };
        xhr.onerror = function () {
            // Show the appropriate error message
            searchResults.innerHTML = '';
            errorMessage.textContent = 'An error occurred while searching.';
        };
        xhr.open('GET', 'search.php?q=' + query, true);
        xhr.send();
    }
});
    </script>
</body>
</html>