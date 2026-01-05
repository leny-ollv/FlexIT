<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ExerciseMuscleSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id_exercice' => 7, 'id_muscle' => 4],
            ['id_exercice' => 1, 'id_muscle' => 5],
        ];
        $this->db->table('exercise_muscle')->insertBatch($data);
    }
}