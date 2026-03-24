<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class WorkoutLog extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'id_program' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'workout_date' => [
                'type' => 'DATE',
            ],
            'rating' => [
                'type'       => 'INT',
                'constraint' => 5,
                'null'       => true,
            ],
            'fatigue' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'unsigned'   => true,
                'default'    => 1,
            ],
            'comment' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('id_program', 'program', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('id_user', 'user', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('workout_log');
    }

    public function down()
    {
        $this->forge->dropTable('workout_log');
    }
}
