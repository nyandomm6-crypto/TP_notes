<div class="page-header">
    <div>
        <h2>Gestion des étudiants</h2>
        <div class="breadcrumb">Accueil / <span>Étudiants</span></div>
    </div>
    <a href="<?= base_url('/etudiant/create') ?>" class="btn btn-primary btn-sm">
        <svg viewBox="0 0 24 24">
            <path d="M12 5v14M5 12h14" />
        </svg>
        Nouvel étudiant
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-info">
        <svg viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10" />
            <path d="M12 16v-4M12 8h.01" />
        </svg>
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert" style="background:rgba(239,68,68,.08);color:#b91c1c;">
        <svg viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10" />
            <line x1="12" y1="8" x2="12" y2="12" />
            <line x1="12" y1="16" x2="12.01" y2="16" />
        </svg>
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="toolbar">
    <div class="toolbar-left">
        <div class="search-box">
            <svg viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8" />
                <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
            <input type="text" placeholder="Rechercher par nom, prénom ou matricule..." id="searchInput" />
        </div>
        <select class="filter-select" id="filterParcours">
            <option value="">Tous les parcours</option>
            <?php foreach ($parcours ?? [] as $p): ?>
                <option value="<?= $p['id'] ?>"><?= esc($p['libelle']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <button class="btn btn-ghost btn-sm" id="exportBtn">
            <svg viewBox="0 0 24 24">
                <polyline points="23 6 13.5 15.5 8.5 10.5 1 18" />
                <polyline points="17 6 23 6 23 12" />
            </svg>
            Exporter
        </button>
    </div>
</div>

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th class="td-check"><input type="checkbox" id="selectAll" /></th>
                <th>Matricule</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Parcours</th>
                <th>Année académique</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="etudiantsTableBody">
            <?php if (empty($etudiants)): ?>
                <tr>
                    <td colspan="7" style="text-align:center; padding:40px;">
                        Aucun étudiant trouvé
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($etudiants as $e): ?>
                    <tr data-id="<?= $e['id'] ?>" data-parcours="<?= $e['parcours_id'] ?>">
                        <td class="td-check"><input type="checkbox" class="studentCheck" value="<?= $e['id'] ?>" /></td>
                        <td><strong><?= esc($e['matricule']) ?></strong></td>
                        <td><?= esc($e['nom']) ?></td>
                        <td><?= esc($e['prenom']) ?></td>
                        <td>
                            <span class="badge badge-blue">
                                <?= esc($e['parcours_libelle'] ?? 'Non défini') ?>
                            </span>
                        </td>
                        <td><?= esc($e['annee_academique']) ?></td>
                        <td class="td-actions">
                            <a href="<?= base_url('/etudiant/show/' . $e['id']) ?>" class="action-btn" title="Voir">
                                <svg viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="3" />
                                    <path d="M22 12c-2.667 4.667-6 7-10 7s-7.333-2.333-10-7c2.667-4.667 6-7 10-7s7.333 2.333 10 7z" />
                                </svg>
                            </a>
                            <a href="<?= base_url('/etudiant/edit/' . $e['id']) ?>" class="action-btn" title="Modifier">
                                <svg viewBox="0 0 24 24">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                </svg>
                            </a>
                            <button class="action-btn del" onclick="deleteStudent(<?= $e['id'] ?>)" title="Supprimer">
                                <svg viewBox="0 0 24 24">
                                    <polyline points="3 6 5 6 21 6" />
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="pagination">
        <div>Affichage de <?= count($etudiants) ?> étudiant(s)</div>
        <div class="page-btns">
            <button class="page-btn" id="prevPage" disabled>«</button>
            <button class="page-btn active">1</button>
            <button class="page-btn" id="nextPage">»</button>
        </div>
    </div>
</div>

<script>
    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function(e) {
        let keyword = this.value.toLowerCase();
        let rows = document.querySelectorAll('#etudiantsTableBody tr');

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(keyword) ? '' : 'none';
        });
    });

    // Filter by parcours
    document.getElementById('filterParcours').addEventListener('change', function(e) {
        let parcoursId = this.value;
        let rows = document.querySelectorAll('#etudiantsTableBody tr');

        rows.forEach(row => {
            if (!parcoursId || row.dataset.parcours == parcoursId) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Select all checkboxes
    document.getElementById('selectAll')?.addEventListener('change', function(e) {
        let checkboxes = document.querySelectorAll('.studentCheck');
        checkboxes.forEach(cb => cb.checked = e.target.checked);
    });

    // Delete student with confirmation
    function deleteStudent(id) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?')) {
            fetch('<?= base_url("/etudiant/delete/") ?>' + id, {
                    method: 'DELETE',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                });
        }
    }

    // Export to CSV
    document.getElementById('exportBtn')?.addEventListener('click', function() {
        let rows = [];
        let tableRows = document.querySelectorAll('#etudiantsTableBody tr');

        tableRows.forEach(row => {
            if (row.style.display !== 'none') {
                let cells = row.querySelectorAll('td');
                rows.push({
                    matricule: cells[1]?.innerText,
                    nom: cells[2]?.innerText,
                    prenom: cells[3]?.innerText,
                    parcours: cells[4]?.innerText,
                    annee: cells[5]?.innerText
                });
            }
        });

        let csv = "Matricule;Nom;Prénom;Parcours;Année académique\n";
        rows.forEach(row => {
            csv += `${row.matricule};${row.nom};${row.prenom};${row.parcours};${row.annee}\n`;
        });

        let blob = new Blob([csv], {
            type: 'text/csv'
        });
        let link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = 'etudiants.csv';
        link.click();
    });
</script>