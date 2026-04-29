<?php

namespace App\Models;

use CodeIgniter\Model;

class LoanModel extends Model
{
    protected $table = 'emprunts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['livre_id', 'emprunteur_nom', 'date_emprunt', 'date_retour'];
    protected $useTimestamps = false;
    
    // Dernier emprunt d'un livre
    public function getLastLoan($bookId)
    {
        return $this->where('livre_id', $bookId)
                    ->orderBy('date_emprunt', 'DESC')
                    ->first();
    }
    
    // Emprunt actif (sans date de retour)
    public function getActiveLoan($bookId)
    {
        return $this->where('livre_id', $bookId)
                    ->where('date_retour IS NULL')
                    ->first();
    }
}