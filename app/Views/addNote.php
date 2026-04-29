<h1>Ajouter des notes</h1>

<?php $matieres = $matieres ?? []; ?>
<?php $etudiant = $etudiant ?? null; ?>
<?php $etudiantId = $etudiantId ?? null; ?>

<p><strong>Étudiant :</strong> <?= esc((string) ($etudiant['nom'] ?? 'Inconnu')) ?> (ID <?= esc((string) $etudiantId) ?>)</p>

<form action="<?= base_url('notes/save/' . $etudiantId) ?>" method="post">
    
    <div id="container">
        <div class="note">
            <input type="text" name="note[]" placeholder="Entrez une note" required>

            <select name="matiere[]" required>
                <option value="">Sélectionnez une matière</option>
                <?php foreach ($matieres as $matiere): ?>
                    <option value="<?= esc((string) $matiere['id']) ?>"><?= esc((string) $matiere['nom']) ?></option>
                <?php endforeach; ?>
            </select>

            <button type="button" class="remove">Supprimer</button>
        </div>
    </div>

    <button type="button" id="add">Plus</button>
    <br><br>

    <button type="submit">Valider</button>

</form>

<script>
const container = document.getElementById('container');
const addBtn = document.getElementById('add');

addBtn.addEventListener('click', () => {
    const firstNote = document.querySelector('.note');
    const newNote = firstNote.cloneNode(true);

    newNote.querySelector('input').value = '';
    newNote.querySelectorAll('select').forEach((select) => {
        select.selectedIndex = 0;
    });

    container.appendChild(newNote);
});

container.addEventListener('click', (e) => {
    if (e.target.classList.contains('remove')) {
        if (document.querySelectorAll('.note').length > 1) {
            e.target.parentNode.remove();
        }
    }
});
</script>