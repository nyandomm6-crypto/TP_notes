<?php

namespace App\Models;

use CodeIgniter\Model;

class NoteModel extends Model
{
    protected $table            = 'notes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'etudiant_id', 
        'matiere_id', 
        'note', 
        'annee_academique'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation rules
    protected $validationRules = [
        'etudiant_id' => 'required|integer',
        'matiere_id'  => 'required|integer',
        'note'        => 'permit_empty|numeric|greater_than_equal[0]|less_than_equal[20]',
        'annee_academique' => 'required|regex_match[/(19|20)[0-9]{2}-(19|20)[0-9]{2}/]'
    ];

    // Récupérer les notes d'un étudiant avec détails matière
    public function getNotesWithMatieres($etudiantId, $semestre = null, $annee = null)
    {
        $builder = $this->db->table('notes n')
            ->select('n.*, m.code, m.intitule, m.credits, m.semestre, m.is_optionnelle')
            ->join('matieres m', 'm.id = n.matiere_id')
            ->where('n.etudiant_id', $etudiantId);
        
        if ($semestre) {
            $builder->where('m.semestre', $semestre);
        }
        
        if ($annee) {
            $builder->where('n.annee_academique', $annee);
        }
        
        return $builder->orderBy('m.semestre', 'ASC')
                       ->orderBy('m.code', 'ASC')
                       ->get()
                       ->getResultArray();
    }

    // Récupérer les notes groupées par semestre
    public function getNotesBySemestre($etudiantId, $annee = null)
    {
        $notes = $this->getNotesWithMatieres($etudiantId, null, $annee);
        
        $result = [
            'semestre3' => [],
            'semestre4' => []
        ];
        
        foreach ($notes as $note) {
            if ($note['semestre'] == 3) {
                $result['semestre3'][] = $note;
            } else {
                $result['semestre4'][] = $note;
            }
        }
        
        return $result;
    }
    
    // Calculer les crédits validés par semestre
    public function calculateCredits($notes)
    {
        $credits = 0;
        foreach ($notes as $note) {
            if ($note['note'] !== null && $note['note'] >= 10) {
                $credits += $note['credits'];
            }
        }
        return $credits;
    }
    
    // Calculer la moyenne générale
    public function calculateAverage($notes)
    {
        $total = 0;
        $count = 0;
        foreach ($notes as $note) {
            if ($note['note'] !== null) {
                $total += $note['note'];
                $count++;
            }
        }
        return $count > 0 ? round($total / $count, 2) : 0;
    }
}