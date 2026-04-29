<?php

namespace App\Controllers;

use App\Models\EtudiantModel;
use App\Models\NoteModel;

class NoteController extends BaseController
{
    private array $etudiants = [];

    private const MATIERES = [
        ['id' => 1, 'nom' => 'Math'],
        ['id' => 2, 'nom' => 'Français'],
        ['id' => 3, 'nom' => 'Physique'],
        ['id' => 4, 'nom' => 'SVT'],
    ];

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);

        // Chargement des étudiants avec leurs parcours
        $this->etudiants = model(EtudiantModel::class)->getWithParcours();

        // Log de diagnostic (à retirer en production)
        log_message('debug', 'NoteController::initController — étudiants chargés : ' . count($this->etudiants));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Helpers privés
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Retourne un étudiant par son ID, ou null si introuvable.
     */
    private function getEtudiantById(int $etudiantId): ?array
    {
        foreach ($this->etudiants as $etudiant) {
            if ((int) $etudiant['id'] === $etudiantId) {
                return $etudiant;
            }
        }
        return null;
    }

    /**
     * Redirige vers le dashboard avec un message de debug flashé et loggé.
     */
    private function redirectDashboardDebug(string $reason, array $context = [])
    {
        $message = $reason;
        if ($context !== []) {
            $message .= ' | ' . json_encode($context, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
        log_message('debug', 'NoteController: ' . $message);
        return redirect()->to('/dashboard')->with('debug_redirect', $message);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Actions publiques
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Affiche le tableau de bord principal.
     */
    public function dashboard()
    {
        return view('dashboard');
    }

    /**
     * Affiche le formulaire d'ajout de notes pour un étudiant donné.
     */
    public function ajouter(int $etudiantId = null)
    {
        // Vérification : l'ID est-il fourni ?
        if ($etudiantId === null) {
            return $this->redirectDashboardDebug(
                'ajouter() redirige vers le dashboard car etudiantId est null'
            );
        }

        // Vérification : l'étudiant existe-t-il dans la liste chargée ?
        $etudiant = $this->getEtudiantById($etudiantId);
        if ($etudiant === null) {
            return $this->redirectDashboardDebug(
                'ajouter() redirige vers le dashboard car étudiant introuvable',
                [
                    'etudiantId'       => $etudiantId,
                    'etudiantsCharges' => count($this->etudiants),
                ]
            );
        }

        return view('addNote', [
            'etudiant'   => $etudiant,
            'etudiantId' => $etudiantId,
            'matieres'   => self::MATIERES,
        ]);
    }

    /**
     * Sauvegarde les notes soumises via le formulaire.
     *
     * CORRECTIONS apportées :
     *  1. 'etudiant_id' utilisait la valeur en dur « 1 » — remplacé par $etudiantId.
     *  2. Validation des notes (plage 0-20) ajoutée avant l'insertion.
     *  3. Vérification que la matière soumise fait bien partie des matières connues.
     */
    public function sauvegarder(int $etudiantId = null)
    {
        $notes    = (array) $this->request->getPost('note');
        $matieres = (array) $this->request->getPost('matiere');

        // ── Vérification de l'étudiant ────────────────────────────────────
        if ($etudiantId === null || $this->getEtudiantById($etudiantId) === null) {
            return $this->redirectDashboardDebug(
                "sauvegarder() redirige vers le dashboard car l'étudiant est invalide",
                [
                    'etudiantId'      => $etudiantId,
                    'notesRecues'     => count($notes),
                    'matieresRecues'  => count($matieres),
                    'etudiantsCharges'=> count($this->etudiants),
                ]
            );
        }

        // ── IDs de matières valides (index rapide) ────────────────────────
        $matiereIdsValides = array_column(self::MATIERES, 'id');

        $noteModel       = model(NoteModel::class);
        $anneeAcademique = date('Y') . '-' . (date('Y') + 1);
        $nbInseres       = 0;

        foreach ($notes as $index => $note) {
            $noteValue = trim((string) $note);
            $matiereId = isset($matieres[$index]) ? (int) $matieres[$index] : null;

            // ── Ignorer les lignes vides ou sans matière ──────────────────
            if ($noteValue === '' || $matiereId === null) {
                continue;
            }

            // ── Vérifier que la note est numérique et dans la plage 0-20 ──
            if (!is_numeric($noteValue) || (float) $noteValue < 0 || (float) $noteValue > 20) {
                log_message('warning', "NoteController::sauvegarder — note invalide ignorée : '{$noteValue}' (étudiant {$etudiantId}, matière {$matiereId})");
                continue;
            }

            // ── Vérifier que la matière est connue ────────────────────────
            if (!in_array($matiereId, $matiereIdsValides, true)) {
                log_message('warning', "NoteController::sauvegarder — matière inconnue ignorée : {$matiereId} (étudiant {$etudiantId})");
                continue;
            }

            // ── Insertion ─────────────────────────────────────────────────
            $noteModel->addNote([
                'etudiant_id'     => $etudiantId,   // CORRECTION : était en dur à 1
                'matiere_id'      => $matiereId,
                'note'            => (float) $noteValue,
                'annee_academique'=> $anneeAcademique,
            ]);

            $nbInseres++;
        }

        log_message('info', "NoteController::sauvegarder — {$nbInseres} note(s) insérée(s) pour l'étudiant {$etudiantId}");

        return redirect()
            ->to('/notes/ajouter/' . $etudiantId)
            ->with('success', $nbInseres > 0
                ? "{$nbInseres} note(s) ajoutée(s) avec succès."
                : 'Aucune note valide soumise.'
            );
    }
}