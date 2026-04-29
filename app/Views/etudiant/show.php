<div class="page-header">
    <div>
        <h2>👨‍🎓 Détail de l'étudiant</h2>
        <div class="breadcrumb">
            Accueil / <a href="<?= base_url('/etudiant') ?>">Étudiants</a> / 
            <span><?= esc($etudiant['prenom']) ?> <?= esc($etudiant['nom']) ?></span>
        </div>
    </div>
    <div>
        <a href="<?= base_url('/bulletin/generate/'.$etudiant['id']) ?>" class="btn btn-secondary">
            📄 Générer bulletin
        </a>
        <a href="<?= base_url('/etudiant/edit/'.$etudiant['id']) ?>" class="btn btn-primary">
            ✏️ Modifier
        </a>
    </div>
</div>

<!-- KPI Cards -->
<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-header">
            <div class="kpi-label">👤 Étudiant</div>
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
    
    <div class="kpi-card">
        <div class="kpi-header">
            <div class="kpi-label">📊 Crédits obtenus</div>
        </div>
        <div class="kpi-value"><?= $stats['total_credits'] ?? 0 ?></div>
        <div class="kpi-delta">sur 60 crédits</div>
    </div>
    
    <div class="kpi-card">
        <div class="kpi-header">
            <div class="kpi-label">⭐ Moyenne générale</div>
        </div>
        <div class="kpi-value">
            <?php 
                $allNotes = array_merge($stats['semestre3'] ?? [], $stats['semestre4'] ?? []);
                $moyenne = !empty($allNotes) ? array_sum($allNotes) / count($allNotes) : 0;
                echo number_format($moyenne, 2);
            ?>
        </div>
        <div class="kpi-delta <?= $moyenne >= 10 ? 'up' : 'down' ?>">
            <?= $moyenne >= 10 ? '✅ Admissible' : '❌ Non admissible' ?>
        </div>
    </div>
</div>

<?php if(!empty($notes)): ?>
    <!-- Semestre 3 -->
    <?php 
    $s3Notes = array_filter($notes, fn($n) => $n['semestre'] == 3);
    if(!empty($s3Notes)): 
    ?>
    <div class="card">
        <div class="card-header">
            <div class="card-title">📚 Semestre 3 (Tronc commun)</div>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Code</th><th>Intitulé</th><th>Crédits</th>
                        <th>Devoir</th><th>Examen</th><th>Moyenne</th><th>Résultat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($s3Notes as $note): ?>
                    <tr>
                        <td><?= esc($note['code']) ?></td>
                        <td><?= esc($note['intitule']) ?></td>
                        <td><?= $note['credits'] ?></td>
                        <td><?= $note['note_devoir'] ?? '-' ?></td>
                        <td><?= $note['note_examen'] ?? '-' ?></td>
                        <td><strong><?= number_format($note['moyenne'], 2) ?></strong></td>
                        <td>
                            <span class="badge <?= $note['moyenne'] >= 10 ? 'badge-success' : 'badge-danger' ?>">
                                <?= $note['moyenne'] >= 10 ? '✅ Validé' : '❌ Non validé' ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Semestre 4 -->
    <?php 
    $s4Notes = array_filter($notes, fn($n) => $n['semestre'] == 4);
    if(!empty($s4Notes)): 
    ?>
    <div class="card">
        <div class="card-header">
            <div class="card-title">🚀 Semestre 4 (Parcours)</div>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Code</th><th>Intitulé</th><th>Crédits</th>
                        <th>Devoir</th><th>Examen</th><th>Moyenne</th><th>Résultat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($s4Notes as $note): ?>
                    <tr>
                        <td><?= esc($note['code']) ?></td>
                        <td><?= esc($note['intitule']) ?></td>
                        <td><?= $note['credits'] ?></td>
                        <td><?= $note['note_devoir'] ?? '-' ?></td>
                        <td><?= $note['note_examen'] ?? '-' ?></td>
                        <td><strong><?= number_format($note['moyenne'], 2) ?></strong></td>
                        <td>
                            <span class="badge <?= $note['moyenne'] >= 10 ? 'badge-success' : 'badge-danger' ?>">
                                <?= $note['moyenne'] >= 10 ? '✅ Validé' : '❌ Non validé' ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
<?php else: ?>
    <div class="card">
        <div style="text-align: center; padding: 40px;">
            <p>📭 Aucune note enregistrée pour cet étudiant.</p>
            <a href="<?= base_url('/notes/create/'.$etudiant['id']) ?>" class="btn btn-primary" style="margin-top: 15px;">
                ➕ Ajouter des notes
            </a>
        </div>
    </div>
<?php endif; ?>