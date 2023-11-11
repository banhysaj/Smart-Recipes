<?php
include 'auth.php';

// Initialize the $status variable
$status = "";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./style/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .password-container {
            position: relative;
        }

        .password-container i {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            color: black;
        }
    </style>
</head>
<body>
    <main class="height__screen bg__img">
        <div class="darken__mask"></div>
        <nav>
        <?php if (!isset($_SESSION["isLogedIn"]) || $_SESSION["isLogedIn"] != true): ?>
            <a href="index.html" style="color: black;">RECIPES</a>
            <div>
                <a href="contact.php" style="background-color: black; color: white;">Contact</a>
                <a href="register.php" style="background-color: black; color: white;">Register</a>
            </div>
        <?php endif; ?>
        </nav>
        <form class="custom__form" method="POST" action="">
            <h2>Login</h2>
            <input type="text" name="username" placeholder="Username" required/>
            <div class="password-container">
                <input type="password" name="password" placeholder="Password" required/>
                <i class="fas fa-eye" id="togglePassword"></i>
            </div>
            <button type="submit" name="login" value="Login" >Login</button>
            <p>Don't have an account? <a href="register.php">Register</a></p>
            <p><?php echo $status; ?></p>
        </form>
    </main>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.querySelector('input[name="password"]');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>