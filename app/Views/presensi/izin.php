<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div style="max-width: 500px; margin: 40px auto; padding: 0 20px;" data-aos="fade-up">
    <div style="background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; overflow: hidden;">
        
        <div style="background: #f59e0b; padding: 20px; text-align: center; color: white;">
            <h3 style="margin: 0; font-weight: 800;">Ajukan Izin / Sakit</h3>
            <p style="margin: 5px 0 0 0; font-size: 13px;">Isi form di bawah untuk mengajukan ketidakhadiran.</p>
        </div>

        <div style="padding: 30px;">
            <form action="<?= base_url('presensi/submit-izin') ?>" method="POST">
                <?= csrf_field() ?>
                
                <div style="margin-bottom: 20px;">
                    <label style="font-weight: bold; font-size: 14px; display: block; margin-bottom: 8px; color: #334155;">Jenis Pengajuan</label>
                    <select name="status_izin" required style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;">
                        <option value="Izin">Izin (Ada keperluan)</option>
                        <option value="Sakit">Sakit (Butuh istirahat)</option>
                    </select>
                </div>

                <div style="margin-bottom: 25px;">
                    <label style="font-weight: bold; font-size: 14px; display: block; margin-bottom: 8px; color: #334155;">Alasan / Keterangan</label>
                    <textarea name="alasan" rows="4" required placeholder="Tuliskan alasan izin atau sakit..." style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;"></textarea>
                </div>

                <div style="display: flex; gap: 10px;">
                    <a href="<?= base_url('presensi') ?>" style="padding: 12px 20px; background: #f1f5f9; border-radius: 8px; text-decoration: none; color: #334155; font-weight: bold; text-align: center; width: 40%;">Batal</a>
                    <button type="submit" style="padding: 12px 20px; background: #f59e0b; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; width: 60%;">
                        <i class="bi bi-send"></i> Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>