<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div style="max-width: 1200px; margin: 30px auto; padding: 0 20px; font-family: 'DM Sans', sans-serif;" data-aos="fade-up">
    
    <!-- BANNER SAPAAN & MOTIVASI (BIRU GRADASI) -->
    <div style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); border-radius: 20px; padding: 40px; color: white; position: relative; overflow: hidden; margin-bottom: 25px; box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);">
        
        <!-- Ornamen -->
        <div style="position: absolute; top: -50px; right: -20px; width: 250px; height: 250px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
        <div style="position: absolute; bottom: -30px; left: 10%; width: 100px; height: 100px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
        <div style="position: absolute; top: 20px; right: 250px; width: 100px; height: 100px; background-image: radial-gradient(rgba(255,255,255,0.2) 2px, transparent 2px); background-size: 15px 15px;"></div>

        <div style="position: relative; z-index: 2;">
            <span style="background: rgba(255,255,255,0.2); padding: 6px 15px; border-radius: 20px; font-size: 12px; font-weight: bold; letter-spacing: 1px; display: inline-block; margin-bottom: 15px;">
                <i class="bi bi-sun"></i> SELAMAT SIANG, <?= strtoupper($nama) ?>
            </span>
            <h1 style="margin: 0 0 10px 0; font-size: 34px; font-weight: 800; line-height: 1.2; text-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                Hari yang baik untuk bertumbuh dan berkarya.
            </h1>
            <p style="margin: 0 0 25px 0; font-size: 15px; color: #e0e7ff; max-width: 600px; line-height: 1.6;">
                Pantau tugas, tulis jurnal, dan mulai hari dengan presensi. Sedikit progres setiap hari akan menjadi portofolio yang membanggakan.
            </p>
            
            <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                <a href="<?= base_url('/presensi') ?>" style="background: #f59e0b; color: #0f172a; padding: 12px 25px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; transition: transform 0.2s; box-shadow: 0 4px 10px rgba(245, 158, 11, 0.4);" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    <i class="bi bi-geo-alt-fill"></i> Presensi Sekarang
                </a>
                <a href="<?= base_url('/jurnal/create') ?>" style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.4); color: white; padding: 12px 25px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; backdrop-filter: blur(5px); transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.25)'" onmouseout="this.style.background='rgba(255,255,255,0.15)'">
                    <i class="bi bi-journal-plus"></i> Jurnal Hari Ini
                </a>
            </div>
        </div>
    </div>

    <!-- KARTU STATISTIK ATAS -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 25px;">
        <!-- Tugas -->
        <div style="background: white; border-radius: 15px; padding: 25px; border: 1px solid #e2e8f0; position: relative; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
            <div style="width: 40px; height: 40px; background: #eff6ff; color: #3b82f6; border-radius: 10px; display: flex; justify-content: center; align-items: center; font-size: 20px; margin-bottom: 15px;"><i class="bi bi-list-task"></i></div>
            <span style="position: absolute; top: 25px; right: 25px; background: #eff6ff; color: #3b82f6; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: bold;"><?= $total_tugas - $tugas_selesai ?> berjalan</span>
            <h2 style="margin: 0; font-size: 32px; font-weight: 800; color: #0f172a;"><?= $total_tugas ?></h2>
            <p style="margin: 5px 0 15px 0; font-size: 13px; color: #64748b;">Total tugas saya</p>
            <div style="background: #3b82f6; height: 4px; border-radius: 2px; width: <?= $total_tugas > 0 ? ($tugas_selesai / $total_tugas * 100) : 0 ?>%;"></div>
        </div>

        <!-- Tugas Selesai -->
        <div style="background: white; border-radius: 15px; padding: 25px; border: 1px solid #e2e8f0; position: relative; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
            <div style="width: 40px; height: 40px; background: #fffbeb; color: #f59e0b; border-radius: 10px; display: flex; justify-content: center; align-items: center; font-size: 20px; margin-bottom: 15px;"><i class="bi bi-hourglass-split"></i></div>
            <h2 style="margin: 0; font-size: 32px; font-weight: 800; color: #0f172a;"><?= $tugas_selesai ?></h2>
            <p style="margin: 5px 0 15px 0; font-size: 13px; color: #64748b;">Tugas selesai</p>
            <p style="margin: 0; font-size: 12px; color: #64748b;">0 menunggu review mentor</p>
        </div>

        <!-- Presensi -->
        <div style="background: white; border-radius: 15px; padding: 25px; border: 1px solid #e2e8f0; position: relative; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
            <div style="width: 40px; height: 40px; background: #eff6ff; color: #3b82f6; border-radius: 10px; display: flex; justify-content: center; align-items: center; font-size: 20px; margin-bottom: 15px;"><i class="bi bi-geo-alt-fill"></i></div>
            <span style="position: absolute; top: 25px; right: 25px; background: #f1f5f9; color: #64748b; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: bold;"><?= $presensi_hari_ini ? 'Sudah absen' : 'Belum absen' ?></span>
            <h2 style="margin: 0; font-size: 32px; font-weight: 800; color: #0f172a;"><?= $presensi_hari_ini ? $presensi_hari_ini['jam_masuk'] : '—' ?></h2>
            <p style="margin: 5px 0 15px 0; font-size: 13px; color: #64748b;">Presensi masuk</p>
            <a href="<?= base_url('/presensi') ?>" style="font-size: 12px; color: #3b82f6; text-decoration: none; font-weight: bold;">Mulai presensi sekarang</a>
        </div>

        <!-- Jurnal -->
        <div style="background: white; border-radius: 15px; padding: 25px; border: 1px solid #e2e8f0; position: relative; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
            <div style="width: 40px; height: 40px; background: #f5f3ff; color: #8b5cf6; border-radius: 10px; display: flex; justify-content: center; align-items: center; font-size: 20px; margin-bottom: 15px;"><i class="bi bi-journal-check"></i></div>
            <h2 style="margin: 0; font-size: 32px; font-weight: 800; color: #0f172a;"><?= $jurnal_disetujui ?></h2>
            <p style="margin: 5px 0 15px 0; font-size: 13px; color: #64748b;">Jurnal disetujui</p>
            <p style="margin: 0; font-size: 12px; color: #64748b;">Total <?= $jurnal_disetujui ?> jurnal tercatat</p>
        </div>
    </div>

    <!-- SECTION BAWAH (Rencana Kerja & Presensi) -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <!-- Rencana Kerja -->
        <div style="background: white; border-radius: 15px; border: 1px solid #e2e8f0; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <div>
                    <h3 style="margin: 0; font-size: 16px; font-weight: 800; color: #0f172a;"><i class="bi bi-check2-square" style="color: #3b82f6;"></i> Rencana Kerja Terdekat</h3>
                    <p style="margin: 5px 0 0 0; font-size: 12px; color: #64748b;">Tugas yang perlu kamu selesaikan</p>
                </div>
                <a href="<?= base_url('/task') ?>" style="background: #f1f5f9; color: #475569; padding: 8px 15px; border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: bold;">Lihat semua</a>
            </div>
            
            <div style="text-align: center; padding: 40px 0;">
                <div style="width: 60px; height: 60px; background: #eff6ff; color: #3b82f6; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-size: 24px; margin: 0 auto 15px auto;">
                    <i class="bi bi-check2-all"></i>
                </div>
                <h4 style="margin: 0 0 5px 0; color: #0f172a; font-size: 15px;">Semua tugas selesai</h4>
                <p style="margin: 0; font-size: 12px; color: #64748b;">Kamu hebat, tidak ada tugas yang tertunda.</p>
            </div>
        </div>

        <!-- Presensi Hari Ini -->
        <div style="background: white; border-radius: 15px; border: 1px solid #e2e8f0; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <div>
                    <h3 style="margin: 0; font-size: 16px; font-weight: 800; color: #0f172a;"><i class="bi bi-geo-alt-fill" style="color: #3b82f6;"></i> Presensi Hari Ini</h3>
                    <p style="margin: 5px 0 0 0; font-size: 12px; color: #64748b;"><?= date('l, d F Y') ?></p>
                </div>
                <a href="<?= base_url('/presensi') ?>" style="background: #f1f5f9; color: #475569; padding: 8px 15px; border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: bold;">Detail</a>
            </div>
            
            <div style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 12px; padding: 20px; text-align: center;">
                <span style="background: #fef3c7; color: #b45309; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: bold;"><?= $presensi_hari_ini ? 'Sudah Presensi' : 'Belum presensi' ?></span>
                <p style="margin: 15px 0; font-size: 13px; color: #64748b; line-height: 1.5;">Ambil foto dan pastikan lokasi kamu berada dalam radius PKL.</p>
                <a href="<?= base_url('/presensi') ?>" style="display: block; background: #3b82f6; color: white; padding: 12px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 14px;">
                    <i class="bi bi-fingerprint"></i> Presensi Sekarang
                </a>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>