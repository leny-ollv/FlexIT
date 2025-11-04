<?php

namespace App\Models;

use App\Traits\DataTableTrait;
use CodeIgniter\Model;

class ExerciseModel extends Model
{
    use DataTableTrait;

    protected $table            = 'exercices';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name', 'description', 'rest_time', 'reps', 'nber_series', 'time_series', 'id_cat'
    ];
    protected $useTimestamps = false;

    // Callbacks
    protected $allowCallbacks = true;

    public function getExercise(int $id): ?array
    {
        return $this
            ->select('exercices.*, categories.name as category_name')
            ->join('categories', 'exercices.id_cat = categories.id', 'left')
            ->where('exercices.id', $id)
            ->first();
    }

    public function getAllWithCategory(): array
    {
        return $this
            ->select('exercices.*, categories.name as category_name')
            ->join('categories', 'exercices.id_cat = categories.id', 'left')
            ->orderBy('exercices.name', 'ASC')
            ->findAll();
    }

    protected function getDataTableConfig(): array
    {
        return [
            'searchable_fields' => [
                'exercices.id',
                'exercices.name',
                'categories.name',
                'exercices.description',
                'exercices.reps',
                'exercices.nber_series',
                'exercices.rest_time'
            ],
            'joins' => [
                [
                    'table' => 'categories',
                    'condition' => 'exercices.id_cat = categories.id',
                    'type' => 'left'
                ],
                [
                    'table' => 'exercise_muscle',
                    'condition' => 'exercices.id = exercise_muscle.id_exercice',
                    'type' => 'left'
                ],
                [
                    'table' => 'muscles',
                    'condition' => 'exercise_muscle.id_muscle = muscles.id',
                    'type' => 'left'
                ]
            ],
            'select' => 'exercices.id, exercices.name, categories.name as category_name, muscles.name as muscle_name, exercices.description, exercices.reps, exercices.nber_series, exercices.rest_time, exercices.id_cat',
        ];
    }
}