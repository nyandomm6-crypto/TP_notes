<div class="page-header">
    <div>
        <h2>Gestion des étudiants</h2>
        <div class="breadcrumb">
            Accueil / <a href="<?= base_url('/etudiant') ?>">Étudiants</a>
        </div>
    </div>
    <a href="<?= base_url('/etudiant/create') ?>" class="btn btn-primary">
        ➕ Nouvel étudiant
    </a>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        ✅ <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-error">
        ❌ <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="toolbar">
    <div style="display: flex; gap: 10px;">
        <div class="search-box">
            🔍
            <input type="text" id="searchInput" placeholder="Rechercher...">
        </div>
        <select id="filterParcours" class="filter-select">
            <option value="">📌 Tous les parcours</option>
            <?php foreach($parcours ?? [] as $p): ?>
                <option value="<?= $p['id'] ?>"><?= esc($p['libelle']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button class="btn btn-ghost" id="exportBtn">
        📎 Exporter CSV
    </button>
</div>

<div class="table-container">
    <div class="card" style="padding: 0; overflow: hidden;">
        <table>
            <thead>
                <tr>
                    <th style="width: 30px"><input type="checkbox" id="selectAll"></th>
                    <th>Matricule</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Parcours</th>
                    <th>Année</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="studentsTable">
                <?php if(empty($etudiants)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px;">
                            📭 Aucun étudiant trouvé
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach($etudiants as $e): ?>
                    <tr data-id="<?= $e['id'] ?>" data-parcours="<?= $e['parcours_id'] ?>">
                        <td><input type="checkbox" class="studentCheck" value="<?= $e['id'] ?>"></td>
                        <td><strong><?= esc($e['matricule']) ?></strong></td>
                        <td><?= esc($e['nom']) ?></td>
                        <td><?= esc($e['prenom']) ?></td>
                        <td>
                            <span class="badge badge-info">
                                <?= esc($e['parcours_libelle'] ?? 'Non défini') ?>
                            </span>
                        </td>
                        <td><?= esc($e['annee_academique']) ?></td>
                        <td>
                            <div class="action-buttons">
                                <a href="<?= base_url('/etudiant/show/'.$e['id']) ?>" class="action-btn view" title="Voir">👁️</a>
                                <a href="<?= base_url('/etudiant/edit/'.$e['id']) ?>" class="action-btn edit" title="Modifier">✏️</a>
                                <button onclick="deleteStudent(<?= $e['id'] ?>)" class="action-btn delete" title="Supprimer">🗑️</button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        
        <div class="pagination">
            <div>
                📊 <?= count($etudiants) ?> étudiant(s)
            </div>
            <div class="page-btns">
                <button class="page-btn" id="prevPage">«</button>
                <button class="page-btn active">1</button>
                <button class="page-btn" id="nextPage">»</button>
            </div>
        </div>
    </div>
</div>

<script>
// Search filter
document.getElementById('searchInput').addEventListener('keyup', function() {
    let keyword = this.value.toLowerCase();
    let rows = document.querySelectorAll('#studentsTable tr');
    rows.forEach(row => {
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(keyword) ? '' : 'none';
    });
});

// Parcours filter
document.getElementById('filterParcours').addEventListener('change', function() {
    let parcoursId = this.value;
    let rows = document.querySelectorAll('#studentsTable tr');
    rows.forEach(row => {
        if (!parcoursId || row.dataset.parcours == parcoursId) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Select all
document.getElementById('selectAll')?.addEventListener('change', function(e) {
    document.querySelectorAll('.studentCheck').forEach(cb => cb.checked = e.target.checked);
});

// Delete student
function deleteStudent(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?')) {
        fetch('<?= base_url("/etudiant/delete/") ?>' + id, {
            method: 'DELETE',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) location.reload();
            else alert(data.message);
        });
    }
}

// Export CSV
document.getElementById('exportBtn')?.addEventListener('click', function() {
    let rows = [];
    document.querySelectorAll('#studentsTable tr').forEach(row => {
        if (row.style.display !== 'none' && row.dataset.id) {
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
    
    let csv = "Matricule;Nom;Prénom;Parcours;Année\n";
    rows.forEach(r => csv += `${r.matricule};${r.nom};${r.prenom};${r.parcours};${r.annee}\n`);
    
    let blob = new Blob([csv], { type: 'text/csv' });
    let link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'etudiants.csv';
    link.click();
});
</script>