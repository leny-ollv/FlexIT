<?php

namespace App\Models;

use CodeIgniter\Model;

class WorkoutModel extends Model
{
    protected $table         = 'workout';
    protected $primaryKey    = 'id';
    protected $useAutoIncrement = true;
    protected $returnType    = 'array';
    protected $protectFields = true;
    protected $allowedFields = ['id_exercice', 'id_program', 'date', 'rest_time', '`order`'];
    protected $useTimestamps = false;
}