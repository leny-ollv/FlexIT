<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Model;

class Exercise extends BaseController
{
    public function index()
    {
        return $this->view('/admin/exercise/index');
    }

    public function create()
    {
        helper('form');
        $cm = model('CategoryModel');
        $categories = $cm->findAll();
        return $this->view('/admin/exercise/form', ['categories' => $categories]);
    }

    public function edit($id)
    {
        helper('form');
        $em = model('ExerciseModel');
        $cm = model('CategoryModel');
        $exercise = $em->find($id);
        $categories = $cm->findAll();
        return $this->view('/admin/exercise/form', ['exercise' => $exercise, 'categories' => $categories]);
    }

    public function save()
    {
        $data = $this->request->getPost();
        $em = model('ExerciseModel');

        if ($em->save($data)) {
            $id = $data['id'] ?? $em->getInsertID();
            $this->success(isset($data['id']) ? 'Exercice modifié' : 'Exercice ajouté');
        } else {
            $id = '';
            foreach ($em->errors() as $error) $this->error($error);
        }

        return $this->redirect('/admin/exercise/' . $id);
    }

    public function delete()
    {
        $id = $this->request->getPost('id');
        $em = model('ExerciseModel');

        if ($em->delete($id)) {
            $response = ['success' => true, 'message' => 'Exercice supprimé'];
        } else {
            $response = ['success' => false, 'message' => $em->errors()];
        }

        return $this->response->setJSON($response);
    }
}