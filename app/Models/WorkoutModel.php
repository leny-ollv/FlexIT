<?php

namespace App\Models;

use CodeIgniter\Model;

class WorkoutModel extends Model
{
    protected $table         = 'workout';
    protected $primaryKey    = 'id';
    protected $useAutoIncrement = true;
    protected $returnType    = 'array';
    protected $protectFields = true;
    protected $allowedFields = ['id_exercice', 'id_program', 'date', 'rest_time', 'order'];
    protected $useTimestamps = false;

    public function getWorkoutsByProgramId(int $programId): array
    {
        // Récupérer TOUTES les lignes (exercices) pour le programme donné
        $allExercises = $this->where('id_program', $programId)
            ->orderBy('date', 'ASC') // Pour afficher les séances par ordre chronologique
            ->orderBy('order', 'ASC') // Pour l'ordre des exercices dans la séance
            ->findAll();

        $workouts = [];

        // Regrouper les exercices dans des "séances" basées sur la date
        foreach ($allExercises as $exerciseRow) {
            $date = $exerciseRow['date']; // La date est l'identifiant de notre séance

            // Si c'est la première fois que nous rencontrons cette date (nouvelle séance)
            if (!isset($workouts[$date])) {
                $workouts[$date] = [
                    'id' => null, // La vue attend un 'id', on peut le laisser à null ou utiliser la date
                    'date' => $date, // La date est le champ important pour l'affichage
                    'exercises' => [] // Pour stocker tous les exercices de cette séance
                ];
            }

            // Ajouter la ligne d'exercice actuelle au tableau d'exercices de cette séance
            $workouts[$date]['exercises'][] = $exerciseRow;
        }
        return array_values($workouts);
    }

    public function getWorkoutByDate(int $programId, string $date): array
    {
        // On récupère les exercices pour ce programme à cette date précise
        return $this->where('id_program', $programId)
            ->where('date', $date)
            ->orderBy('order', 'ASC')
            ->findAll();
    }
}