<?php
    include "service/database.php";
    include "service/artikle.php";
    session_start();

    // Cek koneksi
    if ($db->connect_error) {
        die("Koneksi database rusak: " . $db->connect_error);
    }
    

    
    // Query untuk mengambil data
    $sql = "SELECT judul, isi, tanggal, gambar FROM artikel";

    $artikel = "SELECT judul, isi FROM artikel";
    $gallery = "SELECT gambar FROM artikel WHERE gambar IS NOT NULL AND gambar != ''";
    $users = "SELECT username FROM users";


    $result = $conn->query($sql);

    $result2 = $conn->query($artikel);
    $result3 = $conn->query($gallery);
    $result4 = $db->query($users);


    if(isset($_POST['logout'])) {
        session_unset();
        session_destroy();
        header("location: index.php");
    }
    
    $jumlah_article = $result2->num_rows;
    $jumlah_gallery = $result3->num_rows;
    $jumlah_user = $result4->num_rows;


    // Simpan data untuk ditampilkan nanti
    $artikel = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $artikel[] = [
                'judul' => $row['judul'],
                'isi' => $row['isi'],
                'tanggal' => $row['tanggal']
            ];
            
        }
    } else {
        $artikel[] = [
            'judul' => "Tidak ada data ditemukan.",
            'isi' => "Tidak ada data ditemukan.",
            'tanggal' => "Tidak ada data ditemukan."
        ];
    }

    $first_article = !empty($artikel) ? $artikel[0] : ["judul" => "Tidak ada data ditemukan.", "isi" => "Tidak ada data ditemukan.", 'tanggal' => "Tidak ada data ditemukan."];

    // Tutup koneksi
    $db->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>My Daily Journal | Admin</title>
    <link rel="icon" href="img/logo.png" />
    <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
    />
    <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
    crossorigin="anonymous"
    /> 
    <style>  
        html {
            position: relative;
            min-height: 100%;
        }
        body {
            margin-bottom: 100px; /* Margin bottom by footer height */
        }
        footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 100px; /* Set the fixed height of the footer here */ 
        }
    </style>
</head>
<body>
    <!-- nav begin -->
    <nav class="navbar navbar-expand-sm bg-body-tertiary sticky-top bg-danger-subtle">
    <div class="container">
        <a class="navbar-brand" target="_blank" href=".">My Daily Journal</a>
        <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
        >
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-dark">
            <li class="nav-item">
                <a class="nav-link" href="dashboard.php">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Artikel.php">Article</a>
            </li> 
            <li class="nav-item dropdown">
            <li class="nav-item">
                <a class="nav-link" href="user_manajemen.php">Users</a>
            </li> 
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-danger fw-bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?= $_SESSION['username']?>
                </a>
                <ul class="dropdown-menu">
                    <form action="" method="POST">
                        <button type="submit" name="logout" class="dropdown-item">Logout</button>
                    </form>
                </ul>
            </li> 
        </ul>
        </div>
    </div>
    </nav>
    <!-- nav end -->
    <!-- content begin -->
    <section id="content" class="p-5">
        <div class="container"> 
            <!-- Selamat datang <?= $_SESSION['username'] ?> -->
            <h1 class="text-center">Dashboard</h1>
            <hr>
             
                <div class="row row-cols-1 row-cols-md-4 g-4 justify-content-center pt-4">
                    <div class="col">
                        <div class="card border border-danger mb-3 shadow" style="max-width: 18rem;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div class="p-3">
                                        <h5 class="card-title"><i class="bi bi-newspaper"></i> Article</h5> 
                                    </div>
                                    <div class="p-3">
                                        <span class="badge rounded-pill text-bg-danger fs-2"><?php echo $jumlah_article; ?></span>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="col">
                        <div class="card border border-danger mb-3 shadow" style="max-width: 18rem;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div class="p-3">
                                        <h5 class="card-title"><i class="bi bi-camera"></i> Gallery</h5> 
                                    </div>
                                    <div class="p-3">
                                        <span class="badge rounded-pill text-bg-danger fs-2"><?php echo $jumlah_gallery; ?></span>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="col">
                        <div class="card border border-danger mb-3 shadow" style="max-width: 18rem;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div class="p-3">
                                        <h5 class="card-title"><i class="bi bi-person"></i> Users</h5> 
                                    </div>
                                    <div class="p-3">
                                        <span class="badge rounded-pill text-bg-danger fs-2"><?php echo $jumlah_user; ?></span>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>             
        </div> 
    </section>
    <!-- content end -->
    <!-- footer begin -->
    <footer class="text-center p-6 bg-danger-subtle">
    <div class="mt-3">
        <a href="https://www.instagram.com/udinusofficial"
        ><i class="bi bi-instagram h2 p-2 text-dark"></i
        ></a>
        <a href="https://twitter.com/udinusofficial"
        ><i class="bi bi-twitter h2 p-2 text-dark"></i
        ></a>
        <a href="https://wa.me/+62812685577"
        ><i class="bi bi-whatsapp h2 p-2 text-dark"></i
        ></a>
    </div>
    <div>Pramudya Putra Pratama &copy; 2024</div>
    </footer>
    <!-- footer end -->
    <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"
    ></script>
</body>
</html> 