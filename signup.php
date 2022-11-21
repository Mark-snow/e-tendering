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
        <form action="signup.php">
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
            <input type="submit" value="Create" >

            <a href="signup.php">Login</a>
        </form>
    </div>
</body>
</html>