<?php
// search.php

// Include the necessary files and establish the database connection
include "auth.php";
$conn = createConnectionToMySql();

// Get the search query
$query = $_GET['q'];

// Perform the database query
$sql = "SELECT * FROM recipes WHERE name LIKE '%$query%'";
$result = $conn->query($sql);

// Generate HTML for the search results
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='recipe__card'>";
        echo "<img src='" . $row['img_url'] . "' alt='img'>";
        echo "<h3>" . $row['name'] . "</h3>";
        echo "<p>" . $row['description'] . "</p>";
        echo "</div>";
    }
} else {
    echo "<p>No results found.</p>";
}

// Close the database connection
$conn->close();
?>