<?php

function createConnectionToMySql(){
    
    $host = "localhost";
    $DB_name = "web23_ahysaj";
    $username = "ahysaj";
    $password = "Gjeswe23";
    
    $conn = new mysqli($host, $username, $password, $DB_name);
    return $conn;
}

// Start user session
session_start();

// Check login status
if (isset($_SESSION["isLogedIn"]) && $_SESSION["isLogedIn"] == true) {
    // If the user is already logged in, redirect to recipes page.
    redirectRecipes(); 
}

// Create connection with the database
$conn = createConnectionToMySql();

// Create Users table in the database if it does not already exist
createUsersTable($conn);

$status = ""; // Variable to store login status

try {
    if (isset($_POST['login'])) {
        $status = login($conn);
    } else if (isset($_POST['register'])) {
        $status = register($conn);
    }
} catch (Exception $e) {
    //Hide the error from user and show another message
    $status = "Sorry, an error occurred. Please try again later.";
}

// Close the database connection
$conn->close();

function createUsersTable($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(30) NOT NULL,
        email VARCHAR(30) NOT NULL,
        password VARCHAR(40) NOT NULL
        )";

    $stmt = $conn->prepare($sql);

    try {
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Sorry, an error occurred. Please try again later.";
        throw new Exception("Failed to create users table");
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Redirect to recipes page if registration is successful
if ($status === "registered") {
    redirectRecipes();
}

function register($conn) {
    $usernameErr = $passwordErr = $emailErr = "";
    $username = $password = $email = "";
    $isSubmitted = false;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["username"])) {
            $usernameErr = "Username is required";
        } else {
            $username = test_input($_POST["username"]);
            if (!preg_match("/^[a-zA-Z0-9 ]*$/", $username)) {
                $usernameErr = "Only letters, numbers, and white space allowed";
            }
        }

        if (empty($_POST["password"])) {
            $passwordErr = "Password is required";
        } else {
            $password = test_input($_POST["password"]);
            if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,16}$/", $password)) {
                $passwordErr = "Password must contain 8-16 characters, at least 1 uppercase letter, 1 lowercase letter, and 1 number";
            }
        }

        if (empty($_POST["email"])) {
            $emailErr = "Email is required";
        } else {
            $email = test_input($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            }
        }

        if (empty($usernameErr) && empty($passwordErr) && empty($emailErr)) {
            // Check if the user already exists in the database
            $query = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                $emailErr = "Email already exists";
            } else {
                $hashedPassword = md5($password);

                $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";

                $stmt = mysqli_prepare($conn, $sql);
                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPassword);

                    if (mysqli_stmt_execute($stmt)) {
                        $isSubmitted = true;
                    } else {
                        echo "Error: " . mysqli_stmt_error($stmt);
                    }

                    mysqli_stmt_close($stmt);
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            }
            if ($isSubmitted) {
                // Log User registration 
                file_put_contents('log.txt', $username . " is registered with email '" . $email . "' at " . date('Y-m-d H:i:s') . ".\n", FILE_APPEND);

                // Set session variables for the registered user
                $_SESSION["isLogedIn"] = true;
                $_SESSION["username"] = $username;

                // Redirect to recipes page
                header("Location: recipes.php");
                exit;
            } else {
                return "Couldn't create account";
            }
        }
    }
}

function login($conn){

    $username = $_POST['username'];
    $password = $_POST['password'];

    if($username == "" || $password == ""){
        return "Username/Password is empty.";
    }

    // Retrieve user data from the database
    $sql = "SELECT * FROM users WHERE username = '$username'";

    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['password'];
        //Verify the entered password with the hashed password
        if (md5($password) === $storedPassword) {
            file_put_contents('log.txt', $username." is logged in at ".date('Y-m-d H:i:s').".\n", FILE_APPEND);
            // redirect user to recipes page
            $_SESSION["isLogedIn"] = true;
            $_SESSION['username'] = $username;
            redirectRecipes();
        } else {
            echo "Password or username is incorrect";
        }

    } else {
        return "User not found!";
    }
}

// Redirect to recipes page
function redirectRecipes() {
    header("Location: recipes.php");
    exit;
}

?>