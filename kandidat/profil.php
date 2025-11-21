<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php?error=" . urlencode("Sesi berakhir atau Anda belum login."));
    exit();
}

if ($_SESSION['user_role'] !== 'kandidat') {
    header("Location: ../login.php?error=" . urlencode("Akses ditolak. Anda tidak memiliki izin Kandidat."));
    exit();
}
require_once '../koneksi.php';


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile </title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <link rel="import" href="navbar.php">
</head>

<body class="bg">
    <!-- Navbar -->
    <div class="container mb-5">
        <nav class="navbar navbar-expand-lg mt-2 mb-5">
            <div class="container d-flex justify-content-center flex-row">
                <a class="col-lg-6 col-8" href="#"><img src="../assets/img/logo1.png" width="40%" alt=""></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav rounded-3 text-end my-4 p-4 gap-4 button-nav ms-auto mb-2 gap-2">
                        <li class="nav-item">
                            <a class="btn-hitam" href="index.php">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn-merah" data-bs-toggle="modal"
                                data-bs-target="#modal-keluar">KELUAR</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <!-- Card Kandidat -->
    <div class="container  mb-5">
        <div class="row p-3 py-4 rounded-4 card-bg">
            <!-- Profil -->
            <div class="col-lg-3 col-12">
                <img src="../assets/img/Avatar Vektor Pengguna, Clipart Manusia, Pengguna Perempuan, Ikon PNG dan Vektor dengan Background Transparan untuk Unduh Gratis 6.png" class="rounded-4 d-block mx-auto mb-3 img-fit" alt="...">
                <p class="card-title poppins-semibold">Nama</p>
                <p class="card-text">Momo Hirai</p>
                <hr>
                <p class="card-text poppins-semibold">Pendidikan</p>
                <p class="card-text">Diploma IV</p>
                <hr>
                <p class="card-title poppins-semibold">Pekerjaan</p>
                <p class="card-text">Wiraswasta</p>
                <hr>
                <p class="card-title poppins-semibold">Alamat</p>
                <p class="card-text">Buana Vista Indah 2 Blok A No.48</p><br>
                <div class="d-grid gap-1">
                    <a href="#" class="btn-hitam" data-bs-toggle="modal" data-bs-target="#modal-ubah-profil">UBAH PROFIL
                        KANDIDAT</a>
                </div>
            </div>
            <!-- Visi Misi -->
            <!-- Visi Misi -->
            <div class="col-lg-9 col-12 ms-auto mt-4 text-putih">
                <h4 class="poppins-semibold  text-putih mb-3">Visi & Misi</h4>

                <div class="mb-4 text-putih ">
                    <h5 class="text-uppercase poppins-semibold text-putih">Visi</h5>
                    <p class="text-text-putih ">
                        Menjadi sosok pemimpin yang inspiratif, berintegritas, dan mampu menciptakan lingkungan yang
                        produktif,
                        inovatif, serta harmonis bagi seluruh anggota komunitas.
                    </p>
                </div>

                <div>
                    <h5 class="text-uppercase poppins-semibold text-putih">Misi</h5>
                    <ol class="">
                        <li>Meningkatkan partisipasi aktif seluruh anggota dalam setiap kegiatan organisasi.</li>
                        <li>Mendorong kreativitas dan inovasi melalui program-program berbasis ide baru dan teknologi.
                        </li>
                        <li>Mewujudkan transparansi serta komunikasi yang terbuka antara anggota dan pengurus.</li>
                        <li>Mengembangkan kepemimpinan yang adil, disiplin, dan berorientasi pada kerja sama tim.</li>
                        <li>Menciptakan lingkungan yang inklusif, suportif, dan saling menghargai satu sama lain.</li>
                    </ol>
                </div>
            </div>

        </div>
    </div>
    <!-- Modal -->
    <div class="container">
        <div class="modal fade" id="modal-keluar" tabindex="-1" aria-labelledby="keluar" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content bg-putih">
                    <div class="modal-body">
                        <div class="text-end">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="container-fluid">
                            <div class="row">
                                <h5 class="text-center mt-0 mb-3">apakah anda ingin keluar dari website suara warga?
                                </h5>
                                <div class="d-grid">
                                    <button type="button" onclick="window.location.href='../login.php'" class="btn-hitam border-0">YA</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-ubah-profil" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content rounded-4 bg-putih">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Formulir Profil Kandidat</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="" class="col-form-label">Foto <span
                                        class="text-danger">*</span></label>
                                <input type="file" class="form-control " id="inputGroupFile02">
                            </div>
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">Visi : <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control " id="message-text"
                                    style="height: 200px;"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">Misi : <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control " id="message-text"
                                    style="height: 200px;"></textarea>
                            </div>
                            <button type="button" class="btn-hijau">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script src="../bootstrap/js/bootstrap.bundle.js"></script>
</body>

</html>