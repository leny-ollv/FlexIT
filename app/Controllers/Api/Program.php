<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Program extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        //
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        try {
            $pm = model('ProgramModel');
            $wm = model('WorkoutModel');
            $sm = model('SeriesModel');

            $program = $pm->find($id);
            $workouts = $wm->getWorkoutsByProgramId($id);

            foreach ($workouts as &$workout) {
                foreach ($workout['exercises'] as &$exercise) {
                    $exercise['series'] = $sm->getSerieByProgramAndDate($id, $exercise['id_exercice'], $exercise['date']);
                }
            }
            $program['workouts'] = $workouts;

            return $this->respond($program);
        }
        catch (\Exception $e) {
            return $this->respond(['message' => $e->getMessage()], 500);
        }
    }

    public function showall($id = null)
    {
        try {
            if (!$id) {
                return $this->fail('User ID est requis', 400);
            }

            $pm = model('ProgramModel');
            $program = $pm->getProgramByIdUser($id);
            return $this->respond($program);

        } catch (\Exception $e) {
            return $this->respond(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $name    = $this->request->getPost('name');
        $userId  = $this->request->getPost('id_user');

        $pm = model('ProgramModel');

        if (empty($name) || empty($userId)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Données manquantes (nom ou id_user)'
            ]);
        }

        $data = [
            'name'    => $name,
            'id_user' => $userId,
        ];

        if ($pm->insert($data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Programme créé avec succès !'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur lors de l’insertion en base.'
            ]);
        }
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null) {
        $id = $this->request->getPost('id');
        $userId = $this->request->getPost('id_user');

        $pm = model('ProgramModel');

        // VERIFICATION : Est-ce que ce programme appartient à cet utilisateur
        $program = $pm->where('id', $id)->where('id_user', $userId)->first();

        if (!$program) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Accès refusé ou programme inexistant'
            ]);
        }

        // Si oui, alors on supprime le programme
        if ($pm->delete($id)) {
            $response = [
                'success' => true,
                'message' => 'Le programme a bien été supprimé'
            ];
        } else {
            $response = ['success' => false, 'message' => 'Erreur lors de la suppression'];
        }

        return $this->response->setJSON($response);
    }
}
