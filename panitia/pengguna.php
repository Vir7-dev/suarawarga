<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'panitia') {
    header("Location: ../login.php");
    exit;
}

require_once '../koneksi.php';

// ===========================
// INSERT (TAMBAH) - POST
// ===========================
if (isset($_POST['tambah'])) {

    $nik            = $_POST['nik'];
    $nama           = $_POST['nama'];
    $tempat_lahir   = $_POST['tempat_lahir'];
    $tanggal_lahir  = $_POST['tanggal_lahir'];
    $jenis_kelamin  = $_POST['jenis_kelamin'];
    $pendidikan     = $_POST['pendidikan'];
    $pekerjaan      = $_POST['pekerjaan'];
    $alamat         = $_POST['alamat'];
    $agama          = $_POST['agama'];
    $status_pilih   = $_POST['status_pilih'] ?? 'belum';
    $role           = $_POST['role'] ?? 'warga';
    $password       = password_hash($_POST['nik'], PASSWORD_DEFAULT);

    try {
        $query = "INSERT INTO pengguna 
            (nik, nama, tempat_lahir, tanggal_lahir, jenis_kelamin, pendidikan, pekerjaan, alamat, agama, status_pilih, role, password)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            $nik, $nama, $tempat_lahir, $tanggal_lahir, $jenis_kelamin,
            $pendidikan, $pekerjaan, $alamat, $agama, $status_pilih, $role, $password
        ]);

        header("Location: pengguna.php?msg=added");
        exit;
    } catch (PDOException $e) {
        header("Location: pengguna.php?err=" . urlencode("Gagal menambah pengguna: " . $e->getMessage()));
        exit;
    }
}

// ===========================
// UPDATE (EDIT) - POST
// ===========================
if (isset($_POST['edit'])) {
    $id             = $_POST['id'] ?? null;
    $nik            = trim($_POST['nik'] ?? '');
    $nama           = trim($_POST['nama'] ?? '');
    $tempat_lahir   = trim($_POST['tempat_lahir'] ?? '');
    $tanggal_lahir  = trim($_POST['tanggal_lahir'] ?? '');
    $jenis_kelamin  = trim($_POST['jenis_kelamin'] ?? '');
    $pendidikan     = trim($_POST['pendidikan'] ?? '');
    $pekerjaan      = trim($_POST['pekerjaan'] ?? '');
    $alamat         = trim($_POST['alamat'] ?? '');
    $agama          = trim($_POST['agama'] ?? '');
    $status_pilih   = trim($_POST['status_pilih'] ?? 'belum');
    $role           = trim($_POST['role'] ?? 'warga');

    if (!$id || $nik === '' || $nama === '') {
        header("Location: pengguna.php?err=" . urlencode("ID, NIK, dan Nama wajib diisi."));
        exit;
    }

    try {
        // Update tanpa password jika tidak diisi
        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $query = "UPDATE pengguna SET
                        nik = ?, nama = ?, tempat_lahir = ?, tanggal_lahir = ?, jenis_kelamin = ?,
                        pendidikan = ?, pekerjaan = ?, alamat = ?, agama = ?, status_pilih = ?, role = ?, password = ?
                      WHERE id = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                $nik, $nama, $tempat_lahir, $tanggal_lahir, $jenis_kelamin,
                $pendidikan, $pekerjaan, $alamat, $agama, $status_pilih, $role, $password,
                $id
            ]);
        } else {
            $query = "UPDATE pengguna SET
                        nik = ?, nama = ?, tempat_lahir = ?, tanggal_lahir = ?, jenis_kelamin = ?,
                        pendidikan = ?, pekerjaan = ?, alamat = ?, agama = ?, status_pilih = ?, role = ?
                      WHERE id = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                $nik, $nama, $tempat_lahir, $tanggal_lahir, $jenis_kelamin,
                $pendidikan, $pekerjaan, $alamat, $agama, $status_pilih, $role,
                $id
            ]);
        }

        header("Location: pengguna.php?msg=updated");
        exit;
    } catch (PDOException $e) {
        header("Location: pengguna.php?err=" . urlencode("Gagal mengubah pengguna: " . $e->getMessage()));
        exit;
    }
}

// ===========================
// DELETE (HAPUS) - GET
// ===========================
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    try {
        $query = "DELETE FROM pengguna WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);

        header("Location: pengguna.php?msg=deleted");
        exit;
    } catch (PDOException $e) {
        header("Location: pengguna.php?err=" . urlencode("Gagal menghapus pengguna."));
        exit;
    }
}

// ===========================
// SEARCH FUNCTIONALITY
// ===========================
$search = $_GET['q'] ?? '';
$search_param = '%' . $search . '%';

try {
    if (!empty($search)) {
        $stmt = $pdo->prepare("SELECT id, nik, nama, tempat_lahir, tanggal_lahir, jenis_kelamin, pendidikan, pekerjaan, alamat, agama, status_pilih, role 
                               FROM pengguna 
                               WHERE nik LIKE ? OR nama LIKE ?
                               ORDER BY id DESC");
        $stmt->execute([$search_param, $search_param]);
    } else {
        $stmt = $pdo->query("SELECT id, nik, nama, tempat_lahir, tanggal_lahir, jenis_kelamin, pendidikan, pekerjaan, alamat, agama, status_pilih, role 
                            FROM pengguna 
                            ORDER BY id DESC");
    }
    $pengguna_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $pengguna_list = [];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengguna</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
</head>

<body class="bg">
    <div class="container mb-5">
        <nav class="navbar navbar-expand-lg mt-2 mb-5">
            <div class="container d-flex align-items-center">

                <!-- Logo -->
                <a class="navbar-brand" href="#">
                    <img src="../assets/img/logo1.png" alt="Logo" style="width:170px;">
                </a>

                <!-- Toggle button -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Menu -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-2">
                        <li class="nav-item">
                            <a href="index.php" class="btn btn-dark"><i class="fa-solid fa-house-user me-2"></i>BERANDA</a>
                        </li>
                        <li class="nav-item">
                            <a href="periode.php" class="btn btn-dark"><i class="fa-solid fa-calendar-day me-2"></i>PERIODE</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-keluar" href="#"><i class="fa-solid fa-right-from-bracket me-2"></i>KELUAR</a>
                        </li>
                    </ul>
                </div>

            </div>
        </nav>

    </div>

    <div class="container mb-3">
        <!-- Alert Messages -->
        <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php 
                    if ($_GET['msg'] == 'added') echo 'Data pengguna berhasil ditambahkan!';
                    if ($_GET['msg'] == 'updated') echo 'Data pengguna berhasil diubah!';
                    if ($_GET['msg'] == 'deleted') echo 'Data pengguna berhasil dihapus!';
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['err'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_GET['err']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-8">
                <form class="d-flex" role="search" method="GET" action="pengguna.php">
                    <input name="q" class="form-control rounded-0 rounded-start-4 border-2 shadow" type="search" placeholder="Cari NIK atau Nama" aria-label="Search" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" />
                    <button class="btn btn-putih rounded-0 rounded-end-4 border-2" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
            <div class="col-4 text-end">
                <button type="button" class="btn btn-success poppins-bold shadow" data-bs-toggle="modal" data-bs-target="#modal-pengguna"><i class="fa-solid fa-circle-plus me-2"></i>TAMBAH</button>
                <button type="button" class="btn btn-success poppins-bold shadow" data-bs-toggle="modal" data-bs-target="#modal-import"><i class="fa-solid fa-upload me-2"></i>IMPORT</button>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-3">
                <div class="table-responsive col-12 rounded-4 shadow">
                    <table class="poppins-medium bg-putih rounded-4 w-100">
                        <thead>
                            <tr class="bg-hijau">
                                <th>NIK</th>
                                <th>NAMA</th>
                                <th>TEMPAT, TANGGAL LAHIR</th>
                                <th>JENIS KELAMIN</th>
                                <th>PENDIDIKAN</th>
                                <th>PEKERJAAN</th>
                                <th>ALAMAT</th>
                                <th>AGAMA</th>
                                <th>STATUS PEMILIHAN</th>
                                <th>ROLE</th>
                                <th style="width: 8%;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody id="t-body">
                            <?php if (!empty($pengguna_list)): ?>
                                <?php foreach ($pengguna_list as $data): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($data['nik']) ?></td>
                                        <td><?= htmlspecialchars($data['nama']) ?></td>
                                        <td><?= htmlspecialchars($data['tempat_lahir']) ?>, <?= htmlspecialchars($data['tanggal_lahir']) ?></td>
                                        <td><?= $data['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                                        <td><?= htmlspecialchars($data['pendidikan']) ?></td>
                                        <td><?= htmlspecialchars($data['pekerjaan']) ?></td>
                                        <td><?= htmlspecialchars($data['alamat']) ?></td>
                                        <td><?= htmlspecialchars($data['agama']) ?></td>
                                        <td>
                                            <?php if ($data['status_pilih'] == 'sudah'): ?>
                                                <h6><span class="badge bg-success">Sudah</span></h6>
                                            <?php else: ?>
                                                <h6><span class="badge bg-secondary">Belum</span></h6>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($data['role']) ?></td>

                                        <td>
                                            <button type="button" class="btn btn-sm btn-warning me-2"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modal-ubah"
                                                data-id="<?= htmlspecialchars($data['id']) ?>"
                                                data-nik="<?= htmlspecialchars($data['nik']) ?>"
                                                data-nama="<?= htmlspecialchars($data['nama']) ?>"
                                                data-tempat_lahir="<?= htmlspecialchars($data['tempat_lahir']) ?>"
                                                data-tanggal_lahir="<?= htmlspecialchars($data['tanggal_lahir']) ?>"
                                                data-jenis_kelamin="<?= htmlspecialchars($data['jenis_kelamin']) ?>"
                                                data-pendidikan="<?= htmlspecialchars($data['pendidikan']) ?>"
                                                data-pekerjaan="<?= htmlspecialchars($data['pekerjaan']) ?>"
                                                data-alamat="<?= htmlspecialchars($data['alamat']) ?>"
                                                data-agama="<?= htmlspecialchars($data['agama']) ?>"
                                                data-status_pilih="<?= htmlspecialchars($data['status_pilih']) ?>"
                                                data-role="<?= htmlspecialchars($data['role']) ?>">
                                                <i class="fa-solid fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modal-hapus"
                                                data-id-hapus="<?= htmlspecialchars($data['id']) ?>">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modal-kandidat" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content rounded-4 bg-putih">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5">Formulir Kandiat - Tambah</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" action="pengguna.php">
                                                        <div class="row">
                                                            <input type="hidden" name="id" value="<?= htmlspecialchars($data['id']) ?>">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="col-form-label">NIK <span class="text-danger">*</span></label>
                                                                <input type="text" name="nik" class="form-control" required>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="col-form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                                                <input type="text" name="nama" class="form-control" required>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="col-form-label">Tempat Lahir</label>
                                                                <input type="text" name="tempat_lahir" class="form-control">
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="col-form-label">Tanggal Lahir</label>
                                                                <input type="date" name="tanggal_lahir" class="form-control">
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="col-form-label">Jenis Kelamin</label>
                                                                <div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_l" value="L" checked>
                                                                        <label class="form-check-label" for="jk_l">Laki-laki</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_p" value="P">
                                                                        <label class="form-check-label" for="jk_p">Perempuan</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="col-form-label">Agama</label>
                                                                <select name="agama" class="form-control">
                                                                    <option value="">-- Pilih Agama --</option>
                                                                    <option value="Islam">Islam</option>
                                                                    <option value="Kristen">Kristen</option>
                                                                    <option value="Katolik">Katolik</option>
                                                                    <option value="Hindu">Hindu</option>
                                                                    <option value="Buddha">Buddha</option>
                                                                    <option value="Konghucu">Konghucu</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="col-form-label">Pendidikan Terakhir</label>
                                                                <select name="pendidikan" class="form-control">
                                                                    <option value="">-- Pilih Pendidikan --</option>
                                                                    <option value="SD">SD</option>
                                                                    <option value="SMP">SMP</option>
                                                                    <option value="SMA/SMK">SMA/SMK</option>
                                                                    <option value="D3">D3</option>
                                                                    <option value="S1">S1</option>
                                                                    <option value="S2">S2</option>
                                                                    <option value="S3">S3</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="col-form-label">Pekerjaan</label>
                                                                <input type="text" name="pekerjaan" class="form-control">
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                <label class="col-form-label">Alamat</label>
                                                                <textarea name="alamat" class="form-control" rows="3"></textarea>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="col-form-label">Status Pemilihan</label>
                                                                <select name="status_pilih" class="form-control">
                                                                    <option value="belum">Belum Memilih</option>
                                                                    <option value="sudah">Sudah Memilih</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="col-form-label">Role</label>
                                                                <select name="role" class="form-control">
                                                                    <option value="warga">Warga</option>
                                                                    <option value="panitia">Panitia</option>
                                                                    <option value="kandidat">Kandidat</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="col-form-label">Password <span class="text-danger">*</span> <small class="text-muted">(Default: NIK)</small></label>
                                                                <input type="text" name="password" class="form-control" value="" placeholder="Otomatis menggunakan NIK">
                                                            </div>
                                                        </div>

                                                        <div class="text-end">
                                                            <button type="submit" name="tambah" class="btn btn-success">Simpan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="11" class="text-center">Belum ada data pengguna.</td>
                                </tr>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center align-items-center gap-2 mt-3">
                    <!-- placeholder pagination jika diperlukan nantinya -->
                </div>

            </div>
        </div>
    </div>

    <!-- Modal TAMBAH -->
    <div class="container">
        <div class="modal fade" id="modal-pengguna" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content rounded-4 bg-putih">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Formulir Pengguna - Tambah</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="pengguna.php">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="col-form-label">NIK <span class="text-danger">*</span></label>
                                    <input type="text" name="nik" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="col-form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="col-form-label">Tempat Lahir<span class="text-danger">*</span></label>
                                    <input type="text" name="tempat_lahir" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="col-form-label">Tanggal Lahir<span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_lahir" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="col-form-label">Jenis Kelamin<span class="text-danger">*</span></label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_l" value="L" checked required>
                                            <label class="form-check-label" for="jk_l">Laki-laki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_p" value="P" required>
                                            <label class="form-check-label" for="jk_p">Perempuan</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="col-form-label">Agama<span class="text-danger">*</span></label>
                                    <select name="agama" class="form-control" required>
                                        <option value="">-- Pilih Agama --</option>
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen">Kristen</option>
                                        <option value="Katolik">Katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Buddha">Buddha</option>
                                        <option value="Konghucu">Konghucu</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="col-form-label">Pendidikan Terakhir<span class="text-danger">*</span></label>
                                    <select name="pendidikan" class="form-control" required>
                                        <option value="">-- Pilih Pendidikan --</option>
                                        <option value="SD">SD</option>
                                        <option value="SMP">SMP</option>
                                        <option value="SMA/SMK">SMA/SMK</option>
                                        <option value="D3">D3</option>
                                        <option value="S1">S1</option>
                                        <option value="S2">S2</option>
                                        <option value="S3">S3</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="col-form-label">Pekerjaan<span class="text-danger">*</span></label>
                                    <input type="text" name="pekerjaan" class="form-control" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="col-form-label">Alamat<span class="text-danger">*</span></label>
                                    <textarea name="alamat" class="form-control" rows="3" required></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="col-form-label">Status Pemilihan<span class="text-danger">*</span></label>
                                    <select name="status_pilih" class="form-control" required>
                                        <option value="belum">Belum Memilih</option>
                                        <option value="sudah">Sudah Memilih</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="col-form-label">Role<span class="text-danger">*</span></label>
                                    <select name="role" class="form-control" required>
                                        <option value="warga">Warga</option>
                                        <option value="panitia">Panitia</option>
                                        <option value="kandidat">Kandidat</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="col-form-label" >Password<span class="text-danger">*</span> <small class="text-muted">(Default: NIK)</small></label>
                                    <input type="text" name="password" class="form-control" value="" placeholder="Otomatis menggunakan NIK" required>
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" name="tambah" class="btn btn-success">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal UBAH -->
        <div class="modal fade" id="modal-ubah" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content rounded-4 bg-putih">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Formulir Pengguna - Ubah</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="pengguna.php">
                            <input type="hidden" name="id" id="ubah-id">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="col-form-label">NIK <span class="text-danger">*</span></label>
                                    <input type="text" name="nik" id="ubah-nik" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="col-form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" id="ubah-nama" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="col-form-label">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" id="ubah-tempat_lahir" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="col-form-label">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" id="ubah-tanggal_lahir" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="col-form-label">Jenis Kelamin</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="ubah_jk_l" value="L">
                                            <label class="form-check-label" for="ubah_jk_l">Laki-laki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="ubah_jk_p" value="P">
                                            <label class="form-check-label" for="ubah_jk_p">Perempuan</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="col-form-label">Agama</label>
                                    <select name="agama" id="ubah-agama" class="form-control">
                                        <option value="">-- Pilih Agama --</option>
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen">Kristen</option>
                                        <option value="Katolik">Katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Buddha">Buddha</option>
                                        <option value="Konghucu">Konghucu</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="col-form-label">Pendidikan Terakhir</label>
                                    <select name="pendidikan" id="ubah-pendidikan" class="form-control">
                                        <option value="">-- Pilih Pendidikan --</option>
                                        <option value="SD">SD</option>
                                        <option value="SMP">SMP</option>
                                        <option value="SMA/SMK">SMA/SMK</option>
                                        <option value="D3">D3</option>
                                        <option value="S1">S1</option>
                                        <option value="S2">S2</option>
                                        <option value="S3">S3</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="col-form-label">Pekerjaan</label>
                                    <input type="text" name="pekerjaan" id="ubah-pekerjaan" class="form-control">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="col-form-label">Alamat</label>
                                    <textarea name="alamat" id="ubah-alamat" class="form-control" rows="3"></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="col-form-label">Status Pemilihan</label>
                                    <select name="status_pilih" id="ubah-status_pilih" class="form-control">
                                        <option value="belum">Belum Memilih</option>
                                        <option value="sudah">Sudah Memilih</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="col-form-label">Role</label>
                                    <select name="role" id="ubah-role" class="form-control">
                                        <option value="warga">User</option>
                                        <option value="panitia">Panitia</option>
                                        <option value="kandidat">Kandidat</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="col-form-label">Password <small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small></label>
                                    <input type="password" name="password" class="form-control">
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" name="edit" class="btn btn-success">Ubah Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal HAPUS -->
        <div class="modal fade" id="modal-hapus" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content bg-putih rounded-4">
                    <div class="modal-body">
                        <div class="text-end">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="container-fluid">
                            <div class="row">
                                <h5 class="text-center mt-0 mb-3">Apakah Anda yakin ingin <b>Menghapus</b> Pengguna?</h5>
                            </div>
                            <div class="d-grid">
                                <a href="#" id="confirm-delete-btn" class="btn btn-success border-0 text-decoration-none text-center">YA</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal KELUAR -->
        <div class="modal fade" id="modal-keluar" tabindex="-1" aria-labelledby="keluar" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content bg-putih">
                    <div class="modal-body">
                        <div class="text-end">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="container-fluid">
                            <div class="row">
                                <h5 class="text-center mt-0 mb-3">Apakah Anda ingin keluar dari website <b>Suara
                                        Warga</b>?</h5>
                                <div class="d-grid">
                                    <button type="button" onclick="window.location.href='../login.php'" class="btn btn-dark border-0">YA</button>
                                </div>
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
        // POPULATE MODAL UBAH
        // ------------------------------------
        const modalUbah = document.getElementById('modal-ubah');
        modalUbah.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;

            // Ambil data dari data-attributes
            const id = button.getAttribute('data-id');
            const nik = button.getAttribute('data-nik');
            const nama = button.getAttribute('data-nama');
            const tempat_lahir = button.getAttribute('data-tempat_lahir');
            const tanggal_lahir = button.getAttribute('data-tanggal_lahir');
            const jenis_kelamin = button.getAttribute('data-jenis_kelamin');
            const pendidikan = button.getAttribute('data-pendidikan');
            const pekerjaan = button.getAttribute('data-pekerjaan');
            const alamat = button.getAttribute('data-alamat');
            const agama = button.getAttribute('data-agama');
            const status_pilih = button.getAttribute('data-status_pilih');
            const role = button.getAttribute('data-role');

            // Isi form modal
            modalUbah.querySelector('#ubah-id').value = id || '';
            modalUbah.querySelector('#ubah-nik').value = nik || '';
            modalUbah.querySelector('#ubah-nama').value = nama || '';
            modalUbah.querySelector('#ubah-tempat_lahir').value = tempat_lahir || '';
            modalUbah.querySelector('#ubah-tanggal_lahir').value = tanggal_lahir || '';
            
            // Set radio button jenis kelamin
            if (jenis_kelamin === 'L') {
                modalUbah.querySelector('#ubah_jk_l').checked = true;
            } else if (jenis_kelamin === 'P') {
                modalUbah.querySelector('#ubah_jk_p').checked = true;
            }
            
            modalUbah.querySelector('#ubah-pendidikan').value = pendidikan || '';
            modalUbah.querySelector('#ubah-pekerjaan').value = pekerjaan || '';
            modalUbah.querySelector('#ubah-alamat').value = alamat || '';
            modalUbah.querySelector('#ubah-agama').value = agama || '';
            modalUbah.querySelector('#ubah-status_pilih').value = status_pilih || 'belum';
            modalUbah.querySelector('#ubah-role').value = role || 'warga';
        });

        // ------------------------------------
        // MODAL HAPUS (SET LINK CONFIRM)
        // ------------------------------------
        const modalHapus = document.getElementById('modal-hapus');
        modalHapus.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const idHapus = button.getAttribute('data-id-hapus');

            const btnYaHapus = modalHapus.querySelector('#confirm-delete-btn');
            btnYaHapus.href = 'pengguna.php?hapus=' + encodeURIComponent(idHapus);
        });
    </script>
</body>

</html>