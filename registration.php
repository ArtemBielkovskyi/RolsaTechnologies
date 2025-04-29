<?php
include "header.php";
include 'database/db_connect.php';
$conn = new mysqli($servername, $username, $password, $dbname);
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // setting all variables 
    $email = $_POST['email'];
    $password = $_POST['password'];
    $username = $_POST['username'];
    $timezone = new DateTimeZone("Europe/London" );
    $date = new DateTime();
    $date->setTimezone($timezone );
    $dtobj = $date->format('Y-m-d H:i:s');
    $confirmPassword = $_POST['confirmPassword'];
    $type='null';
    // connnecting table
    $checkEmailStmt = $conn->prepare("SELECT email FROM userinformation WHERE email = ?");
    $checkEmailStmt->bind_param("s", $email);
    $checkEmailStmt->execute();
    $checkEmailStmt->store_result();
    //Security statements for a various issues
    if ($checkEmailStmt->num_rows > 0) {
        $message = "Email already exists";
    }elseif($password!==$confirmPassword){
        $message = "Passwords are not the same!";
    }elseif(strlen($password)<=5){
        $message = "Password needs to be longer than 5 characters";
    }
    else {
        //Hashing password
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        //Creating and inserting new column into existing table
        $stmt = $conn->prepare("INSERT INTO userinformation (email,username, password, type, lastLogin) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $email, $username, $hashPassword, $type, $dtobj);

        if ($stmt->execute()) {
            //Creating session data
            session_start();
            $_SESSION['email'] = $email;
            $_SESSION['username'] = $username;
            $_SESSION['lastLogin'] = $dtobj;
            $_SESSION['type'] = $type;
            // Redirecting user into index page
            echo '<script type="text/javascript">window.open("index.php","_self");</script>';
            $message = "Account created successfully";
        } else {
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $checkEmailStmt->close();
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="registration.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>Registration</title>
</head>
<body>
    <div class="mainContainer">
    <form method="post" class="regContainer">
        <center><span class="blockTitle">Registration</span></center>
        <div class="username">username:<br><input type="username" name="username"/></div>
        <div class="email">Email address:<br><input type="email" name="email"/></div>
        <div class="password">Password:<br><input type="password" name="password"/></div>
        <div class="confirmPassword">Confirm password:<br><input type="password" name="confirmPassword"/></div>
        <center><button type="submit" class="btn btn-outline-success">Create account</button></center>
        <a href="login.php" type="_blank">Exisitng user? Log in</a>
        <h4 class="message"><?php echo $message ?></h4>
    </form>
    </div>
    <script src="js/bootstrap.bundle.js"></script>
</body>
</html>