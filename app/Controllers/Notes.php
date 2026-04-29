<?php

namespace App\Controllers;

use App\Models\NoteModel;
use App\Models\EtudiantModel;
use App\Models\MatiereModel;

class Notes extends BaseController
{
    protected $noteModel;
    protected $etudiantModel;
    protected $matiereModel;

    public function __construct()
    {
        $this->noteModel = new NoteModel();
        $this->etudiantModel = new EtudiantModel();
        $this->matiereModel = new MatiereModel();
        
        helper(['form', 'url']);
        
        if (!session()->get('isLoggedIn')) {
            redirect()->to('/auth/login');
        }
    }

    /**
     * Formulaire d'ajout de notes pour un étudiant
     * GET /notes/ajouter/(:num)
     */
    public function ajouter($etudiantId = null)
    {
        if (!$etudiantId) {
            return redirect()->to('/etudiant');
        }
        
        $etudiant = $this->etudiantModel->getWithParcours($etudiantId);
        
        if (!$etudiant) {
            session()->setFlashdata('error', 'Étudiant non trouvé');
            return redirect()->to('/etudiant');
        }
        
        // Récupérer les matières S3 (tronc commun)
        $matieresS3 = $this->matiereModel->where('semestre', 3)
            ->where('parcours_id', 1)
            ->findAll();
        
        // Récupérer les matières S4 (spécifiques au parcours)
        $matieresS4 = $this->matiereModel->where('semestre', 4)
            ->where('parcours_id', $etudiant['parcours_id'])
            ->findAll();
        
        // Récupérer les notes existantes
        $notesExistantes = [];
        $existingNotes = $this->noteModel->where('etudiant_id', $etudiantId)->findAll();
        foreach ($existingNotes as $note) {
            $notesExistantes[$note['matiere_id']] = $note['note'];
        }
        
        $data = [
            'title' => 'Ajouter des notes - ' . $etudiant['prenom'] . ' ' . $etudiant['nom'],
            'etudiant' => $etudiant,
            'matieresS3' => $matieresS3,
            'matieresS4' => $matieresS4,
            'notesExistantes' => $notesExistantes,
            'validation' => \Config\Services::validation()
        ];
        
        return view('layouts/header', $data)
             . view('notes/ajouter', $data)
             . view('layouts/footer');
    }

    /**
     * Sauvegarde des notes
     * POST /notes/save/(:num)
     */
    public function sauvegarder($etudiantId = null)
    {
        if (!$etudiantId) {
            return redirect()->to('/etudiant');
        }
        
        $etudiant = $this->etudiantModel->find($etudiantId);
        
        if (!$etudiant) {
            session()->setFlashdata('error', 'Étudiant non trouvé');
            return redirect()->to('/etudiant');
        }
        
        $matieresIds = $this->request->getPost('matiere_id');
        $notes = $this->request->getPost('note');
        
        if (empty($matieresIds)) {
            session()->setFlashdata('error', 'Veuillez sélectionner au moins une matière');
            return redirect()->back()->withInput();
        }
        
        $saved = 0;
        
        foreach ($matieresIds as $index => $matiereId) {
            $noteValue = $notes[$index] ?? null;
            
            // Si la note est vide, on ignore
            if ($noteValue === '' || $noteValue === null) {
                continue;
            }
            
            $noteValue = floatval($noteValue);
            
            // Vérifier si une note existe déjà
            $existing = $this->noteModel->where('etudiant_id', $etudiantId)
                ->where('matiere_id', $matiereId)
                ->first();
            
            $data = [
                'etudiant_id' => $etudiantId,
                'matiere_id' => $matiereId,
                'note' => $noteValue,
                'annee_academique' => $etudiant['annee_academique']
            ];
            
            if ($existing) {
                $this->noteModel->update($existing['id'], $data);
            } else {
                $this->noteModel->insert($data);
            }
            $saved++;
        }
        
        if ($saved > 0) {
            session()->setFlashdata('success', "$saved note(s) enregistrée(s) avec succès");
        }
        
        return redirect()->to('/etudiant/show/' . $etudiantId);
    }

    /**
     * Supprimer une note
     */
    public function delete($id = null)
    {
        $note = $this->noteModel->find($id);
        
        if (!$note) {
            return $this->response->setJSON(['success' => false, 'message' => 'Note non trouvée']);
        }
        
        if ($this->noteModel->delete($id)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Note supprimée']);
        }
        
        return $this->response->setJSON(['success' => false, 'message' => 'Erreur lors de la suppression']);
    }
}