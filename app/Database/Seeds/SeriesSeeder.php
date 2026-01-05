<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SeriesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id_program' => 1, 'id_exercice' => 1, 'reps' => 8, 'weight' => 112, 'date' => '2025-12-16'],
            ['id_program' => 1, 'id_exercice' => 1, 'reps' => 8, 'weight' => 12,  'date' => '2025-12-16'],
            ['id_program' => 7, 'id_exercice' => 1, 'reps' => 8, 'weight' => 85,  'date' => '2025-12-18'],
        ];
        $this->db->table('series')->insertBatch($data);
    }
}