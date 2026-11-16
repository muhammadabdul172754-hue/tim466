<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div style="max-width: 1100px; margin: 30px auto; padding: 0 20px;" data-aos="fade-up">
    <h2 style="margin: 0 0 20px 0; color: #0f172a; font-weight: 800;">Verifikasi Jurnal Siswa</h2>
    
    <div style="background: white; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <th style="padding: 15px;">Siswa</th>
                    <th style="padding: 15px;">Kegiatan</th>
                    <th style="padding: 15px;">Tanggal</th>
                    <th style="padding: 15px;">Status</th>
                    <th style="padding: 15px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($jurnal as $j): ?>
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 15px; font-weight: bold; color: #0f172a;"><?= esc($j['nama_anggota']) ?></td>
                    <td style="padding: 15px; color: #334155;"><?= esc($j['judul_kegiatan']) ?></td>
                    <td style="padding: 15px; color: #64748b;"><?= date('d M Y', strtotime($j['tanggal'])) ?></td>
                    <td style="padding: 15px;">
                        <span style="background: #f1f5f9; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: bold;"><?= $j['status'] ?></span>
                    </td>
                    <td style="padding: 15px; text-align: center;">
                        <a href="<?= base_url('jurnal/detail/'.$j['id']) ?>" style="color: #3b82f6; text-decoration: none; font-weight: bold;">Lihat Detail</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>