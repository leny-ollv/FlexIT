<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateExercicesTable extends Migration
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
            'rest_time' => ['type' => 'INT', 'null' => true],
            'reps' => ['type' => 'INT', 'null' => true],
            'nber_series' => ['type' => 'INT', 'null' => true],
            'time_series' => ['type' => 'INT', 'null' => true],
            'id_cat' => [
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
        $this->forge->addForeignKey('id_cat', 'categories', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('exercices');
    }

    public function down()
    {
        $this->forge->dropTable('exercices');
    }
}
