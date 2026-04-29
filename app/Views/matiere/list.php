<!-- Matière List View -->
<div class="content">
    <div class="page-header">
        <div>
            <h1 class="page-title"><?= $title ?? 'Gestion des matières' ?></h1>
            <p class="page-subtitle">Liste de toutes les matières disponibles</p>
        </div>
        <div class="page-actions">
            <a href="<?= base_url('matiere/create') ?>" class="btn btn-primary">
                <svg viewBox="0 0 24 24" width="18" height="18">
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                </svg>
                Ajouter une matière
            </a>
        </div>
    </div>

    <!-- Messages d'alerte -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <svg viewBox="0 0 24 24" width="18" height="18">
                <polyline points="20 6 9 17 4 12" />
            </svg>
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error">
            <svg viewBox="0 0 24 24" width="18" height="18">
                <circle cx="12" cy="12" r="10" />
                <line x1="15" y1="9" x2="9" y2="15" />
                <line x1="9" y1="9" x2="15" y2="15" />
            </svg>
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Filtres et recherche -->
    <div class="card">
        <div class="card-header">Filtres et recherche</div>
        <div class="card-body">
            <form method="GET" class="filter-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="search">Rechercher</label>
                        <input type="text" id="search" name="search" placeholder="Code ou intitulé..."
                            value="<?= htmlspecialchars($search ?? '') ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="semestre">Semestre</label>
                        <select id="semestre" name="semestre" class="form-control">
                            <option value="">-- Tous les semestres --</option>
                            <?php foreach ($semestres ?? [] as $sem): ?>
                                <option value="<?= $sem['semestre'] ?>"
                                    <?= ($filteredSemestre == $sem['semestre']) ? 'selected' : '' ?>>
                                    Semestre <?= $sem['semestre'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="parcours">Parcours</label>
                        <select id="parcours" name="parcours" class="form-control">
                            <option value="">-- Tous les parcours --</option>
                            <?php foreach ($parcours ?? [] as $p): ?>
                                <option value="<?= $p['id'] ?>"
                                    <?= ($filteredParcours == $p['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($p['libelle']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-secondary">
                        <svg viewBox="0 0 24 24" width="16" height="16">
                            <circle cx="11" cy="11" r="8" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" />
                        </svg>
                        Filtrer
                    </button>
                    <a href="<?= base_url('matiere') ?>" class="btn btn-tertiary">Réinitialiser</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tableau des matières -->
    <div class="card">
        <div class="card-header">
            Matières (<?= count($matieres ?? []) ?>)
        </div>
        <div class="card-body">
            <?php if (empty($matieres)): ?>
                <div class="empty-state">
                    <svg viewBox="0 0 24 24" width="48" height="48">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                    </svg>
                    <h3>Aucune matière trouvée</h3>
                    <p>Commencez par <a href="<?= base_url('matiere/create') ?>">ajouter une nouvelle matière</a></p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Intitulé</th>
                                <th>Semestre</th>
                                <th>Crédits</th>
                                <th>Parcours</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($matieres as $matiere): ?>
                                <tr>
                                    <td>
                                        <span class="badge badge-primary"><?= htmlspecialchars($matiere['code']) ?></span>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('matiere/show/' . $matiere['id']) ?>" class="table-link">
                                            <?= htmlspecialchars($matiere['intitule']) ?>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">S<?= $matiere['semestre'] ?></span>
                                    </td>
                                    <td>
                                        <strong><?= $matiere['credits'] ?> ECTS</strong>
                                    </td>
                                    <td>
                                        <?php if ($matiere['parcours_id']): ?>
                                            <a href="<?= base_url('matiere/filter/' . $matiere['parcours_id']) ?>" class="table-link">
                                                <?= htmlspecialchars($matiere['parcours_libelle']) ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">Commun</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-right">
                                        <div class="action-buttons">
                                            <a href="<?= base_url('matiere/edit/' . $matiere['id']) ?>" class="btn btn-sm btn-secondary" title="Modifier">
                                                <svg viewBox="0 0 24 24" width="16" height="16">
                                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                </svg>
                                                Modifier
                                            </a>
                                            <form method="POST" action="<?= base_url('matiere/delete/' . $matiere['id']) ?>" class="inline-form" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette matière ?');">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                                    <svg viewBox="0 0 24 24" width="16" height="16">
                                                        <polyline points="3 6 5 6 21 6" />
                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                                    </svg>
                                                    Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .filter-form {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #333;
    }

    .form-control {
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 0.95rem;
    }

    .form-actions {
        display: flex;
        gap: 0.5rem;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table thead {
        background-color: #f5f5f5;
        border-bottom: 2px solid #ddd;
    }

    .table th {
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        color: #666;
    }

    .table td {
        padding: 1rem;
        border-bottom: 1px solid #eee;
    }

    .table tbody tr:hover {
        background-color: #fafafa;
    }

    .table-link {
        color: #0066cc;
        text-decoration: none;
        font-weight: 500;
    }

    .table-link:hover {
        text-decoration: underline;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: flex-end;
    }

    .inline-form {
        display: inline;
    }

    .badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .badge-primary {
        background-color: #e3f2fd;
        color: #1976d2;
    }

    .badge-secondary {
        background-color: #f0f0f0;
        color: #666;
    }

    .badge-info {
        background-color: #e0f2f1;
        color: #00796b;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #999;
    }

    .empty-state svg {
        opacity: 0.3;
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        color: #666;
        margin-bottom: 0.5rem;
    }

    .alert {
        padding: 1rem;
        border-radius: 4px;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .text-right {
        text-align: right;
    }
</style>