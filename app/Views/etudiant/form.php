<div class="page-header">
    <div>
        <h2><?= isset($etudiant) ? '✏️ Modifier' : '➕ Ajouter' ?> un étudiant</h2>
        <div class="breadcrumb">
            Accueil / <a href="<?= base_url('/etudiant') ?>">Étudiants</a> / 
            <span><?= isset($etudiant) ? 'Modification' : 'Ajout' ?></span>
        </div>
    </div>
</div>

<div class="card">
    <form action="<?= base_url(isset($etudiant) ? '/etudiant/update/'.$etudiant['id'] : '/etudiant/store') ?>" 
          method="POST">
        
        <?php if(isset($etudiant)): ?>
            <input type="hidden" name="_method" value="PUT">
        <?php endif; ?>
        
        <div class="form-row">
            <div class="form-group">
                <label>Matricule <span style="color:red">*</span></label>
                <input type="text" name="matricule" 
                       value="<?= old('matricule', $etudiant['matricule'] ?? '') ?>"
                       placeholder="Ex: ETU2024001" required>
                <small style="color:#666">6 à 20 caractères alphanumériques</small>
            </div>
            
            <div class="form-group">
                <label>Nom <span style="color:red">*</span></label>
                <input type="text" name="nom" 
                       value="<?= old('nom', $etudiant['nom'] ?? '') ?>"
                       placeholder="Ex: RAKOTO" required>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>Prénom <span style="color:red">*</span></label>
                <input type="text" name="prenom" 
                       value="<?= old('prenom', $etudiant['prenom'] ?? '') ?>"
                       placeholder="Ex: Jean" required>
            </div>
            
            <div class="form-group">
                <label>Parcours <span style="color:red">*</span></label>
                <select name="parcours_id" required>
                    <option value="">-- Sélectionner un parcours --</option>
                    <?php foreach($parcours as $p): ?>
                        <option value="<?= $p['id'] ?>" 
                            <?= (old('parcours_id', $etudiant['parcours_id'] ?? '') == $p['id']) ? 'selected' : '' ?>>
                            <?= esc($p['libelle']) ?> (S<?= $p['semestre'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label>Année académique <span style="color:red">*</span></label>
            <input type="text" name="annee_academique" 
                   value="<?= old('annee_academique', $etudiant['annee_academique'] ?? date('Y').'-'.(date('Y')+1)) ?>"
                   placeholder="Ex: 2024-2025" required>
            <small style="color:#666">Format: AAAA-AAAA</small>
        </div>
        
        <?php if(isset($errors) && !empty($errors)): ?>
            <div class="alert alert-error">
                <?php foreach($errors as $error): ?>
                    <div>⚠️ <?= esc($error) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <div class="form-actions">
            <a href="<?= base_url('/etudiant') ?>" class="btn btn-secondary">❌ Annuler</a>
            <button type="submit" class="btn btn-primary">
                💾 <?= isset($etudiant) ? 'Mettre à jour' : 'Enregistrer' ?>
            </button>
        </div>
    </form>
</div>

<script>
document.querySelector('form')?.addEventListener('submit', function(e) {
    let matricule = document.querySelector('[name="matricule"]').value;
    let annee = document.querySelector('[name="annee_academique"]').value;
    
    if (!/^[A-Z0-9]{6,20}$/i.test(matricule)) {
        e.preventDefault();
        alert('Matricule invalide: 6 à 20 caractères alphanumériques');
        return false;
    }
    
    if (!/^(19|20)[0-9]{2}-(19|20)[0-9]{2}$/.test(annee)) {
        e.preventDefault();
        alert('Format d\'année invalide. Ex: 2024-2025');
        return false;
    }
});
</script>