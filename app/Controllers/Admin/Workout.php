<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Model;

class Workout extends BaseController
{
    protected $workoutModel;

    public function __construct()
    {
        $this->workoutModel = model('WorkoutModel');
    }

    public function store()
    {
        $data = $this->request->getPost();
        if ($this->workoutModel->insert($data)) {
            $response = ['success' => true, 'message' => 'Exercice ajouté au programme.'];
        } else {
            $response = ['success' => false, 'message' => $this->workoutModel->errors()];
        }

        return $this->response->setJSON($response);
    }

    public function delete()
    {
        $id = $this->request->getPost('id');
        if ($this->workoutModel->delete($id)) {
            $response = ['success' => true, 'message' => 'Exercice retiré du programme.'];
        } else {
            $response = ['success' => false, 'message' => $this->workoutModel->errors()];
        }

        return $this->response->setJSON($response);
    }
}