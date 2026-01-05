<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Workout extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_program' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_exercice' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],
            'date' => ['type' => 'DATE', 'null' => true],
            'rest_time' => ['type' => 'TIME', 'null' => true],
            '`order`' => ['type' => 'INT', 'null' => true],
        ]);

        $this->forge->addPrimaryKey(['id_program', 'id_exercice', 'date']);
        $this->forge->addForeignKey('id_program', 'program', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_exercice', 'exercices', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('workout');
    }

    public function down()
    {
        $this->forge->dropTable('workout');
    }
}