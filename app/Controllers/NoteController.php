<?php 
namespace App\Controllers;

class NoteController extends BaseController {

    private const ETUDIANTS = [
        ['id' => 1, 'nom' => 'Alice Martin'],
        ['id' => 2, 'nom' => 'Youssef Diallo'],
        ['id' => 3, 'nom' => 'Sara Benali'],
        ['id' => 4, 'nom' => 'Lucas Morel'],
    ];

    private const MATIERES = [
        ['id' => 1, 'nom' => 'Math'],
        ['id' => 2, 'nom' => 'Français'],
        ['id' => 3, 'nom' => 'Physique'],
        ['id' => 4, 'nom' => 'SVT'],
    ];

    private function getEtudiantById(int $etudiantId): ?array
    {
        foreach (self::ETUDIANTS as $etudiant) {
            if ((int) $etudiant['id'] === $etudiantId) {
                return $etudiant;
            }
        }

        return null;
    }

    public function dashboard() {
        return view('dashboard');
    }

    public function ajouter(int $etudiantId = null)
    {
        if ($etudiantId === null) {
            return redirect()->to('/dashboard');
        }

        $etudiant = $this->getEtudiantById($etudiantId);

        if ($etudiant === null) {
            return redirect()->to('/dashboard');
        }

        return view('addNote', [
            'etudiant' => $etudiant,
            'etudiantId' => $etudiantId,
            'matieres' => self::MATIERES,
        ]);
    }

    public function sauvegarder(int $etudiantId = null)
    {
        $notes = (array) $this->request->getPost('note');
        $matieres = (array) $this->request->getPost('matiere');

        if ($etudiantId === null || $this->getEtudiantById($etudiantId) === null) {
            return redirect()->to('/dashboard');
        }

        $noteModel = model(\App\Models\NoteModel::class);
        $anneeAcademique = date('Y') . '-' . (date('Y') + 1);

        foreach ($notes as $index => $note) {
            $noteValue = trim((string) $note);
            $matiereId = $matieres[$index] ?? null;

            if ($noteValue === '' || $matiereId === null || $matiereId === '') {
                continue;
            }

            $noteModel->addNote([
                'etudiant_id' => $etudiantId,
                'matiere_id' => (int) $matiereId,
                'note' => $noteValue,
                'annee_academique' => $anneeAcademique,
            ]);
        }

        return redirect()->to('/notes/ajouter/' . $etudiantId)->with('success', 'Les notes ont bien été ajoutées.');
    }
}
