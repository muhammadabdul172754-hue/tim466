<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Presensi - <?= date('F Y', mktime(0, 0, 0, $bulan, 1, $tahun)) ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; color: #000; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 15px; }
        .header h2 { margin: 0 0 5px 0; text-transform: uppercase; }
        .header p { margin: 0; font-size: 14px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px 10px; text-align: left; }
        th { background-color: #f2f2f2; text-align: center; }
        
        .footer { margin-top: 40px; display: flex; justify-content: space-between; }
        .ttd { text-align: center; width: 200px; }
        .ttd p { margin-bottom: 60px; }
        
        @media print {
            body { margin: 0; }
            @page { size: landscape; margin: 15mm; } /* Format kertas Landscape */
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h2>Laporan Rekap Presensi PKL</h2>
        <p>Tim466App - RM Alam Sari</p>
        <p><strong>Bulan: <?= date('F Y', mktime(0, 0, 0, $bulan, 1, $tahun)) ?></strong></p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Nama Anggota</th>
                <th width="15%">Tanggal</th>
                <th width="10%">Jam Masuk</th>
                <th width="10%">Jam Pulang</th>
                <th width="15%">Status</th>
                <th width="20%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($presensi)): ?>
                <tr><td colspan="7" style="text-align: center;">Tidak ada data presensi pada bulan ini.</td></tr>
            <?php else: ?>
                <?php $no = 1; foreach($presensi as $p): ?>
                <tr>
                    <td style="text-align: center;"><?= $no++ ?></td>
                    <td><?= esc($p['nama']) ?></td>
                    <td style="text-align: center;"><?= $p['tanggal'] ? date('d/m/Y', strtotime($p['tanggal'])) : '-' ?></td>
                    <td style="text-align: center;"><?= $p['jam_masuk'] ?? '-' ?></td>
                    <td style="text-align: center;"><?= $p['jam_pulang'] ?? '-' ?></td>
                    <td><?= $p['status'] ?? 'Alpa' ?></td>
                    <td><?= $p['alasan'] ?? '-' ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <div class="ttd">
            <p>Mengetahui,<br>Pembimbing PKL</p>
            <hr style="border: 1px solid #000; width: 150px;">
        </div>
        <div class="ttd">
            <p>Sumedang, <?= date('d F Y') ?><br>Admin / Petugas</p>
            <hr style="border: 1px solid #000; width: 150px;">
        </div>
    </div>

</body>
</html>