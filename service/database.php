<?php
    $hostname = "localhost";
    $username = "myuser";
    $password = "Pramudya76";
    $database_name = "buku_tamu";

    $db = mysqli_connect($hostname, $username, $password, $database_name);

    if($db->connect_error) {
        echo "koneksi database rusak";
        die();
    }


?>