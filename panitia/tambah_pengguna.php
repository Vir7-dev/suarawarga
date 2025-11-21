<?php
include "../koneksi.php";

if(isset($_POST['tambah'])) {
    $nik = $_POST['nik'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $agama = $_POST['agama'];
    $alamat = $_POST['alamat'];
    $pendidikan = $_POST['pendidikan'];
    $pekerjaan = $_POST['pekerjaan'];
    $role = $_POST['role'];
    $status_ambil = 'Belum Mengambil'; // default
    
    try {
        $stmt = $pdo->prepare("INSERT INTO pengguna (nik, nama_lengkap, tempat_lahir, tanggal_lahir, jenis_kelamin, agama, alamat, pendidikan, pekerjaan, role, status_ambil) VALUES ('$nik', '$nama_lengkap', '$tempat_lahir', '$tanggal_lahir', '$agama', '$alamat', '$pendidikan', '$pekerjaan', '$role', '$status_ambil')");
        
        $stmt->execute([$nik, $nama_lengkap, $tempat_lahir, $tanggal_lahir, $jenis_kelamin, $agama, $alamat, $pendidikan, $pekerjaan, $role, $status_ambil]);
        
        header("Location: index.php?success=tambah");
        exit();
    } catch(PDOException $e) {
        header("Location: index.php?error=" . urlencode($e->getMessage()));
        exit();
    }
}
?>
