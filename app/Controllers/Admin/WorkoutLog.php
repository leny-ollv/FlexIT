<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\WorkoutLogModel;

class WorkoutLog extends BaseController
{
    public function index()
    {
        return $this->view('/admin/workout_log/index');
    }

    public function show(int $id)
    {
        $model = new WorkoutLogModel();
        $workout_log = $model->find($id);

        if (!$workout_log) {
            return redirect()->to('/admin/workoutlog')->with('error', 'Journal introuvable.');
        }

        return $this->view('/admin/workout_log/show', [
            'workout_log' => $workout_log,
            'program_name' => $program['name'] ?? 'Programme inconnu'
        ]);
    }

    public function delete(int $id)
    {
        $model = new WorkoutLogModel();

        if ($model->delete($id)) {
            return redirect()->to('/admin/workoutlog')->with('success', 'Journal supprimée avec succès.');
        }

        return redirect()->to('/admin/workoutlog')->with('error', 'Erreur lors de la suppression.');
    }
}
