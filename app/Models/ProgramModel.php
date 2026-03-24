<?php

namespace App\Models;

use App\Traits\DataTableTrait;
use CodeIgniter\Model;

class ProgramModel extends Model
{
    use DataTableTrait;

    protected $table            = 'program';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'id_user'];
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

    public function getProgram($id) : array {
        return
            $this
                ->select('program.*, user.username as creator_name')
                ->join('user', 'program.id_user = user.id', 'left')
                ->where('program.id', $id)
                ->first();
    }

    public function getProgramByIdUser($id) : array {
        return
            $this
                ->select('program.id, program.name')
                ->where('program.id_user', $id)
                ->findAll();
    }

    protected function getDataTableConfig(): array
    {
        return [
            'searchable_fields' => [
                'program.id',
                'program.name',
                'user.username'
            ],
            'joins' => [
                [
                    'table' => 'user',
                    'condition' => 'program.id_user = user.id',
                    'type' => 'left'
                ]
            ],
            'select' => 'program.id, program.name, user.username as creator_name, program.id_user',
        ];
    }
}
