<?php
include "../koneksi.php";

if(isset($_POST['tambah'])) {
    $nik = mysqli_real_escape_string($conn, $_POST['nik']);
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $tempat_lahir = mysqli_real_escape_string($conn, $_POST['tempat_lahir']);
    $tanggal_lahir = mysqli_real_escape_string($conn, $_POST['tanggal_lahir']);
    $agama = mysqli_real_escape_string($conn, $_POST['agama']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $pendidikan = mysqli_real_escape_string($conn, $_POST['pendidikan']);
    $pekerjaan = mysqli_real_escape_string($conn, $_POST['pekerjaan']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $status_ambil = 'Belum Mengambil';
    
    $query = "INSERT INTO pengguna (nik, nama_lengkap, tempat_lahir, tanggal_lahir, agama, alamat, pendidikan, pekerjaan, role, status_ambil) 
              VALUES ('$nik', '$nama_lengkap', '$tempat_lahir', '$tanggal_lahir', '$agama', '$alamat', '$pendidikan', '$pekerjaan', '$role', '$status_ambil')";
    
    $input = mysqli_query($conn, $query);
    
    if($input) {
        header("Location: index.php?success=tambah");
        exit();
    } else {
        header("Location: index.php?error=" . urlencode(mysqli_error($conn)));
        exit();
    }
}
?>