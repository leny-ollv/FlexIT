<?php

namespace App\Models;

use CodeIgniter\Model;

class SeriesModel extends Model
{
    protected $table         = 'series';
    protected $primaryKey    = 'id';
    protected $useAutoIncrement = true;
    protected $returnType    = 'array';
    protected $protectFields = true;
    protected $allowedFields = ['id_program', 'id_exercice', 'reps', 'weight', 'date'];
    protected $useTimestamps = false;

    public function getByProgram(int $programId): array
    {
        return $this->where('id_program', $programId)->findAll();
    }

    public function getByExercise(int $exerciseId): array
    {
        return $this->where('id_exercice', $exerciseId)->findAll();
    }
}