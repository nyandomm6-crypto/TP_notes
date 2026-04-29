<div class="page-header">
    <div>
        <h2>📄 Générer un bulletin</h2>
        <div class="breadcrumb">
            Accueil / <span>Bulletin</span>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Sélection des paramètres</div>
    </div>
    
    <form action="<?= base_url('/bulletin/afficher') ?>" method="POST">
        <div class="form-row">
            <div class="form-group">
                <label>👨‍🎓 Étudiant <span style="color:red">*</span></label>
                <select name="etudiant_id" required style="width: 100%; padding: 10px;">
                    <option value="">-- Sélectionner un étudiant --</option>
                    <?php foreach($etudiants as $e): ?>
                        <option value="<?= $e['id'] ?>" <?= (isset($etudiantId) && $etudiantId == $e['id']) ? 'selected' : '' ?>>
                            <?= esc($e['matricule']) ?> - <?= esc($e['prenom']) ?> <?= esc($e['nom']) ?> (<?= esc($e['parcours_libelle']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>📚 Semestre <span style="color:red">*</span></label>
                <select name="semestre" required style="width: 100%; padding: 10px;">
                    <option value="">-- Sélectionner --</option>
                    <option value="3">Semestre 3 (Tronc commun)</option>
                    <option value="4">Semestre 4 (Spécialisation)</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>📅 Année académique</label>
                <select name="annee_academique" style="width: 100%; padding: 10px;">
                    <option value="">Année en cours</option>
                    <?php foreach($annees as $a): ?>
                        <option value="<?= $a ?>"><?= $a ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary" style="padding: 12px 30px;">
                📄 Générer le bulletin
            </button>
        </div>
    </form>
</div>

<!-- Guide d'utilisation -->
<div class="card" style="margin-top: 20px; background: #f0f7ff;">
    <div class="card-header">
        <div class="card-title">ℹ️ Guide d'utilisation</div>
    </div>
    <ul style="margin: 0; padding-left: 20px;">
        <li>1. Sélectionnez un étudiant dans la liste</li>
        <li>2. Choisissez le semestre (S3 tronc commun ou S4 spécialisation)</li>
        <li>3. Optionnellement, sélectionnez une année académique</li>
        <li>4. Cliquez sur "Générer le bulletin"</li>
        <li>5. Le bulletin affiche toutes les notes avec validation des crédits</li>
        <li>6. Utilisez le bouton "Imprimer" pour obtenir une version papier</li>
    </ul>
</div>

<?php if(isset($etudiantId)): ?>
<script>
document.querySelector('select[name="etudiant_id"]').value = '<?= $etudiantId ?>';
</script>
<?php endif; ?>