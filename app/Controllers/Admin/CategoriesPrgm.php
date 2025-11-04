<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Model;

class CategoriesPrgm extends BaseController
{
    public function index()
    {
        return $this->view('/admin/categories_prgm/index');
    }

    public function create()
    {
        helper('form');
        return $this->view('/admin/categories_prgm/form');
    }

    public function edit($id)
    {
        helper('form');
        $cpm = model('CategoriesPrgmModel');
        $category = $cpm->find($id);
        return $this->view('/admin/categories_prgm/form', ['category' => $category]);
    }

    public function save()
    {
        $data = $this->request->getPost();
        $cpm = model('CategoriesPrgmModel');

        if ($cpm->save($data)) {
            $id = $data['id'] ?? $cpm->getInsertID();
            $this->success(isset($data['id']) ? 'Catégorie de programme modifiée' : 'Catégorie de programme ajoutée');
        } else {
            $id = '';
            foreach ($cpm->errors() as $error) $this->error($error);
        }

        return $this->redirect('/admin/categories_prgm/' . $id);
    }

    public function delete()
    {
        $id = $this->request->getPost('id');
        $cpm = model('CategoriesPrgmModel');

        if ($cpm->delete($id)) {
            $response = ['success' => true, 'message' => 'Catégorie de programme supprimée'];
        } else {
            $response = ['success' => false, 'message' => $cpm->errors()];
        }

        return $this->response->setJSON($response);
    }
}
