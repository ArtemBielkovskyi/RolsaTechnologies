<?php
include "header.php";
// Energy price calculator
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $volume = $_POST['volume'];
    $length = $_POST['length'];
    $price = $_POST['price'];
    if(is_numeric($volume) and is_numeric($length) and is_numeric($price)){
        if($volume>0 and $length>0 and $price>0){
            $result = $volume * $length * $price;
        } else{
            $error = "Values can not be less than 0";
        }
    } else{
        $error = "Incorrect value";
    }
    
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="products.css">
    <title>Products</title>
</head>
<body>
    <center>
        <div class="title">Our green energy products</div>
        <div class="subTitle">Contact us through our email to make a purchase</div>
    </center>
    <!-- Products container -->
    <div class="container text-center">
        <div class="row justify-content-md-center gx-5 gy-5">
        <?php
            $imgSrc = 'img/solarPanelItem.jpg';
            $imgAlt = 'Solar panel';
            $imgTitle = 'Solar panel installation and maintenance'; 
            $productTitle = 'Solar panel installation and maintenance';
            $productText = 'Install solar pannels and maintain them, using our full services package.';
            $productButton = 'From 599£';
            include "productItem.php";
            $imgSrc = 'img/thermostatItem.jpg';
            $imgAlt = 'Smart heating';
            $imgTitle = 'Smart house'; 
            $productTitle = 'Smart house thermostat installation';
            $productText = 'Smart thermostat installation and home energy management';
            $productButton = 'From 300£';
            include "productItem.php";
            $imgSrc = 'img/chargingItem.jpg';
            $imgAlt = 'Charging station';
            $imgTitle = 'Chragin station'; 
            $productTitle = 'Electric vehicle charging station installation and maintenance';
            $productText = 'Installation of charging station for your electric vehicles';
            $productButton = 'From 1299£';
            include "productItem.php";
        ?>
        </div>
    </div>
    <center><a href="#calculate"><img src="img/down-arrow.png" class="down" width="100px" style="position:absolute; bottom: 15px; margin-left:-50px;"></a></center>
    <center>
        <!-- Electricity calculator form -->
    <div class="electricity">
        <div class="elTitle" id="calculate">Calculate your electricity usage</div>
        <div class="calculator">
            <form method="post" class="logContainer">
            <div class="power field"><input placeholder="5" name="volume">kW</div>
            <div class="hours field"><input placeholder="24" name="length">h</div>
            <div class="price field"><input placeholder="0.15" name="price">£/kW</div>
            <button type="submit" class="btn btn-outline-success">Calculate</button>
            </form>
            <?php if(isset($result)): ?>
                <div class="result">Electricity bill = <span style="color:green; font-size:1.7em;"><?php echo $result;?>£</span></div>
            <?php endif; ?>
            <?php if(isset($error)): ?>
                <div class="result" style="color: red;"><?php echo $error;?></div>
            <?php endif; ?>
        </div>
    </div>
    </center>
</body>
</html>