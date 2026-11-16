<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div style="max-width: 1100px; margin: 30px auto; padding: 0 20px;" data-aos="fade-up">
    
    <!-- Header & Filter -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px;">
        <div>
            <h2 style="margin: 0; color: #0f172a; font-weight: 800; font-size: 24px;">Rekap Presensi Anggota</h2>
            <p style="margin: 5px 0 0 0; color: #64748b; font-size: 14px;">Lihat dan cetak laporan kehadiran anggota PKL.</p>
        </div>
        
        <!-- Toolbar Filter & Print -->
        <form action="<?= base_url('presensi/rekap') ?>" method="GET" style="display: flex; gap: 10px; align-items: center; background: white; padding: 10px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
            <select name="bulan" style="padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; outline: none; font-size: 14px; color: #334155;">
                <?php for($i=1; $i<=12; $i++): $m = str_pad($i, 2, '0', STR_PAD_LEFT); ?>
                    <option value="<?= $m ?>" <?= $bulan == $m ? 'selected' : '' ?>><?= date('F', mktime(0, 0, 0, $i, 1)) ?></option>
                <?php endfor; ?>
            </select>
            <select name="tahun" style="padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; outline: none; font-size: 14px; color: #334155;">
                <?php for($i=date('Y'); $i>=date('Y')-2; $i--): ?>
                    <option value="<?= $i ?>" <?= $tahun == $i ? 'selected' : '' ?>><?= $i ?></option>
                <?php endfor; ?>
            </select>
            <button type="submit" style="background: #0f172a; color: white; padding: 8px 16px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 14px; transition: 0.2s;">Tampilkan</button>
            
            <a href="<?= base_url('presensi/print?bulan='.$bulan.'&tahun='.$tahun) ?>" target="_blank" style="background: #10b981; color: white; padding: 8px 16px; border-radius: 6px; font-weight: bold; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; font-size: 14px; transition: 0.2s;">
                <i class="bi bi-printer"></i> Print
            </a>
        </form>
    </div>

    <!-- Tabel Data Presensi -->
    <div style="background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #e2e8f0;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
                <thead>
                    <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                        <th style="padding: 15px 20px; color: #475569; font-weight: 600; white-space: nowrap;">Nama Anggota</th>
                        <th style="padding: 15px 20px; color: #475569; font-weight: 600; white-space: nowrap;">Tanggal</th>
                        <th style="padding: 15px 20px; color: #475569; font-weight: 600; white-space: nowrap;">Jam Masuk</th>
                        <th style="padding: 15px 20px; color: #475569; font-weight: 600; white-space: nowrap;">Jam Pulang</th>
                        <th style="padding: 15px 20px; color: #475569; font-weight: 600; white-space: nowrap;">Status</th>
                        <th style="padding: 15px 20px; color: #475569; font-weight: 600; white-space: nowrap;">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($presensi)): ?>
                        <tr>
                            <td colspan="6" style="padding: 40px; text-align: center; color: #94a3b8;">
                                <i class="bi bi-inbox" style="font-size: 30px; display: block; margin-bottom: 10px;"></i>
                                Belum ada data presensi di bulan ini.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($presensi as $p): 
                            // Logika Warna Badge Status
                            $bgStatus = '#f1f5f9'; $txtStatus = '#475569';
                            if($p['status'] == 'Hadir' || $p['status'] == 'Tepat Waktu') { $bgStatus = '#dcfce7'; $txtStatus = '#15803d'; }
                            if($p['status'] == 'Terlambat') { $bgStatus = '#fef3c7'; $txtStatus = '#b45309'; }
                            if($p['status'] == 'Izin' || $p['status'] == 'Sakit') { $bgStatus = '#e0f2fe'; $txtStatus = '#0284c7'; }
                        ?>
                        <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                            <!-- Nama & Role -->
                            <td style="padding: 15px 20px;">
                                <div style="font-weight: 600; color: #0f172a;"><?= esc($p['nama']) ?></div>
                                <div style="font-size: 11px; color: #3b82f6; font-weight: 600; text-transform: capitalize; margin-top: 2px;"><?= esc($p['role'] ?? 'User') ?></div>
                            </td>
                            <!-- Tanggal -->
                            <td style="padding: 15px 20px; color: #475569;">
                                <?= $p['tanggal'] ? date('d M Y', strtotime($p['tanggal'])) : '-' ?>
                            </td>
                            <!-- Jam Masuk & Pulang -->
                            <td style="padding: 15px 20px; color: #10b981; font-weight: 700; font-family: monospace; font-size: 14px;"><?= $p['jam_masuk'] ?? '-' ?></td>
                            <td style="padding: 15px 20px; color: #ef4444; font-weight: 700; font-family: monospace; font-size: 14px;"><?= $p['jam_pulang'] ?? '-' ?></td>
                            <!-- Status -->
                            <td style="padding: 15px 20px;">
                                <span style="background: <?= $bgStatus ?>; color: <?= $txtStatus ?>; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; display: inline-block;">
                                    <?= $p['status'] ?? 'Alpa' ?>
                                </span>
                            </td>
                            <!-- Keterangan -->
                            <td style="padding: 15px 20px; color: #64748b;">
                                <?= $p['alasan'] ? esc($p['alasan']) : '-' ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>