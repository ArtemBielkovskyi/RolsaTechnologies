<?php
include "header.php";
include "database/db_connect.php";
// Security measure, if user going to try to access account page unsigned 
if(!isset($_SESSION['email'])){
    echo '<script type="text/javascript">window.open("index.php","_self");</script>';
}
// Changing account type to admin
$conn->close();
$conn = new mysqli($servername, $username, $password, $dbname);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = $_POST['code'];
    if($code == "OcProjectMar25"){
        $adminPremission = $conn->prepare("UPDATE userinformation SET type = 'admin' WHERE email = ?");
        $adminPremission->bind_param("s", $_SESSION['email']);
        $adminPremission->execute();
        $adminPremission->store_result();
        $_SESSION['type'] = "admin";
        $success = "Acount type has been changed";
        // redirecting user to an admin page if code is valid
        echo '<script type="text/javascript">window.open("adminCentre.php","_self");</script>';
    } else{
        $error = "Invalid code!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <center>
    <div class="accountInfo">
        <div class="accountTitle">Account information</div>
        <div class="accName Info">
            Username: <?php echo $_SESSION['username']; ?>
        </div>
        <div class="accEmail Info">
            Email: <?php echo $_SESSION['email']; ?>
        </div>
        <div class="accLastLogin Info">
            Last login date: <?php echo $_SESSION['lastLogin']; ?>
        </div>
        <!-- if account type is not an admin -->
        <?php if($_SESSION['type']=='null'):?>
        <form method="post">
            <br><br>Admin privileges?<br>
            <input type="password" name="code" class="AdminCode" placeholder="Admin code"><button type="submit" class="btn btn-success codeSubmit">Submit</button>
            <?php if(isset($error)):?>
                <div class="errorMessage" style="color:red;"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if(isset($success)):?>
                <div class="errorMessage" style="color:green;"><?php echo $success; ?></div>
            <?php endif; ?>
        </form>
        <?php endif;?>
        <!-- if account type is admin -->
        <?php if($_SESSION['type']=='admin'):?>
            Account type: <?php echo $_SESSION['type']; ?>
        <?php endif; ?>
        <div class="buttonContainer">
            <a href="changeUsername.php"><button type="button" class="btn btn-outline-dark btn-lg">Change username</button></a>
            <a href="changePassword.php"><button type="button" class="btn btn-outline-dark btn-lg">Change password</button></a>
        </div>
    </div>
    </center>
</body>
</html>