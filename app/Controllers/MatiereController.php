<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MatiereModel;
use App\Models\ParcoursModel;

class MatiereController extends BaseController
{
    protected $matiereModel;
    protected $parcoursModel;
    protected $helpers = ['form', 'url', 'session'];

    public function __construct()
    {
        $this->matiereModel = new MatiereModel();
        $this->parcoursModel = new ParcoursModel();

        // Vérifier si l'utilisateur est connecté
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }
    }

    /**
     * Afficher la liste des matières
     * GET /matiere
     */
    public function index()
    {
        // Filtre par semestre si fourni
        $semestre = $this->request->getGet('semestre');
        $parcours = $this->request->getGet('parcours');
        $search = $this->request->getGet('search');

        $query = $this->matiereModel;

        if ($search) {
            $matieres = $this->matiereModel->search($search);
        } elseif ($semestre && $parcours) {
            $matieres = $this->matiereModel->getBySemestreAndParcours($semestre, $parcours);
        } elseif ($semestre) {
            $matieres = $this->matiereModel->getBySemestre($semestre);
        } else {
            $matieres = $this->matiereModel->getWithParcours();
        }

        $data = [
            'title' => 'Gestion des matières',
            'matieres' => $matieres,
            'semestres' => $this->matiereModel->getAllSemestres(),
            'parcours' => $this->parcoursModel->findAll(),
            'session' => session(),
            'search' => $search,
            'filteredSemestre' => $semestre,
            'filteredParcours' => $parcours
        ];

        return view('layouts/header', $data)
            . view('matiere/list', $data)
            . view('layouts/footer');
    }

    /**
     * Afficher le formulaire d'ajout de matière
     * GET /matiere/create
     */
    public function create()
    {
        $data = [
            'title' => 'Ajouter une matière',
            'parcours' => $this->parcoursModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('layouts/header', $data)
            . view('matiere/form', $data)
            . view('layouts/footer');
    }

    /**
     * Enregistrer une nouvelle matière
     * POST /matiere/store
     */
    public function store()
    {
        $rules = [
            'code'      => 'required|min_length[2]|max_length[10]|is_unique[matieres.code]',
            'intitule'  => 'required|min_length[3]|max_length[150]',
            'credits'   => 'required|integer|greater_than[0]|less_than_equal_to[30]',
            'semestre'  => 'required|integer|greater_than[0]|less_than_equal_to[8]',
            'parcours_id' => 'permit_empty|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'code'      => strtoupper($this->request->getPost('code')),
            'intitule'  => ucfirst($this->request->getPost('intitule')),
            'credits'   => $this->request->getPost('credits'),
            'semestre'  => $this->request->getPost('semestre'),
            'parcours_id' => $this->request->getPost('parcours_id') ?: null
        ];

        if ($this->matiereModel->insert($data)) {
            session()->setFlashdata('success', 'Matière ajoutée avec succès !');
            return redirect()->to('/matiere');
        } else {
            session()->setFlashdata('error', 'Erreur lors de l\'ajout de la matière.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Afficher le formulaire de modification
     * GET /matiere/edit/{id}
     */
    public function edit($id = null)
    {
        if (!$id) {
            return redirect()->to('/matiere');
        }

        $matiere = $this->matiereModel->find($id);

        if (!$matiere) {
            session()->setFlashdata('error', 'Matière introuvable.');
            return redirect()->to('/matiere');
        }

        $data = [
            'title' => 'Modifier une matière',
            'matiere' => $matiere,
            'parcours' => $this->parcoursModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('layouts/header', $data)
            . view('matiere/form', $data)
            . view('layouts/footer');
    }

    /**
     * Mettre à jour une matière
     * POST /matiere/update/{id}
     */
    public function update($id = null)
    {
        if (!$id) {
            return redirect()->to('/matiere');
        }

        $matiere = $this->matiereModel->find($id);
        if (!$matiere) {
            session()->setFlashdata('error', 'Matière introuvable.');
            return redirect()->to('/matiere');
        }

        $rules = [
            'code'      => 'required|min_length[2]|max_length[10]|is_unique[matieres.code,id,' . $id . ']',
            'intitule'  => 'required|min_length[3]|max_length[150]',
            'credits'   => 'required|integer|greater_than[0]|less_than_equal_to[30]',
            'semestre'  => 'required|integer|greater_than[0]|less_than_equal_to[8]',
            'parcours_id' => 'permit_empty|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'code'      => strtoupper($this->request->getPost('code')),
            'intitule'  => ucfirst($this->request->getPost('intitule')),
            'credits'   => $this->request->getPost('credits'),
            'semestre'  => $this->request->getPost('semestre'),
            'parcours_id' => $this->request->getPost('parcours_id') ?: null
        ];

        if ($this->matiereModel->update($id, $data)) {
            session()->setFlashdata('success', 'Matière mise à jour avec succès !');
            return redirect()->to('/matiere');
        } else {
            session()->setFlashdata('error', 'Erreur lors de la mise à jour de la matière.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Supprimer une matière
     * DELETE /matiere/delete/{id}
     */
    public function delete($id = null)
    {
        if (!$id) {
            return redirect()->to('/matiere');
        }

        $matiere = $this->matiereModel->find($id);
        if (!$matiere) {
            session()->setFlashdata('error', 'Matière introuvable.');
            return redirect()->to('/matiere');
        }

        if ($this->matiereModel->delete($id)) {
            session()->setFlashdata('success', 'Matière supprimée avec succès !');
        } else {
            session()->setFlashdata('error', 'Erreur lors de la suppression de la matière.');
        }

        return redirect()->to('/matiere');
    }

    /**
     * Afficher les détails d'une matière
     * GET /matiere/show/{id}
     */
    public function show($id = null)
    {
        if (!$id) {
            return redirect()->to('/matiere');
        }

        $matiere = $this->matiereModel->getWithParcours($id);
        if (!$matiere) {
            session()->setFlashdata('error', 'Matière introuvable.');
            return redirect()->to('/matiere');
        }

        $data = [
            'title' => 'Détails de la matière',
            'matiere' => $matiere,
            'session' => session()
        ];

        return view('layouts/header', $data)
            . view('matiere/show', $data)
            . view('layouts/footer');
    }

    /**
     * Rechercher des matières
     * GET /matiere/search
     */
    public function search()
    {
        $keyword = $this->request->getGet('q');

        if (!$keyword) {
            return redirect()->to('/matiere');
        }

        $matieres = $this->matiereModel->search($keyword);

        $data = [
            'title' => 'Résultats de recherche - Matières',
            'matieres' => $matieres,
            'keyword' => $keyword,
            'session' => session()
        ];

        return view('layouts/header', $data)
            . view('matiere/list', $data)
            . view('layouts/footer');
    }

    /**
     * Filtrer les matières par parcours
     * GET /matiere/filter/{id}
     */
    public function filter($parcoursId = null)
    {
        if (!$parcoursId) {
            return redirect()->to('/matiere');
        }

        $parcours = $this->parcoursModel->find($parcoursId);
        if (!$parcours) {
            session()->setFlashdata('error', 'Parcours introuvable.');
            return redirect()->to('/matiere');
        }

        $matieres = $this->matiereModel->getByParcours($parcoursId);

        $data = [
            'title' => 'Matières du parcours : ' . $parcours['libelle'],
            'matieres' => $matieres,
            'parcours' => $parcours,
            'session' => session()
        ];

        return view('layouts/header', $data)
            . view('matiere/list', $data)
            . view('layouts/footer');
    }
}
