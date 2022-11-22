<?php
   include("db.php");
   
   session_start();
   
   
   if(isset($_POST["login"])){
       $db = new Database();
       
       $email = htmlspecialchars($_POST["email"]);
       $password = htmlspecialchars($_POST["password"]);
       
       $result = $db->login($email, $password);
       if ($result){
           $_SESSION["user_id"] = $result["user_id"];
           $_SESSION["name"] = $result["name"];
           $_SESSION["email"] = $result["email"];
           echo '<meta http-equiv="refresh" content="2;url=index.php">';
           echo '<div class="message success">Welcome back, '.$_SESSION["name"].'</div>';
           
       }else{
           echo '<div class="message error">Invalid credentials</div>';
       }
       
   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <h3>E-Tendering Login</h3>
        <form action="login.php" method="post">
            <input type="email" placeholder="Email" name="email">
            <input type="password" placeholder="password" name="password">
            <input type="submit" name="login" value="login">

            <a href="signup.php">Create account</a>
        </form>
    </div>
</body>
</html>