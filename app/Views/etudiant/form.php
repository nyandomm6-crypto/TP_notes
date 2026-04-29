<div class="page-header">
    <div>
        <h2><?= isset($etudiant) ? 'Modifier' : 'Ajouter' ?> un étudiant</h2>
        <div class="breadcrumb">
            Accueil / <a href="<?= base_url('/etudiant') ?>">Étudiants</a> /
            <span><?= isset($etudiant) ? 'Modification' : 'Ajout' ?></span>
        </div>
    </div>
</div>

<div class="form-card">
    <form action="<?= base_url(isset($etudiant) ? '/etudiant/update/' . $etudiant['id'] : '/etudiant/store') ?>"
        method="POST" id="studentForm">

        <?php if (isset($etudiant)): ?>
            <input type="hidden" name="_method" value="PUT" />
        <?php endif; ?>

        <div class="form-section-title">Informations personnelles</div>

        <div class="form-grid">
            <div class="field-group">
                <label class="field-label">Matricule <span class="required">*</span></label>
                <input type="text" name="matricule"
                    value="<?= old('matricule', $etudiant['matricule'] ?? '') ?>"
                    placeholder="Ex: ETU2024001" required />
                <div class="field-hint">Format: 6 à 20 caractères alphanumériques</div>
            </div>

            <div class="field-group">
                <label class="field-label">Nom <span class="required">*</span></label>
                <input type="text" name="nom"
                    value="<?= old('nom', $etudiant['nom'] ?? '') ?>"
                    placeholder="Ex: RAKOTO" required />
            </div>

            <div class="field-group">
                <label class="field-label">Prénom <span class="required">*</span></label>
                <input type="text" name="prenom"
                    value="<?= old('prenom', $etudiant['prenom'] ?? '') ?>"
                    placeholder="Ex: Jean" required />
            </div>

            <div class="field-group">
                <label class="field-label">Parcours <span class="required">*</span></label>
                <select name="parcours_id" required>
                    <option value="">Sélectionner un parcours</option>
                    <?php foreach ($parcours as $p): ?>
                        <option value="<?= $p['id'] ?>"
                            <?= (old('parcours_id', $etudiant['parcours_id'] ?? '') == $p['id']) ? 'selected' : '' ?>>
                            <?= esc($p['libelle']) ?> (S<?= $p['semestre'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="field-group">
                <label class="field-label">Année académique <span class="required">*</span></label>
                <input type="text" name="annee_academique"
                    value="<?= old('annee_academique', $etudiant['annee_academique'] ?? date('Y') . '-' . (date('Y') + 1)) ?>"
                    placeholder="Ex: 2024-2025" required />
                <div class="field-hint">Format: AAAA-AAAA</div>
            </div>
        </div>

        <?php if (isset($errors) && !empty($errors)): ?>
            <div class="alert" style="background:rgba(239,68,68,.08);color:#b91c1c; margin-bottom:20px;">
                <?php foreach ($errors as $error): ?>
                    <div>• <?= esc($error) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="form-footer">
            <a href="<?= base_url('/etudiant') ?>" class="btn btn-secondary">Annuler</a>
            <button type="submit" class="btn btn-primary">
                <svg viewBox="0 0 24 24">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                    <polyline points="17 21 17 13 7 13 7 21" />
                    <polyline points="7 3 7 8 15 8" />
                </svg>
                <?= isset($etudiant) ? 'Mettre à jour' : 'Enregistrer' ?>
            </button>
        </div>
    </form>
</div>

<script>
    // Form validation before submit
    document.getElementById('studentForm')?.addEventListener('submit', function(e) {
        let matricule = document.querySelector('[name="matricule"]').value;
        let annee = document.querySelector('[name="annee_academique"]').value;

        // Validate matricule format
        if (!/^[A-Z0-9]{6,20}$/i.test(matricule)) {
            e.preventDefault();
            alert('Le matricule doit contenir 6 à 20 caractères alphanumériques');
            return false;
        }

        // Validate year format
        if (!/^(19|20)[0-9]{2}-(19|20)[0-9]{2}$/.test(annee)) {
            e.preventDefault();
            alert('Format d\'année académique invalide. Ex: 2024-2025');
            return false;
        }
    });
</script>