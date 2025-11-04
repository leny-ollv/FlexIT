<?php

namespace App\Models;

use App\Traits\DataTableTrait;
use CodeIgniter\Model;

class CategoriesPrgmModel extends Model
{
    use DataTableTrait;

    protected $table            = 'categories_prgm';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['name'];
    protected $useTimestamps    = false;

    // Callbacks
    protected $allowCallbacks = true;

    public function getAllCategories(): array
    {
        return $this->orderBy('name', 'ASC')->findAll();
    }

    public function getCategory(int $id): ?array
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