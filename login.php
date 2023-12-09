<?php
// This script will handle login
session_start();

// check if the user is already logged in
if (isset($_SESSION['email'])) {
    header("location: welcome.php");
    exit;
}

require_once "config.php";

$email = $password = "";
$err = "";

// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty(trim($_POST['email'])) || empty(trim($_POST['password']))) {
        $err = "Please enter email + password";
    } else {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
    }

    if (empty($err)) {
        $sql = "SELECT id, email, password FROM user WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $param_email);
        $param_email = $email;

        // Try to execute this statement
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) == 1) {
                mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password);
                if (mysqli_stmt_fetch($stmt)) {
                    if (password_verify(trim($password), $hashed_password)) {
                        // this means the password is correct. Allow the user to login
                        $_SESSION["email"] = $email;
                        $_SESSION["id"] = $id;
                        $_SESSION["loggedin"] = true;
                    
                        // Redirect the user to the welcome page
                        header("location: welcome.php");
                        exit();
                    } else {
                        echo "Password verification failed. Input password: $password, Hashed password: $hashed_password";
                    }
                    
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login Page</title>
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <!-- Add your form fields here (email, password) -->
            <!-- Example: -->
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
        </form>
        <div class="form-footer">
            Don't have an account? <a href="signUp.php">Sign up here</a>.
        </div>
    </div>
</body>

</html>
