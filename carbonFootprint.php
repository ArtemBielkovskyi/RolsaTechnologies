<?php
include "header.php";
include "database/db_connect.php";
// Gaining data from emmision database to present it as a dashboards 
$conn = new mysqli($servername, $username, $password, $carbondb);
$result = $conn->query('SELECT emission FROM carbonEmission');
$emission = array();
while ($row = $result->fetch_assoc()){
    $emission[] = $row['emission'];
}
//Creating encoded json array, so we can use it in JS file later
$encodeEmission = json_encode($emission);

$result = $conn->query('SELECT year FROM carbonEmission');
$year = array();
while ($row = $result->fetch_assoc()){
    $year[] = $row['year'];
}
//Creating encoded json array, so we can use it in JS file later
$encodeYear = json_encode($year);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="carbon.css">
        <title>Carbon footprint</title>
    </head>
    <body>
        <center><div class="title">Emission data</div></center>
        <div class="chartContainer">
        <canvas id="myChart"></canvas>
        </div>
        <div class="chartContainer2">
        <canvas id="myChart2"></canvas>
        </div>
        <center>
            <a href="#Reduce"><img src="img/down-arrow.png" class="down"></a>
            <div class="secondSection">
                <video autoplay muted loop class="video" id="video">
                    <source src="img/video.mp4" type="video/mp4">
                </video>
                <div class="vidTitle">Rolsa Technologies</div>
                <a href="#Reduce"><img src="img/down-arrow (1).png" class="down2"></a>
            </div>
            <div class="title2" id="Reduce">How to make our planet greener?</div>
            <div class="title3">Reduce your carbon footprint</div>
            <div class="carbonInfo">
                <div class="firstSet">
                    <span class="firstSetText">Eat low on food chain</span>
                    <span class="firstSetText">Choose organic and local food</span>
                    <span class="firstSetText">Don't buy fast fasion clothes</span>
                </div>
                <div class="line"></div>
                <div class="secondSet">
                    <span class="secondSetText">Buy less stuff</span>
                    <span class="secondSetText">Do an energy audit</span>
                    <span class="secondSetText">Use green energy</span>
                </div>
            </div>
        </center>
        <center><div class="title">Carbon footprint calculator</div></center>
        <iframe width="100%" height="700px" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" src="https://calculator.carbonfootprint.com/calculator.aspx"></iframe>
            



        <!-- Chart JS  -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script head="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js">
            const ctx = document.getElementById('myChart');
            // Preparing encoded json file and creating a JS array instead 
            var emission = JSON.parse('<?php echo $encodeEmission; ?>');
            var year = JSON.parse('<?php echo $encodeYear; ?>');
            new Chart(ctx, {
            type: 'line',
            data: {
                labels: year,
                datasets: [{
                label: 'World carbon footprint',
                data: emission,
                borderWidth: 1
                }]
            },
            options: {
                scales: {
                y: {
                    beginAtZero: false
                }
                }
            }
            });
            // Second chart 
            const ctx2 = document.getElementById('myChart2');
            var emission = [74.4,17.3,6.2,2.1];
            var year = ['Carbon dioxide','Methane','Nitrous oxide','Other emissions'];
            new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: year,
                datasets: [{
                label: 'emission sources %',
                data: emission,
                borderWidth: 1
                }]
            }
            });
        </script>
    </body>
</html>