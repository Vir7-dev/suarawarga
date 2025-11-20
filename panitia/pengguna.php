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
    <div class="container mb-5">
        <nav class="navbar navbar-expand-lg mt-2 mb-5">
            <div class="container d-flex justify-content-center flex-row">
                <a class="col-7 col-lg-5" href="#"><img src="../assets/img/logo1.png" width="40%" alt=""></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            <!-- test -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav rounded-3 text-end my-4 p-4 gap-4 button-nav ms-auto mb-2 gap-2">
                        <li class="nav-item">
                            <a href="periode.php" class="btn-hitam">MANAJEMEN PERIODE</a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php" class="btn-hitam">Beranda</a>
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
                    <form class="search-wrapper" role="search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input class="form-control rounded-pill form-control-search" type="search"
                            placeholder="Cari Data Pengguna.." aria-label="Search">
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
                            <th style="width: 9%;">AKSI</th>
                        </tr>
                        <tbody id="t-body">
                            <?php
                            include "../koneksi.php";

                            // --- Konfigurasi Pagination ---
                            $limit = 10; // jumlah baris per halaman
                            $page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                            $page  = $page < 1 ? 1 : $page;

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
                <button class='btn-hijau btn-sm'>Edit</button>
                <button class='btn-merah btn-sm'>Hapus</button>
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
                        <a href="?page=<?= $page - 1 ?>" class="btn btn-outline-success">Prev</a>
                    <?php else: ?>
                        <button class="btn btn-outline-secondary" disabled>Prev</button>
                    <?php endif; ?>

                    <!-- Nomor Halaman -->
                    <?php for ($i = 1; $i <= $totalPage; $i++): ?>
                        <a href="?page=<?= $i ?>"
                            class="btn <?= $i == $page ? 'btn-success text-white' : 'btn-outline-success' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>

                    <!-- Tombol Next -->
                    <?php if ($page < $totalPage): ?>
                        <a href="?page=<?= $page + 1 ?>" class="btn btn-outline-success">Next</a>
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
        <div class="modal fade" id="modal-pengguna" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content rounded-4 bg-putih">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Formulir Pengguna</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="" class="col-form-label">NIK <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-underline" id="input-nik">
                            </div>
                            <div class="mb-3">
                                <label for="" class="col-form-label">Nama Lengkap <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control input-underline" id="input-nama">
                            </div>
                            <div class="mb-3">
                                <label for="" class="col-form-label">Tempat Lahir <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control input-underline" id="input-tempat-lahir">
                            </div>
                            <div class="mb-3">
                                <label for="" class="col-form-label">Tanggal Lahir <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control input-underline" id="input-tanggal-lahir">
                            </div>
                            <div class="mb-3">
                                <label for="" class="col-form-label">Agama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-underline" id="input-agama">
                            </div>
                            <div class="mb-3">
                                <label for="" class="col-form-label">Alamat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-underline" id="input-alamat">
                            </div>
                            <div class="mb-3">
                                <label for="" class="col-form-label">Pendidikan <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control input-underline" id="input-pendidikan">
                            </div>
                            <div class="mb-3">
                                <label for="" class="col-form-label">Pekerjaan <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control input-underline" id="input-pekerjaan">
                            </div>
                            <button type="button" class="btn-hijau">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-ubah" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content rounded-4 bg-putih">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Formulir Pengguna</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="" class="col-form-label">Nama Lengkap</label>
                                <input type="text" class="form-control form-control-abu" id="inputGroupFile02">
                            </div>
                            <div class="mb-3">
                                <label for="" class="col-form-label">Agama</label>
                                <input type="text" class="form-control form-control-abu" id="inputGroupFile02">
                            </div>
                            <div class="mb-3">
                                <label for="" class="col-form-label">Alamat</label>
                                <input type="text" class="form-control form-control-abu" id="inputGroupFile02">
                            </div>
                            <div class="mb-3">
                                <label for="" class="col-form-label">Pendidikan</label>
                                <input type="text" class="form-control form-control-abu" id="inputGroupFile02">
                            </div>
                            <div class="mb-3">
                                <label for="" class="col-form-label">Pekerjaan</label>
                                <input type="text" class="form-control form-control-abu" id="inputGroupFile02">
                            </div>
                            <div class="mb-3">
                                <label for="" class="col-form-label">Role</label>
                                <input type="text" class="form-control form-control-abu" id="inputGroupFile02">
                            </div>
                            <button type="button" class="btn-hijau">Simpan</button>
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
                                <h5 class="text-center mt-0 mb-3">Apakah Anda yakin ingin. <b>Menghapus</b> Pengguna?
                                </h5>
                            </div>
                            <div class="d-grid">
                                <button type="button" class="btn-hitam border-0">YA</button>
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
                                <h5 class="text-center mt-0 mb-3">Apakah Anda ingin keluar dari website <b>Suara
                                        Warga</b>?</h5>
                                <div class="d-grid">
                                    <button type="button" onclick="window.location.href='../login.php'" class="btn-hitam border-0">YA</button>
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
</body>

</html>