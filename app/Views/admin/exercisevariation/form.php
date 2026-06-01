<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h1 class="h3">
                    <?php if (isset($category['id'])) : ?>
                        Modification d'une variation
                    <?php else: ?>
                        Création d'une variation
                    <?php endif; ?>
                </h1>
            </div>
            <?= form_open('admin/exercisevariation/save') ?>
            <?php if (isset($category['id'])) : ?>
                <input type="hidden" name="id" value="<?= $category['id'] ?>">
            <?php endif; ?>
            <div class="card-body">
                <div class="mb-3 form-floating">
                    <input type="text" class="form-control" name="name" value="<?= $category['name'] ?? '' ?>" placeholder="Nom de la catégorie" required>
                    <label for="name">Nom de la catégorie</label>
                </div>
                <div class="mb-3 form-floating">
                    <input type="text" class="form-control" name="name" value="<?= $category['name'] ?? '' ?>" placeholder="Nom de la catégorie" required>
                    <label for="name">Description</label>
                </div>
                <div class="mb-3 form-floating">
                    <input type="text" class="form-control" name="name" value="<?= $category['name'] ?? '' ?>" placeholder="Nom de la catégorie" required>
                    <label for="name">Nom de la catégorie</label>
                </div>
                <div class="mb-3 form-floating">
                    <select>
                        <?php foreach($exercises as $exo): ?>
                        <option><?= $exo['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>