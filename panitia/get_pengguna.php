<?php
require_once "../koneksi.php";

header('Content-Type: application/json');

if (isset($_GET['nik'])) {
    $nik = $_GET['nik'];
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM pengguna WHERE nik = ?");
        $stmt->execute([$nik]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($data) {
            echo json_encode([
                'success' => true,
                'data' => $data
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    } catch(PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'NIK tidak ditemukan'
    ]);
}
?>