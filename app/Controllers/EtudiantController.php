<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EtudiantModel;
use App\Models\ParcoursModel;

class EtudiantController extends BaseController
{
    protected $etudiantModel;
    protected $parcoursModel;
    protected $helpers = ['form', 'url', 'session'];

    public function __construct()
    {
        $this->etudiantModel = new EtudiantModel();
        $this->parcoursModel = new ParcoursModel();
        
        // Vérifier si l'utilisateur est connecté
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }
    }

    /**
     * Afficher la liste des étudiants
     * GET /etudiant
     */
    public function index()
    {
        $data = [
            'title' => 'Liste des étudiants',
            'etudiants' => $this->etudiantModel->getWithParcours(),
            'session' => session()
        ];
        
        return view('layouts/header', $data)
             . view('etudiant/list', $data)
             . view('layouts/footer');
    }

    /**
     * Afficher le formulaire d'ajout d'étudiant
     * GET /etudiant/create
     */
    public function create()
    {
        $data = [
            'title' => 'Ajouter un étudiant',
            'parcours' => $this->parcoursModel->findAll(),
            'validation' => \Config\Services::validation()
        ];
        
        return view('layouts/header', $data)
             . view('etudiant/form', $data)
             . view('layouts/footer');
    }

    /**
     * Enregistrer un nouvel étudiant
     * POST /etudiant/store
     */
    public function store()
    {
        // Règles de validation
        $rules = [
            'matricule' => 'required|min_length[6]|max_length[20]|is_unique[etudiants.matricule]',
            'nom' => 'required|min_length[2]|max_length[100]',
            'prenom' => 'required|min_length[2]|max_length[100]',
            'parcours_id' => 'required|integer',
            'annee_academique' => 'required|regex_match[/(19|20)[0-9]{2}-(19|20)[0-9]{2}/]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'matricule' => $this->request->getPost('matricule'),
            'nom' => strtoupper($this->request->getPost('nom')),
            'prenom' => ucfirst($this->request->getPost('prenom')),
            'parcours_id' => $this->request->getPost('parcours_id'),
            'annee_academique' => $this->request->getPost('annee_academique')
        ];

        if ($this->etudiantModel->insert($data)) {
            session()->setFlashdata('success', 'Étudiant ajouté avec succès !');
            return redirect()->to('/etudiant');
        } else {
            session()->setFlashdata('error', 'Erreur lors de l\'ajout de l\'étudiant.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Afficher le formulaire de modification
     * GET /etudiant/edit/{id}
     */
    public function edit($id = null)
    {
        if (!$id) {
            return redirect()->to('/etudiant');
        }

        $etudiant = $this->etudiantModel->find($id);
        
        if (!$etudiant) {
            session()->setFlashdata('error', 'Étudiant non trouvé.');
            return redirect()->to('/etudiant');
        }

        $data = [
            'title' => 'Modifier un étudiant',
            'etudiant' => $etudiant,
            'parcours' => $this->parcoursModel->findAll(),
            'validation' => \Config\Services::validation()
        ];
        
        return view('layouts/header', $data)
             . view('etudiant/form', $data)
             . view('layouts/footer');
    }

    /**
     * Mettre à jour un étudiant
     * PUT /etudiant/update/{id}
     */
    public function update($id = null)
    {
        if (!$id) {
            return redirect()->to('/etudiant');
        }

        $rules = [
            'matricule' => "required|min_length[6]|max_length[20]|is_unique[etudiants.matricule,id,{$id}]",
            'nom' => 'required|min_length[2]|max_length[100]',
            'prenom' => 'required|min_length[2]|max_length[100]',
            'parcours_id' => 'required|integer',
            'annee_academique' => 'required|regex_match[/(19|20)[0-9]{2}-(19|20)[0-9]{2}/]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'matricule' => $this->request->getPost('matricule'),
            'nom' => strtoupper($this->request->getPost('nom')),
            'prenom' => ucfirst($this->request->getPost('prenom')),
            'parcours_id' => $this->request->getPost('parcours_id'),
            'annee_academique' => $this->request->getPost('annee_academique')
        ];

        if ($this->etudiantModel->update($id, $data)) {
            session()->setFlashdata('success', 'Étudiant modifié avec succès !');
            return redirect()->to('/etudiant');
        } else {
            session()->setFlashdata('error', 'Erreur lors de la modification.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Supprimer un étudiant
     * DELETE /etudiant/delete/{id}
     */
    public function delete($id = null)
    {
        if (!$id) {
            return $this->response->setJSON(['success' => false, 'message' => 'ID non fourni']);
        }

        // Vérifier si l'étudiant existe
        $etudiant = $this->etudiantModel->find($id);
        if (!$etudiant) {
            return $this->response->setJSON(['success' => false, 'message' => 'Étudiant non trouvé']);
        }

        // Vérifier si l'étudiant a des notes (optionnel)
        $noteModel = new \App\Models\NoteModel();
        $hasNotes = $noteModel->where('etudiant_id', $id)->countAllResults();
        
        if ($hasNotes > 0) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Impossible de supprimer : cet étudiant a déjà des notes enregistrées.'
            ]);
        }

        if ($this->etudiantModel->delete($id)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Étudiant supprimé avec succès']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Erreur lors de la suppression']);
        }
    }

    /**
     * Afficher le détail d'un étudiant avec ses notes
     * GET /etudiant/show/{id}
     */
    public function show($id = null)
    {
        if (!$id) {
            return redirect()->to('/etudiant');
        }

        $etudiant = $this->etudiantModel->getWithParcours($id);
        
        if (!$etudiant) {
            session()->setFlashdata('error', 'Étudiant non trouvé.');
            return redirect()->to('/etudiant');
        }

        // Récupérer les notes de l'étudiant
        $noteModel = new \App\Models\NoteModel();
        $notes = $noteModel->select('notes.*, matieres.intitule, matieres.code, matieres.credits')
                          ->join('matieres', 'matieres.id = notes.matiere_id')
                          ->where('notes.etudiant_id', $id)
                          ->orderBy('matieres.semestre', 'ASC')
                          ->findAll();

        // Calculer les statistiques
        $stats = [
            'total_credits' => 0,
            'moyenne_generale' => 0,
            'semestre3' => [],
            'semestre4' => []
        ];

        foreach ($notes as $note) {
            if ($note['moyenne'] >= 10) {
                $stats['total_credits'] += $note['credits'];
            }
            
            if ($note['semestre'] == 3) {
                $stats['semestre3'][] = $note['moyenne'];
            } else {
                $stats['semestre4'][] = $note['moyenne'];
            }
        }

        $data = [
            'title' => 'Détail de l\'étudiant',
            'etudiant' => $etudiant,
            'notes' => $notes,
            'stats' => $stats,
            'session' => session()
        ];
        
        return view('layouts/header', $data)
             . view('etudiant/show', $data)
             . view('layouts/footer');
    }

    /**
     * Rechercher des étudiants (AJAX)
     * GET /etudiant/search
     */
    public function search()
    {
        $keyword = $this->request->getGet('keyword');
        
        if (!$keyword) {
            return $this->response->setJSON([]);
        }
        
        $results = $this->etudiantModel->search($keyword);
        return $this->response->setJSON($results);
    }

    /**
     * Filtrer les étudiants par parcours
     * GET /etudiant/filter/{parcoursId}
     */
    public function filter($parcoursId = null)
    {
        if ($parcoursId) {
            $etudiants = $this->etudiantModel->getByParcours($parcoursId);
        } else {
            $etudiants = $this->etudiantModel->getWithParcours();
        }
        
        return $this->response->setJSON($etudiants);
    }
}