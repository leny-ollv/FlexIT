<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Model;

class Muscle extends BaseController
{
    public function index()
    {
        return $this->view('/admin/muscle/index');
    }

    public function create()
    {
        helper('form');
        return $this->view('/admin/muscle/form');
    }

    public function edit($id)
    {
        helper('form');
        $mm = model('MuscleModel');
        $muscle = $mm->find($id);
        return $this->view('/admin/muscle/form', ['muscle' => $muscle]);
    }

    public function save()
    {
        $data = $this->request->getPost();
        $mm = model('MuscleModel');

        if ($mm->save($data)) {
            $id = $data['id'] ?? $mm->getInsertID();
            $this->success(isset($data['id']) ? 'Muscle modifié' : 'Muscle ajouté');
        } else {
            $id = '';
            foreach ($mm->errors() as $error) $this->error($error);
        }

        return $this->redirect('/admin/muscle/' . $id);
    }

    public function delete()
    {
        $id = $this->request->getPost('id');
        $mm = model('MuscleModel');

        if ($mm->delete($id)) {
            $response = ['success' => true, 'message' => 'Muscle supprimé'];
        } else {
            $response = ['success' => false, 'message' => $mm->errors()];
        }

        return $this->response->setJSON($response);
    }
}