<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div style="max-width: 600px; margin: 40px auto; padding: 20px; background: white; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);" data-aos="fade-up">
    <h2 style="margin-top: 0; color: #0f172a;">Tambah Tugas Baru</h2>
    <form action="<?= base_url('task/store') ?>" method="post">
        <?= csrf_field() ?>
        <div style="margin-bottom: 15px;">
            <label style="font-weight: bold; font-size: 14px;">Nama Tugas</label>
            <input type="text" name="judul" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="font-weight: bold; font-size: 14px;">Deskripsi</label>
            <textarea name="deskripsi" rows="3" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;"></textarea>
        </div>
        <div style="margin-bottom: 15px;">
            <label style="font-weight: bold; font-size: 14px;">Kategori</label>
            <select name="kategori" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                <option value="Coding">Coding</option>
                <option value="Desain">Desain</option>
                <option value="Laporan">Laporan</option>
                <option value="Meeting">Meeting</option>
                <option value="Umum">Umum</option>
            </select>
        </div>
        <div style="margin-bottom: 20px;">
            <label style="font-weight: bold; font-size: 14px;">Deadline</label>
            <input type="datetime-local" name="deadline" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="<?= base_url('task') ?>" style="padding: 10px 20px; background: #e2e8f0; border-radius: 5px; text-decoration: none; color: #333; font-weight: bold;">Batal</a>
            <button type="submit" style="padding: 10px 20px; background: #3b82f6; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer;">Simpan Tugas</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>