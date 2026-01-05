<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Series extends Migration
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
            'reps' => ['type' => 'INT', 'null' => true],
            'weight' => ['type' => 'DECIMAL', 'null' => true],
            'date' => ['type' => 'DATE', 'null' => true],
        ]);

        $this->forge->addForeignKey('id_program', 'program', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_exercice', 'exercices', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('series');
    }

    public function down()
    {
        $this->forge->dropTable('series');
    }
}