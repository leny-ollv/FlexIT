<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ExerciceSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id'          => 1,
                'name'        => 'Bench',
                'description' => 'Développé couché',
                'rest_time'   => 150,
                'reps'        => 8,
                'nber_series' => 3,
                'id_cat'      => 1
            ],
            [
                'id'          => 7,
                'name'        => 'Tractions',
                'description' => 'Tractions pronation',
                'rest_time'   => 120,
                'reps'        => 10,
                'nber_series' => 3,
                'id_cat'      => 3
            ],
        ];
        $this->db->table('exercices')->insertBatch($data);
    }
}