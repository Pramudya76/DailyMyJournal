<?php
    $hostname = "localhost";
    $username = "myuser";
    $password = "Pramudya76";
    $database_name = "artikle";

    $db = mysqli_connect($hostname, $username, $password, $database_name);

    if($db->connect_error) {
        echo "koneksi database rusak";
        die();
    }

    $sql = "SELECT isi FROM artikle";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data dari setiap baris
        while ($row = $result->fetch_assoc()) {
            echo "ID: " . $row["isi"];
        }
    } else {
        echo "Tidak ada data ditemukan";
    }
    
    // Tutup koneksi
    $conn->close();


?>