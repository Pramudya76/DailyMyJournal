<?php 
    $hostname = "localhost";
    $username = "myuser";
    $password = "Pramudya76";
    $database_name = "pesanan";

    $database = mysqli_connect($hostname, $username, $password, $database_name);

    if($database->connect_error) {
        echo "koneksi database rusak";
        die();
    }



?>