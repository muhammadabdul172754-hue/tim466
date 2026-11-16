<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div style="max-width: 600px; margin: 40px auto; padding: 30px; background: white; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);" data-aos="fade-up">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 1px solid #e2e8f0; padding-bottom: 15px;">
        <h2 style="margin: 0; color: #0f172a;">Detail Tugas</h2>
        <div style="display: flex; gap: 10px;">
            <a href="<?= base_url('task') ?>" style="padding: 8px 15px; background: #e2e8f0; border-radius: 5px; text-decoration: none; color: #333; font-weight: bold; font-size: 14px;">Kembali</a>
            <a href="<?= base_url('task/edit/'.$task['id']) ?>" style="padding: 8px 15px; background: #3b82f6; border-radius: 5px; text-decoration: none; color: white; font-weight: bold; font-size: 14px;">Edit Tugas</a>
        </div>
    </div>

    <table style="width: 100%; border-collapse: collapse; font-size: 15px;">
        <tr>
            <td style="padding: 12px 0; width: 150px; color: #64748b; font-weight: 600;">Nama Tugas</td>
            <td style="padding: 12px 0; color: #1e293b; font-weight: bold;">: <?= esc($task['judul']) ?></td>
        </tr>
        <tr>
            <td style="padding: 12px 0; color: #64748b; font-weight: 600;">Kategori</td>
            <td style="padding: 12px 0; color: #1e293b;">
                : <span style="background: #eff5ff; color: #2563eb; padding: 3px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;"><?= esc($task['kategori']) ?></span>
            </td>
        </tr>
        <tr>
            <td style="padding: 12px 0; color: #64748b; font-weight: 600;">Deadline</td>
            <td style="padding: 12px 0; color: #ef4444; font-weight: bold;">: <?= date('d F Y, H:i', strtotime($task['deadline'])) ?> WIB</td>
        </tr>
        <tr>
            <td style="padding: 12px 0; color: #64748b; font-weight: 600;">Status</td>
            <td style="padding: 12px 0; color: #1e293b;">
                : <?= $task['status'] == 'done' ? '✅ Selesai' : '⏳ Belum Selesai' ?>
            </td>
        </tr>
        <tr>
            <td style="padding: 12px 0; color: #64748b; font-weight: 600; vertical-align: top;">Deskripsi</td>
            <td style="padding: 12px 0; color: #1e293b; line-height: 1.6;">
                : <?= nl2br(esc($task['deskripsi'])) ?>
            </td>
        </tr>
    </table>
</div>
<?= $this->endSection() ?>