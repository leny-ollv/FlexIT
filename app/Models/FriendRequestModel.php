<?php

namespace App\Models;

use CodeIgniter\Model;

class FriendRequestModel extends Model
{
    protected $table         = 'friend_request';
    protected $primaryKey    = 'id';
    protected $useAutoIncrement = true;
    protected $returnType    = 'array';
    protected $protectFields = true;
    protected $allowedFields = ['requester_id', 'receiver_id'];
    protected $useTimestamps = false;

    public function getRequestsForUser(int $userId): array
    {
        return $this->where('receiver_id', $userId)->findAll();
    }
}