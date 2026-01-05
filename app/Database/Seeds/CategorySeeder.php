<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id' => 1, 'name' => 'Poids libre'],
            ['id' => 2, 'name' => 'Machine'],
            ['id' => 3, 'name' => 'Poids du corps'],
        ];
        $this->db->table('categories')->insertBatch($data);
    }
}