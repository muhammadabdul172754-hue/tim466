<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div style="max-width: 600px; margin: 40px auto; padding: 0 20px;" data-aos="fade-up">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0; color: #0f172a; font-weight: 800;">Edit Profil Pengguna</h2>
        <a href="<?= base_url('/users') ?>" style="background: #e2e8f0; color: #334155; padding: 8px 15px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 14px;">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div style="background: white; border-radius: 12px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
        
        
        <form action="<?= base_url('/users/update/'.$user['id']) ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold; font-size: 14px; color: #334155; display: block; margin-bottom: 5px;">Nama Lengkap</label>
                <input type="text" name="nama" value="<?= esc($user['nama']) ?>" required style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold; font-size: 14px; color: #334155; display: block; margin-bottom: 5px;">Email</label>
                <input type="email" name="email" value="<?= esc($user['email']) ?>" required style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold; font-size: 14px; color: #334155; display: block; margin-bottom: 5px;">Username</label>
                <input type="text" name="username" value="<?= esc($user['username']) ?>" required style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;">
            </div>

                        <div style="background: #f8fafc; padding: 15px; border-radius: 8px; border: 1px solid #e2e8f0; margin-bottom: 20px;">
                <h4 style="margin: 0 0 15px 0; font-size: 14px; color: #0f172a;">Ganti Password (Opsional)</h4>
                <p style="font-size: 12px; color: #64748b; margin-top: -10px; margin-bottom: 15px;">Biarkan kosong jika tidak ingin mengubah password.</p>

                <div style="margin-bottom: 15px;">
                    <label style="font-weight: bold; font-size: 14px; color: #334155; display: block; margin-bottom: 5px;">Password Lama</label>
                    <input type="password" name="password_lama" id="password_lama" placeholder="Masukkan password saat ini" style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="font-weight: bold; font-size: 14px; color: #334155; display: block; margin-bottom: 5px;">Password Baru</label>
                    <input type="password" name="password_baru" id="password_baru" placeholder="Minimal 6 karakter" style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;">
                </div>

                <div style="margin-bottom: 5px;">
                    <label style="font-weight: bold; font-size: 14px; color: #334155; display: block; margin-bottom: 5px;">Konfirmasi Password Baru</label>
                    <input type="password" name="konfirmasi_password" id="konfirmasi_password" placeholder="Ulangi password baru" style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;">
                    <span id="pesan-error" style="color: #ef4444; font-size: 12px; display: none; margin-top: 5px;">Password baru dan konfirmasi tidak cocok!</span>
                </div>
            </div>

<?php if (session()->get('role') == 'admin') : ?>
            <div style="margin-bottom: 20px;">
                <label style="font-weight: bold; font-size: 14px; color: #334155; display: block; margin-bottom: 5px;">Role / Hak Akses</label>
                <select name="role" style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; background: white;">
                    <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="petugas" <?= $user['role'] == 'petugas' ? 'selected' : '' ?>>Petugas</option>
                    <option value="anggota" <?= $user['role'] == 'anggota' ? 'selected' : '' ?>>Anggota</option>
                </select>
            </div>
 <?php endif; ?>          

            <div style="margin-bottom: 25px; display: flex; align-items: center; gap: 20px; background: #f8fafc; padding: 15px; border-radius: 8px; border: 1px dashed #cbd5e1;">
                <div>
                    <label style="font-weight: bold; font-size: 14px; color: #334155; display: block; margin-bottom: 5px;">Foto Profil</label>
                    <input type="file" name="foto" accept="image/*" style="font-size: 14px;">
                    <div style="font-size: 12px; color: #64748b; margin-top: 5px;">Biarkan kosong jika tidak ingin mengubah foto.</div>
                </div>
                <?php if($user['foto']): ?>
                    <img src="<?= base_url('uploads/users/'.$user['foto']) ?>" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 2px solid #cbd5e1;">
                <?php else: ?>
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['nama']) ?>&background=random" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
                <?php endif; ?>
            </div>

            <div style="display: flex; gap: 10px; border-top: 1px solid #e2e8f0; padding-top: 20px;">
                <a href="<?= base_url('/users') ?>" style="padding: 12px 20px; background: #f1f5f9; border-radius: 8px; text-decoration: none; color: #334155; font-weight: bold; text-align: center; width: 30%;">Batal</a>
                <button type="submit" style="padding: 12px 20px; background: #3b82f6; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; width: 70%;">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>

<?= $this->section('scripts') ?>
<script>
    // Validasi kecocokan konfirmasi password sebelum form disubmit
    document.querySelector('form').addEventListener('submit', function(e) {
        const passBaru = document.getElementById('password_baru').value;
        const konfirmasi = document.getElementById('konfirmasi_password').value;
        const pesanError = document.getElementById('pesan-error');

        if (passBaru !== '' || konfirmasi !== '') {
            if (passBaru !== konfirmasi) {
                e.preventDefault(); // Cegah form terkirim
                pesanError.style.display = 'block';
            } else {
                pesanError.style.display = 'none';
            }
        }
    });
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>