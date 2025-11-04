<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h1 class="h3">
                    <?php if (isset($muscle['id'])) : ?>
                        Modification d'un muscle
                    <?php else: ?>
                        Création d'un muscle
                    <?php endif; ?>
                </h1>
            </div>
            <?= form_open('admin/muscle/save') ?>
            <?php if (isset($muscle['id'])) : ?>
                <input type="hidden" name="id" value="<?= $muscle['id'] ?>">
            <?php endif; ?>
            <div class="card-body">
                <div class="mb-3 form-floating">
                    <input type="text" class="form-control" name="name" value="<?= $muscle['name'] ?? '' ?>" placeholder="Nom du muscle" required>
                    <label for="name">Nom du muscle</label>
                </div>
            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>