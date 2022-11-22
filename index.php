<?php
    include ("db.php");
    session_start();
    
    if(session_id() == ""){
        header("Location: ", "/login.php");
    }else{
        if(isset($_POST["create_tender"])){
           
            $title = htmlspecialchars($_POST["title"]);
            $description = htmlspecialchars($_POST["description"]);
            $payment = htmlspecialchars($_POST["payment"]);
            
            $id = $_SESSION["user_id"];
            
            $db = new Database();
            $seller_id = $db->get_seller_by_user($id);
            
            
            if(!$seller_id){
               $db->add_seller($id);
               $seller = $db->insert_id();
            }
            
            if($db->add_tender($title, $description, $payment, $seller)){
                echo '<div class="message success">Tender created successfully</div>';
            }
           
            
        }
        
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Tendering</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        if(isset($_GET["buy"])){
    ?>
        <div class="container">
            <h3>List of tenders</h3>
            <table>
                <thead>
                    <tr>
                        <td>Title</td>
                        <td>Description</td>
                        <td>Payment</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $db = new Database();
                        $tenders = $db->list_tenders();
                        
                        while($tender = $tenders->fetch_assoc()){
                            echo '<tr>
                                    <td>'.$tender["title"].'</td>'.
                                    '<td>'.$tender["description"].'</td>'.
                                    '<td>'.$tender["payment"].'</td>'.
                                    '<td><a href="?view='.$tender["tender_id"].'">View</a></td>
                                </tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>

    <?php
        }elseif (isset($_GET["sell"])) {
    ?>
        <div class="container">
            <form action="index.php?sell" method="post">
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
                <label for="create_tender">
                    <input type="submit" value="Create" name="create_tender">
                </label>
            </form>
        </div>

    <?php
        }elseif(isset($_GET["view"])){
            $db = new Database ();
            
            $id = htmlspecialchars($_GET["view"]);
            $tender = $db->get_tender($id);
            ?>
                 <div class="container">
                     <h3><?= $tender["title"] ?></h3>
                     <p><?= $tender["description"] ?></p>
                 </div>
    <?php
            
        }else{
    ?>

        <div class="container">
            <h3>E-Tendering</h3>
            <p>Buying and selling of tenders online made easier.</p>
            
                <a href="?buy" class="button">Buy</a>
                <a href="?sell" class="button">Sell</a>
            
        </div>
   <?php 
        }
    ?>
</body>
</html>