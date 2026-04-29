<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bulletin - <?= $etudiant['prenom'] ?> <?= $etudiant['nom'] ?></title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h2 { margin: 0; color: #2c3e50; }
        .header p { margin: 5px 0; color: #666; }
        .info {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .valide { color: #27ae60; font-weight: bold; }
        .non-valide { color: #e74c3c; font-weight: bold; }
        .footer {
            margin-top: 30px;
            text-align: right;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .total {
            margin-top: 20px;
            padding: 10px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

<div class="header">
    <h2>UNIVERSITÉ DE MADAGASCAR</h2>
    <p>École Supérieure Polytechnique - Département Informatique</p>
    <h3>BULLETIN DE NOTES - Semestre <?= $semestre ?></h3>
    <p>Année académique : <?= $annee ?></p>
</div>

<div class="info">
    <strong>Matricule :</strong> <?= $etudiant['matricule'] ?> &nbsp;&nbsp;
    <strong>Nom :</strong> <?= $etudiant['nom'] ?> &nbsp;&nbsp;
    <strong>Prénom :</strong> <?= $etudiant['prenom'] ?> &nbsp;&nbsp;
    <strong>Parcours :</strong> <?= $etudiant['parcours_libelle'] ?? 'Tronc commun' ?>
</div>

<table>
    <thead>
        <tr>
            <th>Code</th>
            <th>Intitulé</th>
            <th>Crédits</th>
            <th>Note Devoir</th>
            <th>Note Examen</th>
            <th>Moyenne</th>
            <th>Résultat</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($notesParMatiere as $item): ?>
        <?php 
        $note = $item['note'];
        $matiere = $item['matiere'];
        $moyenne = $note['moyenne'] ?? null;
        $valide = $moyenne && $moyenne >= 10;
        ?>
        <tr>
            <td><?= $matiere['code'] ?></td>
            <td><?= $matiere['intitule'] ?></td>
            <td style="text-align:center"><?= $matiere['credits'] ?></td>
            <td style="text-align:center"><?= $note['note_devoir'] ?? '-' ?></td>
            <td style="text-align:center"><?= $note['note_examen'] ?? '-' ?></td>
            <td style="text-align:center">
                <span class="<?= $valide ? 'valide' : 'non-valide' ?>">
                    <?= $moyenne ? number_format($moyenne, 2) : '-' ?>
                </span>
            </td>
            <td style="text-align:center">
                <?= $valide ? 'Validé' : 'Non validé' ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="total">
    <strong>Crédits validés :</strong> <?= $creditsValides ?> / 30<br>
    <strong>Moyenne générale :</strong> <?= number_format($moyenneGenerale, 2) ?><br>
    <strong>Mention :</strong> <?= $mention ?><br>
    <strong>Décision :</strong> <?= $decision ?>
</div>

<div class="footer">
    <p>Fait à Antananarivo, le <?= date('d/m/Y') ?></p>
    <p><em>Le Chef de département</em></p>
</div>

</body>
</html>