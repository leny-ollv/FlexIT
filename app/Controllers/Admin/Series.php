<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Model;

class Series extends BaseController
{
    protected $seriesModel;

    public function __construct()
    {
        $this->seriesModel = model('SeriesModel');
    }

    public function store()
    {
        $data = $this->request->getPost();
        if ($this->seriesModel->insert($data)) {
            $response = ['success' => true, 'message' => 'Série ajoutée.'];
        } else {
            $response = ['success' => false, 'message' => $this->seriesModel->errors()];
        }

        return $this->response->setJSON($response);
    }

    public function delete()
    {
        $id = $this->request->getPost('id');
        if ($this->seriesModel->delete($id)) {
            $response = ['success' => true, 'message' => 'Série supprimée.'];
        } else {
            $response = ['success' => false, 'message' => $this->seriesModel->errors()];
        }

        return $this->response->setJSON($response);
    }

    public function search()
    {
        $request = $this->request;

        // Vérification AJAX
        if (!$request->isAJAX()) {
            return $this->response->setJSON(['error' => 'Requête non autorisée']);
        }

        $um = Model('SeriesModel');

        // Paramètres de recherche
        $search = $request->getGet('search') ?? '';
        $page = (int)($request->getGet('page') ?? 1);
        $limit = 20;

        // Utilisation de la méthode du Model (via le trait)
        $result = $um->quickSearchForSelect2($search, $page, $limit);

        // Réponse JSON
        return $this->response->setJSON($result);
    }
}