<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php?error=" . urlencode("Sesi berakhir atau Anda belum login."));
    exit();
}

if ($_SESSION['user_role'] !== 'warga') {
    header("Location: ../login.php?error=" . urlencode("Akses ditolak. Anda tidak memiliki izin Panitia."));
    exit();
}
require_once '../koneksi.php';


?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Suara Warga</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="../fontawesome/css/all.min.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
  </head>

  <body class="bg">
    <!-- Navbar -->
    <div class="container mb-5">
      <nav class="navbar navbar-expand-lg mt-2 mb-5">
        <div class="container d-flex justify-content-center flex-row">
          <a class="col-lg-7 col-8" href="#"
            ><img src="../assets/img/logo1.png" width="40%" alt=""
          /></a>
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
            <ul
              class="navbar-nav rounded-3 text-end my-4 p-4 gap-4 button-nav ms-auto mb-2 gap-2"
            >
              <li class="nav-item">
                <a
                  class="btn-hitam"
                  aria-current="page"
                  href="#"
                  data-bs-toggle="modal"
                  data-bs-target="#modal-ambil-token"
                  >AMBIL TOKEN</a
                >
              </li>
              <li class="nav-item">
                <a
                  class="btn-merah"
                  aria-current="page"
                  data-bs-toggle="modal"
                  data-bs-target="#modal-keluar"
                  href="#"
                  >KELUAR</a
                >
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
    <!-- Card Kandidat -->
    <div class="container mb-5">
      <h2 class="text-center poppins-bold mb-5">
        Pemilihan Ketua RT Periode 2025–2026
      </h2>
      <div class="row mb-5">
        <!-- Kandidat 1 -->
        <div data-aos="flip-right" class="col-lg-3 col-md-5 col-11 mx-auto">
          <div class="card rounded-4 card-bg mb-5">
            <img
              src="../assets/img/Avatar Vektor Pengguna, Clipart Manusia, Pengguna Perempuan, Ikon PNG dan Vektor dengan Background Transparan untuk Unduh Gratis 6.png"
              style="border-radius: 26px"
              class="card-img-top p-3 img-fit"
              alt="Kandidat 1"
            />
            <div class="card-body">
              <h1 class="card-title poppins-semibold">01</h1>
              <hr />
              <p class="card-title poppins-semibold">Nama</p>
              <p class="card-text">Momo Hirai</p>
              <hr />
              <p class="card-title poppins-semibold">Pendidikan</p>
              <p class="card-text">Diploma IV</p>
              <hr />
              <p class="card-title poppins-semibold">Pekerjaan</p>
              <p class="card-text">Wiraswasta</p>
              <hr />
              <p class="card-title poppins-semibold">Alamat</p>
              <p class="card-text">Buana Vista Indah 2 Blok A No.48</p>
              <br />
              <div class="d-grid gap-1">
                <a
                  href="#"
                  class="btn-hitam"
                  data-bs-toggle="modal"
                  data-bs-target="#modal-profil-kandidat"
                  >TAMPILKAN LEBIH</a
                >
                <a
                  href="#"
                  class="btn-hitam"
                  data-bs-toggle="modal"
                  data-bs-target="#modal-pilih"
                  >PILIH</a
                >
              </div>
            </div>
          </div>
        </div>

        <!-- Kandidat 2 -->
        <div data-aos="flip-right" class="col-lg-3 col-md-5 col-11 mx-auto">
          <div class="card rounded-4 card-bg mb-5">
            <img
              src="../assets/img/Avatar Vektor Pengguna, Clipart Manusia, Pengguna Perempuan, Ikon PNG dan Vektor dengan Background Transparan untuk Unduh Gratis 6.png"
              style="border-radius: 26px"
              class="card-img-top p-3 img-fit"
              alt="Kandidat 2"
            />
            <div class="card-body">
              <h1 class="card-title poppins-semibold">02</h1>
              <hr />
              <p class="card-title poppins-semibold">Nama</p>
              <p class="card-text">Jihyo Park</p>
              <hr />
              <p class="card-title poppins-semibold">Pendidikan</p>
              <p class="card-text">Sarjana Komunikasi</p>
              <hr />
              <p class="card-title poppins-semibold">Pekerjaan</p>
              <p class="card-text">Pegawai Negeri</p>
              <hr />
              <p class="card-title poppins-semibold">Alamat</p>
              <p class="card-text">Jl. Melati Raya No.12, RT 02 RW 05</p>
              <br />
              <div class="d-grid gap-1">
                <a
                  href="#"
                  class="btn-hitam"
                  data-bs-toggle="modal"
                  data-bs-target="#modal-profil-kandidat"
                  >TAMPILKAN LEBIH</a
                >
                <a
                  href="#"
                  class="btn-hitam"
                  data-bs-toggle="modal"
                  data-bs-target="#modal-pilih"
                  >PILIH</a
                >
              </div>
            </div>
          </div>
        </div>

        <!-- Kandidat 3 -->
        <div data-aos="flip-right" class="col-lg-3 col-md-5 col-11 mx-auto">
          <div class="card rounded-4 card-bg mb-5">
            <img
              src="../assets/img/Avatar Vektor Pengguna, Clipart Manusia, Pengguna Perempuan, Ikon PNG dan Vektor dengan Background Transparan untuk Unduh Gratis 6.png"
              style="border-radius: 26px"
              class="card-img-top p-3 img-fit"
              alt="Kandidat 3"
            />
            <div class="card-body">
              <h1 class="card-title poppins-semibold">03</h1>
              <hr />
              <p class="card-title poppins-semibold">Nama</p>
              <p class="card-text">Nayeon Im</p>
              <hr />
              <p class="card-title poppins-semibold">Pendidikan</p>
              <p class="card-text">SMA Sederajat</p>
              <hr />
              <p class="card-title poppins-semibold">Pekerjaan</p>
              <p class="card-text">Ibu Rumah Tangga</p>
              <hr />
              <p class="card-title poppins-semibold">Alamat</p>
              <p class="card-text">Jl. Cempaka Putih No.8, RT 03 RW 06</p>
              <br />
              <div class="d-grid gap-1">
                <a
                  href="#"
                  class="btn-hitam"
                  data-bs-toggle="modal"
                  data-bs-target="#modal-profil-kandidat"
                  >TAMPILKAN LEBIH</a
                >
                <a
                  href="#"
                  class="btn-hitam"
                  data-bs-toggle="modal"
                  data-bs-target="#modal-pilih"
                  >PILIH</a
                >
              </div>
            </div>
          </div>
        </div>

        <!-- Kandidat 4 -->
        <div data-aos="flip-right" class="col-lg-3 col-md-5 col-11 mx-auto">
          <div class="card rounded-4 card-bg mb-5">
            <img
              src="../assets/img/Avatar Vektor Pengguna, Clipart Manusia, Pengguna Perempuan, Ikon PNG dan Vektor dengan Background Transparan untuk Unduh Gratis 6.png"
              style="border-radius: 26px"
              class="card-img-top p-3 img-fit"
              alt="Kandidat 4"
            />
            <div class="card-body">
              <h1 class="card-title poppins-semibold">04</h1>
              <hr />
              <p class="card-title poppins-semibold">Nama</p>
              <p class="card-text">Sana Minatozaki</p>
              <hr />
              <p class="card-title poppins-semibold">Pendidikan</p>
              <p class="card-text">Magister Manajemen</p>
              <hr />
              <p class="card-title poppins-semibold">Pekerjaan</p>
              <p class="card-text">Karyawan Swasta</p>
              <hr />
              <p class="card-title poppins-semibold">Alamat</p>
              <p class="card-text">Jl. Anggrek No.25, RT 04 RW 02</p>
              <br />
              <div class="d-grid gap-1">
                <a
                  href="#"
                  class="btn-hitam"
                  data-bs-toggle="modal"
                  data-bs-target="#modal-profil-kandidat"
                  >TAMPILKAN LEBIH</a
                >
                <a
                  href="#"
                  class="btn-hitam"
                  data-bs-toggle="modal"
                  data-bs-target="#modal-pilih"
                  >PILIH</a
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Diagram -->
    <div class="container col-lg-12 col-10 mb-5">
      <h2 class="text-center poppins-bold mb-5">
        Hasil Sementara Pemilihan Ketua RT Periode 2025–2026
      </h2>
      <div class="row p-3 py-4 gap-4 gap-md-0 rounded-4 card-bg">
        <div
          class="col-12 flex-md-row flex-column d-flex justify-content-between align-items-center mb-3"
        >
          <h2 class="text-left poppins-bold text-putih">Hasil Pemilihan</h2>
          <a href="" class="text-sedang btn-hitam">CETAK PEMILIHAN</a>
        </div>
        <div class="col-lg-8">
          <div
            class="d-flex justify-content-around bg-chart gap-lg-4 gap-3 p-1 px-md-4 py-4 rounded-4 bg-putih h-100"
          >
            <div class="box-satu">
              <div
                class="grafik-batang grafik-batang1"
                data-height="250"
                style="--target-height: 250px; background-color: #86a83d"
              ></div>
              <p class="text-center poppins text-hitam fs-6">Nevin Rin</p>
            </div>
            <div class="box-satu">
              <div
                class="grafik-batang grafik-batang2"
                data-height="300"
                style="--target-height: 300px; background-color: #007f5f"
              ></div>
              <p class="text-center poppins text-hitam fs-6">Nevin Rin</p>
            </div>
            <div class="box-satu">
              <div
                class="grafik-batang grafik-batang3"
                data-height="120"
                style="--target-height: 120px; background-color: #ffd93d"
              ></div>
              <p class="text-center poppins text-hitam fs-6">Nevin Rin</p>
            </div>
            <div class="box-satu">
              <div
                class="grafik-batang grafik-batang4"
                data-height="200"
                style="--target-height: 200px; background-color: #ff914d"
              ></div>
              <p class="text-center poppins text-hitam fs-6">Nevin Rin</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 mt-4 mt-lg-0">
          <div
            class="rounded-4 bg-putih p-1 p-lg-4 d-flex justify-content-center flex-column h-100"
          >
            <div class="pie-chart m-auto"></div>
            <div class="persen mt-2 text-black">
              <div class="row">
                <div
                  class="col d-flex text-center text-align-center flex-column"
                >
                  <p class="poppins-bold fs-5">40%</p>
                  <p class="poppins">Nevin rin</p>
                </div>
                <div class="col d-flex text-center flex-column">
                  <p class="poppins-bold fs-5">40%</p>
                  <p class="poppins">Nevin rin</p>
                </div>
              </div>
              <div class="row">
                <div class="col text-center flex-column">
                  <p class="poppins-bold fs-5">40%</p>
                  <p class="poppins">Nevin rin</p>
                </div>
                <div class="col d-flex text-center flex-column">
                  <p class="poppins-bold fs-5">40%</p>
                  <p class="poppins">Nevin rin</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="container">
      <!-- Modal Profil Kandidat -->
      <div
        class="modal fade"
        id="modal-profil-kandidat"
        tabindex="-1"
        aria-labelledby="profil-kandidat"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered modal-xl">
          <div class="modal-content bg-putih rounded-4">
            <div class="modal-body">
              <div class="text-end">
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                ></button>
              </div>
              <div class="container-fluid">
                <div class="row d-flex">
                  <!-- Kiri: Info kandidat -->
                  <div class="col-lg-3 col-12">
                    <img
                      src="../assets/img/Avatar Vektor Pengguna, Clipart Manusia, Pengguna Perempuan, Ikon PNG dan Vektor dengan Background Transparan untuk Unduh Gratis 6.png"
                      class="rounded-4 d-block mx-auto mb-3 img-fit"
                      alt="Kandidat"
                    />
                    <h1 class="card-title poppins-semibold">01</h1>
                    <hr />
                    <p class="card-title poppins-bold">Nama</p>
                    <p class="card-text">Momo Hirai</p>
                    <hr />
                    <p class="card-title poppins-bold">Pendidikan</p>
                    <p class="card-text">Diploma IV</p>
                    <hr />
                    <p class="card-title poppins-bold">Pekerjaan</p>
                    <p class="card-text">Wiraswasta</p>
                    <hr />
                    <p class="card-title poppins-bold">Alamat</p>
                    <p class="card-text">Buana Vista Indah 2 Blok A No.48</p>
                    <br />
                    <div class="d-grid gap-2">
                      <button
                        class="btn-hitam"
                        data-bs-toggle="modal"
                        data-bs-target="#modal-pilih"
                      >
                        PILIH
                      </button>
                    </div>
                  </div>

                  <!-- Kanan: Visi Misi -->
                  <div class="col-lg-9 col-12 mt-4 ms-auto bg-putih">
                    <h4 class="poppins-bold">Visi</h4>
                    <p class="card-text mb-4">
                      Mewujudkan lingkungan RT yang aman, bersih, dan saling
                      mendukung antar warga.
                    </p>
                    <h4 class="poppins-bold">Misi</h4>
                    <ul>
                      <li>
                        Meningkatkan keamanan lingkungan melalui ronda malam
                        terjadwal.
                      </li>
                      <li>
                        Mengadakan kegiatan sosial setiap bulan untuk mempererat
                        hubungan warga.
                      </li>
                      <li>
                        Menjaga kebersihan dengan program gotong royong rutin.
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Pilih Kandidat -->
      <div
        class="modal fade"
        id="modal-pilih"
        tabindex="-1"
        aria-labelledby="pilih"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content bg-putih rounded-4">
            <div class="modal-body">
              <div class="text-end">
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                ></button>
              </div>
              <div class="container-fluid">
                <div class="row">
                  <div class="col-lg-3 col-12 mb-3">
                    <img
                      src="../assets/img/Avatar Vektor Pengguna, Clipart Manusia, Pengguna Perempuan, Ikon PNG dan Vektor dengan Background Transparan untuk Unduh Gratis 6.png"
                      class="rounded-4 d-block mx-auto mb-2 img-fit"
                      alt="Kandidat Dipilih"
                    />
                    <h5 class="text-center"><strong>01 </strong> Momo Hirai</h5>
                  </div>
                  <div
                    class="col-12 col-lg-12 ms-auto d-flex justify-content-center align-items-center"
                  >
                    <h5 class="text-center mt-0 mb-3">
                      Suara yang sudah diberikan <b>tidak dapat diubah</b>.
                      Apakah Anda tetap ingin memilih?
                    </h5>
                  </div>
                  <div class="col-12">
                    <div class="d-grid">
                      <input
                        type="text"
                        placeholder="Masukkan Token Anda"
                        class="form-control-hitam text-kecil btn-hitam mb-2 text-uppercase"
                      />
                      <button
                        type="button"
                        class="btn-hitam border-0"
                        data-bs-toggle="modal"
                        data-bs-target="#modal-ambil-token"
                      >
                        YA
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Ambil Token -->
      <div
        class="modal fade"
        id="modal-ambil-token"
        tabindex="-1"
        aria-labelledby="ambil-token"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content bg-putih rounded-4">
            <div class="modal-body">
              <div class="text-end">
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                ></button>
              </div>
              <div class="container-fluid">
                <div class="row">
                  <h5 class="text-center mt-0 mb-3">
                    Ini adalah token Anda. <b>Harap simpan dengan baik</b> dan
                    jangan dibagikan kepada orang lain!
                  </h5>
                  <div class="d-grid">
                    <button
                      type="button"
                      id="copyTokenBtn"
                      class="btn-hitam border-0"
                    >
                      <i class="fa-solid fa-copy"></i>
                      <span id="tokenValue">15042007</span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Keluar -->
      <div
        class="modal fade"
        id="modal-keluar"
        tabindex="-1"
        aria-labelledby="keluar"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered modal-sm">
          <div class="modal-content bg-putih">
            <div class="modal-body">
              <div class="text-end">
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                ></button>
              </div>
              <div class="container-fluid">
                <div class="row">
                  <h5 class="text-center mt-0 mb-3">
                    Apakah Anda ingin keluar dari website <b>Suara Warga</b>?
                  </h5>
                  <div class="d-grid">
                    <button
                      type="button"
                      onclick="window.location.href='../logout.php'"
                      class="btn-hitam border-0"
                    >
                      YA
                    </button>
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
    <script>
      // Fungsi salin token
      document
        .getElementById("copyTokenBtn")
        .addEventListener("click", function () {
          const token = document.getElementById("tokenValue").innerText;
          navigator.clipboard
            .writeText(token)
            .then(() => {
              // Umpan balik cepat ke user
              const btn = document.getElementById("copyTokenBtn");
              const original = btn.innerHTML;
              btn.innerHTML = '<i class="fa-solid fa-check"></i> Disalin!';
              btn.disabled = true;
              setTimeout(() => {
                btn.innerHTML = original;
                btn.disabled = false;
              }, 1500);
            })
            .catch((err) => console.error("Gagal menyalin token:", err));
        });
    </script>
  </body>
</html>
