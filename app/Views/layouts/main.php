<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Tim466App' ?></title>

    <!-- FONT & ICON -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- LIBRARY ANIMASI AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 260px;
            --topbar-height: 70px;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'DM Sans', sans-serif;
            background-color: #f8fafc;
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* SIDEBAR KIRI (BIRU GRADASI) */
        .sidebar-wrapper {
            width: var(--sidebar-width);
            /* Gradasi Biru Gelap ke Hitam */
            background: linear-gradient(180deg, #1e3a8a 0%, #0f172a 100%);
            flex-shrink: 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 4px 0 15px rgba(0,0,0,0.1);
        }
        .sidebar-wrapper.collapsed {
            width: 0;
            padding: 0;
            overflow: hidden;
        }

        /* KONTEN KANAN */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: all 0.3s ease;
            width: calc(100% - var(--sidebar-width));
        }
        .main-wrapper.expanded {
            margin-left: 0;
            width: 100%;
        }

        /* TOP BAR */
        .topbar {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            height: var(--topbar-height);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 900;
        }

        .menu-toggle-btn {
            background: none;
            border: none;
            font-size: 24px;
            color: #0f172a;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: 0.2s;
        }
        .menu-toggle-btn:hover { color: #3b82f6; }

        .topbar-title h4 { margin: 0; font-size: 12px; font-weight: 700; color: #1e3a8a; letter-spacing: 1px; }
        .topbar-title h2 { margin: 2px 0 0 0; font-size: 22px; font-weight: 800; color: #0f172a; }

        .topbar-right { display: flex; align-items: center; gap: 20px; }
        .topbar-date { display: flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 600; color: #1e3a8a; }
        
        /* NOTIFIKASI & PROFIL */
        .dropdown-container { position: relative; }
        .notif-icon { width: 42px; height: 42px; border: 1px solid #e2e8f0; border-radius: 12px; display: flex; justify-content: center; align-items: center; font-size: 18px; color: #64748b; cursor: pointer; position: relative; transition: 0.2s; background: white; }
        .notif-icon:hover { background: #f1f5f9; border-color: #cbd5e1; }
        .notif-dot { position: absolute; top: 10px; right: 12px; width: 8px; height: 8px; background: #ef4444; border-radius: 50%; border: 2px solid white; }

        .topbar-profile { display: flex; align-items: center; gap: 12px; cursor: pointer; padding: 5px 10px; border-radius: 10px; transition: 0.2s; border: 1px solid transparent; }
        .topbar-profile:hover { background: white; border-color: #e2e8f0; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .topbar-profile img { width: 42px; height: 42px; border-radius: 50%; object-fit: cover; border: 2px solid #3b82f6; }
        .profile-info h5 { margin: 0; font-size: 14px; font-weight: 800; color: #0f172a; }
        .profile-info p { margin: 0; font-size: 11px; font-weight: 600; color: #64748b; }

        .dropdown-menu-custom { display: none; position: absolute; top: 55px; right: 0; background: white; border: 1px solid #e2e8f0; border-radius: 10px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); min-width: 200px; z-index: 1000; overflow: hidden; }
        .dropdown-menu-custom.show { display: block; animation: fadeIn 0.2s ease; }
        .dropdown-menu-custom a { display: block; padding: 12px 20px; text-decoration: none; color: #334155; font-size: 14px; font-weight: 600; border-bottom: 1px solid #f1f5f9; transition: 0.2s; }
        .dropdown-menu-custom a:hover { background: #f8fafc; color: #3b82f6; padding-left: 25px; }
        .dropdown-menu-custom a:last-child { border-bottom: none; }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

        /* AREA KONTEN */
        .content-area { padding: 30px; flex: 1; }
    </style>
</head>
<body>

    <!-- 1. SIDEBAR (Menu Kiri) -->
    <div class="sidebar-wrapper" id="sidebar">
        <?= $this->include('layouts/menu') ?>
    </div>
    
    <!-- 2. AREA KANAN -->
    <div class="main-wrapper" id="mainWrapper">
        
        <!-- TOP BAR -->
        <div class="topbar">
            <div style="display: flex; align-items: center; gap: 15px;">
                <button class="menu-toggle-btn" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
                <div class="topbar-title">
                    <h4>SANTRUY CORPORATION</h4>
                    <h2><?= $title ?? 'Dashboard' ?></h2>
                </div>
            </div>
            
            <div class="topbar-right">
                <!-- Tanggal -->
                <div class="topbar-date">
                    <i class="bi bi-calendar3"></i> <?= date('l, d F Y') ?>
                </div>
                
                <!-- Notifikasi -->
                <div class="dropdown-container">
                    <div class="notif-icon" onclick="toggleDropdown('notifDropdown')">
                        <i class="bi bi-bell"></i>
                        <span class="notif-dot"></span>
                    </div>
                    <div class="dropdown-menu-custom" id="notifDropdown">
                        <a href="#" style="font-size: 12px; color: #64748b; background: #f8fafc;">Notifikasi (1)</a>
                        <a href="<?= base_url('/jurnal/verifikasi') ?>"><i class="bi bi-journal-text" style="color: #3b82f6; margin-right: 8px;"></i> Ada jurnal baru!</a>
                    </div>
                </div>
                
                <!-- Profil -->
                <div class="dropdown-container">
                    <div class="topbar-profile" onclick="toggleDropdown('profileDropdown')">
                        <?php if(session()->get('foto')): ?>
                            <img src="<?= base_url('uploads/users/'.session()->get('foto')) ?>" alt="Profile">
                        <?php else: ?>
                            <img src="https://ui-avatars.com/api/?name=<?= urlencode(session()->get('nama')) ?>&background=3b82f6&color=fff" alt="Profile">
                        <?php endif; ?>
                        <div class="profile-info">
                            <h5><?= session()->get('nama') ?></h5>
                            <p><?= strtoupper(session()->get('role')) ?> · TIM 466</p>
                        </div>
                        <i class="bi bi-chevron-down" style="font-size: 12px; color: #64748b; margin-left: 5px;"></i>
                    </div>
                    
                    <div class="dropdown-menu-custom" id="profileDropdown">
                        <a href="<?= base_url('/users/edit/'.session()->get('id')) ?>"><i class="bi bi-gear" style="margin-right: 8px; color: #3b82f6;"></i> Pengaturan Profil</a>
                        <a href="<?= base_url('/logout') ?>" style="color: #ef4444;"><i class="bi bi-box-arrow-right" style="margin-right: 8px;"></i> Log Out</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- KONTEN HALAMAN -->
        <div class="content-area">
            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true });

        // Buka/Tutup Sidebar
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('collapsed');
            document.getElementById('mainWrapper').classList.toggle('expanded');
        }

        // Buka/Tutup Dropdown
        function toggleDropdown(id) {
            document.querySelectorAll('.dropdown-menu-custom').forEach(el => {
                if(el.id !== id) el.classList.remove('show');
            });
            document.getElementById(id).classList.toggle('show');
        }

        // Tutup dropdown klik di luar
        window.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown-container')) {
                document.querySelectorAll('.dropdown-menu-custom').forEach(el => {
                    el.classList.remove('show');
                });
            }
        });
    </script>
</body>
</html>