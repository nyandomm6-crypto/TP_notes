<?php

namespace App\Models;

use CodeIgniter\Model;

class MatiereModel extends Model
{
    protected $table            = 'matieres';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'code',
        'intitule',
        'credits',
        'semestre',
        'parcours_id'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation rules
    protected $validationRules = [
        'code'      => 'required|min_length[2]|max_length[10]|is_unique[matieres.code,id,{id}]',
        'intitule'  => 'required|min_length[3]|max_length[150]',
        'credits'   => 'required|integer|greater_than[0]|less_than_equal_to[30]',
        'semestre'  => 'required|integer|greater_than[0]|less_than_equal_to[8]',
        'parcours_id' => 'permit_empty|integer'
    ];

    protected $validationMessages = [
        'code' => [
            'required'   => 'Le code matière est obligatoire',
            'min_length' => 'Le code doit avoir au moins 2 caractères',
            'is_unique'  => 'Ce code existe déjà'
        ],
        'intitule' => [
            'required' => 'Le titre de la matière est obligatoire'
        ],
        'credits' => [
            'required' => 'Les crédits sont obligatoires',
            'integer'  => 'Les crédits doivent être un nombre',
            'greater_than' => 'Les crédits doivent être supérieurs à 0'
        ],
        'semestre' => [
            'required' => 'Le semestre est obligatoire',
            'integer'  => 'Le semestre doit être un nombre'
        ]
    ];

    /**
     * Récupérer les matières avec le nom du parcours
     */
    public function getWithParcours($id = null)
    {
        $builder = $this->db->table('matieres m')
            ->select('m.*, COALESCE(p.libelle, \'Commun\') as parcours_libelle')
            ->join('parcours p', 'p.id = m.parcours_id', 'left');

        if ($id) {
            return $builder->where('m.id', $id)->get()->getRowArray();
        }

        return $builder->orderBy('m.semestre', 'ASC')
            ->orderBy('m.intitule', 'ASC')
            ->get()->getResultArray();
    }

    /**
     * Obtenir les matières par parcours
     */
    public function getByParcours($parcoursId)
    {
        return $this->where('parcours_id', $parcoursId)
            ->orderBy('semestre', 'ASC')
            ->orderBy('intitule', 'ASC')
            ->findAll();
    }

    /**
     * Obtenir les matières communes (parcours_id = NULL)
     */
    public function getCommunes()
    {
        return $this->where('parcours_id', null)
            ->orderBy('semestre', 'ASC')
            ->orderBy('intitule', 'ASC')
            ->findAll();
    }

    /**
     * Obtenir les matières par semestre
     */
    public function getBySemestre($semestre)
    {
        return $this->where('semestre', $semestre)
            ->orderBy('intitule', 'ASC')
            ->findAll();
    }

    /**
     * Obtenir les matières par semestre et parcours
     */
    public function getBySemestreAndParcours($semestre, $parcoursId)
    {
        return $this->where('semestre', $semestre)
            ->groupStart()
            ->where('parcours_id', $parcoursId)
            ->orWhere('parcours_id', null)
            ->groupEnd()
            ->orderBy('intitule', 'ASC')
            ->findAll();
    }

    /**
     * Rechercher des matières
     */
    public function search($keyword)
    {
        return $this->groupStart()
            ->like('code', $keyword)
            ->orLike('intitule', $keyword)
            ->groupEnd()
            ->orderBy('intitule', 'ASC')
            ->findAll();
    }

    /**
     * Obtenir tous les semestres
     */
    public function getAllSemestres()
    {
        return $this->select('DISTINCT semestre')
            ->orderBy('semestre', 'ASC')
            ->findAll();
    }

    /**
     * Obtenir le nombre de matières par semestre
     */
    public function getCountBySemestre()
    {
        return $this->select('semestre, COUNT(*) as count')
            ->groupBy('semestre')
            ->orderBy('semestre', 'ASC')
            ->findAll();
    }
}
