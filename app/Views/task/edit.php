<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div style="max-width: 600px; margin: 40px auto; padding: 30px; background: white; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);" data-aos="fade-up">
    <h2 style="margin-top: 0; color: #0f172a; margin-bottom: 25px;">Edit Tugas</h2>
    
    <form action="<?= base_url('task/update/'.$task['id']) ?>" method="post">
        <?= csrf_field() ?>
        
        <div style="margin-bottom: 15px;">
            <label style="font-weight: bold; font-size: 14px; color: #334155;">Nama Tugas</label>
            <input type="text" name="judul" value="<?= esc($task['judul']) ?>" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-top: 5px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="font-weight: bold; font-size: 14px; color: #334155;">Deskripsi</label>
            <textarea name="deskripsi" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-top: 5px;"><?= esc($task['deskripsi']) ?></textarea>
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="font-weight: bold; font-size: 14px; color: #334155;">Kategori</label>
            <select name="kategori" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-top: 5px;">
                <?php foreach(['Coding', 'Desain', 'Laporan', 'Meeting', 'Umum'] as $kat): ?>
                    <option value="<?= $kat ?>" <?= ($task['kategori'] == $kat) ? 'selected' : '' ?>><?= $kat ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="font-weight: bold; font-size: 14px; color: #334155;">Deadline</label>
            <input type="datetime-local" name="deadline" value="<?= date('Y-m-d\TH:i', strtotime($task['deadline'])) ?>" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-top: 5px;">
        </div>
        
        <div style="margin-bottom: 25px;">
            <label style="font-weight: bold; font-size: 14px; color: #334155;">Status</label>
            <select name="status" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-top: 5px;">
                <option value="todo" <?= ($task['status'] == 'todo') ? 'selected' : '' ?>>Belum Selesai (To Do)</option>
                <option value="done" <?= ($task['status'] == 'done') ? 'selected' : '' ?>>Selesai (Done)</option>
            </select>
        </div>
        
        <div style="display: flex; gap: 10px;">
            <a href="<?= base_url('task/detail/'.$task['id']) ?>" style="padding: 10px 20px; background: #e2e8f0; border-radius: 5px; text-decoration: none; color: #333; font-weight: bold; text-align: center;">Batal</a>
            <button type="submit" style="padding: 10px 20px; background: #3b82f6; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; flex-grow: 1;">Simpan Perubahan</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>