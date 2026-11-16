<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div style="max-width: 900px; margin: 40px auto; padding: 0 20px;" data-aos="fade-up">
    <a href="<?= base_url('jurnal') ?>" style="display: inline-flex; align-items: center; gap: 8px; background: #e2e8f0; color: #334155; padding: 8px 15px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 14px; margin-bottom: 20px;"><i class="bi bi-arrow-left"></i> Kembali</a>

    <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
        <div style="padding: 30px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <span style="background: #f1f5f9; color: #475569; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: bold;"><i class="bi bi-calendar-event"></i> <?= date('d F Y', strtotime($jurnal['tanggal'])) ?></span>
                <h2 style="margin: 15px 0 0 0; color: #0f172a; font-weight: 800; font-size: 24px;"><?= esc($jurnal['judul_kegiatan']) ?></h2>
                <div style="margin-top: 10px; color: #64748b; font-size: 14px;"><i class="bi bi-clock"></i> <?= esc($jurnal['waktu_mulai']) ?> - <?= esc($jurnal['waktu_selesai']) ?> WIB</div>
            </div>
            <?php $bgStatus = '#fef3c7'; $txtStatus = '#b45309'; if($jurnal['status'] == 'Disetujui') { $bgStatus = '#dcfce7'; $txtStatus = '#15803d'; } if($jurnal['status'] == 'Perlu Revisi') { $bgStatus = '#fee2e2'; $txtStatus = '#b91c1c'; } ?>
            <span style="background: <?= $bgStatus ?>; color: <?= $txtStatus ?>; padding: 6px 15px; border-radius: 20px; font-size: 13px; font-weight: bold;"><?= $jurnal['status'] ?></span>
        </div>

        <div style="padding: 30px; display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
            <div><?php if($jurnal['foto']): ?><img src="<?= base_url('uploads/jurnal/'.$jurnal['foto']) ?>" style="width: 100%; border-radius: 10px; border: 1px solid #e2e8f0; object-fit: cover; max-height: 400px;"><?php endif; ?></div>
            <div>
                <h4 style="color: #0f172a; font-size: 16px; margin-bottom: 10px; font-weight: bold;">Deskripsi</h4>
                <div style="background: #f8fafc; padding: 15px; border-radius: 8px; color: #334155; font-size: 14px; border-left: 4px solid #3b82f6; margin-bottom: 20px;"><?= nl2br(esc($jurnal['deskripsi'])) ?></div>
                <?php if($jurnal['catatan_admin']): ?>
                    <h4 style="color: #0f172a; font-size: 16px; margin-bottom: 10px; font-weight: bold;">Catatan Admin</h4>
                    <div style="background: #fffbeb; padding: 15px; border-radius: 8px; color: #b45309; font-size: 14px; border-left: 4px solid #f59e0b;"><i class="bi bi-chat-left-text"></i> <?= nl2br(esc($jurnal['catatan_admin'])) ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>