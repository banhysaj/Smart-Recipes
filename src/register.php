<?php include 'auth.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="./style/style.css" />
</head>
<body>
    <main class="height__screen bg__img">
        <div class="darken__mask"></div>
        <nav>
            <a href="index.html">RECIPES</a>
            <div>
                <a href="contact.php">Contact</a>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            </div>
        </nav>
        <form class="custom__form" method="POST" action="">
            <h2>Register</h2>
            <input type="email" name="email" placeholder="Email" required/>
            <input type="text" name="username" placeholder="Username" required/>
            <input type="password" name="password" placeholder="Password" required/>
            <button type="submit" name="register" value="Register">Register</button>
            <p>Already have an account? <a href="login.php">Login</a></p>
            <p><?php echo $status; ?></p>
        </form>
    </main>
</body>
</html>