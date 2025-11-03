<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Model;

class ExerciseMuscle extends BaseController
{
    protected $exerciseMuscleModel;

    public function __construct()
    {
        $this->exerciseMuscleModel = model('ExerciseMuscleModel');
    }

    public function store()
    {
        $data = $this->request->getPost();
        if ($this->exerciseMuscleModel->insert($data)) {
            $response = ['success' => true, 'message' => 'Muscle lié à l\'exercice.'];
        } else {
            $response = ['success' => false, 'message' => $this->exerciseMuscleModel->errors()];
        }

        return $this->response->setJSON($response);
    }

    public function delete()
    {
        $id = $this->request->getPost('id');
        if ($this->exerciseMuscleModel->delete($id)) {
            $response = ['success' => true, 'message' => 'Muscle retiré de l\'exercice.'];
        } else {
            $response = ['success' => false, 'message' => $this->exerciseMuscleModel->errors()];
        }

        return $this->response->setJSON($response);
    }
}