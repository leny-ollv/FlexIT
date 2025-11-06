<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1 class="h3">
                    <?= isset($program['id']) ? 'Modification d\'un programme' : 'Création d\'un programme' ?>
                </h1>

                <?php if (isset($program['id'])): ?>
                    <a href="<?= base_url('admin/workout/create/'.$program['id']) ?>" class="btn btn-success">
                        Ajouter une séance
                    </a>
                <?php endif; ?>
            </div>

            <?= form_open('admin/program/save') ?>
            <?php if (isset($program['id'])): ?>
                <input type="hidden" name="id" value="<?= $program['id'] ?>">
            <?php endif; ?>

            <div class="card-body">
                <!-- Nom du programme -->
                <div class="mb-3 form-floating">
                    <input type="text" class="form-control" name="name"
                           value="<?= $program['name'] ?? '' ?>" placeholder="Nom du programme" required>
                    <label for="name">Nom du programme</label>
                </div>

                <!-- Créateur -->
                <div class="mb-3">
                    <select class="form-select" name="id_user" id="user" required>
                        <?php if (isset($program['id_user'])): ?>
                            <option value="<?= $program['id_user'] ?>" selected><?= esc($program['creator_name']) ?></option>
                        <?php endif; ?>
                    </select>
                </div>

                <?php if (isset($program['id'])): ?>
                    <hr>
                    <h4>Séances du programme</h4>

                    <?php if (!empty($workouts)): ?>
                        <table class="table table-striped align-middle">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Nombre d’exercices</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($workouts as $w): ?>
                                <tr>
                                    <td><?= esc($w['day']) ?></td>
                                    <td><?= count($w['exercises'] ?? []) ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/workout/edit/'.$w['id']) ?>" class="btn btn-sm btn-primary">Modifier</a>
                                        <a href="<?= base_url('admin/workout/delete/'.$w['id'].'/'.$program['id']) ?>"
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Supprimer cette séance ?')">Supprimer</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p class="text-muted">Aucune séance pour l’instant.</p>
                    <?php endif; ?>
                <?php endif; ?>
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
        // --- INIT SELECT2 UTILISATEUR ---
        initAjaxSelect2('#user', {
            url: '<?= base_url('admin/user/search') ?>',
            placeholder: "Rechercher un utilisateur ...",
            searchFields: "username",
            delay: 250
        });
    });
</script>
