<?php
require "../koneksi.php";

if(isset($_POST['update'])) {
    $nik_lama = $_POST['nik_lama'];
    $nama = $_POST['nama'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $agama = $_POST['agama'];
    $alamat = $_POST['alamat'];
    $pendidikan = $_POST['pendidikan'];
    $pekerjaan = $_POST['pekerjaan'];
    $role = $_POST['role'];
    
    try {
        $stmt = $pdo->prepare("UPDATE pengguna SET 
            nama = ?, 
            tempat_lahir = ?, 
            tanggal_lahir = ?, 
            jenis_kelamin = ?, 
            agama = ?, 
            alamat = ?, 
            pendidikan = ?, 
            pekerjaan = ?, 
            role = ? 
            WHERE nik = ?");
        
        $stmt->execute([
            $nama, 
            $tempat_lahir, 
            $tanggal_lahir, 
            $jenis_kelamin, 
            $agama, 
            $alamat, 
            $pendidikan, 
            $pekerjaan, 
            $role,
            $nik_lama
        ]);
        
        header("Location: pengguna.php?success=update");
        exit();
    } catch(PDOException $e) {
        header("Location: pengguna.php?error=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    header("Location: pengguna.php");
    exit();
}
?>