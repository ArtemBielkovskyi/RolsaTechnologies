<?php
include "header.php";
include "database/db_connect.php";
// Security measure if user trying to access admin center without being an admin
if($_SESSION['type']!=='admin'){
    echo '<script type="text/javascript">window.open("index.php","_self");</script>';
}
$conn->close();
$conn = new mysqli($servername, $username, $password, $dbname);
// Total amount of users registered
$stmt = $conn->prepare("SELECT * FROM userinformation");
$stmt->execute();
$stmt->store_result();
$amountOfUsers = $stmt->num_rows;
// Gaining information about last registered user
$stmt = $conn->prepare("SELECT email, type, username, lastLogin FROM userinformation WHERE id = ?");
$stmt->bind_param("s", $amountOfUsers);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($db_email, $type, $db_username, $db_lastLogin);
$stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <title>Admin centre</title>
</head>
<body>
    <center><div class="title">User analitics</div>
    <div class="chartContainer" style="width:50vh; margin-top:5%;">
        <canvas id="myChart"></canvas>
    </div>
    <div class="lastUser" style="font-size:1.5em; margin-top:5%;">Last registered user:</div>
    <div class="email">Email: <?php echo $db_email; ?></div>
    <div class="username">Username: <?php echo $db_username; ?></div>
    <div class="type">Acount type: <?php echo $type; ?></div>
    <div class="loginDate">Last login date: <?php echo $db_lastLogin; ?></div>
    </center>

    <!-- Chart JS library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script head="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js">
        const ctx = document.getElementById('myChart');
        var users = '<?php echo $amountOfUsers;?>';
        var label = 'x';
        new Chart(ctx, {
        type: 'bar',
        data: {
            labels: label,
            datasets: [{
            label: 'Amount of registered users',
            data: users,
            borderWidth: 1
            }]
        },
        options: {
            scales: {
            y: {
                beginAtZero: true,
            }
            }
        }
        });
    </script>
</body>
</html>