<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h1 class="h3">
                    <?php if (isset($exercise['id'])) : ?>
                        Modification d'un exercice
                    <?php else: ?>
                        Création d'un exercice
                    <?php endif; ?>
                </h1>
            </div>
            <?= form_open('admin/exercise/save') ?>
            <?php if (isset($exercise['id'])) : ?>
                <input type="hidden" name="id" value="<?= $exercise['id'] ?>">
            <?php endif; ?>
            <div class="card-body">
                <div class="mb-3 form-floating">
                    <input type="text" class="form-control" name="name" value="<?= $exercise['name'] ?? '' ?>" placeholder="Nom de l'exercice" required>
                    <label>Nom de l'exercice</label>
                </div>

                <div class="mb-3">
                    <label for="id_cat" class="form-label">Catégorie</label>
                    <select class="form-select" name="id_cat" required>
                        <?php foreach($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= isset($exercise) && $exercise['id_cat']==$cat['id'] ? 'selected' : '' ?>>
                                <?= esc($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3 form-floating">
                    <textarea class="form-control" name="description" placeholder="Description"><?= $exercise['description'] ?? '' ?></textarea>
                    <label>Description</label>
                </div>

                <div class="mb-3 form-floating">
                    <input type="number" class="form-control" name="reps" value="<?= $exercise['reps'] ?? '' ?>" placeholder="Nombre de répétitions">
                    <label>Nombre de répétitions</label>
                </div>

                <div class="mb-3 form-floating">
                    <input type="number" class="form-control" name="nber_series" value="<?= $exercise['nber_series'] ?? '' ?>" placeholder="Nombre de séries">
                    <label>Nombre de séries</label>
                </div>

                <div class="mb-3 form-floating">
                    <input type="number" class="form-control" name="rest_time" value="<?= $exercise['rest_time'] ?? '' ?>" placeholder="Temps de repos">
                    <label>Temps de repos (secondes)</label>
                </div>
            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="<?= base_url('admin/exercise') ?>" class="btn btn-secondary">Annuler</a>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>