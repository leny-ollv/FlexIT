<?php

namespace App\Models;

use CodeIgniter\Model;

class ExerciseMuscleModel extends Model
{
    protected $table         = 'exercise_muscle';
    protected $primaryKey    = 'id';
    protected $useAutoIncrement = true;
    protected $returnType    = 'array';
    protected $protectFields = true;
    protected $allowedFields = ['id_exercice', 'id_muscle'];
    protected $useTimestamps = false;

    public function getMusclesByExercise(int $exerciseId): array
    {
        return $this->where('id_exercice', $exerciseId)->findAll();
    }

    public function getExercisesByMuscle(int $muscleId): array
    {
        return $this->where('id_muscle', $muscleId)->findAll();
    }
}