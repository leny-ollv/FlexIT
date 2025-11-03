<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Model;

class Friend extends BaseController
{
    protected $friendModel;

    public function __construct()
    {
        $this->friendModel = model('FriendModel');
    }

    public function store()
    {
        $data = $this->request->getPost();
        if ($this->friendModel->insert($data)) {
            $response = ['success' => true, 'message' => 'Amitié ajoutée.'];
        } else {
            $response = ['success' => false, 'message' => $this->friendModel->errors()];
        }

        return $this->response->setJSON($response);
    }

    public function delete()
    {
        $id = $this->request->getPost('id');
        if ($this->friendModel->delete($id)) {
            $response = ['success' => true, 'message' => 'Amitié supprimée.'];
        } else {
            $response = ['success' => false, 'message' => $this->friendModel->errors()];
        }

        return $this->response->setJSON($response);
    }
}