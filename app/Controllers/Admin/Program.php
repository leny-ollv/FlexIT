<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Model;

class Program extends BaseController
{
    public function index()
    {
        return $this->view('/admin/program/index', ['test'=>'coucou']);
    }

    public function create()
    {
        helper('form');
        return $this->view('/admin/program/form');
    }

    public function edit($id)
    {
        helper('form');

        $pm = model('ProgramModel');
        $em = model('ExerciseModel');
        $wm = model('WorkoutModel');
        $sm = model('SeriesModel');

        // Récupérer le programme avec le nom du créateur
        $program = $pm->getProgram($id);

        // Tous les exercices pour les selects
        $exercises = $em->getAllWithCategory();

        // Les workouts associés au programme
        $workouts = $wm->getExercisesByProgram($id);

        // Pour chaque workout, récupérer ses séries
        foreach ($workouts as &$workout) {
            $workout['series'] = $sm->getByExercise($workout['id_exercice']);
        }

        return $this->view('/admin/program/form', [
            'program' => $program,
            'exercises' => $exercises,
            'workouts' => $workouts
        ]);
    }

    public function save() {
        $data = $this->request->getPost();
        $pm = Model('ProgramModel');
        if ($pm->save($data)) {
            if (isset($data['id'])) {
                $id = $data['id'];
                $this->success('Programme bien modifié');
            } else {
                $id = $pm->getinsertID();
                $this->success('Programme bien ajouté');
            }
        } else {
            $id = '';
            foreach ($pm->errors() as $error) {
                $this->error($error);
            }
        }
        return $this->redirect('/admin/program/' .$id);
    }

    public function delete() {
        $id = $this->request->getPost('id');
        $pm = Model('ProgramModel');
        if ($pm->delete($id)) {
            $response = [
                'success' => true,
                'message' => 'Le programme à bien été supprimé'
            ];
        } else {
            $response = ['success' => false];
            foreach($pm->errors() as $error) {
                $response['message'][] = $error;
            }
        }
        return $this->response->setJSON($response);
    }
}