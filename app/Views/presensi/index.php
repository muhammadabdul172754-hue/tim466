<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    .presensi-container { max-width: 1200px; margin: 30px auto; padding: 0 20px; font-family: 'DM Sans', sans-serif; }
    
    /* Header */
    .pres-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 25px; }
    .pres-header h2 { margin: 0; font-weight: 800; font-size: 24px; color: #0f172a; }
    .pres-header p { margin: 5px 0 0 0; font-size: 13px; color: #64748b; }
    
    /* Kotak Statistik */
    .stat-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 15px; margin-bottom: 25px; }
    .stat-box { background: white; border: 1px solid #e2e8f0; border-radius: 10px; padding: 20px; text-align: center; }
    .stat-box h3 { margin: 0; font-size: 24px; font-weight: 800; color: #0d9488; }
    .stat-box.warning h3 { color: #f59e0b; }
    .stat-box.info h3 { color: #3b82f6; }
    .stat-box.purple h3 { color: #8b5cf6; }
    .stat-box p { margin: 5px 0 0 0; font-size: 12px; font-weight: bold; color: #64748b; }

    /* Layout Grid Utama */
    .main-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; }

    /* Kartu Kiri (Absen & Riwayat) */
    .card-left { display: flex; flex-direction: column; gap: 20px; }
    .absen-box { background: white; border-radius: 12px; padding: 25px; border: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; }
    .absen-info h4 { margin: 0; font-size: 12px; color: #0d9488; font-weight: bold; letter-spacing: 1px; }
    .absen-info h2 { margin: 10px 0 5px 0; font-size: 22px; color: #0f172a; font-weight: 800; }
    
    /* Style Jam Besar */
    .jam-besar { font-size: 48px; font-weight: 800; color: #0f172a; margin: 15px 0; font-family: monospace; }
    .jam-besar span { font-size: 18px; color: #64748b; font-family: 'DM Sans', sans-serif; }
    
    .absen-action { width: 320px; text-align: center; }
    .btn-absen { width: 100%; padding: 15px; background: #0d9488; color: white; border: none; border-radius: 8px; font-weight: bold; font-size: 16px; cursor: pointer; transition: 0.2s; }
    .btn-absen:hover { background: #0f766e; }
    .btn-absen:disabled { background: #cbd5e1; cursor: not-allowed; }

    .riwayat-box { background: white; border-radius: 12px; padding: 25px; border: 1px solid #e2e8f0; }
    .riwayat-box h3 { margin: 0 0 15px 0; font-size: 16px; font-weight: 800; }
    .table-riwayat { width: 100%; border-collapse: collapse; font-size: 13px; }
    .table-riwayat th { text-align: left; padding: 12px; border-bottom: 2px solid #e2e8f0; color: #64748b; font-weight: bold; }
    .table-riwayat td { padding: 12px; border-bottom: 1px solid #f1f5f9; color: #334155; }
    .badge-status { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: bold; }
    .badge-hadir { background: #dcfce7; color: #15803d; }
    .badge-terlambat { background: #fef3c7; color: #b45309; }
    .badge-izin, .badge-sakit { background: #e0f2fe; color: #0284c7; }

    /* Kartu Kanan (Lokasi) */
    .card-right { display: flex; flex-direction: column; gap: 20px; }
    .lokasi-box { background: white; border-radius: 12px; padding: 20px; border: 1px solid #e2e8f0; }
    .lokasi-header { display: flex; align-items: center; gap: 10px; margin-bottom: 15px; }
    .lokasi-header h3 { margin: 0; font-size: 16px; font-weight: 800; }
    .map-placeholder { width: 100%; height: 180px; background: #e2e8f0; border-radius: 8px; display: flex; justify-content: center; align-items: center; position: relative; background-image: url('https://www.transparenttextures.com/patterns/cubes.png'); margin-bottom: 15px; }
    .map-pin { width: 40px; height: 40px; background: rgba(239, 68, 68, 0.2); border-radius: 50%; display: flex; justify-content: center; align-items: center; }
    .map-pin-inner { width: 15px; height: 15px; background: #ef4444; border-radius: 50%; }
    
    .lokasi-detail p { margin: 0 0 5px 0; font-size: 13px; color: #475569; }
</style>

<div class="presensi-container" data-aos="fade-up">
    
    <!-- Header -->
    <div class="pres-header">
        <div>
            <h2>Presensi</h2>
            <p>Catat kehadiran dengan lokasi GPS sebagai bukti kegiatan PKL.</p>
        </div>
        <div>
            <!-- Tombol Izin yang sudah diperbaiki -->
            <a href="<?= base_url('presensi/izin') ?>" style="color: #f59e0b; font-weight: bold; text-decoration: none; font-size: 14px; display: inline-flex; align-items: center; gap: 5px; border: 1px solid #f59e0b; padding: 8px 15px; border-radius: 6px;">
                <i class="bi bi-envelope-paper"></i> Ajukan Izin / Sakit
            </a>
        </div>
    </div>

    <!-- Statistik -->
    <div class="stat-grid">
        <div class="stat-box"><h3><?= $stats['hadir'] ?></h3><p>Hadir</p></div>
        <div class="stat-box warning"><h3><?= $stats['terlambat'] ?></h3><p>Terlambat</p></div>
        <div class="stat-box info"><h3><?= $stats['izin'] ?></h3><p>Izin</p></div>
        <div class="stat-box purple"><h3><?= $stats['sakit'] ?></h3><p>Sakit</p></div>
        <div class="stat-box"><h3><?= $stats['total'] ?></h3><p>Total bulan ini</p></div>
    </div>

    <!-- Layout Utama -->
    <div class="main-grid">
        
        <!-- KOLOM KIRI -->
        <div class="card-left">
            <!-- Kotak Absen -->
            <div class="absen-box">
                <div class="absen-info">
                    <h4><i class="bi bi-clock"></i> HARI INI, <?= date('l, d F Y') ?></h4>
                    <h2>Siap memulai hari dengan disiplin?</h2>
                    
                    <!-- LOKASI GPS USER -->
                    <p style="font-size: 13px; color: #64748b; margin: 0;">
                        <i class="bi bi-geo-alt-fill" style="color: #ef4444;"></i> 
                        <span id="lokasiUser" style="color: #0d9488; font-weight: bold;">Mendeteksi lokasi...</span>
                    </p>
                    
                    <!-- JAM DIGITAL BESAR -->
                    <div class="jam-besar" id="jamDigital">00:00:00 <span>WIB</span></div>
                    
                    <div style="font-size: 12px; color: #64748b; display: flex; gap: 15px;">
                        <span><i class="bi bi-box-arrow-in-right"></i> Masuk: 06:30 - 13:00</span>
                        <span><i class="bi bi-box-arrow-right"></i> Keluar: 14:00 - 18:00</span>
                    </div>
                </div>

                <div class="absen-action">
                    <div style="background: #f0fdfa; border: 1px solid #ccfbf1; padding: 10px; border-radius: 8px; margin-bottom: 15px; text-align: left;">
                        <span style="font-size: 12px; font-weight: bold; color: #0d9488;"><i class="bi bi-circle-fill" style="font-size: 8px;"></i> <?= $presensi ? 'Sudah Absen' : 'Belum presensi' ?></span>
                        <p style="margin: 5px 0 0 0; font-size: 11px; color: #64748b;">Aktifkan GPS untuk mendeteksi lokasi Anda.</p>
                    </div>
                    
                    <form action="<?= base_url('presensi/submit') ?>" method="POST">
                        <?= csrf_field() ?>
                        <!-- Hidden input untuk menyimpan koordinat -->
                        <input type="hidden" name="lokasi" id="inputLokasi">
                        <input type="hidden" name="aksi" value="<?= !$presensi ? 'masuk' : (!$presensi['jam_pulang'] ? 'pulang' : 'selesai') ?>">
                        
                        <?php if(!$presensi): ?>
                            <button type="submit" class="btn-absen"><i class="bi bi-fingerprint"></i> Presensi Masuk</button>
                        <?php elseif($presensi && !$presensi['jam_pulang']): ?>
                            <button type="submit" class="btn-absen" style="background: #ef4444;"><i class="bi bi-box-arrow-right"></i> Presensi Pulang</button>
                        <?php else: ?>
                            <button type="button" class="btn-absen" disabled><i class="bi bi-check-circle"></i> Presensi Selesai</button>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

            <!-- Riwayat Presensi -->
            <div class="riwayat-box">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <h3><i class="bi bi-calendar2-week"></i> Riwayat Presensi</h3>
                    <input type="month" value="<?= date('Y-m') ?>" style="padding: 5px 10px; border: 1px solid #cbd5e1; border-radius: 5px;">
                </div>
                <table class="table-riwayat">
                    <thead>
                        <tr>
                            <th>TANGGAL</th>
                            <th>STATUS</th>
                            <th>MASUK</th>
                            <th>KELUAR</th>
                            <th>VERIFIKASI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($riwayat)): ?>
                            <tr><td colspan="5" style="text-align: center; padding: 30px; color: #94a3b8;">Belum ada riwayat presensi pada bulan ini.</td></tr>
                        <?php else: ?>
                            <?php foreach($riwayat as $r): 
                                $bgClass = 'badge-hadir';
                                if($r['status'] == 'Terlambat') $bgClass = 'badge-terlambat';
                                if($r['status'] == 'Izin' || $r['status'] == 'Sakit') $bgClass = 'badge-izin';
                            ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($r['tanggal'])) ?></td>
                                <td><span class="badge-status <?= $bgClass ?>"><?= $r['status'] ?></span></td>
                                <td><?= $r['jam_masuk'] ?? '-' ?></td>
                                <td><?= $r['jam_pulang'] ?? '-' ?></td>
                                <td><span style="color: #10b981; font-weight: bold; font-size: 12px;"><i class="bi bi-patch-check-fill"></i> Terverifikasi</span></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- KOLOM KANAN -->
        <div class="card-right">
            <!-- Lokasi PKL -->
            <div class="lokasi-box">
                <div class="lokasi-header">
                    <i class="bi bi-geo-alt-fill" style="color: #0d9488; font-size: 20px;"></i>
                    <h3>Lokasi PKL</h3>
                </div>
                <div class="map-placeholder">
                    <div class="map-pin">
                        <div class="map-pin-inner"></div>
                    </div>
                </div>
                <div class="lokasi-detail">
                    <p style="font-weight: bold; color: #0f172a;"><i class="bi bi-building"></i> RM Alam Sari</p>
                    <p>Gunungdatar, Gunturmekar, Sumedang, Jawa Barat</p>
                    <hr style="border: none; border-top: 1px dashed #cbd5e1; margin: 10px 0;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="font-size: 12px; color: #64748b;">Koordinat Kantor</span>
                        <span style="font-size: 12px; font-family: monospace;">-6.80850, 107.89008</span>
                    </div>
                </div>
            </div>

            <!-- Info Keamanan -->
            <div class="lokasi-box" style="background: #f0fdf4; border-color: #bbf7d0; display: flex; gap: 15px; align-items: flex-start;">
                <i class="bi bi-shield-check" style="color: #16a34a; font-size: 24px;"></i>
                <div>
                    <h4 style="margin: 0 0 5px 0; font-size: 14px; color: #15803d;">Presensi aman & terverifikasi</h4>
                    <p style="margin: 0; font-size: 12px; color: #166534; line-height: 1.5;">Setiap presensi memerlukan lokasi, jarak, dan waktu. Pembimbing akan memverifikasi data Anda.</p>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // 1. JAM DIGITAL
        function updateJam() {
            const now = new Date();
            const jam = String(now.getHours()).padStart(2, '0');
            const menit = String(now.getMinutes()).padStart(2, '0');
            const detik = String(now.getSeconds()).padStart(2, '0');
            
            const elemenJam = document.getElementById('jamDigital');
            if (elemenJam) {
                elemenJam.innerHTML = `${jam}:${menit}:${detik} <span>WIB</span>`;
            }
        }
        
        // Jalankan jam
        setInterval(updateJam, 1000);
        updateJam(); 

        // 2. LOKASI GPS
        const lokasiTeks = document.getElementById('lokasiUser');
        const inputLokasi = document.getElementById('inputLokasi');

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const lat = position.coords.latitude.toFixed(6);
                    const lon = position.coords.longitude.toFixed(6);
                    if(lokasiTeks) {
                        lokasiTeks.innerText = `Terdeteksi (${lat}, ${lon})`;
                        lokasiTeks.style.color = '#10b981';
                    }
                    if(inputLokasi) inputLokasi.value = `${lat}, ${lon}`;
                },
                function(error) {
                    if(lokasiTeks) {
                        lokasiTeks.innerText = "Lokasi tidak diizinkan / Gagal dideteksi";
                        lokasiTeks.style.color = '#ef4444';
                    }
                },
                { enableHighAccuracy: true, timeout: 5000, maximumAge: 0 }
            );
        } else {
            if(lokasiTeks) lokasiTeks.innerText = "Browser tidak mendukung Geolocation";
        }
    });
</script>
<?= $this->endSection() ?>