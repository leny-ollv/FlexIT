<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Model;

class Exercise extends BaseController
{
    public function index()
    {
        return $this->view('/admin/exercise/index');
    }

    public function create()
    {
        helper('form');
        $cm = model('CategoryModel');
        $mm  = model('MuscleModel');

        $categories = $cm->findAll();
        $muscles = $mm->findAll();

        return $this->view('/admin/exercise/form', [
            'categories' => $categories,
            'muscles' => $muscles
        ]);
    }

    public function edit($id)
    {
        helper('form');
        $em = model('ExerciseModel');
        $cm = model('CategoryModel');
        $emm = model('ExerciseMuscleModel');
        $mm  = model('MuscleModel');

        $exercise = $em->find($id);
        $categories = $cm->findAll();
        $muscles = $mm->findAll();
        $exerciseMuscle = $emm->where('id_exercice', $id)->first();
        $selectedMuscleId = $exerciseMuscle['id_muscle'] ?? null;

        return $this->view('/admin/exercise/form', [
            'exercise' => $exercise,
            'categories' => $categories,
            'muscles' => $muscles,
            'selectedMuscleId' => $selectedMuscleId
        ]);
    }

    public function save()
    {
        $data = $this->request->getPost();
        $em = model('ExerciseModel');
        $emm = model('ExerciseMuscleModel'); // modèle pour la table pivot

        // Sauvegarde ou mise à jour de l'exercice
        if ($em->save($data)) {
            $exerciseId = $data['id'] ?? $em->getInsertID();

            // Gérer la relation exercice ↔ muscle
            if (!empty($data['id_muscle'])) {
                // Supprimer l'ancienne association si elle existe
                $emm->where('id_exercice', $exerciseId)->delete();

                // Créer la nouvelle association
                $emm->insert([
                    'id_exercice' => $exerciseId,
                    'id_muscle'   => $data['id_muscle']
                ]);
            }

            $this->success(isset($data['id']) ? 'Exercice modifié' : 'Exercice ajouté');
        } else {
            foreach ($em->errors() as $error) {
                $this->error($error);
            }
        }

        return $this->redirect('/admin/exercise/' . ($data['id'] ?? $em->getInsertID()));
    }

    public function delete()
    {
        $id = $this->request->getPost('id');
        $em = model('ExerciseModel');
        $emm = model('ExerciseMuscleModel'); // modèle pour la table pivot

        // Supprimer d'abord les associations dans exercise_muscle
        $emm->where('id_exercice', $id)->delete();

        // Puis supprimer l'exercice lui-même
        if ($em->delete($id)) {
            $response = ['success' => true, 'message' => 'Exercice supprimé'];
        } else {
            $response = ['success' => false, 'message' => $em->errors()];
        }

        return $this->response->setJSON($response);
    }

    public function getSeries($id)
    {
        $exerciseModel = model('ExerciseModel');
        $seriesModel = model('SeriesModel');

        // On récupère l'exercice
        $exercise = $exerciseModel->find($id);
        if (!$exercise) {
            return $this->response->setJSON(['error' => 'Exercice non trouvé']);
        }

        // On récupère les séries personnalisées si elles existent
        $series = $seriesModel->getByExercise($id);

        // Si aucune série personnalisée, on génère les séries par défaut à partir de l'exercice
        if (empty($series)) {
            $series = [];

            // On crée autant de séries que défini par nber_series
            $nbSeries = $exercise['nber_series'] ?? 3;
            $defaultReps = $exercise['reps'] ?? 10;

            for ($i = 0; $i < $nbSeries; $i++) {
                $series[] = [
                    'id_exercice' => $exercise['id'],
                    'reps' => $defaultReps,
                    'weight' => null, // Pas de poids par défaut
                ];
            }
        }

        // Retour en JSON
        return $this->response->setJSON([
            'id_exercice' => (int) $exercise['id'],
            'name' => $exercise['name'],
            'series' => $series,
        ]);
    }

    public function info(int $id)
    {
        $em = model('ExerciseModel'); // instancie le modèle
        $exercise = $em->getExercise($id); // récupère l'exercice

        if (!$exercise) {
            return $this->response->setJSON(['error' => 'Exercice non trouvé']);
        }

        return $this->response->setJSON([
            'id' => $exercise['id'],
            'name' => $exercise['name'],
            'reps' => $exercise['reps'] ?? '',
            'nber_series' => $exercise['nber_series'] ?? '',
            'rest_time' => $exercise['rest_time'] ?? '',
        ]);
    }
}