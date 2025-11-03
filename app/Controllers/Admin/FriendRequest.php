<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Model;

class FriendRequest extends BaseController
{
    protected $friendRequestModel;

    public function __construct()
    {
        $this->friendRequestModel = model('FriendRequestModel');
    }

    public function store()
    {
        $data = $this->request->getPost();
        if ($this->friendRequestModel->insert($data)) {
            $response = ['success' => true, 'message' => 'Demande d\'ami envoyée.'];
        } else {
            $response = ['success' => false, 'message' => $this->friendRequestModel->errors()];
        }

        return $this->response->setJSON($response);
    }

    public function delete()
    {
        $id = $this->request->getPost('id');
        if ($this->friendRequestModel->delete($id)) {
            $response = ['success' => true, 'message' => 'Demande d\'ami supprimée.'];
        } else {
            $response = ['success' => false, 'message' => $this->friendRequestModel->errors()];
        }

        return $this->response->setJSON($response);
    }
}