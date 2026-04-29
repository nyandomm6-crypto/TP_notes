<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Gestion des notes' ?> - SysInfo</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            color: #333;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: #1a1a2e;
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #2d2d44;
        }

        .sidebar-header h3 {
            font-size: 18px;
        }

        .sidebar-header p {
            font-size: 11px;
            color: #888;
            margin-top: 5px;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .menu-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #ccc;
            text-decoration: none;
            transition: all 0.3s;
        }

        .menu-item:hover, .menu-item.active {
            background: #2d2d44;
            color: white;
        }

        .menu-icon {
            width: 20px;
            text-align: center;
        }

        .badge {
            background: #e74c3c;
            color: white;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 10px;
            margin-left: auto;
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid #2d2d44;
            margin-top: auto;
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar {
            width: 40px;
            height: 40px;
            background: #2d2d44;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* Main content */
        .main-content {
            margin-left: 260px;
            flex: 1;
        }

        /* Topbar */
        .topbar {
            background: white;
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-title {
            font-size: 20px;
            font-weight: 600;
        }

        .topbar-search input {
            padding: 8px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 250px;
        }

        .topbar-actions {
            display: flex;
            gap: 10px;
        }

        .icon-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 18px;
            padding: 5px;
            position: relative;
        }

        .notif-dot {
            position: absolute;
            top: 0;
            right: 0;
            width: 8px;
            height: 8px;
            background: red;
            border-radius: 50%;
        }

        /* Content */
        .content {
            padding: 25px;
        }

        /* Page header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .page-header h2 {
            font-size: 24px;
        }

        .breadcrumb {
            color: #666;
            font-size: 13px;
            margin-top: 5px;
        }

        .breadcrumb a {
            color: #3498db;
            text-decoration: none;
        }

        /* Buttons */
        .btn {
            padding: 8px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #3498db;
            color: white;
        }

        .btn-primary:hover {
            background: #2980b9;
        }

        .btn-secondary {
            background: #95a5a6;
            color: white;
        }

        .btn-secondary:hover {
            background: #7f8c8d;
        }

        .btn-danger {
            background: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background: #c0392b;
        }

        .btn-sm {
            padding: 5px 12px;
            font-size: 12px;
        }

        .btn-ghost {
            background: none;
            border: 1px solid #3498db;
            color: #3498db;
        }

        .btn-ghost:hover {
            background: #3498db;
            color: white;
        }

        /* Alert messages */
        .alert {
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Cards */
        .card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
        }

        /* Table */
        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f8f9fa;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #dee2e6;
        }

        tr:hover {
            background: #f8f9fa;
        }

        /* Form */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-group input:focus, .form-group select:focus {
            outline: none;
            border-color: #3498db;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        /* KPI Grid */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .kpi-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .kpi-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .kpi-label {
            color: #666;
            font-size: 12px;
            text-transform: uppercase;
        }

        .kpi-value {
            font-size: 28px;
            font-weight: bold;
            margin: 10px 0;
        }

        .kpi-delta {
            font-size: 12px;
        }

        .kpi-delta.up { color: #27ae60; }
        .kpi-delta.down { color: #e74c3c; }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: 500;
        }

        .badge-success {
            background: #d4edda;
            color: #155724;
        }

        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .badge-warning {
            background: #fff3cd;
            color: #856404;
        }

        .badge-info {
            background: #d1ecf1;
            color: #0c5460;
        }

        /* Toolbar */
        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .search-box {
            display: flex;
            align-items: center;
            gap: 10px;
            background: white;
            padding: 5px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .search-box input {
            border: none;
            padding: 8px 0;
            width: 200px;
        }

        .search-box input:focus {
            outline: none;
        }

        .filter-select {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background: white;
            border-top: 1px solid #dee2e6;
        }

        .page-btns {
            display: flex;
            gap: 5px;
        }

        .page-btn {
            padding: 6px 12px;
            border: 1px solid #ddd;
            background: white;
            cursor: pointer;
        }

        .page-btn.active {
            background: #3498db;
            color: white;
            border-color: #3498db;
        }

        /* Action buttons in table */
        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .action-btn {
            padding: 5px 8px;
            border: none;
            background: none;
            cursor: pointer;
            border-radius: 3px;
        }

        .action-btn.view { background: #3498db; color: white; }
        .action-btn.edit { background: #f39c12; color: white; }
        .action-btn.delete { background: #e74c3c; color: white; }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                z-index: 1000;
            }
            .main-content {
                margin-left: 0;
            }
            .form-row {
                grid-template-columns: 1fr;
            }
            .kpi-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <aside class="sidebar">
        <div class="sidebar-header">
            <h3>📚 SysInfo</h3>
            <p>Gestion des notes v1.0</p>
        </div>
        <nav class="sidebar-menu">
            <a href="<?= base_url('/dashboard') ?>" class="menu-item <?= (current_url() == base_url('/dashboard')) ? 'active' : '' ?>">
                <span class="menu-icon">📊</span> Tableau de bord
            </a>
            <a href="<?= base_url('/etudiant') ?>" class="menu-item <?= (strpos(current_url(), '/etudiant') !== false) ? 'active' : '' ?>">
                <span class="menu-icon">👥</span> Étudiants
                <span class="badge"><?= $total_etudiants ?? '0' ?></span>
            </a>
            <a href="<?= base_url('/notes') ?>" class="menu-item">
                <span class="menu-icon">📝</span> Notes
            </a>
            <a href="<?= base_url('/bulletin') ?>" class="menu-item">
                <span class="menu-icon">📄</span> Bulletin
            </a>
            <a href="<?= base_url('/matieres') ?>" class="menu-item">
                <span class="menu-icon">📖</span> Matières
            </a>
            <a href="<?= base_url('/parcours') ?>" class="menu-item">
                <span class="menu-icon">🎓</span> Parcours
            </a>
            <a href="<?= base_url('/parametres') ?>" class="menu-item">
                <span class="menu-icon">⚙️</span> Paramètres
            </a>
        </nav>
        <div class="sidebar-footer">
            <div class="user-info">
                <div class="avatar"><?= strtoupper(substr(session()->get('username') ?? 'AD', 0, 2)) ?></div>
                <div>
                    <div><strong><?= session()->get('username') ?? 'Admin' ?></strong></div>
                    <div style="font-size: 11px; color:#888"><?= session()->get('role') ?? 'Administrateur' ?></div>
                </div>
            </div>
        </div>
    </aside>

    <div class="main-content">
        <div class="topbar">
            <div class="topbar-title"><?= $title ?? 'Dashboard' ?></div>
            <div class="topbar-search">
                <input type="text" id="globalSearch" placeholder="Rechercher...">
            </div>
            <div class="topbar-actions">
                <button class="icon-btn">
                    🔔
                    <span class="notif-dot"></span>
                </button>
                <button class="icon-btn">
                    👤
                </button>
            </div>
        </div>

        <div class="content">