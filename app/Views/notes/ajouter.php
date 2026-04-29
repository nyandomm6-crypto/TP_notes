<div class="page-header">
    <div>
        <h2>📝 Ajouter des notes</h2>
        <div class="breadcrumb">
            Accueil / <a href="<?= base_url('/etudiant') ?>">Étudiants</a> / 
            <a href="<?= base_url('/etudiant/show/'.$etudiant['id']) ?>"><?= esc($etudiant['prenom']) ?> <?= esc($etudiant['nom']) ?></a> /
            <span>Ajouter des notes</span>
        </div>
    </div>
    <div>
        <a href="<?= base_url('/etudiant/show/'.$etudiant['id']) ?>" class="btn btn-secondary">
            ↩️ Retour
        </a>
    </div>
</div>

<!-- Info étudiant -->
<div class="kpi-grid" style="margin-bottom: 20px;">
    <div class="kpi-card">
        <div class="kpi-header">
            <div class="kpi-label">👨‍🎓 Étudiant</div>
        </div>
        <div class="kpi-value" style="font-size: 18px;"><?= esc($etudiant['matricule']) ?></div>
        <div class="kpi-delta"><?= esc($etudiant['prenom']) ?> <?= esc($etudiant['nom']) ?></div>
    </div>
    <div class="kpi-card">
        <div class="kpi-header">
            <div class="kpi-label">🎓 Parcours</div>
        </div>
        <div class="kpi-value" style="font-size: 16px;"><?= esc($etudiant['parcours_libelle'] ?? 'Non défini') ?></div>
        <div class="kpi-delta">Année: <?= esc($etudiant['annee_academique']) ?></div>
    </div>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success">✅ <?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-error">❌ <?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<form action="<?= base_url('/notes/save/'.$etudiant['id']) ?>" method="POST">
    
    <!-- Semestre 3 -->
    <?php if(!empty($matieresS3)): ?>
    <div class="card">
        <div class="card-header">
            <div class="card-title">📚 Semestre 3 (Tronc commun)</div>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Matière</th>
                        <th>Crédits</th>
                        <th>Note /20</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($matieresS3 as $matiere): ?>
                    <?php $existingNote = $notesExistantes[$matiere['id']] ?? ''; ?>
                    <tr>
                        <td>
                            <strong><?= esc($matiere['code']) ?></strong>
                            <input type="hidden" name="matiere_id[]" value="<?= $matiere['id'] ?>">
                        </td>
                        <td><?= esc($matiere['intitule']) ?></td>
                        <td><?= $matiere['credits'] ?></td>
                        <td>
                            <input type="number" step="0.5" min="0" max="20" 
                                   name="note[]" 
                                   value="<?= $existingNote ?>"
                                   placeholder="0-20" 
                                   style="width: 100px; padding: 8px;">
                            <?php if($existingNote): ?>
                                <span style="color: green; margin-left: 10px;">✓ déjà noté</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Semestre 4 -->
    <?php if(!empty($matieresS4)): ?>
    <div class="card">
        <div class="card-header">
            <div class="card-title">🚀 Semestre 4 (Spécialisation)</div>
            <div class="field-hint">⚠️ Pour les UE optionnelles, seule la meilleure note sera prise en compte</div>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Matière</th>
                        <th>Crédits</th>
                        <th>Optionnelle</th>
                        <th>Note /20</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($matieresS4 as $matiere): ?>
                    <?php $existingNote = $notesExistantes[$matiere['id']] ?? ''; ?>
                    <tr>
                        <td>
                            <strong><?= esc($matiere['code']) ?></strong>
                            <input type="hidden" name="matiere_id[]" value="<?= $matiere['id'] ?>">
                        </td>
                        <td><?= esc($matiere['intitule']) ?></td>
                        <td><?= $matiere['credits'] ?></td>
                        <td>
                            <?php if($matiere['is_optionnelle']): ?>
                                <span class="badge badge-warning">Optionnelle</span>
                            <?php else: ?>
                                <span class="badge badge-success">Obligatoire</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <input type="number" step="0.5" min="0" max="20" 
                                   name="note[]" 
                                   value="<?= $existingNote ?>"
                                   placeholder="0-20" 
                                   style="width: 100px; padding: 8px;">
                            <?php if($existingNote): ?>
                                <span style="color: green; margin-left: 10px;">✓ déjà noté</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
    
    <div class="form-actions">
        <a href="<?= base_url('/etudiant/save/'.$etudiant['id']) ?>" class="btn btn-secondary">Annuler</a>
        <button type="submit" class="btn btn-primary">
            💾 Enregistrer les notes
        </button>
    </div>
</form>