<?php
include "../koneksi.php";
require "../PhpSpreadsheet-5.3.0/src/PhpSpreadsheet";

use PhpOffice\PhpSpreadsheet\IOFactory;

if (!isset($_FILES['file']['name']) || $_FILES['file']['name'] == '') {
    echo "<script>alert('Error: File belum dipilih!'); window.location.href='index.php';</script>";
    exit;
}

try {
    $file       = $_FILES['file']['tmp_name'];
    $file_name  = $_FILES['file']['name'];
    $ext        = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    $allowed = ['xls', 'xlsx'];
    if (!in_array($ext, $allowed)) {
        echo "<script>alert('Error: Format file tidak valid. Harus .xls atau .xlsx'); window.location.href='index.php';</script>";
        exit;
    }

    $reader = IOFactory::createReader($ext === "xls" ? 'Xls' : 'Xlsx');
    $spreadsheet = $reader->load($file);
    $sheet = $spreadsheet->getActiveSheet();

    $success = 0;
    $failed  = 0;

    $highestRow = $sheet->getHighestRow();
    if ($highestRow < 2) {
        echo "<script>alert('Error: File Excel kosong!'); window.location.href='index.php';</script>";
        exit;
    }

    for ($i = 2; $i <= $highestRow; $i++) {
        $nik            = $sheet->getCell("A$i")->getValue();
        $nama           = $sheet->getCell("B$i")->getValue();
        $tempat_lahir   = $sheet->getCell("C$i")->getValue();
        $tanggal_lahir  = $sheet->getCell("D$i")->getValue();
        $jenis_kelamin  = $sheet->getCell("E$i")->getValue();
        $pendidikan     = $sheet->getCell("F$i")->getValue();
        $pekerjaan      = $sheet->getCell("G$i")->getValue();
        $alamat         = $sheet->getCell("H$i")->getValue();
        $agama          = $sheet->getCell("I$i")->getValue();
        $role           = $sheet->getCell("J$i")->getValue();
        $password_raw   = $sheet->getCell("K$i")->getValue();
        $status_ambil   = $sheet->getCell("L$i")->getValue();

        if ($nik == "" && $nama == "") continue;

        $password = password_hash($password_raw, PASSWORD_DEFAULT);

        $query = mysqli_query($koneksi, "INSERT INTO users 
            (nik, nama, tempat_lahir, tanggal_lahir, jenis_kelamin, pendidikan, pekerjaan, alamat, agama, role, password, status_ambil)
            VALUES ('$nik','$nama','$tempat_lahir','$tanggal_lahir','$jenis_kelamin','$pendidikan','$pekerjaan','$alamat','$agama','$role','$password','$status_ambil')"
        );

        if ($query) $success++; else $failed++;
    }

    echo "<script>alert('Import selesai! Berhasil: $success data, Gagal: $failed data'); window.location.href='index.php';</script>";

} catch (Exception $e) {
    echo "<script>alert('Terjadi kesalahan: ".$e->getMessage()."'); window.location.href='index.php';</script>";
}
?>
