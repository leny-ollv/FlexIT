<?php

namespace App\Models;

use App\Traits\DataTableTrait;
use CodeIgniter\Model;

class MuscleModel extends Model
{
    use DataTableTrait;

    protected $table            = 'muscles';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['name'];
    protected $useTimestamps    = false;

    // Callbacks
    protected $allowCallbacks = true;

    public function getAllMuscles(): array
    {
        return $this->orderBy('name', 'ASC')->findAll();
    }

    public function getMuscle(int $id): ?array
    {
        return $this->where('id', $id)->first();
    }

    protected function getDataTableConfig(): array
    {
        return [
            'searchable_fields' => ['id', 'name'], // Champs par défaut
            'joins' => [],
            'select' => '*',
            'with_deleted' => false, // Inclure les enregistrements soft deleted
        ];
    }
}