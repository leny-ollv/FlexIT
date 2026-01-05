<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategoryPrgmSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id' => 1, 'name' => 'Force'],
            ['id' => 2, 'name' => 'Hypértrophie'],
        ];
        $this->db->table('categories_prgm')->insertBatch($data);
    }
}