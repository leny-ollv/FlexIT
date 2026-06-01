<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ExerciseVariations extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => ['type' => 'VARCHAR', 'constraint' => 255],
            'description' => ['type' => 'TEXT', 'null' => true],
            'difficulty_level' => ['type' => 'TEXT', 'null' => true],
            'id_exercise' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'null' => true
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('id_exercise', 'exercices', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('exercices_variations');
    }

    public function down()
    {
        $this->forge->dropTable('exercices_variations');
    }
}
