<?php

namespace App\Models;

use CodeIgniter\Model;

class MatiereModel extends Model
{
    protected $table = 'matieres'; // Nom de la table associée
    protected $primaryKey = 'id'; // Clé primaire de la table

    protected $allowedFields = [
        'code',
        'intitule',
        'credits',
        'semestre',
        'parcours_id',
        'is_optionnelle',
        'created_at',
        'updated_at'
    ]; // Champs modifiables

    protected $useTimestamps = true; // Active les colonnes created_at et updated_at
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Fonction pour récupérer toutes les matières
    public function getAllMatieres()
    {
        return $this->findAll();
    }

    // Fonction pour récupérer une matière par son ID
    public function getMatiereById($id)
    {
        return $this->find($id);
    }

    // Fonction pour ajouter une nouvelle matière
    public function createMatiere($data)
    {
        return $this->insert($data);
    }

    // Fonction pour mettre à jour une matière existante
    public function updateMatiere($id, $data)
    {
        return $this->update($id, $data);
    }

    // Fonction pour supprimer une matière
    public function deleteMatiere($id)
    {
        return $this->delete($id);
    }

    // Ajoutez des méthodes spécifiques à l'entité Matiere si nécessaire
}