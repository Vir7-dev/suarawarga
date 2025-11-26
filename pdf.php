<?php
require_once __DIR__ . '/dompdf/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();

// contoh HTML
$html = '
<h2>Laporan Voting Warga</h2>
<p>Contoh export PDF tanpa composer</p>
';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// tampilkan PDF di browser (tidak otomatis download)
$dompdf->stream("laporan.pdf", ["Attachment" => false]);
