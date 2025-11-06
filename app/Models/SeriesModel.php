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

    public function getExercisesByWorkout($workoutId)
    {
        $builder = $this->db->table('series s');
        $builder->select('s.id_exercice, e.name AS exercise_name, s.reps, s.weight');
        $builder->join('exercise e', 'e.id = s.id_exercice', 'left');
        $builder->where('s.id_workout', $workoutId);
        $result = $builder->get()->getResultArray();

        $grouped = [];
        foreach ($result as $row) {
            $id = $row['id_exercice'];
            if (!isset($grouped[$id])) {
                $grouped[$id] = [
                    'id_exercice' => $id,
                    'name' => $row['exercise_name'],
                    'series' => [],
                ];
            }
            $grouped[$id]['series'][] = [
                'reps' => $row['reps'],
                'weight' => $row['weight'],
            ];
        }

        return array_values($grouped);
    }
}