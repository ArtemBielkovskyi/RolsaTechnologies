<?php
include "header.php";
include 'database/db_connect.php';
try{
    $conn->close();
    $conn = new mysqli($servername, $username, $password, $dbname);
} catch (Exception $e){
    $conn = new mysqli($servername, $username, $password, $dbname);
}
// Setting timezone variable to add it into table 
$timezone = new DateTimeZone("Europe/London" );
$date = new DateTime();
$date->setTimezone($timezone );
$dtobj = $date->format('Y-m-d H:i:s');
$_SESSION['lastLogin']=$dtobj;

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT password, username, type, lastLogin FROM userinformation WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    //if user email exists 
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($db_password, $db_username, $type, $db_lastLogin);
        $stmt->fetch();
        //If passwords are matching 
        if (password_verify($password, $db_password)) {
            $message = "Login successful";
            $_SESSION['email'] = $email;
            $_SESSION['username'] = $db_username;
            $_SESSION['type'] = $type;
            $conn->close();
            include "database/db_connect.php";
            //updating last login date in the database table
            $conn = new mysqli($servername, $username, $password, $dbname);
            $lastLogin = $_SESSION['lastLogin'];
            $checkEmailStmt = $conn->prepare("UPDATE userinformation SET lastLogin = '$lastLogin' WHERE email = ?");
            $checkEmailStmt->bind_param("s", $_SESSION['email']);
            $checkEmailStmt->execute();
            $checkEmailStmt->store_result();
            // redirecting user to index page 
            echo '<script type="text/javascript">window.open("index.php","_self");</script>';
            exit();
        } else {
            $message = "Incorrect password";
        }
    } else {
        $message = "Email not found";
    }


    $stmt->close();
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>Login</title>
</head>
<body>
    <div class="mainContainer">
    <form method="post" class="logContainer">
        <center><span class="blockTitle">Log in</span></center><div class="email">Email address:<br><input type="email" name="email"/></div>
        <div class="password">Password:<br><input type="password" name="password"/></div>
        <center><button type="submit" class="btn btn-outline-success">Login</button></center>
        <a href="registration.php" type="_blank">Create account?</a>
        <h4 class="message"><?php echo $message ?></h4>
    </form>
    </div>
    <script src="js/bootstrap.bundle.js"></script>
</body>
</html>