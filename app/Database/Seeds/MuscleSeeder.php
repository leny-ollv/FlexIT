<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MuscleSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id' => 2, 'name' => 'Biceps'],
            ['id' => 3, 'name' => 'Triceps'],
            ['id' => 4, 'name' => 'Grand dorsal'],
            ['id' => 5, 'name' => 'Pecs'],
        ];
        $this->db->table('muscles')->insertBatch($data);
    }
}