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
    <!-- Notifikasi Sukses/Error -->
    <?php if(isset($_GET['success']) && $_GET['success'] == 'tambah'): ?>
        <div class="alert alert-success alert-dismissible fade show mx-auto mt-3" style="max-width: 500px;" role="alert">
            ✅ Data pengguna berhasil ditambahkan!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show mx-auto mt-3" style="max-width: 500px;" role="alert">
            ❌ Error: <?= htmlspecialchars($_GET['error']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="container mb-5">
        <nav class="navbar navbar-expand-lg mt-2 mb-5">
            <div class="container d-flex justify-content-center flex-row">
                <a class="col-7 col-lg-5" href="index.php"><img src="../assets/img/logo1.png" width="40%" alt=""></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav rounded-3 text-end my-4 p-4 gap-4 button-nav ms-auto mb-2 gap-2">
                        <li class="nav-item">
                            <a href="periode.php" class="btn-hitam">MANAJEMEN PERIODE</a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php" class="btn-hitam">BERANDA</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn-merah" aria-current="page" data-bs-toggle="modal"
                                data-bs-target="#modal-keluar" href="#">KELUAR</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <div class="container mb-3">
        <div class="row">
            <div class="col-lg-8 mb-lg-0 mb-3 col-12">
                <div class="input-group ">
                    <form class="search-wrapper" role="search" method="GET" action="">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input class="form-control rounded-pill form-control-search" type="search" name="search"
                            placeholder="Cari Data Pengguna.." aria-label="Search"
                            value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                    </form>
                </div>
            </div>
            <div
                class="col-12 col-lg-4 flex-column flex-lg-row gap-2 d-flex gap-lg-4   justify-content-lg-end justify-content-between">
                <button type="button" class="btn-hijau  " data-bs-toggle="modal" data-bs-target="#modal-pengguna">TAMBAH
                    PENGGUNA</button>
                <button type="button" class="btn-hijau col-md-5 " data-bs-toggle="modal"
                    data-bs-target="#modal-excel">IMPORT EXCEL</button>
            </div>
            <div class="col-12 mt-3">
                <div class="table-responsive col-12 rounded-4 shadow">
                    <table class="poppins-medium bg-putih rounded-4 w-100">
                        <tr class="bg-hijau">
                            <th>NIK</th>
                            <th>NAMA</th>
                            <th>TEMPAT, TANGGAL LAHIR</th>
                            <th>JENIS KELAMIN</th>
                            <th>ALAMAT</th>
                            <th>AGAMA</th>
                            <th>PENDIDIKAN</th>
                            <th>PEKERJAAN</th>
                            <th>STATUS PEMILIHAN</th>
                            <th>ROLE</th>
                            <th style="width: 14%;">AKSI</th>
                        </tr>
                        <tbody id="t-body">
                            <?php

                            // --- Konfigurasi Pagination ---
                            $limit = 10;
                            $page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                            $page  = $page < 1 ? 1 : $page;

                            // --- KODE PENCARIAN DITAMBAHKAN DI SINI ---
                            $search = isset($_GET['search']) ? trim($_GET['search']) : '';

                            if ($search != '') {
                                // DENGAN PENCARIAN
                                $searchParam = "%$search%";

                                // Hitung total data dengan pencarian
                                $countStmt = $pdo->prepare("SELECT COUNT(*) FROM pengguna WHERE nik LIKE ? OR nama LIKE ? OR alamat LIKE ?");
                                $countStmt->execute([$searchParam, $searchParam, $searchParam]);
                                $totalData = $countStmt->fetchColumn();

                                // total halaman
                                $totalPage = ceil($totalData / $limit);

                                // offset
                                $offset = ($page - 1) * $limit;

                                // Ambil data dengan pencarian
                                $stmt = $pdo->prepare("SELECT * FROM pengguna WHERE nik LIKE ? OR nama LIKE ? OR alamat LIKE ? ORDER BY nama ASC LIMIT :limit OFFSET :offset");
                                $stmt->bindValue(1, $searchParam, PDO::PARAM_STR);
                                $stmt->bindValue(2, $searchParam, PDO::PARAM_STR);
                                $stmt->bindValue(3, $searchParam, PDO::PARAM_STR);
                                $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                                $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
                                $stmt->execute();
                            } else {
                                // TANPA PENCARIAN (kode lama)

                                // Hitung total data
                                $countStmt = $pdo->prepare("SELECT COUNT(*) FROM pengguna");
                                $countStmt->execute();
                                $totalData = $countStmt->fetchColumn();

                                // total halaman
                                $totalPage = ceil($totalData / $limit);

                                // offset
                                $offset = ($page - 1) * $limit;

                                // Ambil data sesuai halaman
                                $stmt = $pdo->prepare("SELECT * FROM pengguna ORDER BY nama ASC LIMIT :limit OFFSET :offset");
                                $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                                $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
                                $stmt->execute();
                            }

                            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($data as $row) {
                                echo "<tr>
                                <td>{$row['nik']}</td>
                                <td>{$row['nama']}</td>
                                <td>{$row['tempat_lahir']}, {$row['tanggal_lahir']}</td>
                                <td>{$row['jenis_kelamin']}</td>
                                <td>{$row['alamat']}</td>
                                <td>{$row['agama']}</td>
                                <td>{$row['pendidikan']}</td>
                                <td>{$row['pekerjaan']}</td>
                                <td>{$row['status_ambil']}</td>
                                <td>{$row['role']}</td>
                                <td>
                                    <button class='btn-hijau btn-sm' onclick=\"editPengguna('{$row['nik']}')\">Edit</button>
                                    <button class='btn-merah btn-sm' onclick=\"hapusPengguna('{$row['nik']}')\">Hapus</button>
                                </td>
                            </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center align-items-center gap-2 mt-3">

                    <!-- Tombol Prev -->
                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page - 1 ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?>"
                            class="btn btn-outline-success">Prev</a>
                    <?php else: ?>
                        <button class="btn btn-outline-secondary" disabled>Prev</button>
                    <?php endif; ?>

                    <!-- Nomor Halaman -->
                    <?php for ($i = 1; $i <= $totalPage; $i++): ?>
                        <a href="?page=<?= $i ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?>"
                            class="btn <?= $i == $page ? 'btn-success text-white' : 'btn-outline-success' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>

                    <!-- Tombol Next -->
                    <?php if ($page < $totalPage): ?>
                        <a href="?page=<?= $page + 1 ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?>"
                            class="btn btn-outline-success">Next</a>
                    <?php else: ?>
                        <button class="btn btn-outline-secondary" disabled>Next</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="container">
        <div class="modal fade" id="modal-excel" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content rounded-4 bg-putih">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Formulir Import Excel </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="" class="col-form-label">Excel Data Pengguna <span
                                        class="text-danger">*</span></label>
                                <input type="file" class="form-control form-control-abu" id="inputGroupFile02">
                            </div>
                            <button type="button" class="btn-hijau">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Tambah Pengguna -->
        <div class="modal fade" id="modal-pengguna" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content rounded-4 bg-putih">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Formulir Pengguna</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="tambah_pengguna.php">
                            <div class="mb-3">
                                <label for="" class="col-form-label">NIK <span class="text-danger">*</span></label>
                                <input type="text" name="nik" class="form-control input-underline" id="input-nik" required>
                            </div>
                            <div class="mb-3">
                                <label for="" class="col-form-label">Nama <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control input-underline" id="input-nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="" class="col-form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" name="tempat_lahir" class="form-control input-underline" id="input-tempat-lahir" required>
                            </div>
                            <div class="mb-3">
                                <label for="" class="col-form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_lahir" class="form-control input-underline" id="input-tanggal-lahir" required>
                            </div>
                            <div class="mb-3">
                                <label for="" class="col-form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="jenis_kelamin" class="form-control input-underline" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="col-form-label">Agama <span class="text-danger">*</span></label>
                                <select name="agama" class="form-control input-underline" required>
                                    <option value="">Pilih Agama</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="col-form-label">Alamat <span class="text-danger">*</span></label>
                                <textarea name="alamat" class="form-control input-underline" id="input-alamat" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="" class="col-form-label">Pendidikan <span class="text-danger">*</span></label>
                                <input type="text" name="pendidikan" class="form-control input-underline" id="input-pendidikan" required>
                            </div>
                            <div class="mb-3">
                                <label for="" class="col-form-label">Pekerjaan <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="pekerjaan" class="form-control input-underline" id="input-pekerjaan" required>
                            </div>
                            <div class="mb-3">
                                <label for="" class="col-form-label">Role <span class="text-danger">*</span></label>
                                <select name="role" class="form-control input-underline" required>
                                    <option value="">Pilih Role</option>
                                    <option value="warga" selected>Warga</option>
                                    <option value="panitia">Panitia</option>
                                    <option value="kandidat">Kandidat</option>
                                </select>
                            </div>
                            <button type="submit" name="tambah" class="btn-hijau">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Ubah Pengguna -->
        <div class="modal fade" id="modal-ubah" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content rounded-4 bg-putih">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Edit Data Pengguna</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="ubah_pengguna.php">
                            <input type="hidden" name="nik_lama" id="edit-nik">

                            <div class="mb-3">
                                <label class="col-form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control input-underline" id="edit-nama" required>
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" name="tempat_lahir" class="form-control input-underline" id="edit-tempat-lahir" required>
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_lahir" class="form-control input-underline" id="edit-tanggal-lahir" required>
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="jenis_kelamin" class="form-control input-underline" id="edit-jenis-kelamin" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label">Agama <span class="text-danger">*</span></label>
                                <select name="agama" class="form-control input-underline" id="edit-agama" required>
                                    <option value="">Pilih Agama</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label">Alamat <span class="text-danger">*</span></label>
                                <textarea name="alamat" class="form-control input-underline" id="edit-alamat" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label">Pendidikan <span class="text-danger">*</span></label>
                                <input type="text" name="pendidikan" class="form-control input-underline" id="edit-pendidikan" required>
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label">Pekerjaan <span class="text-danger">*</span></label>
                                <input type="text" name="pekerjaan" class="form-control input-underline" id="edit-pekerjaan" required>
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label">Role <span class="text-danger">*</span></label>
                                <select name="role" class="form-control input-underline" id="edit-role" required>
                                    <option value="">Pilih Role</option>
                                    <option value="panitia">Panitia</option>
                                    <option value="kandidat">Kandidat</option>
                                    <option value="warga">Warga</option>
                                </select>
                            </div>
                            <button type="submit" name="update" class="btn-hijau">Update</button>
                        </form>
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
                                <h5 class="text-center mt-0 mb-3">Apakah Anda ingin keluar dari website <b>Suara
                                        Warga</b>?</h5>
                                <div class="d-grid">
                                    <button type="button" onclick="window.location.href='../logout.php'" class="btn-hitam border-0">YA</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../data.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.js"></script>
    <script>
        function editPengguna(nik) {
            // Fetch data pengguna berdasarkan NIK
            fetch('get_pengguna.php?nik=' + nik)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Isi form modal dengan data
                        document.getElementById('edit-nik').value = data.data.nik;
                        document.getElementById('edit-nama').value = data.data.nama;
                        document.getElementById('edit-tempat-lahir').value = data.data.tempat_lahir;
                        document.getElementById('edit-tanggal-lahir').value = data.data.tanggal_lahir;
                        document.getElementById('edit-jenis-kelamin').value = data.data.jenis_kelamin;
                        document.getElementById('edit-agama').value = data.data.agama;
                        document.getElementById('edit-alamat').value = data.data.alamat;
                        document.getElementById('edit-pendidikan').value = data.data.pendidikan;
                        document.getElementById('edit-pekerjaan').value = data.data.pekerjaan;
                        document.getElementById('edit-role').value = data.data.role;

                        // Tampilkan modal
                        var modal = new bootstrap.Modal(document.getElementById('modal-ubah'));
                        modal.show();
                    } else {
                        alert('Data tidak ditemukan!');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengambil data');
                });
        }

        function hapusPengguna(nik) {
            if (confirm('Apakah Anda yakin ingin menghapus pengguna ini?')) {
                window.location.href = 'hapus_pengguna.php?nik=' + nik;
            }
        }
    </script>

</body>

</html>