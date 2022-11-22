<?php
   include("db.php");
   
   if(isset($_POST["signup"])){
       
       $name = htmlspecialchars($_POST["name"]);
       $email = htmlspecialchars($_POST["email"]);
       $org = htmlspecialchars($_POST["organization"]);
       $gender = htmlspecialchars($_POST["gender"]);
       $password = htmlspecialchars($_POST["password"]);
       
       if($name == "" || $email == "" || $gender == "" || $password == ""){
           echo '<div class="message error">Please provide all required fields</div>';
       }else{
           $db = new Database ();
           
           if($db->register($name, $email, $org, $gender, $password)){
               
               if(session_id() != ''){
                   session_destroy();
               }
               
               session_start();
                $_SESSION["user_id"] = $db->insert_id();
                $_SESSION["name"] = $name;
                $_SESSION["email"] = $password;
               
               echo '<div class="message success">Registerd successfully</div>';
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
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <h3>E-Tendering Sign up</h3>
        <form action="signup.php" method="post">
            <input type="text" name="name" id="name" placeholder="Name">
            <input type="text" name="email" id="email" placeholder="Email">
            <input type="text" name="organization" id="organization" placeholder="Organization">
            <label for="gender">
                <span>Gender</span>
                <select name="gender" id="gender">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </label>

            <input type="password" placeholder="password" name="password">
            <input type="submit" value="Sign up" name="signup" >

            <a href="login.php">Login</a>
        </form>
    </div>
</body>
</html>