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

        $idProgram = $data['id_program'];
        $date      = $data['day'];

        // SUPPRESSION DE LA SÉANCE EXISTANTE (WORKOUT + SERIES)
        $this->workoutModel
            ->where('id_program', $idProgram)
            ->where('date', $date)
            ->delete();

        $this->seriesModel
            ->where('id_program', $idProgram)
            ->where('date', $date)
            ->delete();

        // --- BOUCLE PRINCIPALE : Un enregistrement par EXERCICE ---
        foreach ($data['exercises'] ?? [] as $exerciseData) {

            $idExercise = $exerciseData['id_exercice'];
            $seriesData = $exerciseData['series'];
            $order = $exerciseData['order'];

            // Enregistrement dans la table WORKOUT (pour chaque exercice)
            $workoutInsertData = [
                'id_program'  => $data['id_program'],
                'id_exercice' => $idExercise,
                'date'        => $data['day'],
                'rest_time'   => $exerciseData['rest_time'],
                'order'       => $order
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

    public function edit($id_program, $date)
    {
        helper('form');
        $data['program'] = $this->programModel->find($id_program);
        $data['selected_date'] = $date;
        $data['workout_details'] = $this->workoutModel->getWorkoutByDate($id_program, $date);

        foreach ($data['workout_details'] as &$workout) {
            $workout['name'] = $this->exerciseModel->getExercise($workout['id_exercice']);
            $workout['series'] = $this->seriesModel->getSerieByProgramAndDate($id_program, $workout['id_exercice'] ,$date);
        }
        return $this->view('/admin/workout/form', $data);
    }

    public function delete($id_program, $date)
    {
        $this->seriesModel
            ->where('id_program', $id_program)
            ->where('date', $date)
            ->delete();

        $this->workoutModel
            ->where('id_program', $id_program)
            ->where('date', $date)
            ->delete();

        return redirect()
            ->to('/admin/program/edit/' . $id_program)
            ->with('success', 'Séance supprimée avec succès.');
    }
}