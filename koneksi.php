<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root'); 
define('DB_PASS', ''); 
define('DB_NAME', 'suarawarga');

try {
    // Menggunakan PDO untuk koneksi yang lebih modern dan aman
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    // Atur mode error agar exception dilempar saat ada kesalahan
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Koneksi berhasil!"; // Hapus ini setelah testing!
} catch (PDOException $e) {
    // Jika koneksi gagal, hentikan aplikasi dan tampilkan pesan (catat ke log server, JANGAN tampilkan error sensitif di produksi)
    die("Koneksi Database Gagal: " . $e->getMessage());
}
?>