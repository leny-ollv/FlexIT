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
            $sm = model('SerieModel');

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
}
