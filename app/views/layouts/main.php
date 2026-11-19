<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'FerroStock — Sistema de Inventario' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,500;0,9..40,700;1,9..40,300&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg-body: #e8e0d4;
            --bg-sidebar: #292524;
            --accent: #d97706;
            --accent-hover: #b45309;
            --text-dark: #292524;
            --text-light: #faf8f5;
            --text-muted: #78716c;
            --border-color: #d6cfc4;
            --font-main: 'DM Sans', sans-serif;
            --font-mono: 'Space Mono', monospace;
        }

        body {
            font-family: var(--font-main);
            background: var(--bg-body);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
        }

        /* Pegboard pattern background */
        body::before {
            content: '';
            position: fixed; inset: 0;
            background-image: radial-gradient(circle, #c4b9a8 1.2px, transparent 1.2px);
            background-size: 26px 26px;
            opacity: .45;
            pointer-events: none;
            z-index: 0;
        }

        /* Caution Tape */
        .tape {
            position: fixed; top: 0; left: 0; right: 0;
            height: 5px; z-index: 1000;
            background: repeating-linear-gradient(
                -55deg,
                var(--accent), var(--accent) 10px,
                var(--bg-sidebar) 10px, var(--bg-sidebar) 20px
            );
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: var(--bg-sidebar);
            color: var(--text-light);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; bottom: 0; left: 0;
            z-index: 100;
            transition: transform .3s ease;
        }

        .sidebar-header {
            padding: 32px 24px;
            border-bottom: 1px solid rgba(255,255,255,.05);
        }

        .logo-stamp {
            display: inline-block;
            border: 2px solid var(--text-light);
            padding: 6px 12px;
            transform: rotate(-2deg);
        }
        .logo-text {
            font-family: var(--font-mono);
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .logo-text span { color: var(--accent); }

        .nav-menu {
            flex: 1;
            padding: 24px 16px;
            list-style: none;
        }

        .nav-item { margin-bottom: 8px; }
        
        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-radius: 4px;
            transition: all .2s;
            font-family: var(--font-mono);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 12px;
        }

        .nav-link i { font-size: 16px; width: 20px; text-align: center; }
        
        .nav-link:hover, .nav-link.active {
            background: rgba(217,119,6,.1);
            color: var(--accent);
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid rgba(255,255,255,.05);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .user-avatar {
            width: 32px; height: 32px;
            background: var(--accent);
            color: var(--bg-sidebar);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-family: var(--font-mono);
            border-radius: 2px;
        }

        .user-details { overflow: hidden; }
        .user-name { font-size: 13px; font-weight: 700; color: var(--text-light); white-space: nowrap; text-overflow: ellipsis; overflow: hidden; }
        .user-role { font-size: 10px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; }

        .btn-logout {
            width: 100%;
            padding: 10px;
            background: rgba(220,38,38,.1);
            color: #fca5a5;
            border: 1px solid rgba(220,38,38,.2);
            font-family: var(--font-mono);
            font-size: 10px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all .2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-logout:hover { background: #dc2626; color: white; }

        /* Main Content */
        .main-wrapper {
            flex: 1;
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 1;
        }

        .topbar {
            height: 64px;
            padding: 0 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(250, 248, 245, 0.8);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0; z-index: 50;
        }

        .page-title {
            font-family: var(--font-mono);
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--text-muted);
        }

        .page-content {
            padding: 40px;
            flex: 1;
        }

        /* UI Elements - Common */
        .card {
            background: var(--text-light);
            border: 1px solid var(--border-color);
            border-left: 4px solid var(--bg-sidebar);
            padding: 24px;
            margin-bottom: 24px;
            position: relative;
        }

        .card-title {
            font-family: var(--font-mono);
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--text-muted);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            font-family: var(--font-mono);
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all .2s;
            border-radius: 2px;
            border: none;
            text-decoration: none;
        }

        .btn-primary { background: var(--accent); color: var(--bg-sidebar); }
        .btn-primary:hover { background: var(--accent-hover); }

        .btn-secondary { background: var(--bg-sidebar); color: var(--text-light); }
        .btn-secondary:hover { opacity: .9; }

        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        th {
            text-align: left;
            padding: 12px 16px;
            background: #f5f0ea;
            font-family: var(--font-mono);
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            border-bottom: 2px solid var(--border-color);
        }

        td {
            padding: 16px;
            border-bottom: 1px dashed var(--border-color);
            vertical-align: middle;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            font-size: 10px;
            font-family: var(--font-mono);
            font-weight: 700;
            text-transform: uppercase;
            border-radius: 2px;
        }

        .badge-success { background: rgba(21,128,61,.1); color: #15803d; }
        .badge-warning { background: rgba(217,119,6,.1); color: #d97706; }
        .badge-danger { background: rgba(220,38,38,.1); color: #dc2626; }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .main-wrapper { margin-left: 0; }
            .topbar { padding: 0 20px; }
            .page-content { padding: 20px; }
        }
    </style>
</head>
<body>
    <div class="tape"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo-stamp">
                <div class="logo-text">FERRO<span>STOCK</span></div>
            </div>
        </div>

        <nav class="nav-menu">
            <ul>
                <li class="nav-item">
                    <a href="<?= BASE_URL ?>index.php?route=dashboard" class="nav-link <?= $_GET['route'] == 'dashboard' ? 'active' : '' ?>">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= BASE_URL ?>index.php?route=inventory" class="nav-link <?= strpos($_GET['route'], 'inventory') !== false ? 'active' : '' ?>">
                        <i class="fas fa-boxes"></i> Inventario
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= BASE_URL ?>index.php?route=billing" class="nav-link <?= strpos($_GET['route'], 'billing') !== false ? 'active' : '' ?>">
                        <i class="fas fa-file-invoice-dollar"></i> Facturación
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= BASE_URL ?>index.php?route=history" class="nav-link <?= $_GET['route'] == 'history' ? 'active' : '' ?>">
                        <i class="fas fa-history"></i> Historial
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= BASE_URL ?>index.php?route=reports" class="nav-link <?= $_GET['route'] == 'reports' ? 'active' : '' ?>">
                        <i class="fas fa-chart-bar"></i> Reportes
                    </a>
                </li>
            </ul>
        </nav>

        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar"><?= strtoupper(substr($_SESSION['user']['nombre'], 0, 1)) ?></div>
                <div class="user-details">
                    <div class="user-name"><?= $_SESSION['user']['nombre'] ?></div>
                    <div class="user-role"><?= $_SESSION['user']['role'] ?></div>
                </div>
            </div>
            <a href="<?= BASE_URL ?>index.php?route=logout" class="btn-logout">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
            </a>
        </div>
    </aside>

    <main class="main-wrapper">
        <header class="topbar">
            <h2 class="page-title"><?= $title ?? 'Sistema FerroStock' ?></h2>
            <div class="topbar-actions">
                <span id="current-date" style="font-family: var(--font-mono); font-size: 11px; color: var(--text-muted);"><?= date('d/m/Y') ?></span>
            </div>
        </header>

        <section class="page-content">
            <?= $content ?>
        </section>
    </main>

    <script>
        // Simple toggle sidebar for mobile if needed
        // For now, let's keep it simple.
    </script>
</body>
</html>
