<?php
foreach ($kandidat as &$row) {
    $path = "/assets/img" . $row['foto_profil']; // lokasi foto asli
    if (file_exists($path)) {
        $imgData = base64_encode(file_get_contents($path));
        $row['foto_base64'] = "data:image/png;base64," . $imgData;
    } else {
        $row['foto_base64'] = ""; // jika foto tidak ada
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        * {
            font-family: Poppins, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        td {
            padding: 10px;
            vertical-align: top;
        }

        .card {
            width: 200px;
            border: 2px solid #000;
            border-radius: 12px;
            padding: 15px;
            text-align: center;
        }

        img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 10px;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="header-title">HASIL SEMENTARA PEMILIHAN RT</div>
        <div class="subtitle">Data perhitungan suara real-time berdasarkan sistem e-Voting</div>
    </div>

    <table border="0" cellspacing="15" cellpadding="10" style="margin:auto;">
        <tr>
            <?php
            $rank = 1;
            $count = 0;
            foreach ($kandidat as $row):
                $persen = $totalKeseluruhan > 0 ? number_format(($row['total_suara'] / $totalKeseluruhan) * 100, 2) : 0;

                if ($count > 0 && $count % 2 == 0) {
                    echo "</tr><tr>";
                }
            ?>
                <td>
                    <div class="card">
                        <div class="rank">#<?= $rank ?></div>

                        <?php if ($row['foto_base64'] !== ""): ?>
                            <img src="<?= $row['foto_base64']; ?>">
                        <?php else: ?>
                            <div style="width:120px;height:120px;border:1px dashed #000;display:flex;align-items:center;justify-content:center;">
                                No Image
                            </div>
                        <?php endif; ?>

                        <div class="nama" style="font-weight:bold; margin-top:8px;">
                            <?= htmlspecialchars($row['nama']); ?>
                        </div>
                        <div class="suara"><?= $row['total_suara']; ?> Suara</div>
                        <div class="percent"><?= $persen ?>%</div>
                    </div>
                </td>
            <?php
                $rank++;
                $count++;
            endforeach;
            ?>
        </tr>
    </table>

    <div class="footer" style="text-align:center; margin-top:10px;">
        Dicetak pada: <?= date("d-m-Y H:i:s") ?><br>
        Sistem e-Voting SuaraWarga
    </div>

</body>

</html>