<?php
include "../koneksi.php";

if(isset($_GET['nik'])) {
    $nik = $_GET['nik'];
    
    try {
        $stmt = $pdo->prepare("DELETE FROM pengguna WHERE nik = ?");
        $stmt->execute([$nik]);
        
        header("Location: pengguna.php?success=hapus");
        exit();
    } catch(PDOException $e) {
        header("Location: pengguna.php?error=" . urlencode($e->getMessage()));
        exit();
    }
}
?>