<?php

namespace App\Models;

use App\Traits\DataTableTrait;
use App\Traits\Select2Searchable;
use CodeIgniter\Model;

class ExerciseVariationsModel extends Model
{
    use DataTableTrait;
    use Select2Searchable;

    protected $table            = 'exercices_variations';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name', 'description', 'difficulty_level', 'id_exercise'
    ];

    protected $useTimestamps = false;

    // Callbacks
    protected $allowCallbacks = true;

    protected $selectSearchableFields = ['name'];
    protected $select2DisplayField = 'name';

    public function getVariation(int $id): ?array
    {
        return $this
            ->select('exercices_variations.*, exercices.name as exercise_name')
            ->join('exercices', 'exercices_variations.id_exercise = exercices.id', 'left')
            ->where('exercices_variations.id', $id)
            ->first();
    }

    protected function getDataTableConfig(): array
    {
        return [
            'searchable_fields' => [
                'exercices_variations.id',
                'exercices_variations.name',
                'exercices_variations.description',
                'exercices_variations.difficulty_level',
                'exercices.name',
            ],
            'joins' => [
                [
                    'table' => 'exercices',
                    'condition' => 'exercices_variations.id_exercise = exercices.id',
                    'type' => 'left',
                ],
            ],
            'select' => 'exercices_variations.id, exercices_variations.name, exercices_variations.description, exercices_variations.difficulty_level, exercices_variations.id_exercise, exercices.name as exercise_name',
        ];
    }
}
