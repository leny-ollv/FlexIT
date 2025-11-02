<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ExerciseMuscle extends Migration
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
            'id_exercice' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],
            'id_muscle' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('id_exercice', 'exercices', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_muscle', 'muscles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('exercise_muscle');
    }

    public function down()
    {
        $this->forge->dropTable('exercise_muscle');
    }
}