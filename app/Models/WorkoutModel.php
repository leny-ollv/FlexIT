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
    protected $allowedFields = ['id_exercice', 'id_program', 'date', 'rest_time', '`order`'];
    protected $useTimestamps = false;

    public function getExercisesByProgram(int $programId): array
    {
        return $this->where('id_program', $programId)->findAll();
    }

    public function getWorkoutsWithExercises($programId)
    {
        $seriesModel = new SeriesModel();

        $workouts = $this->where('id_program', $programId)
            ->orderBy('order', 'ASC')
            ->findAll();

        foreach ($workouts as &$workout) {
            $workout['exercises'] = $seriesModel->getExercisesByWorkout($workout['id']);
        }

        return $workouts;
    }
}