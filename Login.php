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

        // Cek apakah ini admin
        if($username === "Admin" && $password === "123") {
            $_SESSION["username"] = $username;
            $_SESSION["is_login"] = true;
            header("Location: dashboard.php");

        } 
        // Jika bukan admin, cek di database
        else {
            $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
            $result = $database->query($sql);

            if($result->num_rows > 0) {
                $data = $result->fetch_assoc();
                $_SESSION["username"] = $data["username"];
                $_SESSION["is_login"] = true;
                header("location: index2.php");
                exit();
            } else {
                $login_message = "Username atau password salah";
            }
        }
        $database->close();
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

