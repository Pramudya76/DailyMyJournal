<?php
    include "service/artikle.php";
    session_start();
    if ($db->connect_error) {
        die("Koneksi database rusak: " . $db->connect_error);
    }

    if(isset($_POST['logout'])) {
        session_unset();
        session_destroy();
        header("location: index.php");
    }
    
    // Query untuk mengambil data
    $sql = "SELECT judul, isi, tanggal FROM artikel";
    $result = $db->query($sql);

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


    

//jika tombol simpan diklik
if (isset($_POST['simpan'])) {
        $judul = $_POST['judul'];
        $isi = $_POST['isi'];
        $tanggal = date("Y-m-d H:i:s");
        $username = $_SESSION['username'];
        $gambar = '';
        $nama_gambar = $_FILES['gambar']['name'];

    //upload gambar
    if ($nama_gambar != '') {
        $cek_upload = upload_foto($_FILES["gambar"]);

        if ($cek_upload['status']) {
            $gambar = $cek_upload['message'];
        } else {
            echo "<script>
                alert('" . $cek_upload['message'] . "');
                document.location='Artikel.php';
            </script>";
            die;
        }
    }

    if (isset($_POST['id'])) {
        //update data
        $id = $_POST['id'];

        if ($nama_gambar == '') {
            //jika tidak ganti gambar
            $gambar = $_POST['gambar_lama'];
        } else {
            //jika ganti gambar, hapus gambar lama
            unlink("gambar/" . $_POST['gambar_lama']);
        }

        $stmt = $db->prepare("UPDATE artikel 
                                SET 
                                judul =?,
                                isi =?,
                                gambar = ?,
                                tanggal = ?,
                                username = ?
                                WHERE id = ?");

        $stmt->bind_param("sssssi", $judul, $isi, $gambar, $tanggal, $username, $id);
        $simpan = $stmt->execute();
    } else {
		    //insert data
        $stmt = $db->prepare("INSERT INTO artikel (judul,isi,gambar,tanggal,username)
                                VALUES (?,?,?,?,?)");

        $stmt->bind_param("sssss", $judul, $isi, $gambar, $tanggal, $username);
        $simpan = $stmt->execute();
    }

    if ($simpan) {
        echo "<script>
            alert('Simpan data sukses');
            document.location='Artikel.php';
        </script>";
    } else {
        echo "<script>
            alert('Simpan data gagal');
            document.location='Artikel.php';
        </script>";
    }

    $stmt->close();
}

//jika tombol hapus diklik
if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    $gambar = $_POST['gambar'];

    if ($gambar != '') {
        //hapus file gambar
        unlink("gambar/" . $gambar);
    }

    $stmt = $db->prepare("DELETE FROM artikel WHERE id =?");

    $stmt->bind_param("i", $id);
    $hapus = $stmt->execute();

    if ($hapus) {
        echo "<script>
            alert('Hapus data sukses');
            document.location='Artikel.php';
        </script>";
    } else {
        echo "<script>
            alert('Hapus data gagal');
            document.location='Artikel.php';
        </script>";
    }

    $stmt->close();
    $db->close();
}


    // Tutup koneksi
    //$db->close();
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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
            <li class="nav-item">
                <a class="nav-link" href="user_manajemen.php">Users</a>
            </li> 
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-danger fw-bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?= $_SESSION['username']?>
                </a>
                <ul class="dropdown-menu">
                    <form action="index.php" method="POST">
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
             <h1 class="text-center">My Artikel</h1>
             <hr>
             <div class="container">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="bi bi-plus-lg"></i> Tambah Article
                </button>
                <div class="row">
                    <div class="table-responsive" id="artikel_data">
                        
                    </div>
                    
                    <!-- Awal Modal Tambah-->
                    <div class="modal fade" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Article</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="post" action="" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="formGroupExampleInput" class="form-label">Judul</label>
                                            <input type="text" class="form-control" name="judul" placeholder="Tuliskan Judul Artikel" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="floatingTextarea2">Isi</label>
                                            <textarea class="form-control" placeholder="Tuliskan Isi Artikel" name="isi" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="formGroupExampleInput2" class="form-label">Gambar</label>
                                            <input type="file" class="form-control" name="gambar">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <input type="submit" value="simpan" name="simpan" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Akhir Modal Tambah-->
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

    <?php
        $db->close();

    ?>
    <script>
        $(document).ready(function(){
            load_data();
            function load_data(hlm){
                $.ajax({
                    url : "artikel_data.php",
                    method : "POST",
                    data : {
                                        hlm: hlm
                                },
                    success : function(data){
                            $('#artikel_data').html(data);
                    }
                })
            } 

            $(document).on('click', '.halaman', function(){
                var hlm = $(this).attr("id");
                load_data(hlm);
            });


        });

    </script>
</body>
</html> 