<?php
include "header.php";
include 'database/db_connect.php';
$conn->close();
$conn = new mysqli($servername, $username, $password, $dbname);

$message="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = $_POST['username'];
    // Trimming unappropriate characters 
    $trim = strip_tags($content);
    $trim=str_replace([" ","\n","\t","&ndash;","&rsquo;","&#39;","&quot;","&nbsp;"], '', $trim);

    $totalCharacter = strlen(utf8_decode($trim));
    //Making sure new username has more than 3 characters
    if($totalCharacter>3){
        $username = $_POST['username'];
        $checkEmailStmt = $conn->prepare("UPDATE userinformation SET username = '$username' WHERE email = ?");
        $checkEmailStmt->bind_param("s", $_SESSION['email']);
        $checkEmailStmt->execute();
        $checkEmailStmt->store_result();
        echo '<script type="text/javascript">window.open("index.php","_self");</script>';
        $_SESSION['username'] = $username;
    } else{
        $message="New username has to be longer than 3 characters";
    }
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="changeData.css">
    <title>Change username</title>
</head>
<body>
    <center>
    <div class="container">
        <div class="usernameTitle">Change username</div>
        <form method="post">
            <input placeholder="New username" class="Input" name="username"><br>
            <button type="submit" class="btn btn-outline-primary">Change username</button><br><br>
            <div style="color:red"><?php if(isset($message)){echo $message;}?></div>
        </form>
    </div>
    </center>
</body>
</html>