<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Model;

class Category extends BaseController
{
    public function index()
    {
        return $this->view('/admin/category/index');
    }

    public function create()
    {
        helper('form');
        return $this->view('/admin/category/form');
    }

    public function edit($id)
    {
        helper('form');
        $cm = model('CategoryModel');
        $category = $cm->find($id);
        return $this->view('/admin/category/form', ['category' => $category]);
    }

    public function save()
    {
        $data = $this->request->getPost();
        $cm = model('CategoryModel');

        if ($cm->save($data)) {
            $id = $data['id'] ?? $cm->getInsertID();
            $this->success(isset($data['id']) ? 'Catégorie modifiée' : 'Catégorie ajoutée');
        } else {
            $id = '';
            foreach ($cm->errors() as $error) $this->error($error);
        }

        return $this->redirect('/admin/category/' . $id);
    }

    public function delete()
    {
        $id = $this->request->getPost('id');
        $cm = model('CategoryModel');

        if ($cm->delete($id)) {
            $response = ['success' => true, 'message' => 'Catégorie supprimée'];
        } else {
            $response = ['success' => false, 'message' => $cm->errors()];
        }

        return $this->response->setJSON($response);
    }
}