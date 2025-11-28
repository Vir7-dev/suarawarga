<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !='kandidat') {
    header("Location: ../login.php");
    exit;
}


require_once '../koneksi.php';
try {
	// Gunakan $pdo->query() jika tidak ada input user (SELECT murni)
	$stmt = $pdo->query("SELECT
	k.visi,
	k.misi,
	k.foto_profil,
	k.id_kandidat,
	p.nama,
	p.pendidikan,
	p.pekerjaan,
	p.alamat,
	pr.nama_periode
FROM kandidat k
JOIN pengguna p ON k.pengguna_id = p.id
JOIN periode pr ON k.id_periode = pr.id_periode;");
	// Ambil semua hasil dalam bentuk array asosiatif
	$periode_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$stmt1 = $stmt2 = $pdo->query("SELECT 
        k.id_kandidat,
        k.pengguna_id,
        p.nama,
        COUNT(s.id_suara) AS total_suara
    FROM kandidat k
    LEFT JOIN suara s ON k.id_kandidat = s.kandidat_id 
    LEFT JOIN pengguna p ON p.id = k.pengguna_id
    GROUP BY k.id_kandidat, k.pengguna_id, p.nama");

    $suara = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    $kandidat_ids = array_column($suara, 'id_kandidat');
    $pengguna_id  = array_column($suara, 'nama');
    $total_suara  = array_column($suara, 'total_suara');

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
	<title>Panitia</title>
	<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="../style.css">
	<link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body class="bg">
	<!-- Navbar -->
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
                            <a href="profil.php" class="btn btn-dark"><i class="fa-solid fa-address-card me-2"></i>PROFIL</a>
                        </li>
                        <li class="nav-item">
                            <a
                                class="btn btn-dark" aria-current="page" href="#" 
                                data-bs-toggle="modal" data-bs-target="#modal-ambil-token"><i class="fa-solid fa-ticket me-2"></i>TOKEN</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-keluar" href="#"><i class="fa-solid fa-right-from-bracket me-2"></i>KELUAR</a>
                        </li>
                    </ul>
                </div>

            </div>
        </nav>
    </div>
	<!-- Card Kandidat -->
    <div class="container mb-5">
        <h2 class="text-center poppins-bold mb-5">Pemilihan Ketua RT Periode 2025–2026</h2>
        <div class="row mb-5">

            <?php if (!empty($periode_list)): ?>
                <?php foreach ($periode_list as $data): ?>
                    <div data-aos="flip-right" class="col-lg-3 col-md-5 col-11 mx-auto">
                        <div class="card rounded-4 card-bg mb-5">

                            <!-- Foto Kandidat -->
                            <img src="../assets/img/photo.png"
                                class="card-img-top p-3 img-fit"
                                style="border-radius: 26px;"
                                alt="Foto Kandidat">

                            <div class="card-body">
                                <h1 class="card-title poppins-semibold">
                                    <?= htmlspecialchars($data['id_kandidat']) ?>
                                </h1>

                                <hr>
                                <p class="card-title poppins-semibold">Nama</p>
                                <p class="card-text"><?= htmlspecialchars($data['nama']) ?></p>

                                <hr>
                                <p class="card-title poppins-semibold">Pendidikan</p>
                                <?= htmlspecialchars($data['pendidikan']) ?>

                                <hr>
                                <p class="card-title poppins-semibold">Pekerjaan</p>
                                <p class="card-text"><?= htmlspecialchars($data['pekerjaan']) ?>

                                    <hr>
                                <p class="card-title poppins-semibold">Alamat</p>
                                <p class="card-text"><?= htmlspecialchars($data['alamat']) ?></p><br>

                                <div class="d-grid gap-1">
                                    <!-- Modal Profil Kandidat -->
                                    <a href="#" class="btn btn-dark" data-bs-toggle="modal"
                                        data-bs-target="#modal-profil-<?= htmlspecialchars($data['id_kandidat']) ?>">
                                        TAMPILKAN LEBIH
                                    </a>

                                    <!-- Modal Pilih -->
                                    <a href="#" class="btn btn-dark" data-bs-toggle="modal"
                                        data-bs-target="#modal-pilih-<?= htmlspecialchars($data['id_kandidat']) ?>">
                                        PILIH
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Kandidat -->
                    <div class="modal fade" id="modal-profil-<?= htmlspecialchars($data['id_kandidat']) ?>" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered modal-xl">
                            <div class="modal-content bg-putih rounded-4">
                                <div class="modal-body">
                                    <div class="text-end">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="container-fluid">
                                        <div class="row d-flex">

                                            <!-- Kiri -->
                                            <div class="col-lg-3 col-12">
                                                <img src="../assets/img/photo.png"
                                                    class="rounded-4 d-block mx-auto mb-3 img-fit">

                                                <h1 class="card-title poppins-semibold">
                                                    <?= htmlspecialchars($data['id_kandidat']) ?>
                                                </h1>

                                                <hr>
                                                <p class="card-title poppins-bold">Nama</p>
                                                <p><?= htmlspecialchars($data['nama']) ?></p>

                                                <hr>
                                                <p class="card-title poppins-bold">Pendidikan</p>
                                                <p><?= htmlspecialchars($data['pendidikan']) ?></p>

                                                <hr>
                                                <p class="card-title poppins-bold">Pekerjaan</p>
                                                <p><?= htmlspecialchars($data['pekerjaan']) ?></p>

                                                <hr>
                                                <p class="card-title poppins-bold">Alamat</p>
                                                <p><?= htmlspecialchars($data['alamat']) ?></p><br>

                                                <div class="d-grid gap-2">
                                                    <button class="btn btn-dark" data-bs-toggle="modal"
                                                        data-bs-target="#modal-pilih-<?= htmlspecialchars($data['id_kandidat']) ?>">
                                                        PILIH
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Kanan -->
                                            <div class="col-lg-9 col-12 mt-4">
                                                <h4 class="poppins-bold">Visi</h4>
                                                <p><?= htmlspecialchars($data['visi']) ?></p>

                                                <h4 class="poppins-bold mt-4">Misi</h4>
                                                <p><?= htmlspecialchars($data['misi']) ?></p>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Kandidat -->
                    <div class="modal fade" id="modal-pilih-<?= htmlspecialchars($data['id_kandidat']) ?>" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content bg-putih rounded-4">
                                <div class="modal-body">

                                    <div class="text-end">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <h5 class="text-center mb-3">
                                        Suara tidak dapat diubah setelah diberikan. Apakah yakin memilih?
                                    </h5>

                                    <div class="text-center mb-3">
                                        <strong><?= htmlspecialchars($data['nama']) ?></strong>
                                    </div>

                                    <div class="d-grid">
                                        <input type="text" placeholder="Masukkan Token Anda"
                                            class="btn btn-dark text-uppercase mb-2">

                                        <button class="btn btn-dark border-0">YA</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>

            <?php endif; ?>

        </div>
    </div>

    <!-- Diagram -->
    <div class="container col-lg-12 col-10 mb-5">
        <h2 class="text-center poppins-bold mb-5">
            Hasil Sementara Pemilihan Ketua RT Periode 2025–2026s
        </h2>
        <div class="row p-3 py-4 gap-4 gap-md-0 rounded-4 card-bg">
            <div class="col-12 flex-md-row flex-column d-flex justify-content-between align-items-center mb-3">
                <h2 class="text-left poppins-bold text-putih">Hasil Pemilihan</h2>
                <a href="" class="text-sedang btn btn-dark">CETAK PEMILIHAN</a>
            </div>
            <div class="col-lg-8">

                <div class="d-flex justify-content-around bg-chart gap-lg-4 gap-3 p-1 px-md-4 py-4 rounded-4 bg-putih h-100">
                    <canvas id="myChart" style="width: 100%;"></canvas>
                    <script>
                        var xValues = <?php echo json_encode($pengguna_id); ?>;
                        var yValues = <?php echo json_encode($total_suara); ?>;
                        var barColors = ["red", "green", "blue", "orange", "brown"];

                        new Chart("myChart", {
                            type: "bar",
                            data: {
                                labels: xValues,
                                datasets: [{
                                    backgroundColor: barColors,
                                    data: yValues
                                }]
                            },
                            options: {
                                legend: {
                                    display: false
                                },
                                title: {
                                    display: true,
                                    text: "TOTAL SUARA"
                                },
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }]
                                }
                            }
                        });
                    </script>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="d-flex justify-content-around bg-chart gap-lg-4 gap-3 p-1 px-md-4 py-4 rounded-4 bg-putih h-100">
                    <canvas id="myChart1" style="width: 100%; height: 100%;"></canvas>
                    <script>
                        var xValues = <?php echo json_encode($pengguna_id); ?>;
                        var yValues = <?php echo json_encode($total_suara); ?>;
                        var barColors = ["red", "green", "blue", "orange", "brown"];

                        new Chart("myChart1", {
                            type: "doughnut",
                            data: {
                                labels: xValues,
                                datasets: [{
                                    backgroundColor: barColors,
                                    data: yValues
                                }]
                            },
                            options: {
                                legend: {
                                    display: false
                                },
                                title: {
                                    display: true,
                                    text: "TOTAL SUARA"
                                }
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
	<!-- Modal -->
	<div class="container">
		<!-- Modal Ambil Token -->
		<div class="modal fade" id="modal-ambil-token" tabindex="-1" aria-labelledby="ambil-token" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content bg-putih rounded-4">
					<div class="modal-body">
						<div class="text-end">
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="container-fluid">
							<div class="row">
								<h5 class="text-center mt-0 mb-3">Ini adalah token Anda. <b>Harap simpan dengan baik</b>
									dan jangan dibagikan kepada orang lain!</h5>
								<div class="d-grid">
									<button type="button" class="btn btn-dark border-0"><i class="fa-solid fa-copy"></i>
										15042007</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
        <div class="modal fade" id="modal-keluar" tabindex="-1" aria-labelledby="keluar" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
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

    <!-- Script -->
    <script src="../bootstrap/js/bootstrap.bundle.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="../script.js"></script>
</body>

</html>