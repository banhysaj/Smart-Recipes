<?php

include "auth.php";

session_start();

// check login status
if(!isset($_SESSION["isLogedIn"])){
    // If user is not logged in, redirect to login page
    redirectLogin();
}


// Create connection with databasse
$conn = createConnectionToMySql();

// Create recepies table
createRecipesTable($conn);

// Create Recepies Table
function createRecipesTable($conn){
    $sql = "CREATE TABLE IF NOT EXISTS recipes (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        description VARCHAR(200) NOT NULL,
        img_url VARCHAR(100) NOT NULL,
        ingredients JSON NOT NULL,
        category VARCHAR(30) NOT NULL
    )";
   
    $stmt = $conn->prepare($sql);
    
    try{
        $stmt->execute();
    } catch(PDOException $e){
        // Handle any errors that occur during execution
    }
}


// redirect to login page
function redirectLogin(){
    header("Location: recipes/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipes</title>
    <link href="./style/style.css" rel="stylesheet"/>
</head>
<body>
    <div class="recipe__container">
    <nav>
        <a href="index.html" style="color: black;">RECIPES</a>
        <div>
            <a href="contact.php" style="background-color: black; color: white;">Contact</a>
            <a href="recipes.php" style="background-color: black; color: white;">Recipes</a>
            <a href="logout.php" style="background-color: black; color: white;">Logout</a>
        </div>
    </nav>
        <?php
               $sql = "SELECT * FROM recipes";

               $result = $conn->query($sql);
           
               if (mysqli_num_rows($result) > 0) {
                   // Output data of each row
                   while ($row = mysqli_fetch_assoc($result)) {
                       echo "<div class='recipe__card'>";
                       echo "<img src='".$row['img_url']."' alt='img'>";
                       echo "<h3>".$row['name']."</h3>";
                       echo "<p>".$row['description']."</p>";
                       echo "</div>";
                   }
               } 

               // Close database connection
                $conn->close();
        ?>
    </div>
</body>
<script src='./js/script.js'></script>
</html>