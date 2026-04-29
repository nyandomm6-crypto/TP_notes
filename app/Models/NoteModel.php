<?php

namespace App\Models;

use CodeIgniter\Model;

// CREATE TABLE IF NOT EXISTS notes (
//     id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//     etudiant_id     INT UNSIGNED     NOT NULL,
//     matiere_id      INT UNSIGNED     NOT NULL,
//     note_devoir     DECIMAL(5,2)         NULL DEFAULT NULL COMMENT 'Note de devoir (sur 20)',
//     note_examen     DECIMAL(5,2)         NULL DEFAULT NULL COMMENT 'Note d examen (sur 20)',
//     moyenne         DECIMAL(5,2)         NULL DEFAULT NULL COMMENT 'Calculée : devoir*40% + examen*60%',
//     annee_academique VARCHAR(9)       NOT NULL DEFAULT '2024-2025',
//     created_at      TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP,
//     updated_at      TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
//     CONSTRAINT fk_note_etudiant
//         FOREIGN KEY (etudiant_id) REFERENCES etudiants(id)
//         ON DELETE CASCADE ON UPDATE CASCADE,
//     CONSTRAINT fk_note_matiere
//         FOREIGN KEY (matiere_id) REFERENCES matieres(id)
//         ON DELETE RESTRICT ON UPDATE CASCADE,
//     CONSTRAINT uq_note_etudiant_matiere_annee
//         UNIQUE (etudiant_id, matiere_id, annee_academique)
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    
class NoteModel extends Model
{
    protected $table = 'notes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['etudiant_id', 'matiere_id', 'note_devoir', 'note_examen', 'moyenne', 'annee_academique'];
    protected $useTimestamps = false;
    
  
    
    public function addNote($data)
    {
        // Calcul de la moyenne
        $note_devoir = isset($data['note_devoir']) ? $data['note_devoir'] : null;
        $note_examen = isset($data['note_examen']) ? $data['note_examen'] : null;
        
        if ($note_devoir !== null && $note_examen !== null) {
            $data['moyenne'] = round(($note_devoir * 0.4) + ($note_examen * 0.6), 2);
        } else {
            $data['moyenne'] = null; // Si une des notes est manquante, la moyenne ne peut pas être calculée
        }
        
        return $this->insert($data);
    }
}

