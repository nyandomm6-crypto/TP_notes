<?php

namespace App\Models;

use CodeIgniter\Model;

class ParcoursModel extends Model
{
    protected $table            = 'parcours';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['code', 'libelle', 'responsable', 'semestre'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation rules
    protected $validationRules = [
        'code' => 'required|min_length[2]|max_length[10]|is_unique[parcours.code,id,{id}]',
        'libelle' => 'required|min_length[3]|max_length[150]',
        'semestre' => 'required|integer|in_list[3,4]'
    ];
}