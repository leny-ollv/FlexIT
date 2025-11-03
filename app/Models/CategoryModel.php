<?php

namespace App\Models;

use App\Traits\DataTableTrait;
use CodeIgniter\Model;

class CategoryModel extends Model
{
    use DataTableTrait;

    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name'];

    protected $useTimestamps = false;
    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

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
            'searchable_fields' => ['categories.id', 'categories.name'],
            'select' => 'categories.id, categories.name',
        ];
    }
}