<!-- Matière Show/Detail View -->
<div class="content">
    <div class="page-header">
        <div>
            <h1 class="page-title"><?= htmlspecialchars($matiere['intitule']) ?></h1>
            <p class="page-subtitle">Détails de la matière</p>
        </div>
        <div class="page-actions">
            <a href="<?= base_url('matiere/edit/' . $matiere['id']) ?>" class="btn btn-secondary">
                <svg viewBox="0 0 24 24" width="18" height="18">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                </svg>
                Modifier
            </a>
            <a href="<?= base_url('matiere') ?>" class="btn btn-tertiary">
                <svg viewBox="0 0 24 24" width="18" height="18">
                    <line x1="19" y1="12" x2="5" y2="12" />
                    <polyline points="12 19 5 12 12 5" />
                </svg>
                Retour
            </a>
        </div>
    </div>

    <div class="details-grid">
        <!-- Informations principales -->
        <div class="card">
            <div class="card-header">Informations générales</div>
            <div class="card-body">
                <div class="detail-item">
                    <label>Code matière</label>
                    <span class="badge badge-primary"><?= htmlspecialchars($matiere['code']) ?></span>
                </div>

                <div class="detail-item">
                    <label>Intitulé</label>
                    <p><?= htmlspecialchars($matiere['intitule']) ?></p>
                </div>

                <div class="detail-item">
                    <label>Semestre</label>
                    <span class="badge badge-info">S<?= $matiere['semestre'] ?></span>
                </div>

                <div class="detail-item">
                    <label>Crédits ECTS</label>
                    <strong><?= $matiere['credits'] ?> crédits</strong>
                </div>

                <div class="detail-item">
                    <label>Parcours</label>
                    <?php if ($matiere['parcours_id']): ?>
                        <a href="<?= base_url('matiere/filter/' . $matiere['parcours_id']) ?>" class="detail-link">
                            <?= htmlspecialchars($matiere['parcours_libelle']) ?>
                        </a>
                    <?php else: ?>
                        <span class="badge badge-secondary">Commun (tous les parcours)</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Dates -->
        <div class="card">
            <div class="card-header">Historique</div>
            <div class="card-body">
                <div class="detail-item">
                    <label>Créé le</label>
                    <p><?= isset($matiere['created_at']) ? date('d/m/Y H:i', strtotime($matiere['created_at'])) : 'N/A' ?></p>
                </div>

                <div class="detail-item">
                    <label>Modifié le</label>
                    <p><?= isset($matiere['updated_at']) ? date('d/m/Y H:i', strtotime($matiere['updated_at'])) : 'N/A' ?></p>
                </div>

                <div class="detail-item">
                    <label>ID</label>
                    <code><?= $matiere['id'] ?></code>
                </div>
            </div>
        </div>
    </div>

    <!-- Zone de danger -->
    <div class="card danger-zone">
        <div class="card-header">Zone de danger</div>
        <div class="card-body">
            <p>La suppression de cette matière est définitive et ne peut pas être annulée.</p>
            <form method="POST" action="<?= base_url('matiere/delete/' . $matiere['id']) ?>"
                onsubmit="return confirm('Êtes-vous absolument sûr de vouloir supprimer cette matière ?');"
                class="inline-form">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="btn btn-danger">
                    <svg viewBox="0 0 24 24" width="18" height="18">
                        <polyline points="3 6 5 6 21 6" />
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                        <line x1="10" y1="11" x2="10" y2="17" />
                        <line x1="14" y1="11" x2="14" y2="17" />
                    </svg>
                    Supprimer cette matière
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    .details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .detail-item {
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #eee;
    }

    .detail-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .detail-item label {
        display: block;
        font-weight: 600;
        color: #666;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    .detail-item p {
        margin: 0;
        color: #333;
        font-size: 0.95rem;
    }

    .detail-item code {
        background-color: #f4f4f4;
        padding: 0.25rem 0.5rem;
        border-radius: 3px;
        font-family: 'Courier New', monospace;
        font-size: 0.85rem;
    }

    .detail-link {
        color: #0066cc;
        text-decoration: none;
        font-weight: 500;
    }

    .detail-link:hover {
        text-decoration: underline;
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

    .danger-zone {
        border: 2px solid #d32f2f;
    }

    .danger-zone .card-header {
        background-color: #ffebee;
        color: #c62828;
    }

    .danger-zone .card-body {
        background-color: #fff5f5;
    }

    .danger-zone p {
        margin-bottom: 1rem;
        color: #c62828;
    }

    .inline-form {
        display: inline;
    }

    @media (max-width: 768px) {
        .details-grid {
            grid-template-columns: 1fr;
        }
    }
</style>