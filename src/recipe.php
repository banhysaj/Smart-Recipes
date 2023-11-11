<?php
session_start();

// check login status
if(!isset($_SESSION["isLogedIn"])){
    // If user is not logged in, redirect to login page
    redirectLogin();
}

// redirect to login page
function redirectLogin(){
    header("Location: /recipes/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="./style/style.css" />
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        h1 {
            color: #333;
            font-size: 2.5rem;
            text-transform: uppercase;
            text-align: center;
            letter-spacing: 0.4rem;
            margin-top: 3rem;
        }

        small {
            color: #555;
            text-align: center;
            display: block;
            margin-bottom: 1rem;
        }

        p {
            color: #333;
            padding: 0 2rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .flex {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            padding: 0 2rem;
            margin-bottom: 2rem;
        }

        .flex span {
            background-color: #555;
            color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 16px;
        }

        .recipe-details__image {
            width: 100%;
            max-height: 40rem;
            object-fit: cover;
            margin-top: 3rem;
        }

        @media screen and (min-width: 768px) {
            .container {
                padding: 4rem;
            }

            h1 {
                font-size: 3rem;
            }

            p {
                font-size: 1.1rem;
            }

            .flex span {
                padding: 0.7rem 1.5rem;
                font-size: 1.1rem;
            }
        }
    </style>
</head>

<body>
    <nav>
        <a href="index.html" style="color: black;">RECIPES</a>
        <div>
            <a href="contact.php" style="background-color: black; color: white;">Contact</a>
            <a href="recipes.php" style="background-color: black; color: white;">Recipes</a>
            <a href="logout.php" style="background-color: black; color: white;">Logout</a>
        </div>
    </nav>
    <div class="container">
        <?php
        include "auth.php";
        // Create connection with database
        $conn = createConnectionToMySql();

        $name = $_GET['name'];

        $sql = "SELECT * FROM recipes WHERE name='$name'";

        $result = $conn->query($sql);

        if (mysqli_num_rows($result) > 0) {
            // Output data of each row
            $row = mysqli_fetch_assoc($result);
            echo "<img src='".$row['img_url']."' alt='' class='recipe-details__image'>";
            echo "<h1>".$name."</h1>";
            echo "<small>".$row['category']."</small>";
            echo "<p>".$row['description']."</p>";
            echo "<div class='flex'>";
            $ingredients_array = json_decode($row['ingredients'], true);
            foreach($ingredients_array as $ingredient){
                echo "<span>".$ingredient."</span>";
            }
            
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>



