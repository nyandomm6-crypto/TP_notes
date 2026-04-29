<?php

namespace App\Controllers;

use App\Models\EtudiantModel;
use App\Models\ParcoursModel;
use App\Models\MatiereModel;
use App\Models\NoteModel;

class Bulletin extends BaseController
{
    protected $etudiantModel;
    protected $parcoursModel;
    protected $matiereModel;
    protected $noteModel;

    public function __construct()
    {
        $this->etudiantModel = new EtudiantModel();
        $this->parcoursModel = new ParcoursModel();
        $this->matiereModel = new MatiereModel();
        $this->noteModel = new NoteModel();
        
        helper(['form', 'url']);
        
        if (!session()->get('isLoggedIn')) {
            redirect()->to('/auth/login');
        }
    }

    /**
     * Formulaire de sélection du bulletin
     */
    public function index()
    {
        $data = [
            'title' => 'Générer bulletin',
            'etudiants' => $this->etudiantModel->getWithParcours(),
            'parcours' => $this->parcoursModel->findAll(),
            'annees' => ['2023-2024', '2024-2025', '2025-2026']
        ];
        
        return view('layouts/header', $data)
             . view('bulletin/index', $data)
             . view('layouts/footer');
    }

    /**
     * Afficher le bulletin (HTML)
     */
    public function afficher()
    {
        $etudiantId = $this->request->getPost('etudiant_id') ?? $this->request->getGet('etudiant_id');
        $semestre = $this->request->getPost('semestre') ?? $this->request->getGet('semestre');
        $annee = $this->request->getPost('annee_academique') ?? $this->request->getGet('annee_academique');
        
        if (!$etudiantId || !$semestre) {
            session()->setFlashdata('error', 'Veuillez sélectionner un étudiant et un semestre');
            return redirect()->to('/bulletin');
        }
        
        // Récupérer l'étudiant
        $etudiant = $this->etudiantModel->getWithParcours($etudiantId);
        if (!$etudiant) {
            session()->setFlashdata('error', 'Étudiant non trouvé');
            return redirect()->to('/bulletin');
        }
        
        // Récupérer les matières selon semestre et parcours
        if ($semestre == 3) {
            $matieres = $this->matiereModel->where('semestre', 3)
                ->where('parcours_id', 1) // COMMUN
                ->orderBy('code', 'ASC')
                ->findAll();
        } else {
            $matieres = $this->matiereModel->where('semestre', 4)
                ->where('parcours_id', $etudiant['parcours_id'])
                ->orderBy('code', 'ASC')
                ->findAll();
        }
        
        // Récupérer les notes de l'étudiant
        $builder = $this->noteModel->select('matiere_id, note')
            ->where('etudiant_id', $etudiantId);
        
        if ($annee) {
            $builder->where('annee_academique', $annee);
        } else {
            $builder->where('annee_academique', $etudiant['annee_academique']);
        }
        
        $notesData = $builder->findAll();
        
        // Mapper les notes par matière
        $notesParMatiere = [];
        foreach ($notesData as $n) {
            $notesParMatiere[$n['matiere_id']] = $n['note'];
        }
        
        // Construire le tableau des résultats
        $resultats = [];
        $creditsValides = 0;
        $totalNotes = 0;
        $nbNotes = 0;
        
        foreach ($matieres as $matiere) {
            $note = $notesParMatiere[$matiere['id']] ?? null;
            $valide = ($note !== null && $note >= 10);
            
            if ($valide) {
                $creditsValides += $matiere['credits'];
                $totalNotes += $note;
                $nbNotes++;
            }
            
            $resultats[] = [
                'matiere' => $matiere,
                'note' => $note,
                'valide' => $valide
            ];
        }
        
        $moyenneGenerale = $nbNotes > 0 ? round($totalNotes / $nbNotes, 2) : 0;
        $mention = $this->getMention($moyenneGenerale);
        $decision = $moyenneGenerale >= 10 ? 'ADMIS(E)' : 'NON ADMIS(E)';
        
        $data = [
            'title' => 'Bulletin - ' . $etudiant['prenom'] . ' ' . $etudiant['nom'],
            'etudiant' => $etudiant,
            'semestre' => $semestre,
            'annee' => $annee ?? $etudiant['annee_academique'],
            'resultats' => $resultats,
            'creditsValides' => $creditsValides,
            'creditsTotal' => $semestre == 3 ? 30 : 30,
            'moyenneGenerale' => $moyenneGenerale,
            'mention' => $mention,
            'decision' => $decision
        ];
        
        return view('layouts/header', $data)
             . view('bulletin/afficher', $data)
             . view('layouts/footer');
    }
    
    /**
     * Obtenir la mention selon la moyenne
     */
    private function getMention($moyenne)
    {
        if ($moyenne >= 16) return 'Très bien';
        if ($moyenne >= 14) return 'Bien';
        if ($moyenne >= 12) return 'Assez bien';
        if ($moyenne >= 10) return 'Passable';
        return 'Insuffisant';
    }
}