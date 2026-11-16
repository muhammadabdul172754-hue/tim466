<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!-- Panggil Library Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div style="max-width: 1200px; margin: 30px auto; padding: 0 20px; font-family: 'DM Sans', sans-serif;" data-aos="fade-up">
    
    <!-- BANNER HEADER ADMIN -->
    <div style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); border-radius: 20px; padding: 40px; color: white; position: relative; overflow: hidden; margin-bottom: 25px; box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);">
        <div style="position: absolute; top: -50px; right: -20px; width: 250px; height: 250px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
        <div style="position: absolute; bottom: -30px; left: 10%; width: 100px; height: 100px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>

        <div style="position: relative; z-index: 2;">
            <span style="background: rgba(255,255,255,0.2); padding: 6px 15px; border-radius: 20px; font-size: 12px; font-weight: bold; letter-spacing: 1px; display: inline-block; margin-bottom: 15px;">
                <i class="bi bi-stars"></i> PANEL ADMIN - <?= strtoupper($nama) ?>
            </span>
            <h1 style="margin: 0 0 10px 0; font-size: 34px; font-weight: 800; line-height: 1.2; text-shadow: 0 2px 4px rgba(0,0,0,0.1);">Pantau progres, beri arahan, lihat mereka berkembang.</h1>
            <p style="margin: 0 0 25px 0; font-size: 15px; color: #e0e7ff; max-width: 600px; line-height: 1.6;">Semua aktivitas tim PKL terangkum di sini — mulai dari progres tugas, jurnal, kehadiran, hingga percakapan terbaru.</p>
            
            <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                <a href="<?= base_url('/jurnal/verifikasi') ?>" style="background: #f59e0b; color: #0f172a; padding: 12px 25px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; transition: transform 0.2s; box-shadow: 0 4px 10px rgba(245, 158, 11, 0.4);" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    <i class="bi bi-journal-check"></i> Review Jurnal (<?= $jurnal_review ?>)
                </a>
                <a href="<?= base_url('/presensi/rekap') ?>" style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.4); color: white; padding: 12px 25px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; backdrop-filter: blur(5px); transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.25)'" onmouseout="this.style.background='rgba(255,255,255,0.15)'">
                    <i class="bi bi-geo-alt"></i> Verifikasi Presensi
                </a>
            </div>

            <div style="display: flex; gap: 25px; margin-top: 30px; border-top: 1px solid rgba(255,255,255,0.2); padding-top: 20px; font-size: 13px; color: #e0e7ff;">
                <span><i class="bi bi-people"></i> <?= $total_anggota ?> siswa bimbingan</span>
                <span><i class="bi bi-building"></i> RM Alam Sari</span>
                <span><i class="bi bi-calendar"></i> Periode PKL</span>
            </div>
        </div>
    </div>

    <!-- KARTU STATISTIK ATAS -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 25px;">
        <!-- Card 1: Total Anggota -->
        <div style="background: white; border-radius: 15px; padding: 25px; border: 1px solid #e2e8f0; position: relative; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
            <div style="width: 40px; height: 40px; background: #eff6ff; color: #3b82f6; border-radius: 10px; display: flex; justify-content: center; align-items: center; font-size: 20px; margin-bottom: 15px;"><i class="bi bi-people-fill"></i></div>
            <h2 style="margin: 0; font-size: 32px; font-weight: 800; color: #0f172a;"><?= $total_anggota ?></h2>
            <p style="margin: 5px 0 15px 0; font-size: 13px; color: #64748b;">Total Siswa PKL</p>
            <hr style="border: none; border-top: 1px solid #f1f5f9; margin: 15px 0;">
            <p style="margin: 0; font-size: 12px; color: #64748b;"><?= $hadir_hari_ini ?> orang masuk hari ini</p>
        </div>

        <!-- Card 2: Jurnal Review -->
        <div style="background: white; border-radius: 15px; padding: 25px; border: 1px solid #e2e8f0; position: relative; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
            <div style="width: 40px; height: 40px; background: #fffbeb; color: #f59e0b; border-radius: 10px; display: flex; justify-content: center; align-items: center; font-size: 20px; margin-bottom: 15px;"><i class="bi bi-journal-text"></i></div>
            <span style="position: absolute; top: 25px; right: 25px; background: #fef3c7; color: #b45309; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: bold;">Perlu aksi</span>
            <h2 style="margin: 0; font-size: 32px; font-weight: 800; color: #0f172a;"><?= $jurnal_review ?></h2>
            <p style="margin: 5px 0 15px 0; font-size: 13px; color: #64748b;">Jurnal Menunggu Review</p>
            <hr style="border: none; border-top: 1px solid #f1f5f9; margin: 15px 0;">
            <a href="<?= base_url('/jurnal/verifikasi') ?>" style="font-size: 12px; color: #3b82f6; text-decoration: none; font-weight: bold;">Review sekarang <i class="bi bi-arrow-right"></i></a>
        </div>

        <!-- Card 3: Presensi Hari Ini -->
        <div style="background: white; border-radius: 15px; padding: 25px; border: 1px solid #e2e8f0; position: relative; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
            <div style="width: 40px; height: 40px; background: #eff6ff; color: #3b82f6; border-radius: 10px; display: flex; justify-content: center; align-items: center; font-size: 20px; margin-bottom: 15px;"><i class="bi bi-geo-alt-fill"></i></div>
            <span style="position: absolute; top: 25px; right: 25px; background: #f1f5f9; color: #64748b; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: bold;">Hari ini</span>
            <h2 style="margin: 0; font-size: 32px; font-weight: 800; color: #0f172a;"><?= $hadir_hari_ini + $terlambat_hari_ini ?></h2>
            <p style="margin: 5px 0 15px 0; font-size: 13px; color: #64748b;">Sudah Presensi</p>
            <hr style="border: none; border-top: 1px solid #f1f5f9; margin: 15px 0;">
            <p style="margin: 0; font-size: 12px; color: #64748b;"><?= $hadir_hari_ini ?> hadir · <?= $terlambat_hari_ini ?> terlambat</p>
        </div>

        <!-- Card 4: Tugas Selesai -->
        <div style="background: white; border-radius: 15px; padding: 25px; border: 1px solid #e2e8f0; position: relative; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
            <div style="width: 40px; height: 40px; background: #dcfce7; color: #10b981; border-radius: 10px; display: flex; justify-content: center; align-items: center; font-size: 20px; margin-bottom: 15px;"><i class="bi bi-check-circle-fill"></i></div>
            <h2 style="margin: 0; font-size: 32px; font-weight: 800; color: #0f172a;"><?= $tugas_selesai ?></h2>
            <p style="margin: 5px 0 15px 0; font-size: 13px; color: #64748b;">Tugas Selesai</p>
            <hr style="border: none; border-top: 1px solid #f1f5f9; margin: 15px 0;">
            <p style="margin: 0; font-size: 12px; color: #64748b;">Dari total <?= $total_tugas ?> tugas</p>
        </div>
    </div>

    <!-- SECTION BAWAH: GRAFIK & JURNAL -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        
        <!-- Kiri: Grafik Kehadiran -->
        <div style="background: white; border-radius: 15px; border: 1px solid #e2e8f0; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <div>
                    <h3 style="margin: 0; font-size: 16px; font-weight: 800; color: #0f172a;"><i class="bi bi-pie-chart-fill" style="color: #3b82f6;"></i> Persentase Kehadiran</h3>
                    <p style="margin: 5px 0 0 0; font-size: 12px; color: #64748b;">Data hari ini (<?= date('d M Y') ?>)</p>
                </div>
            </div>
            
            <!-- Canvas untuk Chart.js -->
            <div style="position: relative; height: 220px; width: 100%; display: flex; justify-content: center;">
                <canvas id="chartKehadiran"></canvas>
            </div>
            
            <div style="display: flex; justify-content: center; gap: 15px; margin-top: 20px; font-size: 12px;">
                <span style="display: flex; align-items: center; gap: 5px;"><span style="width: 10px; height: 10px; background: #10b981; border-radius: 50%;"></span> Hadir (<?= $hadir_hari_ini ?>)</span>
                <span style="display: flex; align-items: center; gap: 5px;"><span style="width: 10px; height: 10px; background: #f59e0b; border-radius: 50%;"></span> Terlambat (<?= $terlambat_hari_ini ?>)</span>
                <span style="display: flex; align-items: center; gap: 5px;"><span style="width: 10px; height: 10px; background: #3b82f6; border-radius: 50%;"></span> Izin/Sakit (<?= $izin_sakit_hari_ini ?>)</span>
                <span style="display: flex; align-items: center; gap: 5px;"><span style="width: 10px; height: 10px; background: #cbd5e1; border-radius: 50%;"></span> Belum (<?= $belum_absen ?>)</span>
            </div>
        </div>

        <!-- Kanan: Ringkasan Jurnal -->
        <div style="background: white; border-radius: 15px; border: 1px solid #e2e8f0; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <div>
                    <h3 style="margin: 0; font-size: 16px; font-weight: 800; color: #0f172a;"><i class="bi bi-journal-check" style="color: #3b82f6;"></i> Status Jurnal Keseluruhan</h3>
                    <p style="margin: 5px 0 0 0; font-size: 12px; color: #64748b;">Akumulasi semua jurnal anggota</p>
                </div>
                <a href="<?= base_url('/jurnal/verifikasi') ?>" style="background: #f1f5f9; color: #475569; padding: 8px 15px; border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: bold;">Semua</a>
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 15px;">
                <!-- Disetujui -->
                <div style="background: #f8fafc; padding: 15px; border-radius: 10px; border: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="width: 30px; height: 30px; background: #dcfce7; color: #10b981; border-radius: 50%; display: flex; justify-content: center; align-items: center;"><i class="bi bi-check-lg"></i></div>
                        <span style="font-weight: bold; color: #0f172a; font-size: 14px;">Disetujui</span>
                    </div>
                    <span style="font-weight: 800; font-size: 18px; color: #10b981;"><?= $jurnal_disetujui ?></span>
                </div>
                
                <!-- Menunggu -->
                <div style="background: #f8fafc; padding: 15px; border-radius: 10px; border: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="width: 30px; height: 30px; background: #fef3c7; color: #f59e0b; border-radius: 50%; display: flex; justify-content: center; align-items: center;"><i class="bi bi-hourglass-split"></i></div>
                        <span style="font-weight: bold; color: #0f172a; font-size: 14px;">Menunggu Review</span>
                    </div>
                    <span style="font-weight: 800; font-size: 18px; color: #f59e0b;"><?= $jurnal_review ?></span>
                </div>

                <!-- Revisi -->
                <div style="background: #f8fafc; padding: 15px; border-radius: 10px; border: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="width: 30px; height: 30px; background: #fee2e2; color: #ef4444; border-radius: 50%; display: flex; justify-content: center; align-items: center;"><i class="bi bi-exclamation-triangle-fill"></i></div>
                        <span style="font-weight: bold; color: #0f172a; font-size: 14px;">Perlu Revisi</span>
                    </div>
                    <span style="font-weight: 800; font-size: 18px; color: #ef4444;"><?= $jurnal_revisi ?></span>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Script untuk render Grafik -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('chartKehadiran').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Hadir', 'Terlambat', 'Izin/Sakit', 'Belum Absen'],
                datasets: [{
                    data: [<?= $hadir_hari_ini ?>, <?= $terlambat_hari_ini ?>, <?= $izin_sakit_hari_ini ?>, <?= $belum_absen ?>],
                    backgroundColor: [
                        '#10b981', // Hijau (Hadir)
                        '#f59e0b', // Kuning (Terlambat)
                        '#3b82f6', // Biru (Izin/Sakit)
                        '#cbd5e1'  // Abu-abu (Belum)
                    ],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: { display: false }
                }
            }
        });
    });
</script>

<?= $this->endSection() ?>