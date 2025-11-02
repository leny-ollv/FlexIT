<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FriendRequest extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'requester_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'receiver_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addPrimaryKey(['requester_id', 'receiver_id']);
        $this->forge->addForeignKey('requester_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('receiver_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('friend_request');
    }

    public function down()
    {
        $this->forge->dropTable('friend_request');
    }
}