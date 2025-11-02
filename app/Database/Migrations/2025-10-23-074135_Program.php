<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Program extends Migration
{
    public function up()
    {
        $this->forge->addField([
           'id' => [
               'type' => 'INT',
               'constraint' => 11,
               'unsigned' => true,
               'auto_increment' => true,
               'null' => false,
           ],
           'name' => [
               'type' => 'VARCHAR',
               'constraint' => '255',
               'null' => false,
            ],
           'id_user' => [
               'type' => 'INT',
               'constraint' => 11,
               'unsigned' => true,
               'null' => true,
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('id_user', 'user', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('program');
    }

    public function down()
    {
        $this->forge->dropTable('program');
    }
}
