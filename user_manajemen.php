<?php
session_start();
$hostname = "localhost";
$username = "myuser";
$password = "Pramudya76";
$database_name = "buku_tamu";

// Membuat koneksi ke database
$db = new mysqli($hostname, $username, $password, $database_name);

// Cek koneksi
if ($db->connect_error) {
    die("Koneksi database gagal: " . $db->connect_error);
}

// Jumlah data per halaman
$limit = 4;

// Tentukan halaman saat ini
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Query untuk mengambil data dengan pagination
$query = "SELECT id, username, password FROM users LIMIT $limit OFFSET $offset";
$result = $db->query($query);

// Query untuk menghitung jumlah total data
$count_query = "SELECT COUNT(*) as total FROM users";
$count_result = $db->query($count_query);
$count_row = $count_result->fetch_assoc();
$total_rows = $count_row['total'];

// Menghitung jumlah total halaman
$total_pages = ceil($total_rows / $limit);

// Proses menambah user
if (isset($_POST['tambah_user'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Enkripsi password

    // Query untuk menambahkan user baru ke database
    $insert_query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    
    if ($db->query($insert_query) === TRUE) {
        echo "<script>alert('User berhasil ditambahkan!'); window.location = 'user_manajemen.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menambahkan user.');</script>";
    }
}

// Proses menghapus user
if (isset($_GET['hapus_id'])) {
    $hapus_id = $_GET['hapus_id'];

    // Query untuk menghapus user berdasarkan ID
    $delete_query = "DELETE FROM users WHERE id = '$hapus_id'";

    if ($db->query($delete_query) === TRUE) {
        echo "<script>alert('User berhasil dihapus!'); window.location = 'user_manajemen.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menghapus user.');</script>";
    }
}

// Simpan data untuk ditampilkan nanti
$users = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
} else {
    echo "Error fetching users: " . $db->error;
}
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
        crossorigin="anonymous"
    />
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
            <h1 class="text-center">Users</h1>
            <hr>
            <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="bi bi-plus-lg"></i> Tambah User
            </button>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th class="w-50">Username</th>
                            <th class="w-25">Password</th>
                            <th class="w-25 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php 
                                // Mulai nomor urut berdasarkan offset
                                $no = $offset + 1; 
                                foreach ($users as $row): 
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td> <!-- Menampilkan nomor urut secara bertahap -->
                                    <td><?= htmlspecialchars($row["username"]) ?></td>
                                    <td><?= htmlspecialchars($row["password"]) ?></td>
                                    <td class="w-25 text-end">
                                        <div class="d-flex flex-column gap-2 align-items-end">
                                            <a href="user_manajemen.php?hapus_id=<?= $row['id'] ?>" title="delete" class="badge rounded-pill text-bg-danger px-3 py-2">
                                                <i class="bi bi-x-circle"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data ditemukan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Modal Tambah User -->
            <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="user_manajemen.php" method="POST">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTambahLabel">Tambah User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" required />
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required />
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" name="tambah_user" class="btn btn-primary">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="pagination mt-3">
                <div class="d-flex justify-content-center">
                    <ul class="pagination">
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

    </section>
    <!-- content end -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
