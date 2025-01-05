<?php
    $hostname = "localhost";
    $username = "myuser";
    $password = "Pramudya76";
    $database_name = "article";

    $conn = mysqli_connect($hostname, $username, $password, $database_name);

    if($conn->connect_error) {
        echo "koneksi database rusak";
        die();
    }

    
    
   


?>