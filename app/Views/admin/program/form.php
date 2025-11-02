<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h1 class="h3">
                    <?php if (isset($program['id'])) : ?>
                        Modification d'un programme
                    <?php else: ?>
                        Création d'un programme
                    <?php endif; ?>
                </h1>
            </div>
            <?= form_open('admin/program/save') ?>
            <?php if (isset($program['id'])) : ?>
                <input type="hidden" name="id" value="<?= $program['id'] ?>">
            <?php endif; ?>
            <div class="card-body">
                <div class="mb-3 form-floating">
                    <input type="text" class="form-control" name="name" value="<?= $program['name'] ?? ''
                     ?>" placeholder="Nom du programme" required>
                    <label for="nom">Nom du programme</label>
                </div>
                <div class="mb-3">
                    <select class="form-select" name="id_user" id="user" required>
                        <?php if (isset($program['id_user'])): ?>
                            <option value="<?= $program['id_user'] ?>" selected>
                                <?=$program['creator_name'] ?>
                            </option>
                        <?php endif; ?>
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
<script>
    $(document).ready(function() {
        initAjaxSelect2('#user', {
            url: '<?= base_url('admin/user/search') ?>',
            placeholder : "Rechercher un utilisateur ...",
            searchFields: "username",
            delay: 250
        });
    });
</script>