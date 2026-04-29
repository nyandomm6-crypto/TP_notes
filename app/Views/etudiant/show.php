<div class="page-header">
    <div>
        <h2>Détail de l'étudiant</h2>
        <div class="breadcrumb">
            Accueil / <a href="<?= base_url('/etudiant') ?>">Étudiants</a> /
            <span><?= esc($etudiant['prenom']) ?> <?= esc($etudiant['nom']) ?></span>
        </div>
    </div>
    <div>
        <a href="<?= base_url('/bulletin/generate/' . $etudiant['id']) ?>" class="btn btn-secondary btn-sm">
            <svg viewBox="0 0 24 24">
                <polyline points="23 6 13.5 15.5 8.5 10.5 1 18" />
                <polyline points="17 6 23 6 23 12" />
            </svg>
            Générer bulletin
        </a>
        <a href="<?= base_url('/etudiant/edit/' . $etudiant['id']) ?>" class="btn btn-primary btn-sm">
            <svg viewBox="0 0 24 24">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
            </svg>
            Modifier
        </a>
    </div>
</div>

<!-- Info Cards -->
<div class="kpi-grid" style="margin-bottom:24px">
    <div class="kpi-card">
        <div class="kpi-header">
            <div class="kpi-label">Étudiant</div>
            <div class="kpi-icon bg-blue">
                <svg viewBox="0 0 24 24">
                    <circle cx="12" cy="8" r="4" />
                    <path d="M20 21a8 8 0 1 0-16 0" />
                </svg>
            </div>
        </div>
        <div class="kpi-value" style="font-size:18px"><?= esc($etudiant['matricule']) ?></div>
        <div class="kpi-delta"><?= esc($etudiant['prenom']) ?> <?= esc($etudiant['nom']) ?></div>
    </div>

    <div class="kpi-card">
        <div class="kpi-header">
            <div class="kpi-label">Parcours</div>
            <div class="kpi-icon bg-green">
                <svg viewBox="0 0 24 24">
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                </svg>
            </div>
        </div>
        <div class="kpi-value" style="font-size:18px"><?= esc($etudiant['parcours_libelle'] ?? 'Non défini') ?></div>
        <div class="kpi-delta">Année: <?= esc($etudiant['annee_academique']) ?></div>
    </div>

    <div class="kpi-card">
        <div class="kpi-header">
            <div class="kpi-label">Crédits obtenus</div>
            <div class="kpi-icon bg-amber">
                <svg viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" />
                    <polyline points="12 6 12 12 16 14" />
                </svg>
            </div>
        </div>
        <div class="kpi-value"><?= $stats['total_credits'] ?? 0 ?></div>
        <div class="kpi-delta">sur 60 crédits</div>
    </div>

    <div class="kpi-card">
        <div class="kpi-header">
            <div class="kpi-label">Moyenne générale</div>
            <div class="kpi-icon bg-red">
                <svg viewBox="0 0 24 24">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                </svg>
            </div>
        </div>
        <div class="kpi-value">
            <?php
            $allNotes = array_merge($stats['semestre3'] ?? [], $stats['semestre4'] ?? []);
            $moyenne = !empty($allNotes) ? array_sum($allNotes) / count($allNotes) : 0;
            echo number_format($moyenne, 2);
            ?>
        </div>
        <div class="kpi-delta <?= $moyenne >= 10 ? 'up' : 'down' ?>">
            <?= $moyenne >= 10 ? 'Admissible' : 'Non admissible' ?>
        </div>
    </div>
</div>

<!-- Notes tables -->
<?php if (!empty($notes)): ?>
    <!-- Semestre 3 -->
    <?php
    $s3Notes = array_filter($notes, fn($n) => $n['semestre'] == 3);
    if (!empty($s3Notes)):
    ?>
        <div class="card" style="margin-bottom:24px">
            <div class="card-header">
                <div class="card-title">Semestre 3 (Tronc commun)</div>
            </div>
            <div style="overflow-x:auto">
                <table style="width:100%">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Intitulé</th>
                            <th>Crédits</th>
                            <th>Note devoir</th>
                            <th>Note examen</th>
                            <th>Moyenne</th>
                            <th>Résultat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($s3Notes as $note): ?>
                            <tr>
                                <td><?= esc($note['code']) ?></td>
                                <td><?= esc($note['intitule']) ?></td>
                                <td><?= $note['credits'] ?></td>
                                <td><?= $note['note_devoir'] ?? '-' ?></td>
                                <td><?= $note['note_examen'] ?? '-' ?></td>
                                <td><strong><?= number_format($note['moyenne'], 2) ?></strong></td>
                                <td>
                                    <span class="badge <?= $note['moyenne'] >= 10 ? 'badge-green' : 'badge-red' ?>">
                                        <?= $note['moyenne'] >= 10 ? 'Validé' : 'Non validé' ?>
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
    if (!empty($s4Notes)):
    ?>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Semestre 4 (Parcours)</div>
            </div>
            <div style="overflow-x:auto">
                <table style="width:100%">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Intitulé</th>
                            <th>Crédits</th>
                            <th>Note devoir</th>
                            <th>Note examen</th>
                            <th>Moyenne</th>
                            <th>Résultat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($s4Notes as $note): ?>
                            <tr>
                                <td><?= esc($note['code']) ?></td>
                                <td><?= esc($note['intitule']) ?></td>
                                <td><?= $note['credits'] ?></td>
                                <td><?= $note['note_devoir'] ?? '-' ?></td>
                                <td><?= $note['note_examen'] ?? '-' ?></td>
                                <td><strong><?= number_format($note['moyenne'], 2) ?></strong></td>
                                <td>
                                    <span class="badge <?= $note['moyenne'] >= 10 ? 'badge-green' : 'badge-red' ?>">
                                        <?= $note['moyenne'] >= 10 ? 'Validé' : 'Non validé' ?>
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
        <div style="text-align:center; padding:40px">
            <p>Aucune note enregistrée pour cet étudiant.</p>
            <a href="<?= base_url('/notes/create/' . $etudiant['id']) ?>" class="btn btn-primary btn-sm" style="margin-top:15px">
                Ajouter des notes
            </a>
        </div>
    </div>
<?php endif; ?>