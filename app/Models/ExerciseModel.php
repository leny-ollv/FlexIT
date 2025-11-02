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
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;

    protected $allowedFields = [
        'name',
        'description',
        'rest_time',
        'reps',
        'nber_series',
        'time_series',
        'id_cat',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $allowCallbacks = true;

    // 🔹 Exemple de méthode : récupérer un exercice complet avec sa catégorie
    public function getExercise($id): ?array
    {
        return $this
            ->select('exercices.*, categories.name as category_name')
            ->join('categories', 'exercices.id_cat = categories.id', 'left')
            ->where('exercices.id', $id)
            ->first();
    }

    // 🔹 Configuration DataTable pour affichage admin
    protected function getDataTableConfig(): array
    {
        return [
            'searchable_fields' => [
                'exercices.id',
                'exercices.name',
                'categories.name',
            ],
            'joins' => [
                [
                    'table' => 'categories',
                    'condition' => 'exercices.id_cat = categories.id',
                    'type' => 'left'
                ]
            ],
            'select' => '
                exercices.id,
                exercices.name,
                exercices.rest_time,
                exercices.reps,
                exercices.nber_series,
                exercices.time_series,
                categories.name as category_name,
                exercices.created_at,
                exercices.updated_at
            ',
        ];
    }
}
