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

    public function __construct()
    {
        $this->workoutModel = new \App\Models\WorkoutModel();
        $this->exerciseModel = new \App\Models\ExerciseModel();
        $this->programModel = new \App\Models\ProgramModel();
    }

    public function create($id_program)
    {
        $program = $this->programModel->find($id_program);
        $exercises = $this->exerciseModel->findAll();

        return view('admin/workout/form', compact('program', 'exercises'));
    }

    public function save()
    {
        $data = $this->request->getPost();
        $idWorkout = $this->workoutModel->insert([
            'id_program' => $data['id_program'],
            'day' => $data['day']
        ]);

        // Sauvegarde des exercices
        foreach ($data['exercises'] ?? [] as $ex) {
            $idEx = $this->workoutModel->addExercise($idWorkout, $ex);
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