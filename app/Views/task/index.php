<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div style="max-width: 1100px; margin: 30px auto; padding: 0 20px;" data-aos="fade-up">
    
    <!-- HEADER -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px;">
        <div>
            <h2 style="margin: 0; color: #0f172a; font-weight: 800; font-size: 24px;">Daftar Tugas</h2>
            <p style="margin: 5px 0 0 0; color: #64748b; font-size: 14px;">Kelola tugas harian dan pantau progres pekerjaan PKL.</p>
        </div>
        
        <div style="display: flex; gap: 10px;">
            <a href="<?= base_url('task/print') ?>" target="_blank" style="background: #10b981; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 14px; display: flex; align-items: center; gap: 8px; transition: 0.2s;" onmouseover="this.style.background='#059669'" onmouseout="this.style.background='#10b981'">
                <i class="bi bi-printer"></i> Print
            </a>
            <a href="<?= base_url('task/create') ?>" style="background: #3b82f6; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 14px; display: flex; align-items: center; gap: 8px; transition: 0.2s;" onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">
                <i class="bi bi-plus-lg"></i> Tambah Tugas
            </a>
        </div>
    </div>

    <!-- NOTIFIKASI SUKSES -->
    <?php if(session()->getFlashdata('success')): ?>
        <div style="background: #dcfce7; color: #15803d; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; font-weight: bold; border: 1px solid #bbf7d0;">
            <i class="bi bi-check-circle-fill"></i> <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <!-- TABEL MODERN -->
    <div style="background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #e2e8f0;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
                <thead>
                    <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                        <th style="padding: 15px 20px; color: #475569; font-weight: 600; width: 80px; text-align: center;">Selesai</th>
                        <th style="padding: 15px 20px; color: #475569; font-weight: 600;">Tugas</th>
                        <th style="padding: 15px 20px; color: #475569; font-weight: 600;">Kategori</th>
                        <th style="padding: 15px 20px; color: #475569; font-weight: 600;">Dibuat Oleh</th>
                        <th style="padding: 15px 20px; color: #475569; font-weight: 600;">Deadline</th>
                        <th style="padding: 15px 20px; color: #475569; font-weight: 600; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($tasks)): ?>
                        <tr><td colspan="6" style="padding: 40px; text-align: center; color: #94a3b8;"><i class="bi bi-inbox" style="font-size: 30px; display: block; margin-bottom: 10px;"></i> Belum ada tugas.</td></tr>
                    <?php else: ?>
                        <?php foreach($tasks as $t): 
                            $isDone = $t['status'] == 'done';
                            // Warna Badge Kategori
                            $bgKat = '#f1f5f9'; $txtKat = '#475569';
                            if(strtolower($t['kategori'] ?? '') == 'coding') { $bgKat = '#dbeafe'; $txtKat = '#1d4ed8'; }
                            if(strtolower($t['kategori'] ?? '') == 'desain') { $bgKat = '#fce7f3'; $txtKat = '#be185d'; }
                            if(strtolower($t['kategori'] ?? '') == 'laporan') { $bgKat = '#fef3c7'; $txtKat = '#b45309'; }
                        ?>
                        <tr style="border-bottom: 1px solid #f1f5f9; transition: 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                            
                            <!-- Tombol Ceklis -->
                            <td style="padding: 15px 20px; text-align: center;">
                                <a href="<?= base_url('task/toggle/'.$t['id']) ?>" style="text-decoration: none; font-size: 22px; display: inline-block; transition: 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                                    <?= $isDone ? '<i class="bi bi-check-square-fill" style="color: #10b981;"></i>' : '<i class="bi bi-square" style="color: #cbd5e1;"></i>' ?>
                                </a>
                            </td>

                            <!-- Judul & Deskripsi -->
                            <td style="padding: 15px 20px;">
                                <div style="font-weight: bold; color: #0f172a; font-size: 15px; <?= $isDone ? 'text-decoration: line-through; color: #94a3b8;' : '' ?>">
                                    <?= esc($t['judul']) ?>
                                </div>
                                <div style="font-size: 12px; color: #64748b; margin-top: 3px;">
                                    <?= esc($t['deskripsi'] ?: '-') ?>
                                </div>
                            </td>

                            <!-- Kategori -->
                            <td style="padding: 15px 20px;">
                                <span style="background: <?= $bgKat ?>; color: <?= $txtKat ?>; padding: 5px 10px; border-radius: 6px; font-size: 12px; font-weight: bold;">
                                    <?= esc($t['kategori'] ?? 'Umum') ?>
                                </span>
                            </td>

                            <!-- Dibuat Oleh -->
                            <td style="padding: 15px 20px; font-size: 13px; font-weight: 600; color: #3b82f6;">
                                <?= isset($t['pembuat']) ? esc($t['pembuat']) : 'Anonim' ?>
                            </td>

                            <!-- Deadline -->
                            <td style="padding: 15px 20px; font-size: 13px; color: #475569;">
                                <i class="bi bi-calendar-event" style="color: #94a3b8;"></i> 
                                <?= $t['deadline'] ? date('d M Y, H:i', strtotime($t['deadline'])) : '-' ?>
                            </td>

                            <!-- Aksi -->
                            <td style="padding: 15px 20px; text-align: center; white-space: nowrap;">
                                <a href="<?= base_url('task/detail/'.$t['id']) ?>" style="color: #3b82f6; text-decoration: none; font-weight: bold; font-size: 13px; margin-right: 10px;">Detail</a>
                                <a href="<?= base_url('task/edit/'.$t['id']) ?>" style="color: #f59e0b; text-decoration: none; font-weight: bold; font-size: 13px; margin-right: 10px;">Edit</a>
                                <a href="<?= base_url('task/delete/'.$t['id']) ?>" onclick="return confirm('Yakin ingin menghapus tugas ini?')" style="color: #ef4444; text-decoration: none; font-weight: bold; font-size: 13px;">Hapus</a>
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