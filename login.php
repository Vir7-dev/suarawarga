<?php
session_start();
require_once 'koneksi.php';

$error = $_GET['error'] ?? '';
if (!empty($error)) {
  $error = urldecode($error);
}

//test1235
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $nik = trim($_POST['nik'] ?? '');
  $password_input = $_POST['password'] ?? '';

  if (empty($nik) || empty($password_input)) {
    $error = "NIK dan Password harus diisi.";
  } else {
    try {
      // 1. Prepared Statement menggunakan PDO
      $stmt = $pdo->prepare("SELECT id, nama, role, password FROM pengguna WHERE nik = ?");

      // 2. Eksekusi dengan array data.
      // PDO: bind_param TIDAK ADA. Langsung di execute.
      $stmt->execute([$nik]);

      // 3. Pengecekan jumlah baris
      // PDO: num_rows TIDAK ADA. Gunakan rowCount().
      if ($stmt->rowCount() === 1) {

        // 4. Ambil data
        // PDO: fetch_assoc TIDAK ADA. Gunakan fetch(PDO::FETCH_ASSOC).
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifikasi Password
        if (password_verify($password_input, $data['password'])) {

          // Login Berhasil! Set data sesi
          $_SESSION['user_id'] = $data['id'];
          $_SESSION['user_name'] = $data['nama'];
          $_SESSION['user_role'] = $data['role'];

          // Redirect
          if ($data['role'] === 'panitia') {
            header("Location: panitia/index.php");
          } elseif ($data['role'] === 'kandidat') {
            header("Location: kandidat/index.php");
          } elseif ($data['role'] === 'warga') {
            header("Location: warga/index.php");
          }
          exit();
        } else {
          $error = "NIK atau Password salah.";
        }
      } else {
        $error = "NIK atau Password salah.";
      }
    } catch (PDOException $e) {
      // Menangkap error jika ada masalah di query database
      $error = "Terjadi kesalahan database: " . $e->getMessage();
      // Di produksi, ganti baris di atas dengan: $error = "Terjadi kesalahan internal.";
    }
  }
}

// Jika POST gagal, atau ini adalah GET request dengan error di URL, redirect ke halaman login (diri sendiri)
// Kita hanya redirect jika POST gagal DAN variabel $error berisi sesuatu.
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($error)) {
  header("Location: login.php?error=" . urlencode($error));
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SUARAWARGA - Login</title>
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="fontawesome/css/all.min.css">
  <link rel="stylesheet" href="style.css" />
</head>

<body class="bg">
  <div class="row align-items-center d-flex justify-content-end justify-content-lg-center flex-column-reverse flex-lg-row warp-login min-vh-100 m-0">
    <div class="col-lg-5 col-10 shadow-lg border rounded-4 p-0" style="background-color: #0c8254">
      <div class="p-5">
        <h2 class="mb-4 poppins-bold text-putih">LOG IN</h2>

        <?php if (!empty($error)): ?>
          <div class="alert alert-danger" role="alert">
            <?= $error ?>
          </div>
        <?php endif; ?>

        <form action="login.php" method="POST" class="text-white">
          <label class="form-label">NIK</label>
          <input
            type="text"
            name="nik"
            id="nik_input"
            class="form-control w-100 mb-3 custom-input"
            placeholder="Masukkan NIK"
            required
            value="<?= htmlspecialchars($nik ?? '') ?>" />

          <label class="form-label">Password</label>
          <input
            type="password"
            name="password"
            id="password_input"
            class="form-control w-100 mb-3 custom-input"
            placeholder="Masukkan Password"
            required />

          <div class="d-flex justify-content-between align-items-center mb-3">
          </div>

          <!-- Tombol full width -->
          <button type="submit" class="btn btn-dark w-100">
            LOG IN
          </button>
        </form>
      </div>
    </div>

    <div class="col-lg-4 col-6 text-center mt-5">
      <img src="assets/img/logo.png" class="img-fluid" alt="">
    </div>
  </div>
</body>

</html>
<script>
  const nikInput = document.getElementById("nik_input");
  const passwordInput = document.getElementById("password_input");

  nikInput.addEventListener("keydown", (e) => {
    if (e.key === "ArrowDown") {
      e.preventDefault();
      passwordInput.focus();
    }
  });

  passwordInput.addEventListener("keydown", (e) => {
    if (e.key === "ArrowUp") {
      e.preventDefault();
      nikInput.focus();
    }
  });
</script>

</html>