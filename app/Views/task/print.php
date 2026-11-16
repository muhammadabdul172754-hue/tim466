<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print Daftar Tugas</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .done { text-decoration: line-through; color: #888; }
    </style>
</head>
<body onload="window.print()">
    <h2>Laporan Daftar Tugas PKL</h2>
    <p>Dicetak pada: <?= date('d F Y, H:i') ?></p>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="30%">Tugas</th>
                <th width="15%">Kategori</th>
                <th width="20%">Deadline</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach($tasks as $t): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td>
                    <strong class="<?= $t['status'] == 'done' ? 'done' : '' ?>"><?= $t['judul'] ?></strong><br>
                    <small><?= $t['deskripsi'] ?></small>
                </td>
                <td><?= $t['kategori'] ?></td>
                <td><?= date('d/m/Y H:i', strtotime($t['deadline'])) ?></td>
                <td><?= $t['status'] == 'done' ? 'Selesai' : 'Belum' ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>   