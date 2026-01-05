<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class WorkoutSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_program'  => 1,
                'id_exercice' => 1,
                'date'        => '2025-12-16',
                'rest_time'   => '00:01:50',
                'order'       => 1
            ],
            [
                'id_program'  => 1,
                'id_exercice' => 7,
                'date'        => '2025-12-18',
                'rest_time'   => '00:01:20',
                'order'       => 1
            ],
            [
                'id_program'  => 7,
                'id_exercice' => 1,
                'date'        => '2025-12-18',
                'rest_time'   => '00:01:50',
                'order'       => 1
            ],
        ];
        $this->db->table('workout')->insertBatch($data);
    }
}