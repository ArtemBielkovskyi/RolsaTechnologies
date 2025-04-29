<?php
    // Recieving page name to hide registartion button if user is on registration/login pages
    $pageName = basename($_SERVER['PHP_SELF']);
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="header.css">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
    <div class="header">
        <div class="slider"></div>
        <div class="hamburger" onclick="toggleMenu();">
            <div class="line1 l" id="l1"></div>
            <div class="line2 l" id="l2"></div>
        </div>
        <img src="img/logo.png" class="logo" width="40px">
        <span class="Title" onclick="window.open('index.php','_self');toggleMenu();">Rolsa Technologies</span>
        <div class="button navigation" onclick="window.open('index.php','_self');toggleMenu();">About us</div>
        <div class="button navigation" onclick="window.open('carbonFootprint.php','_self');toggleMenu();">Carbon footprint</div>
        <div class="button navigation" onclick="window.open('products.php','_self');toggleMenu();">Green products</div>
        <div class="button navigation" onclick="window.open('contact.php','_self');toggleMenu();">Contact us</div>
        <?php if($pageName!=="registration.php" and $pageName!=="login.php" and !isset($_SESSION['email'])):?>
        <div class="button Registration Reg" onclick="window.open('registration.php','_self');toggleMenu();">Registration</div>
        <?php endif; ?>
        <?php if($pageName!=="registration.php" and $pageName!=="login.php" and isset($_SESSION['email'])):?>
            <?php if($_SESSION['type']=='admin'):?>
                <div class="button navigation" onclick="window.open('adminCentre.php','_self');toggleMenu();">Admin centre</div>
                <img src="img/crown.png" width="17px" height="22px" class="adminCrown">
            <?php endif; ?>
        <div class="userName" onclick="window.open('account.php','_self');toggleMenu();"><?php echo $_SESSION['username']?></div>
        <div class="button Reg" onclick="window.open('logout.php','_self');">Logout</div>
        <?php endif; ?>
    </div>

    <script src="js/bootstrap.bundle.js"></script>
    <script>
        // Written logic for hamburger buttons including haburger animation 
        const hamburger = document.querySelector(".hamburger");
        const buttons = document.querySelectorAll(".button");
        const header = document.querySelectorAll(".header");
        const slider = document.querySelector(".slider");
        const userName = document.querySelector(".userName");
        const log = document.querySelector(".Reg");
        const Reg = document.querySelector(".Registration");
        const line1 = document.getElementById("l1");
        const line2 = document.getElementById("l2");
    
        function toggleMenu() {
        var margin = 10;
        if (hamburger.classList.contains("showMenu")) {
            hamburger.classList.remove("showMenu");
            line1.classList.remove("line1A");
            line2.classList.remove("line2A");
            line1.style.marginTop="33%";
            line2.style.marginTop="33%";
            line1.style.position="relative";
            line2.style.position="relative";
            line1.style.transition="all 0.3s";
            line2.style.transition="all 0.3s";
            slider.classList.remove("slider2");
            buttons.forEach( 

            function(buttons) { 

                buttons.style.display="none";
            }

            )
            hamburger.style.position="relative";
            try{
                userName.style.display="none";
            } catch(error){

            }
        } else {
            hamburger.classList.add("showMenu");
            slider.classList.add("slider2");
            line1.classList.add("line1A");
            line2.classList.add("line2A");
            line1.style.marginTop="50%";
            line2.style.marginTop="50%";
            line1.style.position="absolute";
            line2.style.position="absolute";
            hamburger.style.position="fixed";
            buttons.forEach( 

            function(buttons) { 
                buttons.style.display="block";
                buttons.style.float="left";
                buttons.style.position="fixed";
                buttons.style.marginTop=margin+'vh';
                margin = margin+10
            }

            )
            try{
            userName.style.display="block";
            userName.style.float="left";
            userName.style.position="fixed";
            userName.style.top="-5px";
            userName.style.right="0px";
            userName.style.fontSize="1.5em";
            log.style.display="block";
            log.style.float="left";
            log.style.position="fixed";
            log.style.bottom="100px";
            log.style.left="45%";
            } catch(error){
            Reg.style.display="block";
            Reg.style.float="left";
            Reg.style.position="fixed";
            Reg.style.bottom="100px";
            Reg.style.left="31%";
            }
        }
        }

        
    </script>
</body>
</html>