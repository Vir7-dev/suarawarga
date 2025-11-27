<?php
require "../koneksi.php";

if(isset($_POST['tambah'])) {
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $agama = $_POST['agama'];
    $alamat = $_POST['alamat'];
    $pendidikan = $_POST['pendidikan'];
    $pekerjaan = $_POST['pekerjaan'];
    $status_ambil = 'belum'; 
    $role = isset($_POST['role']) ? $_POST['role'] : 'user'; // default role
    
    try {
        $stmt = $pdo->prepare("INSERT INTO pengguna (nik, nama, tempat_lahir, tanggal_lahir, jenis_kelamin, agama, alamat, pendidikan, pekerjaan, role, status_ambil) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->execute([$nik, $nama, $tempat_lahir, $tanggal_lahir, $jenis_kelamin, $agama, $alamat, $pendidikan, $pekerjaan, $role, $status_ambil]);
        
        header("Location: pengguna.php?success=tambah");
        exit();
    } catch(PDOException $e) {
        header("Location: pengguna.php?error=" . urlencode($e->getMessage()));
        exit();
    }
}
?>