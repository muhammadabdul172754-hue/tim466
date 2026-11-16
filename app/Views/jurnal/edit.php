<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div style="max-width: 800px; margin: 40px auto; padding: 30px; background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);" data-aos="fade-up">
    <h2 style="margin-top: 0; color: #0f172a; margin-bottom: 25px; font-weight: 800;">Edit Jurnal</h2>
    
    <form action="<?= base_url('jurnal/update/'.$jurnal['id']) ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; margin-bottom: 15px;">
            <div><label style="font-weight: bold; font-size: 14px;">Tanggal</label><input type="date" name="tanggal" value="<?= $jurnal['tanggal'] ?>" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-top: 5px;"></div>
            <div><label style="font-weight: bold; font-size: 14px;">Waktu Mulai</label><input type="time" name="waktu_mulai" value="<?= $jurnal['waktu_mulai'] ?>" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-top: 5px;"></div>
            <div><label style="font-weight: bold; font-size: 14px;">Waktu Selesai</label><input type="time" name="waktu_selesai" value="<?= $jurnal['waktu_selesai'] ?>" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-top: 5px;"></div>
        </div>
        <div style="margin-bottom: 15px;"><label style="font-weight: bold; font-size: 14px;">Judul Kegiatan</label><input type="text" name="judul_kegiatan" value="<?= $jurnal['judul_kegiatan'] ?>" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-top: 5px;"></div>
        <div style="margin-bottom: 15px;"><label style="font-weight: bold; font-size: 14px;">Deskripsi Pekerjaan</label><textarea name="deskripsi" rows="4" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-top: 5px;"><?= $jurnal['deskripsi'] ?></textarea></div>
        <div style="margin-bottom: 25px;">
            <label style="font-weight: bold; font-size: 14px;">Foto Dokumentasi (Biarkan kosong jika tidak diubah)</label>
            <input type="file" name="foto" accept="image/*" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-top: 5px;">
            <div style="margin-top: 10px;"><img src="<?= base_url('uploads/jurnal/'.$jurnal['foto']) ?>" style="height: 100px; border-radius: 8px;"></div>
        </div>
        
        <div style="display: flex; gap: 10px;">
            <a href="<?= base_url('jurnal') ?>" style="padding: 10px 20px; background: #e2e8f0; border-radius: 5px; text-decoration: none; color: #333; font-weight: bold;">Batal</a>
            <button type="submit" style="padding: 10px 20px; background: #f59e0b; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; flex-grow: 1;">Simpan Perubahan</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>