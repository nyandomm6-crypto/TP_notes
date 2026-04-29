<div class="page-header">
    <div>
        <h2>📄 Bulletin de notes - Semestre <?= $semestre ?></h2>
        <div class="breadcrumb">
            Accueil / <a href="<?= base_url('/bulletin') ?>">Bulletin</a> / 
            <span><?= esc($etudiant['prenom']) ?> <?= esc($etudiant['nom']) ?></span>
        </div>
    </div>
    <div>
        <button onclick="window.print()" class="btn btn-secondary">
            🖨️ Imprimer
        </button>
        <a href="<?= base_url('/bulletin') ?>" class="btn btn-primary">
            🔄 Nouveau bulletin
        </a>
    </div>
</div>

<!-- En-tête du bulletin -->
<div class="card" style="text-align: center; margin-bottom: 20px;">
    <h2 style="color: #2c3e50; margin: 0;">UNIVERSITÉ DE MADAGASCAR</h2>
    <p style="color: #666; margin: 5px 0;">École Supérieure Polytechnique - Département Informatique</p>
    <hr style="margin: 15px 0;">
    <h3 style="margin: 0;">BULLETIN DE NOTES - Semestre <?= $semestre ?></h3>
    <p style="margin: 5px 0;"><strong>Année académique :</strong> <?= $annee ?></p>
</div>

<!-- Infos étudiant -->
<div class="kpi-grid" style="margin-bottom: 20px;">
    <div class="kpi-card">
        <div class="kpi-label">📌 Matricule</div>
        <div class="kpi-value" style="font-size: 16px;"><?= esc($etudiant['matricule']) ?></div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">👤 Nom complet</div>
        <div class="kpi-value" style="font-size: 16px;"><?= esc($etudiant['prenom']) ?> <?= esc($etudiant['nom']) ?></div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">🎓 Parcours</div>
        <div class="kpi-value" style="font-size: 14px;"><?= esc($etudiant['parcours_libelle'] ?? 'Tronc commun') ?></div>
    </div>
</div>

<!-- Tableau des notes -->
<div class="card">
    <div class="card-header">
        <div class="card-title">📊 Résultats par matière</div>
    </div>
    <div class="table-container">
        <table style="width: 100%;">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Intitulé</th>
                    <th>Crédits</th>
                    <th>Note /20</th>
                    <th>Résultat</th>
                    <th>Crédits acquis</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($resultats)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px;">
                            📭 Aucune note enregistrée pour ce semestre
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach($resultats as $r): ?>
                    <?php 
                    $matiere = $r['matiere'];
                    $note = $r['note'];
                    $valide = $r['valide'];
                    ?>
                    <tr>
                        <td><strong><?= esc($matiere['code']) ?></strong></td>
                        <td><?= esc($matiere['intitule']) ?></td>
                        <td style="text-align: center;"><?= $matiere['credits'] ?></td>
                        <td style="text-align: center;">
                            <?php if($note !== null): ?>
                                <strong style="color: <?= $valide ? '#27ae60' : '#e74c3c' ?>; font-size: 16px;">
                                    <?= number_format($note, 2) ?>
                                </strong>
                            <?php else: ?>
                                <span style="color: #999;">-</span>
                            <?php endif; ?>
                        </td>
                        <td style="text-align: center;">
                            <?php if($note !== null): ?>
                                <span class="badge <?= $valide ? 'badge-success' : 'badge-danger' ?>">
                                    <?= $valide ? '✅ Validé' : '❌ Non validé' ?>
                                </span>
                            <?php else: ?>
                                <span class="badge badge-warning">⏳ Non noté</span>
                            <?php endif; ?>
                        </td>
                        <td style="text-align: center;">
                            <?= $valide ? $matiere['credits'] : 0 ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
            <?php if($creditsTotal > 0): ?>
            <tfoot>
                <tr style="background-color: #f8f9fa; font-weight: bold;">
                    <td colspan="5" style="text-align: right;">Total crédits :</td>
                    <td style="text-align: center;"><?= $creditsValides ?> / <?= $creditsTotal ?></td>
                </tr>
            </tfoot>
            <?php endif; ?>
        </table>
    </div>
</div>

<!-- Résumé -->
<div class="kpi-grid" style="margin-top: 20px;">
    <div class="kpi-card">
        <div class="kpi-label">🎯 Crédits validés</div>
        <div class="kpi-value"><?= $creditsValides ?> / <?= $creditsTotal ?></div>
        <div class="kpi-delta <?= $creditsValides >= ($creditsTotal/2) ? 'up' : 'down' ?>">
            Taux: <?= round(($creditsValides / $creditsTotal) * 100) ?>%
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">⭐ Moyenne générale</div>
        <div class="kpi-value"><?= number_format($moyenneGenerale, 2) ?></div>
        <div class="kpi-delta <?= $moyenneGenerale >= 10 ? 'up' : 'down' ?>">
            <?= $mention ?>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">📜 Décision</div>
        <div class="kpi-value" style="font-size: 20px; color: <?= $decision == 'ADMIS(E)' ? '#27ae60' : '#e74c3c' ?>;">
            <?= $decision ?>
        </div>
        <div class="kpi-delta">
            <?= $decision == 'ADMIS(E)' ? '🎉 Félicitations !' : '📚 Redoublement' ?>
        </div>
    </div>
</div>

<!-- Pied du bulletin -->
<div class="card" style="margin-top: 20px; text-align: right;">
    <p style="margin: 0;">Fait à Antananarivo, le <?= date('d/m/Y') ?></p>
    <p style="margin: 5px 0 0 0;"><em>Le Chef de département</em></p>
</div>

<style>
@media print {
    .sidebar, .topbar, .page-header .btn, .form-actions, .toolbar, .btn-secondary, .btn-primary {
        display: none !important;
    }
    .main-content {
        margin-left: 0 !important;
    }
    .content {
        padding: 0 !important;
    }
    .card {
        break-inside: avoid;
        box-shadow: none;
        border: 1px solid #ddd;
    }
    .kpi-card {
        break-inside: avoid;
    }
    body {
        background: white;
    }
}
</style>