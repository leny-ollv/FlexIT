<?php

namespace App\Models;

use CodeIgniter\Model;

class WorkoutLogModel extends Model
{
    protected $table            = 'workout_log';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields    = [
        'id_user',
        'id_program',
        'workout_date',
        'rating',
        'fatigue',
        'comment'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getLogsWithDetails()
    {
        return $this->findAll();
    }
}