<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Model;

class ExerciseVariation extends BaseController
{
    public function index()
    {
        return $this->view('/admin/exercisevariation/index');
    }

    public function create()
    {
        helper('form');
        $em = model('ExerciseModel');
        $exercises = $em->findAll();

        return $this->view('/admin/exerciseVariation/form', [
            'exercises' => $exercises,
        ]);
    }

    public function edit($id)
    {
        helper('form');
        $evm = model('ExerciseVariationsModel');
        $em  = model('ExerciseModel');

        $variation = $evm->find($id);
        $exercises = $em->findAll();

        return $this->view('/admin/exerciseVariation/form', [
            'variation' => $variation,
            'exercises' => $exercises,
        ]);
    }

    public function save()
    {
        $data = $this->request->getPost();
        $evm = model('ExerciseVariationsModel');

        if ($evm->save($data)) {
            $id = $data['id'] ?? $evm->getInsertID();
            $this->success(isset($data['id']) ? 'Variation modifiée' : 'Variation ajoutée');
        } else {
            $id = '';
            foreach ($evm->errors() as $error) $this->error($error);
        }

        return $this->redirect('/admin/exerciseVariation/' . $id);
    }

    public function delete()
    {
        $id = $this->request->getPost('id');
        $evm = model('ExerciseVariationsModel');

        if ($evm->delete($id)) {
            $response = ['success' => true, 'message' => 'Variation supprimée'];
        } else {
            $response = ['success' => false, 'message' => $evm->errors()];
        }

        return $this->response->setJSON($response);
    }
}
