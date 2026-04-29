<?php

namespace App\Models;

use CodeIgniter\Model;

class NoteModel extends Model
{
    protected $table = 'notes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['etudiant_id', 'matiere_id', 'note', 'annee_academique'];
    protected $useTimestamps = false;



    public function addNote($data)
    {
        return $this->insert($data);
    }

    public function getNoteByEtudiantAndMatiere($etudiantId, $matiereId)
    {
        return $this->where('etudiant_id', $etudiantId)
            ->where('matiere_id', $matiereId)
            ->first();
    }

    public function updateNote($id, $data)
    {
        return $this->update($id, $data);
    }

    
}
