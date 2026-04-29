<?php

namespace App\Models;

use CodeIgniter\Model;

class EtudiantModel extends Model
{
    protected $table            = 'etudiants';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'matricule',
        'nom',
        'prenom',
        'parcours_id',
        'annee_academique'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation rules
    protected $validationRules = [
        'matricule' => 'required|min_length[6]|max_length[20]|is_unique[etudiants.matricule,id,{id}]',
        'nom'       => 'required|min_length[2]|max_length[100]',
        'prenom'    => 'required|min_length[2]|max_length[100]',
        'parcours_id' => 'required|integer|is_not_unique[parcours.id]',
        'annee_academique' => 'required|regex_match[/(19|20)[0-9]{2}-(19|20)[0-9]{2}/]'
    ];

    protected $validationMessages = [
        'matricule' => [
            'required'   => 'Le matricule est obligatoire',
            'min_length' => 'Le matricule doit avoir au moins 6 caractères',
            'is_unique'  => 'Ce matricule existe déjà'
        ],
        'nom' => [
            'required' => 'Le nom est obligatoire'
        ],
        'prenom' => [
            'required' => 'Le prénom est obligatoire'
        ],
        'parcours_id' => [
            'required'        => 'Le parcours est obligatoire',
            'is_not_unique'   => 'Le parcours sélectionné n\'existe pas'
        ]
    ];

    // Relations
    public function getWithParcours($id = null)
    {
        $builder = $this->db->table('etudiants e')
            ->select('e.*, p.code, p.libelle as parcours_libelle')
            ->join('parcours p', 'p.id = e.parcours_id');

        if ($id) {
            return $builder->where('e.id', $id)->get()->getRowArray();
        }

        return $builder->get()->getResultArray();
    }

    // Recherche d'étudiants
    public function search($keyword)
    {
        return $this->groupStart()
            ->like('matricule', $keyword)
            ->orLike('nom', $keyword)
            ->orLike('prenom', $keyword)
            ->groupEnd()
            ->orderBy('nom', 'ASC')
            ->findAll();
    }

    // Obtenir les étudiants par parcours
    public function getByParcours($parcoursId)
    {
        return $this->where('parcours_id', $parcoursId)
            ->orderBy('nom', 'ASC')
            ->findAll();
    }

    // Obtenir tous les etudiants 
    public function findAll(?int $limit = null, int $offset = 0)
    {
        return parent::findAll($limit, $offset);
    }
}
