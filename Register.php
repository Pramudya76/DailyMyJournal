<?php
    include "service/database.php";
    session_start();

    //$_SESSION['message'] = "Username sudah digunakan, silahkan ganti yang lain!";
    $register_message = "";

    if(isset($_SESSION["is_login"])) {
        header("location: dashboard.php");
    }

    if(isset($_POST['register'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        //$hash_password = hash("sha256",$password);

        try {
            $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

            if($db->query($sql)) {
            $register_message = "Daftar akun berhasil, silahkan daftar login";
            }else {
            $register_message = "Daftar akun gagal, silahkan ulangi kembali";
            }
        }catch(mysqli_sql_exception $e) {
            $register_message = "Username sudah digunakan, silahkan ganti yang lain";
            
        }
        $db->close();

        

        

    }


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <h2>Register</h2>
        <form action="register.php" method="POST">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" placeholder="Username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" placeholder="Password" name="password" required>
            </div>
            <button type="submit" name="register">Submit</button>
        </form>
        <div class="taskbar">
            <p>back to</p>
            <a href="login.php">Login</a>
        </div>
        <p id="error-message"></p>
    </div>

    
</body>
</html>
