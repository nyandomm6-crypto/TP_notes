<!-- Matière Form View -->
<div class="content">
    <div class="page-header">
        <div>
            <h1 class="page-title"><?= $title ?? 'Formulaire matière' ?></h1>
            <p class="page-subtitle"><?= isset($matiere) ? 'Modifiez les informations de la matière' : 'Ajoutez une nouvelle matière au système' ?></p>
        </div>
    </div>

    <!-- Card formulaire -->
    <div class="form-card">
        <div class="card-header">
            <?= isset($matiere) ? 'Modifier une matière' : 'Ajouter une matière' ?>
        </div>
        <div class="card-body">
            <form method="POST"
                action="<?= isset($matiere) ? base_url('matiere/update/' . $matiere['id']) : base_url('matiere/store') ?>"
                class="form-layout">

                <?php if (isset($matiere)): ?>
                    <input type="hidden" name="_method" value="POST">
                <?php endif; ?>

                <!-- Affichage des erreurs de validation -->
                <?php if (isset($validation) && $errors = $validation->getErrors()): ?>
                    <div class="alert alert-error">
                        <svg viewBox="0 0 24 24" width="20" height="20">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                        <div>
                            <strong>Erreurs de validation :</strong>
                            <ul style="margin-top: 0.5rem;">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= htmlspecialchars($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Grille de formulaire -->
                <div class="form-grid">
                    <!-- Code matière -->
                    <div class="form-group">
                        <label for="code">Code matière <span class="required">*</span></label>
                        <input type="text"
                            id="code"
                            name="code"
                            class="form-control"
                            placeholder="Ex: MATH101"
                            value="<?= htmlspecialchars(old('code', $matiere['code'] ?? '')) ?>"
                            required
                            maxlength="10">
                        <small class="form-help">Identifiant unique de la matière (2-10 caractères)</small>
                    </div>

                    <!-- Semestre -->
                    <div class="form-group">
                        <label for="semestre">Semestre <span class="required">*</span></label>
                        <select id="semestre" name="semestre" class="form-control" required>
                            <option value="">-- Sélectionner un semestre --</option>
                            <?php for ($s = 1; $s <= 8; $s++): ?>
                                <option value="<?= $s ?>" <?= (old('semestre', $matiere['semestre'] ?? '') == $s) ? 'selected' : '' ?>>
                                    Semestre <?= $s ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                        <small class="form-help">Session d'enseignement</small>
                    </div>

                    <!-- Crédits -->
                    <div class="form-group">
                        <label for="credits">Crédits ECTS <span class="required">*</span></label>
                        <input type="number"
                            id="credits"
                            name="credits"
                            class="form-control"
                            placeholder="Ex: 3"
                            value="<?= htmlspecialchars(old('credits', $matiere['credits'] ?? '')) ?>"
                            required
                            min="1"
                            max="30">
                        <small class="form-help">Nombre de crédits (1-30)</small>
                    </div>

                    <!-- Parcours -->
                    <div class="form-group form-full">
                        <label for="parcours_id">Parcours</label>
                        <select id="parcours_id" name="parcours_id" class="form-control">
                            <option value="">-- Commun (tous les parcours) --</option>
                            <?php foreach ($parcours ?? [] as $p): ?>
                                <option value="<?= $p['id'] ?>"
                                    <?= (old('parcours_id', $matiere['parcours_id'] ?? '') == $p['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($p['libelle']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="form-help">Laisser vide si la matière est commune à tous les parcours</small>
                    </div>
                </div>

                <!-- Intitulé -->
                <div class="form-group form-full">
                    <label for="intitule">Intitulé de la matière <span class="required">*</span></label>
                    <input type="text"
                        id="intitule"
                        name="intitule"
                        class="form-control"
                        placeholder="Ex: Mathématiques Appliquées"
                        value="<?= htmlspecialchars(old('intitule', $matiere['intitule'] ?? '')) ?>"
                        required
                        maxlength="150">
                    <small class="form-help">Nom complet de la matière (3-150 caractères)</small>
                </div>

                <!-- Boutons d'action -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <svg viewBox="0 0 24 24" width="18" height="18">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                            <polyline points="17 21 17 13 7 13 7 21" />
                            <polyline points="7 3 7 8 15 8" />
                        </svg>
                        <?= isset($matiere) ? 'Mettre à jour' : 'Ajouter la matière' ?>
                    </button>
                    <a href="<?= base_url('matiere') ?>" class="btn btn-tertiary">
                        <svg viewBox="0 0 24 24" width="18" height="18">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Aide contextuelle -->
    <div class="card">
        <div class="card-header">Aide</div>
        <div class="card-body help-content">
            <h4>Guide de remplissage du formulaire</h4>
            <ul>
                <li><strong>Code matière :</strong> Identifiant unique, court et mémorisable (ex: MATH101, PHY201)</li>
                <li><strong>Intitulé :</strong> Nom complet et descriptif de la matière</li>
                <li><strong>Semestre :</strong> Session académique (1-8)</li>
                <li><strong>Crédits ECTS :</strong> Nombre de crédits académiques attribués</li>
                <li><strong>Parcours :</strong> Sélectionnez un parcours ou laissez vide pour une matière commune</li>
            </ul>
            <p class="help-note">Les champs marqués avec <span class="required">*</span> sont obligatoires.</p>
        </div>
    </div>
</div>

<style>
    .form-card {
        margin-bottom: 2rem;
    }

    .form-layout {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.form-full {
        grid-column: 1 / -1;
    }

    .form-group label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #333;
        font-size: 0.95rem;
    }

    .required {
        color: #d32f2f;
        font-weight: bold;
    }

    .form-control {
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 0.95rem;
        font-family: inherit;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: #0066cc;
        box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
    }

    .form-help {
        display: block;
        margin-top: 0.25rem;
        font-size: 0.85rem;
        color: #999;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
    }

    .alert {
        padding: 1rem;
        border-radius: 4px;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
    }

    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .alert-error ul {
        list-style-position: inside;
        margin: 0;
        padding: 0;
    }

    .alert-error ul li {
        margin: 0.25rem 0;
    }

    .help-content {
        background-color: #f5f5f5;
    }

    .help-content h4 {
        margin-top: 0;
        color: #333;
    }

    .help-content ul {
        margin: 1rem 0;
        padding-left: 1.5rem;
    }

    .help-content li {
        margin: 0.5rem 0;
        color: #666;
    }

    .help-note {
        margin-top: 1rem;
        padding: 0.75rem;
        background-color: #e3f2fd;
        border-left: 4px solid #0066cc;
        color: #1565c0;
        margin-bottom: 0;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }
</style>