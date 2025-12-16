<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Model;

class Workout extends BaseController
{
    protected $workoutModel;
    protected $exerciseModel;
    protected $programModel;
    protected $seriesModel;

    public function __construct()
    {
        $this->workoutModel = new \App\Models\WorkoutModel();
        $this->exerciseModel = new \App\Models\ExerciseModel();
        $this->programModel = new \App\Models\ProgramModel();
        $this->seriesModel = new \App\Models\SeriesModel();
    }

    public function index()
    {
        return $this->view('/admin/workout/index', ['test'=>'coucou']);
    }

    public function create($id_program)
    {
        helper('form');
        $program = $this->programModel->find($id_program);
        $exercises = $this->exerciseModel->findAll();

        return $this->view('admin/workout/form', compact('program', 'exercises'));
    }

    public function save()
    {
        $data = $this->request->getPost();

        // --- BOUCLE PRINCIPALE : Un enregistrement par EXERCICE ---
        foreach ($data['exercises'] ?? [] as $exIndex => $exerciseData) {

            $idExercise = $exerciseData['id_exercice'];
            $restTime = $exerciseData['rest_time'];
            $seriesData = $exerciseData['series'];

            // Enregistrement dans la table WORKOUT (pour chaque exercice)
            $workoutInsertData = [
                'id_program'  => $data['id_program'],
                'id_exercice' => $idExercise,
                'rest_time'   => $restTime,
                'order'       => $exIndex + 1, // Ordre de l'exercice dans la séance
                'date'        => $data['day']
            ];

            // On insère l'exercice dans la table 'workout'
            $this->workoutModel->insert($workoutInsertData);

            // Enregistrement dans la table SERIES (pour chaque série de l'exercice)
            foreach ($seriesData as $serie) {

                $seriesInsertData = [
                    'id_program'  => $data['id_program'],
                    'id_exercice' => $idExercise,
                    'reps'        => $serie['reps'],
                    'weight'      => $serie['weight'],
                    'date'        => $data['day'],
                ];

                $this->seriesModel->insert($seriesInsertData);
            }
        }

        return redirect()->to('/admin/program/edit/'.$data['id_program'])
            ->with('success', 'Séance créée avec succès.');
    }

    public function edit($id)
    {
        // (Page similaire à create(), mais avec les valeurs existantes)
    }

    public function delete($id, $id_program)
    {
        $this->workoutModel->delete($id);
        return redirect()->to('/admin/program/edit/'.$id_program);
    }
}