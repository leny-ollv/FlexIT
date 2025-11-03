<?php

namespace App\Models;

use CodeIgniter\Model;

class FriendModel extends Model
{
    protected $table         = 'friend';
    protected $primaryKey    = 'id';
    protected $useAutoIncrement = true;
    protected $returnType    = 'array';
    protected $protectFields = true;
    protected $allowedFields = ['id_user_1', 'id_user_2'];
    protected $useTimestamps = false;

    public function getFriendsOfUser(int $userId): array
    {
        return $this->where('id_user_1', $userId)
            ->orWhere('id_user_2', $userId)
            ->findAll();
    }
}