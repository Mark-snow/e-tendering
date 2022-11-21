<?php


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Tendering</title>
</head>
<body>
    <?php
        if(isset($_GET["buy"])){
    ?>


    <?php
        }elseif (isset($_GET["sell"])) {
    ?>
        <div class="container">
            <form action="index.php" method="post">
                <h3>Create new tender</h3>
                <label for="title">
                    <span>Title</span>
                    <input type="text" name="title" id="title">
                </label>
                <label for="description">
                    <span>Description</span>
                    <input type="text" name="description" id="description">
                </label>
                <label for="payment">
                    <span>Payment</span>
                    <input type="text" name="payment" id="payment">
                </label>
                <input type="submit" value="Create">
            </form>
        </div>

    <?php
            
        }else{
    ?>

        <div class="container">
            <h3>E-Tendering</h3>
            <p>Buying and selling of tenders online made easier.</p>
            <ul>
                <li><a href="?buy">Buy</a></li>
                <li><a href="?sell">Sell</a></li>
            </ul>
        </div>
   <?php 
        }
    ?>
</body>
</html>