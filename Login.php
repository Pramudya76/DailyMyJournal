<?php
    include "service/database.php";
    session_start();

    $login_message = "";

    if(isset($_SESSION["is_login"])) {
        header("location: dashboard.php");
    }

    if(isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        //$hash_password = hash("sha256",$password);

        $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";

        $result = $db->query($sql);

        if($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $_SESSION ["username"] = $data["username"];
            $_SESSION ["is_login"] = true;
            
            header("location: dashboard.php");

        }else  {
            $login_message =  "datanya tidak ada di database";
        }
        $db->close();

    }


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
    
    <div class="login-container">
        
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" placeholder="Username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" placeholder="Password" name="password" required>
            </div>
            <button type="submit" name="login">Submit</button>
        </form>
        <div class="taskbar">
            <p>belum punya akun?</p>
            <a href="register.php">Daftar</a>
        </div>
        <p id="error-message"></p>
    </div>

    
</body>
</html>

