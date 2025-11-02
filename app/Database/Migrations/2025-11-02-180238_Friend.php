<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Friend extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user_1' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_user_2' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addPrimaryKey(['id_user_1', 'id_user_2']);
        $this->forge->addForeignKey('id_user_1', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_user_2', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('friend');
    }

    public function down()
    {
        $this->forge->dropTable('friend');
    }
}