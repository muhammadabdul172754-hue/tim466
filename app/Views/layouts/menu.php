<div style="position: relative; height: 100%; z-index: 1; padding: 25px 20px; display: flex; flex-direction: column; overflow-x: hidden;">
    
    <!-- ORNAMEN DEKORASI SIDEBAR (Lingkaran Transparan & Titik-titik) -->
    <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.05); border-radius: 50%; z-index: -1;"></div>
    <div style="position: absolute; bottom: 10%; left: -80px; width: 250px; height: 250px; border: 40px solid rgba(255,255,255,0.03); border-radius: 50%; z-index: -1;"></div>
    <div style="position: absolute; top: 30%; right: 20px; width: 80px; height: 80px; background-image: radial-gradient(rgba(255,255,255,0.15) 2px, transparent 2px); background-size: 12px 12px; z-index: -1;"></div>

    <!-- LOGO -->
    <a href="<?= base_url('/dashboard') ?>" style="display: flex; align-items: center; gap: 12px; text-decoration: none; margin-bottom: 35px; padding-left: 5px;">
        <div style="width: 42px; height: 42px; background: white; border-radius: 10px; display: flex; justify-content: center; align-items: center; overflow: hidden; padding: 5px; box-shadow: 0 4px 10px rgba(0,0,0,0.2);">
            <!-- GANTI URL GAMBAR DI BAWAH INI JIKA LOGO SUDAH ADA -->
            <img src="<?= base_url('img/logo.png') ?>" alt="Logo" style="width: 100%; height: 100%; object-fit: contain;" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
            <!-- Ikon cadangan jika gambar tidak ditemukan -->
            <i class="bi bi-code-square" style="display: none; font-size: 24px; color: #1e3a8a;"></i>
        </div>
        <div>
            <h2 style="margin: 0; font-size: 22px; font-weight: 800; color: white; letter-spacing: 1px;">Tim466<span style="color: #60a5fa;">App</span></h2>
            <p style="margin: 0; font-size: 11px; color: #cbd5e1; font-weight: 600; letter-spacing: 0.5px;">PKL STUDENT TEAM</p>
        </div>
    </a>

    <!-- MENU UTAMA -->
    <p style="font-size: 10px; font-weight: 800; color: #94a3b8; letter-spacing: 1px; margin-bottom: 15px; padding-left: 10px;">MENU UTAMA</p>
    
    <!-- KODE MENU DENGAN HOVER BIRU -->
    <a href="<?= base_url('/dashboard') ?>" style="display: flex; align-items: center; gap: 12px; padding: 12px 15px; border-radius: 8px; text-decoration: none; color: #e2e8f0; font-size: 14px; font-weight: 600; margin-bottom: 5px; transition: all 0.3s; border-left: 3px solid transparent;" onmouseover="this.style.background='rgba(255,255,255,0.1)'; this.style.borderLeftColor='#60a5fa'; this.style.paddingLeft='20px'; this.style.color='white';" onmouseout="this.style.background='transparent'; this.style.borderLeftColor='transparent'; this.style.paddingLeft='15px'; this.style.color='#e2e8f0';">
        <i class="bi bi-grid-fill" style="font-size: 18px; color: #60a5fa;"></i> Dashboard
    </a>

    <!-- RUANG KERJA -->
    <p style="font-size: 10px; font-weight: 800; color: #94a3b8; letter-spacing: 1px; margin: 25px 0 15px 0; padding-left: 10px;">RUANG KERJA</p>
    
    <a href="<?= base_url('/task') ?>" style="display: flex; align-items: center; gap: 12px; padding: 12px 15px; border-radius: 8px; text-decoration: none; color: #e2e8f0; font-size: 14px; font-weight: 600; margin-bottom: 5px; transition: all 0.3s; border-left: 3px solid transparent;" onmouseover="this.style.background='rgba(255,255,255,0.1)'; this.style.borderLeftColor='#60a5fa'; this.style.paddingLeft='20px'; this.style.color='white';" onmouseout="this.style.background='transparent'; this.style.borderLeftColor='transparent'; this.style.paddingLeft='15px'; this.style.color='#e2e8f0';">
        <i class="bi bi-check2-square" style="font-size: 18px;"></i> Task Planner
    </a>
    
    <a href="<?= base_url('/jurnal') ?>" style="display: flex; align-items: center; gap: 12px; padding: 12px 15px; border-radius: 8px; text-decoration: none; color: #e2e8f0; font-size: 14px; font-weight: 600; margin-bottom: 5px; transition: all 0.3s; border-left: 3px solid transparent;" onmouseover="this.style.background='rgba(255,255,255,0.1)'; this.style.borderLeftColor='#60a5fa'; this.style.paddingLeft='20px'; this.style.color='white';" onmouseout="this.style.background='transparent'; this.style.borderLeftColor='transparent'; this.style.paddingLeft='15px'; this.style.color='#e2e8f0';">
        <i class="bi bi-journal-text" style="font-size: 18px;"></i> Jurnal Aktivitas
    </a>
    
    <a href="<?= base_url('/presensi') ?>" style="display: flex; align-items: center; gap: 12px; padding: 12px 15px; border-radius: 8px; text-decoration: none; color: #e2e8f0; font-size: 14px; font-weight: 600; margin-bottom: 5px; transition: all 0.3s; border-left: 3px solid transparent;" onmouseover="this.style.background='rgba(255,255,255,0.1)'; this.style.borderLeftColor='#60a5fa'; this.style.paddingLeft='20px'; this.style.color='white';" onmouseout="this.style.background='transparent'; this.style.borderLeftColor='transparent'; this.style.paddingLeft='15px'; this.style.color='#e2e8f0';">
        <i class="bi bi-geo-alt-fill" style="font-size: 18px;"></i> Presensi
    </a>
    
    <a href="<?= base_url('/chat') ?>" style="display: flex; align-items: center; gap: 12px; padding: 12px 15px; border-radius: 8px; text-decoration: none; color: #e2e8f0; font-size: 14px; font-weight: 600; margin-bottom: 5px; transition: all 0.3s; border-left: 3px solid transparent;" onmouseover="this.style.background='rgba(255,255,255,0.1)'; this.style.borderLeftColor='#60a5fa'; this.style.paddingLeft='20px'; this.style.color='white';" onmouseout="this.style.background='transparent'; this.style.borderLeftColor='transparent'; this.style.paddingLeft='15px'; this.style.color='#e2e8f0';">
        <i class="bi bi-chat-dots-fill" style="font-size: 18px;"></i> Chat
    </a>

    <!-- KHUSUS ADMIN -->
    <?php if (session()->get('role') == 'admin' || session()->get('role') == 'petugas') : ?>
        <p style="font-size: 10px; font-weight: 800; color: #94a3b8; letter-spacing: 1px; margin: 25px 0 15px 0; padding-left: 10px;">ADMIN PANEL</p>
        
        <a href="<?= base_url('/users') ?>" style="display: flex; align-items: center; gap: 12px; padding: 12px 15px; border-radius: 8px; text-decoration: none; color: #e2e8f0; font-size: 14px; font-weight: 600; margin-bottom: 5px; transition: all 0.3s; border-left: 3px solid transparent;" onmouseover="this.style.background='rgba(255,255,255,0.1)'; this.style.borderLeftColor='#60a5fa'; this.style.paddingLeft='20px'; this.style.color='white';" onmouseout="this.style.background='transparent'; this.style.borderLeftColor='transparent'; this.style.paddingLeft='15px'; this.style.color='#e2e8f0';">
            <i class="bi bi-people-fill" style="font-size: 18px;"></i> Data Users
        </a>
        
        <a href="<?= base_url('/presensi/rekap') ?>" style="display: flex; align-items: center; gap: 12px; padding: 12px 15px; border-radius: 8px; text-decoration: none; color: #e2e8f0; font-size: 14px; font-weight: 600; margin-bottom: 5px; transition: all 0.3s; border-left: 3px solid transparent;" onmouseover="this.style.background='rgba(255,255,255,0.1)'; this.style.borderLeftColor='#60a5fa'; this.style.paddingLeft='20px'; this.style.color='white';" onmouseout="this.style.background='transparent'; this.style.borderLeftColor='transparent'; this.style.paddingLeft='15px'; this.style.color='#e2e8f0';">
            <i class="bi bi-clipboard-data-fill" style="font-size: 18px;"></i> Rekap Presensi
        </a>
    <?php endif; ?>

    <!-- TIM & AKUN -->
    <p style="font-size: 10px; font-weight: 800; color: #94a3b8; letter-spacing: 1px; margin: 25px 0 15px 0; padding-left: 10px;">TIM & AKUN</p>
    
    <a href="<?= base_url('/users/edit/'.session()->get('id')) ?>" style="display: flex; align-items: center; gap: 12px; padding: 12px 15px; border-radius: 8px; text-decoration: none; color: #e2e8f0; font-size: 14px; font-weight: 600; margin-bottom: 5px; transition: all 0.3s; border-left: 3px solid transparent;" onmouseover="this.style.background='rgba(255,255,255,0.1)'; this.style.borderLeftColor='#60a5fa'; this.style.paddingLeft='20px'; this.style.color='white';" onmouseout="this.style.background='transparent'; this.style.borderLeftColor='transparent'; this.style.paddingLeft='15px'; this.style.color='#e2e8f0';">
        <i class="bi bi-person-circle" style="font-size: 18px;"></i> Profil Saya
    </a>

    <!-- KARTU MOTIVASI -->
    <div style="margin-top: auto; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.05); border-radius: 12px; padding: 15px; display: flex; gap: 12px; align-items: flex-start; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        <div style="width: 30px; height: 30px; background: #f59e0b; border-radius: 8px; display: flex; justify-content: center; align-items: center; color: #0f172a; flex-shrink: 0;"><i class="bi bi-stars"></i></div>
        <div>
            <h4 style="margin: 0 0 5px 0; font-size: 13px; font-weight: 800; color: white;">Jaga ritme belajarmu</h4>
            <p style="margin: 0; font-size: 11px; color: #cbd5e1; line-height: 1.4;">Disiplin hari ini adalah portofolio besok.</p>
        </div>
    </div>
</div>