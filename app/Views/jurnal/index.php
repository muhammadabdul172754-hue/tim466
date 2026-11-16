<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div style="max-width: 1100px; margin: 30px auto; padding: 0 20px;" data-aos="fade-up">
    
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 30px;">
        <div>
            <h2 style="margin: 0; color: #0f172a; font-weight: 800; font-size: 28px;">Jurnal Aktivitas</h2>
            <p style="color: #64748b; margin-top: 5px; font-size: 14px;">Dokumentasikan pekerjaan PKL kamu dan dapatkan umpan balik dari Admin.</p>
        </div>
        <?php if($role != 'admin') : ?>
            <a href="<?= base_url('jurnal/create') ?>" style="background: #0d9488; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold;">
                <i class="bi bi-plus-lg"></i> Tulis Jurnal
            </a>
        <?php endif; ?>
    </div>

    <!-- Filter Bar -->
    <form action="<?= base_url('jurnal') ?>" method="GET" style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 15px; display: flex; gap: 10px; margin-bottom: 30px;">
        <input type="text" name="search" placeholder="Cari judul..." value="<?= esc($search) ?>" style="padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; flex: 1;">
        <select name="status" style="padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px;">
            <option value="">Semua Status</option>
            <option value="Menunggu Review" <?= $status == 'Menunggu Review' ? 'selected' : '' ?>>Menunggu Review</option>
            <option value="Disetujui" <?= $status == 'Disetujui' ? 'selected' : '' ?>>Disetujui</option>
            <option value="Perlu Revisi" <?= $status == 'Perlu Revisi' ? 'selected' : '' ?>>Perlu Revisi</option>
        </select>
        <button type="submit" style="background: #0f172a; color: white; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-weight: bold;">Filter</button>
    </form>

    <!-- Grid Jurnal -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px;">
        <?php if(empty($jurnal)): ?>
            <div style="grid-column: 1/-1; text-align: center; padding: 50px; background: white; border-radius: 12px; border: 1px dashed #cbd5e1;">
                <h3 style="color: #64748b; margin: 0;">Belum ada data jurnal.</h3>
            </div>
        <?php else: ?>
            <?php foreach($jurnal as $j): 
                // Warna Badge
                $bg = '#fef3c7'; $txt = '#b45309'; 
                if($j['status'] == 'Disetujui') { $bg = '#dcfce7'; $txt = '#15803d'; }
                if($j['status'] == 'Perlu Revisi') { $bg = '#fee2e2'; $txt = '#b91c1c'; }
            ?>
            <div style="background: white; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; display: flex; flex-direction: column;">
                <?php if($j['foto']): ?>
                    <img src="<?= base_url('uploads/jurnal/'.$j['foto']) ?>" style="width: 100%; height: 180px; object-fit: cover;">
                <?php endif; ?>
                
                <div style="padding: 20px; flex: 1;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <span style="font-size: 12px; color: #64748b;"><i class="bi bi-calendar"></i> <?= date('d M Y', strtotime($j['tanggal'])) ?></span>
                        <span style="background: <?= $bg ?>; color: <?= $txt ?>; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: bold;"><?= $j['status'] ?></span>
                    </div>
                    
                    <!-- Jika Admin, tampilkan siapa pembuatnya -->
                    <?php if($role == 'admin' || $role == 'petugas'): ?>
                        <div style="font-size: 12px; color: #3b82f6; font-weight: bold; margin-bottom: 5px;">
                            <i class="bi bi-person-circle"></i> <?= esc($j['nama_anggota']) ?>
                        </div>
                    <?php endif; ?>

                    <h3 style="margin: 0 0 10px 0; font-size: 16px; color: #0f172a; font-weight: 800;"><?= esc($j['judul_kegiatan']) ?></h3>
                    <p style="margin: 0; font-size: 13px; color: #64748b; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><?= esc($j['deskripsi']) ?></p>
                </div>

                <div style="padding: 15px 20px; border-top: 1px solid #e2e8f0; background: #f8fafc; display: flex; justify-content: space-between; align-items: center;">
                    <a href="<?= base_url('jurnal/detail/'.$j['id']) ?>" style="color: #0ea5e9; text-decoration: none; font-weight: bold; font-size: 13px;">Lihat Detail</a>
                    
                    <!-- Tombol Verifikasi HANYA untuk Admin -->
                    <?php if($role == 'admin'): ?>
                        <button onclick="bukaModalVerifikasi(<?= $j['id'] ?>, '<?= $j['status'] ?>', `<?= str_replace(array("\r", "\n"), ' ', $j['catatan_admin']) ?>`)" style="background: #3b82f6; color: white; border: none; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: bold; cursor: pointer;">
                            <i class="bi bi-check2-square"></i> Verifikasi
                        </button>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- MODAL VERIFIKASI (Hanya muncul untuk Admin) -->
<?php if($role == 'admin'): ?>
<div id="modalVerifikasi" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; z-index: 1000;">
    <div style="background: white; padding: 30px; border-radius: 10px; width: 400px; max-width: 90%;">
        <h3 style="margin-top: 0; color: #0f172a;">Verifikasi Jurnal</h3>
        <form id="formVerifikasi" method="POST">
            <?= csrf_field() ?>
            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold; font-size: 14px; display: block; margin-bottom: 5px;">Ubah Status</label>
                <select name="status" id="inputStatus" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                    <option value="Menunggu Review">Menunggu Review</option>
                    <option value="Disetujui">Disetujui</option>
                    <option value="Perlu Revisi">Perlu Revisi</option>
                </select>
            </div>
            <div style="margin-bottom: 20px;">
                <label style="font-weight: bold; font-size: 14px; display: block; margin-bottom: 5px;">Catatan untuk Siswa (Opsional)</label>
                <textarea name="catatan_admin" id="inputCatatan" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;" placeholder="Berikan saran atau koreksi..."></textarea>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="document.getElementById('modalVerifikasi').style.display='none'" style="padding: 10px 15px; background: #e2e8f0; border: none; border-radius: 5px; font-weight: bold; cursor: pointer;">Batal</button>
                <button type="submit" style="padding: 10px 20px; background: #10b981; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer;">Simpan Verifikasi</button>
            </div>
        </form>
    </div>
</div>

<script>
    function bukaModalVerifikasi(id, status, catatan) {
        document.getElementById('modalVerifikasi').style.display = 'flex';
        document.getElementById('formVerifikasi').action = '<?= base_url('jurnal/verifikasi/') ?>' + id;
        document.getElementById('inputStatus').value = status;
        document.getElementById('inputCatatan').value = catatan;
    }
</script>
<?php endif; ?>

<?= $this->endSection() ?>