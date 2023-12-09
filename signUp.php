<?php

require_once "config.php";

$firstname = $lastname = $email = $password = $confirm_password = "";
$firstname_err = $lastname_err = $email_err = $password_err = $confirm_password_err = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Check if firstname is empty
    if (empty(trim($_POST['firstname']))) {
        $firstname_err = "First Name cannot be blank";
    } else {
        $firstname = trim($_POST['firstname']);
    }

    // Check if lastname is empty
    if (empty(trim($_POST['lastname']))) {
        $lastname_err = "Last Name cannot be blank";
    } else {
        $lastname = trim($_POST['lastname']);
    }

    // Check if email is empty
    if (empty(trim($_POST['email']))) {
        $email_err = "Email cannot be blank";
    } else {
        $email = trim($_POST['email']);
    }

    // Check for password
    if (empty(trim($_POST['password']))) {
        $password_err = "Password cannot be blank";
    } elseif (strlen(trim($_POST['password'])) < 5) {
        $password_err = "Password must be at least 5 characters";
    } else {
        $password = trim($_POST['password']);
    }

    // Password confirmation check
    if (trim($_POST['password']) != trim($_POST['confirm_password'])) {
        $confirm_password_err = "Password must be the same as your confirm password";
    }

    // If there were no errors, then insert data into the database
    if (empty($firstname_err) && empty($lastname_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {

        $sql = "INSERT INTO user (First_Name, Last_Name, Email, Password, Creation_time) VALUES (?, ?, ?, ?, NOW())";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssss", $param_firstname, $param_lastname, $param_email, $param_password);

            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Store the hashed password

            if (mysqli_stmt_execute($stmt)) {
                header("location: login.php");
                exit();
            } else {
                echo "Something went wrong. We can't redirect. Error: " . mysqli_error($conn);
            }

            mysqli_stmt_close($stmt);
        }
    }

    mysqli_close($conn);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Signup Page</title>
</head>

<body>
    <div class="signup-container">
        <h2>Sign Up</h2>
        <form action="signup.php" method="post">
            <input type="text" name="firstname" placeholder="First Name" required>
            <input type="text" name="lastname" placeholder="Last Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <input type="submit" value="Sign Up">
        </form>
        <div class="form-footer">
            Already have an account? <a href="login.php">Login here</a>.
        </div>
    </div>
</body>

</html>
