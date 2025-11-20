<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php?error=" . urlencode("Sesi berakhir atau Anda belum login."));
    exit();
}

if ($_SESSION['user_role'] !== 'panitia') {
    header("Location: ../login.php?error=" . urlencode("Akses ditolak. Anda tidak memiliki izin Panitia."));
    exit();
}
require_once '../koneksi.php';

// ===========================
// CREATE (TAMBAH)
// ===========================
if (isset($_POST['tambah'])) {

    // 1. Ambil data (Tanda [] dihilangkan)
    $nama    = $_POST['nama_periode'];
    $mulai   = $_POST['mulai'];
    $selesai = $_POST['selesai'];
    $status  = $_POST['status_periode']; // Pastikan nama form input benar

    // 2. Gunakan Prepared Statement dengan placeholder (?)
    $query = "INSERT INTO periode (nama_periode, mulai, selesai, status_periode)
              VALUES (?, ?, ?, ?)";

    try {
        $stmt = $pdo->prepare($query);
        // 3. Eksekusi query (Data di-bind di sini, AMAN!)
        $stmt->execute([$nama, $mulai, $selesai, $status]);

        header("Location: periode.php?msg=added"); // Redirect ke file PHP
        exit;
    } catch (PDOException $e) {
        // Handle error, misalnya jika nama periode duplikat
        header("Location: periode.php?err=" . urlencode("Gagal tambah data."));
        exit;
    }
}

// ===========================
// UPDATE (EDIT) - AMAN DENGAN PDO
// ===========================
if (isset($_POST['edit'])) {

    // 1. Ambil data
    $id      = $_POST['id_periode']; // Pastikan ini ada di form
    $nama    = $_POST['nama_periode'];
    $mulai   = $_POST['mulai'];
    $selesai = $_POST['selesai'];
    $status  = $_POST['status_periode'];

    // 2. Gunakan Prepared Statement
    $query = "UPDATE periode SET 
                nama_periode=?,
                mulai=?,
                selesai=?,
                status_periode=?
              WHERE id_periode=?";

    try {
        $stmt = $pdo->prepare($query);
        // 3. Eksekusi query (urutan harus sesuai placeholder)
        $stmt->execute([$nama, $mulai, $selesai, $status, $id]);

        header("Location: periode.php?msg=updated");
        exit;
    } catch (PDOException $e) {
        header("Location: periode.php?err=" . urlencode("Gagal edit data."));
        exit;
    }
}

// ===========================
// DELETE - AMAN DENGAN PDO
// ===========================
if (isset($_GET['hapus'])) {

    $id = $_GET['hapus'];

    // 1. Gunakan Prepared Statement untuk mencegah SQL Injection dari URL
    $query = "DELETE FROM periode WHERE id_periode = ?";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);

        header("Location: periode.php?msg=deleted");
        exit;
    } catch (PDOException $e) {
        header("Location: periode.php?err=" . urlencode("Gagal hapus data."));
        exit;
    }
}

// ===========================
// FETCH DATA UNTUK TABEL
// ===========================
try {
    // Gunakan $pdo->query() jika tidak ada input user (SELECT murni)
    $stmt = $pdo->query("SELECT * FROM periode ORDER BY id_periode DESC");
    // Ambil semua hasil dalam bentuk array asosiatif
    $periode_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Tangani error pengambilan data
    $error_fetch = "Gagal mengambil data periode.";
    $periode_list = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Periode</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
</head>

<body class="bg">
    <div class="container mb-5">
        <nav class="navbar navbar-expand-lg mt-2 mb-5">
            <div class="container d-flex justify-content-center flex-row">
                <a class="col-8 col-lg-5" href="#"><img src="../assets/img/logo1.png" width="40%" alt=""></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav rounded-3 text-end my-4 p-4 gap-4 button-nav ms-auto mb-2 gap-2">
                        <li class="nav-item">
                            <a href="index.php" class="btn-hitam">BERANDA</a>
                        </li>
                        <li class="nav-item">
                            <a href="pengguna.php" class="btn-hitam">DATA PENGGUNA</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn-merah" aria-current="page" data-bs-toggle="modal" data-bs-target="#modal-keluar" href="#">KELUAR</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <div class="container mb-3">
        <div class="row">
            <div class="col-md-8 mb-md-0 mb-3 col-12">
                <div class="input-group ">
                    <form class="search-wrapper" role="search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input class="form-control rounded-pill form-control-search" type="search"
                            placeholder="Cari Data Periode.." aria-label="Search">
                    </form>
                </div>
            </div>
            <div class="col-12 col-md-4 d-flex gap-md-4   justify-content-md-end justify-content-between">
                <button type="button" class="btn-hijau  col-12 col-md-8 " data-bs-toggle="modal" data-bs-target="#modal-periode">TAMBAH
                    PERIODE</button>
                <div class="modal fade" id="modal-periode" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content rounded-4 bg-putih">
                            <div class="modal-body">
                                <form method="POST" action="periode.php">
                                    <div class="mb-3">
                                        <label for="nama_periode_input" class="col-form-label">Nama Periode</label>
                                        <input type="text" class="form-control form-control-abu" name="nama_periode" id="nama_periode_input" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="mulai_input" class="col-form-label">Mulai</label>
                                        <input type="date" class="form-control form-control-abu" name="mulai" id="mulai_input" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="selesai_input" class="col-form-label">Berakhir</label>
                                        <input type="date" class="form-control form-control-abu" name="selesai" id="selesai_input" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="status_input" class="col-form-label">Status</label>
                                        <select class="form-control form-control-abu" name="status_periode" id="status_input" required>
                                            <option value="aktif">Aktif</option>
                                            <option value="tidak_aktif">Tidak Aktif</option>
                                        </select>
                                    </div>
                                    <button type="submit" name="tambah" class="btn-hijau">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <button type="button" class="btn-hijau col-md-5 " data-bs-toggle="modal"
                    data-bs-target="#modal-excel">IMPORT Periode</button> -->
            </div>
            <div class="col-12 mt-3">
                <div class="table-responsive col-12 rounded-4 shadow">
                    <table class=" poppins-medium bg-putih rounded-4 w-100">
                        <tr class="bg-hijau">
                            <th>NAMA PERIODE</th>
                            <th>MULAI</th>
                            <th>BERAKHIR</th>
                            <th>STATUS</th>
                            <th>AKSI</th>
                        </tr>

                        <?php if (!empty($periode_list)): ?>
                            <?php foreach ($periode_list as $data): ?>
                                <tr>
                                    <td><?= htmlspecialchars($data['nama_periode']) ?></td>
                                    <td><?= htmlspecialchars($data['mulai']) ?></td>
                                    <td><?= htmlspecialchars($data['selesai']) ?></td>
                                    <td><?= htmlspecialchars($data['status_periode']) ?></td>

                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning me-2"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal-ubah"
                                            data-id="<?= $data['id_periode'] ?>"
                                            data-nama="<?= htmlspecialchars($data['nama_periode']) ?>"
                                            data-mulai="<?= $data['mulai'] ?>"
                                            data-selesai="<?= $data['selesai'] ?>"
                                            data-status="<?= $data['status_periode'] ?>">
                                            <i class="fa-solid fa-edit"></i> Edit
                                        </button>

                                        <button type="button" class="btn btn-sm btn-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal-hapus"
                                            data-id-hapus="<?= $data['id_periode'] ?>">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Belum ada data periode yang terdaftar.</td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="container">
        <div class="modal fade" id="modal-periode" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content rounded-4 bg-putih">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Formulir Tambah Periode</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="periode.php">
                            <div class="mb-3">
                                <label for="nama_periode_input" class="col-form-label">Nama Periode</label>
                                <input type="text" class="form-control form-control-abu" name="nama_periode" id="nama_periode_input" required>
                            </div>
                            <div class="mb-3">
                                <label for="mulai_input" class="col-form-label">Mulai</label>
                                <input type="date" class="form-control form-control-abu" name="mulai" id="mulai_input" required>
                            </div>
                            <div class="mb-3">
                                <label for="selesai_input" class="col-form-label">Berakhir</label>
                                <input type="date" class="form-control form-control-abu" name="selesai" id="selesai_input" required>
                            </div>
                            <div class="mb-3">
                                <label for="status_input_add" class="col-form-label">Status</label>
                                <select class="form-control form-control-abu" name="status_periode" id="status_input_add" required>
                                    <option value="aktif">Aktif</option>
                                    <option value="tidak_aktif">Tidak Aktif</option>
                                </select>
                            </div>
                            <button type="submit" name="tambah" class="btn-hijau">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-ubah" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content rounded-4 bg-putih">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Formulir Ubah Periode</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="periode.php">
                            <input type="hidden" name="id_periode" id="ubah-id">

                            <div class="mb-3">
                                <label for="ubah-nama" class="col-form-label">Nama Periode</label>
                                <input type="text" class="form-control form-control-abu" name="nama_periode" id="ubah-nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="ubah-mulai" class="col-form-label">Mulai</label>
                                <input type="date" class="form-control form-control-abu" name="mulai" id="ubah-mulai" required>
                            </div>
                            <div class="mb-3">
                                <label for="ubah-selesai" class="col-form-label">Berakhir</label>
                                <input type="date" class="form-control form-control-abu" name="selesai" id="ubah-selesai" required>
                            </div>
                            <div class="mb-3">
                                <label for="ubah-status" class="col-form-label">Status</label>
                                <select class="form-control form-control-abu" name="status_periode" id="ubah-status" required>
                                    <option value="aktif">Aktif</option>
                                    <option value="tidak_aktif">Tidak Aktif</option>
                                </select>
                            </div>
                            <button type="submit" name="edit" class="btn-hijau">Ubah Data</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-hapus" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content bg-putih rounded-4">
                    <div class="modal-body">
                        <div class="text-end">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="container-fluid">
                            <div class="row">
                                <h5 class="text-center mt-0 mb-3">Apakah Anda yakin ingin. <b>Menghapus</b> Periode?</h5>
                            </div>
                            <div class="d-grid">
                                <a href="#" id="confirm-delete-btn" class="btn-hitam border-0 text-center text-decoration-none">YA</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-keluar" tabindex="-1" aria-labelledby="keluar" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content bg-putih">
                    <div class="modal-body">
                        <div class="text-end">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="container-fluid">
                            <div class="row">
                                <h5 class="text-center mt-0 mb-3">apakah anda ingin keluar dari website suara warga?</h5>
                            </div>
                            <div class="d-grid">
                                <a href="../logout.php" class="btn-hitam border-0 text-center text-decoration-none">YA</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.js"></script>
    <script>
        // ------------------------------------
        // LOGIC UNTUK MODAL EDIT (UBAH)
        // ------------------------------------
        const modalUbah = document.getElementById('modal-ubah');
        modalUbah.addEventListener('show.bs.modal', event => {
            // Button yang memicu modal
            const button = event.relatedTarget;

            // Ambil data dari data-attributes
            const id = button.getAttribute('data-id');
            const nama = button.getAttribute('data-nama');
            const mulai = button.getAttribute('data-mulai');
            const selesai = button.getAttribute('data-selesai');
            const status = button.getAttribute('data-status');

            // Isi form modal (Asumsi id input di modal adalah: input-id, input-nama, dst.)
            // Kamu harus memastikan form di modal-ubah memiliki input dengan ID yang sesuai.

            // 1. Set action form untuk EDIT (POST)
            const form = modalUbah.querySelector('form');
            form.action = 'periode.php'; // Aksi form diarahkan ke file ini sendiri

            // 2. Set nilai input di dalam form
            modalUbah.querySelector('#ubah-id').value = id; // Tambahkan hidden input untuk ID
            modalUbah.querySelector('#ubah-nama').value = nama;
            modalUbah.querySelector('#ubah-mulai').value = mulai;
            modalUbah.querySelector('#ubah-selesai').value = selesai;
            // ... dan seterusnya untuk input status

            // Ganti nama button submit dari Tambah ke Edit/Ubah
            form.querySelector('button[type="submit"]').name = 'edit';
            form.querySelector('button[type="submit"]').textContent = 'UBAH';
        });


        // ------------------------------------
        // LOGIC UNTUK MODAL DELETE (HAPUS)
        // ------------------------------------
        const modalHapus = document.getElementById('modal-hapus');
        modalHapus.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const idHapus = button.getAttribute('data-id-hapus');

            // Cari tombol YA/Konfirmasi di modal hapus
            const btnYaHapus = modalHapus.querySelector('.d-grid .btn-hitam');

            // Ubah link tombol YA ke logika delete PHP
            // Kita gunakan query string GET['hapus'] yang sudah kamu buat di logika PHP
            btnYaHapus.onclick = function() {
                window.location.href = 'periode.php?hapus=' + idHapus;
            };
            // Perhatikan, jika tombol YA tidak punya class .btn-hitam, sesuaikan selectornya!
        });
    </script>
</body>

</html>