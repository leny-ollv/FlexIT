<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <h1 class="h3"><?= isset($program['id']) ? 'Modification d\'un programme' : 'Création d\'un programme' ?></h1>
            </div>

            <?= form_open('admin/program/save') ?>
            <?php if (isset($program['id'])): ?>
                <input type="hidden" name="id" value="<?= $program['id'] ?>">
            <?php endif; ?>

            <div class="card-body">
                <!-- Nom du programme -->
                <div class="mb-3 form-floating">
                    <input type="text" class="form-control" name="name" value="<?= $program['name'] ?? '' ?>" placeholder="Nom du programme" required>
                    <label for="name">Nom du programme</label>
                </div>

                <!-- Créateur -->
                <div class="mb-3">
                    <select class="form-select" name="id_user" id="user" required>
                        <option value="<?= $program['id_user'] ?? '' ?>" selected>
                            <?= esc($program['creator_name'] ?? 'Sélectionner un utilisateur') ?>
                        </option>
                    </select>
                </div>

                <?php if (isset($program['id'])): ?>
                    <!-- Séances -->
                    <hr>
                    <h4>Séances du programme</h4>
                    <div id="workoutsContainer"></div>

                    <button type="button" class="btn btn-primary mb-3" id="addWorkout">Ajouter une séance</button>
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
    $(document).ready(function(){

        // Initialisation du select2 pour le créateur
        initAjaxSelect2('#user', {
            url: '<?= base_url('admin/user/search') ?>',
            placeholder: "Rechercher un utilisateur ...",
            searchFields: "username",
            delay: 250
        });

        // ➕ Ajouter une séance
        $('#addWorkout').click(function(){
            let workoutIndex = $('#workoutsContainer .workout-block').length;
            $('#workoutsContainer').append(`
            <div class="card mb-3 workout-block" data-index="${workoutIndex}">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5>Séance #${workoutIndex + 1}</h5>
                        <button type="button" class="btn btn-sm btn-danger remove-workout">Supprimer</button>
                    </div>
                    <div class="exercises-container"></div>
                    <button type="button" class="btn btn-sm btn-primary add-exercise">Ajouter un exercice</button>
                </div>
            </div>
        `);
        });

        // Supprimer une séance
        $(document).on('click', '.remove-workout', function(){
            $(this).closest('.workout-block').remove();
        });

        // Ajouter un bloc de sélection d'exercice
        $(document).on('click', '.add-exercise', function(){
            let workoutBlock = $(this).closest('.workout-block');
            let exercisesContainer = workoutBlock.find('.exercises-container');
            let exerciseIndex = exercisesContainer.children().length;
            let workoutIndex = workoutBlock.data('index');

            exercisesContainer.append(`
            <div class="card mb-2 p-2 exercise-select-block" data-exercise-index="${exerciseIndex}">
                <div class="d-flex gap-2 align-items-center mb-2">
                    <select class="form-select select-exercise" style="flex:1">
                        <option value="">-- Sélectionner un exercice --</option>
                        <?php foreach ($exercises as $ex): ?>
                            <option value="<?= $ex['id'] ?>"><?= esc($ex['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="button" class="btn btn-success add-selected-exercise d-none">Ajouter cet exercice</button>
                    <button type="button" class="btn btn-danger remove-exercise">Annuler</button>
                </div>
            </div>
        `);
        });

        // Quand on choisit un exercice, on affiche le bouton "Ajouter cet exercice"
        $(document).on('change', '.select-exercise', function(){
            let block = $(this).closest('.exercise-select-block');
            let val = $(this).val();
            block.find('.add-selected-exercise').toggleClass('d-none', val === "");
        });

        // Quand on clique sur "Ajouter cet exercice"
        $(document).on('click', '.add-selected-exercise', function(){
            let block = $(this).closest('.exercise-select-block');
            let exerciseId = block.find('.select-exercise').val();
            let exerciseName = block.find('.select-exercise option:selected').text();
            let workoutBlock = block.closest('.workout-block');
            let workoutIndex = workoutBlock.data('index');
            let exerciseIndex = block.data('exercise-index');

            $.get('<?= base_url('admin/exercise/series/') ?>' + exerciseId, function(response){
                if (response.error) {
                    alert(response.error);
                    return;
                }

                // Génère les séries par défaut
                let seriesHtml = '';
                if (response.series && response.series.length > 0) {
                    response.series.forEach(function(s, i){
                        seriesHtml += `
                        <div class="d-flex gap-2 mb-2 series-block">
                            <input type="number" class="form-control" name="workouts[${workoutIndex}][exercises][${exerciseIndex}][series][${i}][reps]" value="${s.reps}" placeholder="Répétitions">
                            <input type="number" class="form-control" name="workouts[${workoutIndex}][exercises][${exerciseIndex}][series][${i}][weight]" value="${s.weight}" placeholder="Charge">
                            <button type="button" class="btn btn-danger remove-series">Supprimer</button>
                        </div>`;
                    });
                }

                // Remplace le bloc par l'exercice complet
                block.replaceWith(`
                <div class="card mb-2 p-2 exercise-block" data-exercise-index="${exerciseIndex}">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <strong>${response.name}</strong>
                        <button type="button" class="btn btn-sm btn-danger remove-exercise">Supprimer</button>
                    </div>
                    <input type="hidden" name="workouts[${workoutIndex}][exercises][${exerciseIndex}][id_exercice]" value="${response.id_exercice}">
                    <div class="series-container">${seriesHtml}</div>
                    <button type="button" class="btn btn-sm btn-secondary add-series">Ajouter une série</button>
                </div>
            `);
            });
        });

        // Ajouter une série manuellement
        $(document).on('click', '.add-series', function(){
            let exerciseBlock = $(this).closest('.exercise-block');
            let seriesContainer = exerciseBlock.find('.series-container');
            let seriesIndex = seriesContainer.children().length;
            let workoutIndex = $(this).closest('.workout-block').data('index');
            let exerciseIndex = exerciseBlock.data('exercise-index');

            seriesContainer.append(`
            <div class="d-flex gap-2 mb-2 series-block">
                <input type="number" class="form-control" name="workouts[${workoutIndex}][exercises][${exerciseIndex}][series][${seriesIndex}][reps]" placeholder="Répétitions">
                <input type="number" class="form-control" name="workouts[${workoutIndex}][exercises][${exerciseIndex}][series][${seriesIndex}][weight]" placeholder="Charge">
                <button type="button" class="btn btn-danger remove-series">Supprimer</button>
            </div>
        `);
        });

        // Supprimer série ou exercice
        $(document).on('click', '.remove-series', function(){ $(this).closest('.series-block').remove(); });
        $(document).on('click', '.remove-exercise', function(){ $(this).closest('.exercise-select-block, .exercise-block').remove(); });
    });
</script>

