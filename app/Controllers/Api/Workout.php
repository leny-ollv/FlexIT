<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Workout extends ResourceController
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
            $wm = model('WorkoutModel');
            $workout = $wm->find($id);
            return $this->respond($workout);
        }
        catch (\Exception $e) {
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
        //
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
    public function delete($id = null)
    {
        //
    }

    /**
     * Réécrit toutes les séances/exercices/séries d'un programme.
     * Reçoit en JSON : { "workouts": [ { "date": "YYYY-MM-DD",
     *   "exercises": [ { "id_exercice": int, "rest_time": "HH:MM:SS",
     *     "order": int, "series": [ { "reps": int, "weight": int }, ... ] }, ... ] }, ... ] }
     */
    public function save($programId = null)
    {
        if (!$programId) {
            return $this->fail('Program ID est requis', 400);
        }

        $payload = $this->request->getJSON(true);
        if (!is_array($payload) || !isset($payload['workouts']) || !is_array($payload['workouts'])) {
            return $this->fail('Payload invalide : workouts manquant', 400);
        }

        $pm = model('ProgramModel');
        $program = $pm->find($programId);
        if (!$program) {
            return $this->fail('Programme introuvable', 404);
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // On vide les anciennes données du programme
        $db->table('workout')->where('id_program', $programId)->delete();
        $db->table('series')->where('id_program', $programId)->delete();

        // On réinsère
        foreach ($payload['workouts'] as $workout) {
            $date = $workout['date'] ?? null;
            if (!$date) {
                continue;
            }
            foreach ($workout['exercises'] ?? [] as $exercise) {
                $db->table('workout')->insert([
                    'id_program'  => $programId,
                    'id_exercice' => (int) ($exercise['id_exercice'] ?? 0),
                    'date'        => $date,
                    'rest_time'   => $exercise['rest_time'] ?? '00:01:00',
                    'order'       => (int) ($exercise['order'] ?? 1),
                ]);
                foreach ($exercise['series'] ?? [] as $serie) {
                    $db->table('series')->insert([
                        'id_program'  => $programId,
                        'id_exercice' => (int) ($exercise['id_exercice'] ?? 0),
                        'reps'        => (int) ($serie['reps'] ?? 0),
                        'weight'      => (int) ($serie['weight'] ?? 0),
                        'date'        => $date,
                    ]);
                }
            }
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->respond([
                'success' => false,
                'message' => 'Erreur lors de la sauvegarde',
            ], 500);
        }

        return $this->respond([
            'success' => true,
            'message' => 'Programme sauvegardé',
        ]);
    }
}
