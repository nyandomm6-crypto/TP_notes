<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $title ?? 'Gestion des notes' ?> — SysInfo</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>" />
</head>

<body>

    <div class="app">

        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-brand">
                <div class="logo-icon">
                    <svg viewBox="0 0 24 24" width="18" height="18">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                    </svg>
                </div>
                <div>
                    <div class="brand-name">SysInfo</div>
                    <div class="brand-sub">Gestion notes v1.0</div>
                </div>
            </div>

            <div class="sidebar-section">Navigation</div>

            <a href="<?= base_url('/dashboard') ?>" class="nav-item <?= (current_url() == base_url('/dashboard')) ? 'active' : '' ?>">
                <svg viewBox="0 0 24 24">
                    <rect width="7" height="9" x="3" y="3" rx="1" />
                    <rect width="7" height="5" x="14" y="3" rx="1" />
                    <rect width="7" height="9" x="14" y="12" rx="1" />
                    <rect width="7" height="5" x="3" y="16" rx="1" />
                </svg>
                Tableau de bord
            </a>

            <a href="<?= base_url('/etudiant') ?>" class="nav-item <?= (current_url() == base_url('/etudiant') || strpos(current_url(), '/etudiant') !== false) ? 'active' : '' ?>">
                <svg viewBox="0 0 24 24">
                    <line x1="8" y1="6" x2="21" y2="6" />
                    <line x1="8" y1="12" x2="21" y2="12" />
                    <line x1="8" y1="18" x2="21" y2="18" />
                    <line x1="3" y1="6" x2="3.01" y2="6" />
                    <line x1="3" y1="12" x2="3.01" y2="12" />
                    <line x1="3" y1="18" x2="3.01" y2="18" />
                </svg>
                Étudiants
                <span class="nav-badge"><?= $total_etudiants ?? '0' ?></span>
            </a>

            <a href="<?= base_url('/notes') ?>" class="nav-item">
                <svg viewBox="0 0 24 24">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                </svg>
                Notes
            </a>

            <a href="<?= base_url('/bulletin') ?>" class="nav-item">
                <svg viewBox="0 0 24 24">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                </svg>
                Bulletin
            </a>

            <div class="sidebar-section">Modules</div>

            <a href="<?= base_url('/matieres') ?>" class="nav-item">
                <svg viewBox="0 0 24 24">
                    <path d="M3 3h7v7H3zM14 3h7v7h-7zM14 14h7v7h-7zM3 14h7v7H3z" />
                </svg>
                Matières
            </a>

            <a href="<?= base_url('/parcours') ?>" class="nav-item">
                <svg viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="3" />
                    <path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14" />
                </svg>
                Parcours
            </a>

            <div class="sidebar-section">Système</div>

            <a href="<?= base_url('/parametres') ?>" class="nav-item">
                <svg viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="3" />
                    <path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14" />
                </svg>
                Paramètres
            </a>

            <div class="sidebar-bottom">
                <a href="<?= base_url('/auth/logout') ?>" class="user-row">
                    <div class="avatar"><?= strtoupper(substr(session()->get('username') ?? 'AD', 0, 2)) ?></div>
                    <div class="user-info">
                        <div class="name"><?= session()->get('username') ?? 'Admin Sys' ?></div>
                        <div class="role"><?= session()->get('role') ?? 'Super administrateur' ?></div>
                    </div>
                </a>
            </div>
        </aside>

        <!-- Main content -->
        <div class="main">
            <div class="topbar">
                <div class="topbar-title"><?= $title ?? 'Dashboard' ?></div>
                <div class="topbar-search">
                    <svg viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    </svg>
                    <input type="text" placeholder="Rechercher…" id="globalSearch" />
                </div>
                <div class="topbar-actions">
                    <button class="icon-btn">
                        <svg viewBox="0 0 24 24">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                            <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                        </svg>
                        <span class="notif-dot"></span>
                    </button>
                    <button class="icon-btn">
                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="8" r="4" />
                            <path d="M20 21a8 8 0 1 0-16 0" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="content">