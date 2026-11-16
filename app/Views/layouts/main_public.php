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
    
    <!-- ANIMASI AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'DM Sans', sans-serif;
            background-color: #f8fafc;
        }

        /* NAVBAR PUBLIK */
        .navbar-public {
            background: #0f172a; /* Warna gelap */
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .navbar-brand { color: white; font-size: 22px; font-weight: 800; text-decoration: none; letter-spacing: 1px; }
        .navbar-brand span { color: #3b82f6; }
        .navbar-menu { display: flex; gap: 20px; align-items: center; }
        .navbar-menu a { color: #cbd5e1; text-decoration: none; font-size: 14px; font-weight: 500; transition: 0.3s; }
        .navbar-menu a:hover { color: #60a5fa; }
        .btn-login { background: #3b82f6; color: white !important; padding: 8px 20px; border-radius: 8px; font-weight: bold !important; }
        .btn-login:hover { background: #2563eb; transform: translateY(-2px); }

        /* KONTEN */
        main { min-height: calc(100vh - 140px); }
        
        /* FOOTER */
        .footer-public { background: #0f172a; color: #94a3b8; text-align: center; padding: 20px; font-size: 13px; }
    </style>
</head>
<body>

    <!-- NAVBAR PUBLIK (Tanpa Sidebar) -->
    <nav class="navbar-public">
        <a href="<?= base_url('/') ?>" class="navbar-brand">Tim466<span>App</span></a>
        
        <div class="navbar-menu">
            <?php if(session()->get('logged_in')): ?>
                <a href="<?= base_url('/dashboard') ?>" class="btn-login" style="background: #10b981;">Dashboard</a>
            <?php else: ?>
                <a href="<?= base_url('/login') ?>" class="btn-login">Sign In</a>
            <?php endif; ?>
        </div>
    </nav>
    
    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <!-- FOOTER -->
    <footer class="footer-public">
        <p>&copy; <?= date('Y') ?> Tim466App - Jurnal Kerja PKL. All Rights Reserved.</p>
    </footer>

    <!-- JAVASCRIPT -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true });
    </script>
</body>
</html>