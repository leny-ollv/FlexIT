<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProgramSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id' => 1, 'name' => 'Test Program', 'id_user' => 1],
            ['id' => 7, 'name' => 'PPL',          'id_user' => 1],
        ];
        $this->db->table('program')->insertBatch($data);
    }
}