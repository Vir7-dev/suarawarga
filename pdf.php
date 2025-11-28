<?php
require_once __DIR__ . '/dompdf/dompdf/autoload.inc.php';
require_once __DIR__ . '/koneksi.php';

use Dompdf\Dompdf;

$sql = "SELECT k.id_kandidat, p.nama, k.no_kandidat, k.foto_profil,
        COUNT(s.id_suara) AS total_suara
        FROM kandidat k
        LEFT JOIN pengguna p ON p.id = k.pengguna_id
        LEFT JOIN suara s ON s.kandidat_id = k.id_kandidat
        GROUP BY k.id_kandidat
        ORDER BY total_suara DESC";


$stmt = $pdo->prepare($sql);
$stmt->execute();
$kandidat = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalKeseluruhan = 0;
foreach ($kandidat as $row) {
    $totalKeseluruhan += $row['total_suara'];
}

// Load template
ob_start();
include __DIR__ . "/template_pdf.php";
$html = ob_get_clean();

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->set_option('isRemoteEnabled', true);
$dompdf->render();
$dompdf->stream("hasil-pemilihan.pdf", ["Attachment" => false]);
