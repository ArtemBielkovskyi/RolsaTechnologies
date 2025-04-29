<?php
include "header.php";
include 'database/db_connect.php';
$conn->close();
$conn = new mysqli($servername, $username, $password, $dbname);

$message="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $email = $_SESSION['email'];

    $stmt = $conn->prepare("SELECT password FROM userinformation WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    // Checking if user exists 
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($db_password);
        $stmt->fetch();
        // Making sure old password verification
        if (password_verify($oldPassword, $db_password)) {
            // trimming unappropriate inputs
            $trim = strip_tags($newPassword);
            $trim=str_replace([" ","\n","\t","&ndash;","&rsquo;","&#39;","&quot;","&nbsp;"], '', $trim);

            $totalCharacter = strlen(utf8_decode($trim));
            // Making sure that new password isn't equal to the old one 
            if (!password_verify($newPassword, $db_password)){
                // Making sure password is longer than 5 characters 
                if($totalCharacter>5){
                    $password = $_POST['newPassword'];
                    $hashPassword = password_hash($password, PASSWORD_DEFAULT);
                    $checkEmailStmt = $conn->prepare("UPDATE userinformation SET password = '$hashPassword' WHERE email = ?");
                    $checkEmailStmt->bind_param("s", $_SESSION['email']);
                    $checkEmailStmt->execute();
                    $checkEmailStmt->store_result();
                    $message="Password successfully changed!";
                } else{
                    $message="New password has to be longer than 5 characters";
                }
            }
            else{
                $message = "New password is the same as the old one!";
            }
        }
        else{
            $message="Old password doesn't match!";
        }
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
    <title>Change password</title>
</head>
<body>
    <center>
    <div class="container">
        <div class="usernameTitle">Change password</div>
        <form method="post">
            <input placeholder="Current password" class="Input" name="oldPassword">
            <input placeholder="New password" class="Input" name="newPassword"><br>
            <button type="submit" class="btn btn-outline-primary">Change password</button><br><br>
            <div style="color:green"><?php if($message == "Password successfully changed!"){echo $message;}?></div>
            <div style="color:red"><?php if(($message == "New password has to be longer than 5 characters") or ($message=="Old password doesn't match!") or ($message=="New password is the same as the old one!")){echo $message;}?></div>
        </form>
    </div>
    </center>
</body>
</html>