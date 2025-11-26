<?php
session_start();
require '../koneksi.php';

$id_kandidat = $_POST['pengguna_id'];
$visi = $_POST['visi'];
$misi = $_POST['misi'];

try {
    $stmt = $pdo->prepare("
        UPDATE kandidat 
        SET visi = :visi, 
            misi = :misi
        WHERE id_kandidat = :id
    ");

    $stmt->execute([
        ':visi' => $visi,
        ':misi' => $misi,
        ':id'   => $id_kandidat
    ]);

    header("Location: profil.php");
    exit;

} catch(PDOException $e) {
    echo "Gagal update: " . $e->getMessage();
}
?>
