<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h1 class="h3">
                    <?= isset($exercise['id']) ? 'Modification d\'un exercice' : 'Création d\'un exercice' ?>
                </h1>
            </div>
            <?= form_open('admin/exercise/save') ?>
            <?php if (isset($exercise['id'])) : ?>
                <input type="hidden" name="id" value="<?= $exercise['id'] ?>">
            <?php endif; ?>

            <div class="card-body">
                <!-- Nom -->
                <div class="mb-3 form-floating">
                    <input type="text" class="form-control" name="name" value="<?= $exercise['name'] ?? '' ?>" placeholder="Nom de l'exercice" required>
                    <label>Nom de l'exercice</label>
                </div>

                <!-- Muscle et Catégorie sur la même ligne -->
                <div class="row mb-3">
                    <div class="col">
                        <label for="id_muscle" class="form-label">Muscle</label>
                        <select class="form-select" name="id_muscle" id="id_muscle" required>
                            <option value="">-- Sélectionner un muscle --</option>
                            <?php foreach ($muscles as $muscle): ?>
                                <option value="<?= $muscle['id'] ?>"
                                    <?= isset($selectedMuscleId) && $selectedMuscleId == $muscle['id'] ? 'selected' : '' ?>>
                                    <?= esc($muscle['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col">
                        <label for="id_cat" class="form-label">Catégorie</label>
                        <select class="form-select" name="id_cat" id="id_cat" required>
                            <option value="">-- Sélectionner une catégorie --</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= isset($exercise) && $exercise['id_cat']==$cat['id'] ? 'selected' : '' ?>>
                                    <?= esc($cat['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-3 form-floating">
                    <textarea class="form-control" name="description" placeholder="Description" style="height:150px;"><?= $exercise['description'] ?? '' ?></textarea>
                    <label>Description</label>
                </div>

                <!-- Répétitions, Séries et Temps de repos sur la même ligne -->
                <div class="row mb-3">
                    <div class="col">
                        <div class="form-floating">
                            <input type="number" class="form-control" name="reps" value="<?= $exercise['reps'] ?? '' ?>" placeholder="Répétitions">
                            <label>Répétitions</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating">
                            <input type="number" class="form-control" name="nber_series" value="<?= $exercise['nber_series'] ?? '' ?>" placeholder="Séries">
                            <label>Séries</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating">
                            <input type="number" class="form-control" name="rest_time" value="<?= $exercise['rest_time'] ?? '' ?>" placeholder="Temps de repos">
                            <label>Temps de repos (s)</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="<?= base_url('admin/exercise') ?>" class="btn btn-secondary">Annuler</a>
            </div>

            <?= form_close() ?>
        </div>
    </div>
</div>