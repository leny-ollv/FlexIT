<?php

namespace App\Models;

use App\Traits\Select2Searchable;
use CodeIgniter\Model;

class SeriesModel extends Model
{
    use Select2Searchable;

    protected $table         = 'series';
    protected $primaryKey    = 'id';
    protected $useAutoIncrement = true;
    protected $returnType    = 'array';
    protected $protectFields = true;
    protected $allowedFields = ['id_program', 'id_exercice', 'reps', 'weight', 'date'];
    protected $useTimestamps = false;

    protected $selectSearchableFields = ['name'];
    protected $select2DisplayField = 'name';

    public function getByProgram(int $programId): array
    {
        return $this->where('id_program', $programId)->findAll();
    }

    public function getByExercise(int $exerciseId): array
    {
        return $this->where('id_exercice', $exerciseId)->findAll();
    }

    public function getSerieByProgramAndDate(int $programId, int $exerciseId, string $date): array
    {
        // On récupère les exercices pour ce programme à cette date précise
        return $this->where('id_program', $programId)
            ->where('id_exercice', $exerciseId)
            ->where('date', $date)
            ->findAll();
    }
}