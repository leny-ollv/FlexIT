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
                        <?php if (isset($program['id_user'])): ?>
                            <option value="<?= $program['id_user'] ?>" selected><?= esc($program['creator_name']) ?></option>
                        <?php endif; ?>
                    </select>
                </div>

                <?php if (isset($program['id'])): ?>
                    <!-- Séances -->
                    <hr>
                    <h4>Séances du programme</h4>
                    <div id="workoutsContainer">
                        <?php foreach ($workouts ?? [] as $workoutIndex => $workout): ?>
                            <div class="card mb-3 workout-block" data-index="<?= $workoutIndex ?>">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h5>Séance #<?= $workoutIndex + 1 ?></h5>
                                        <button type="button" class="btn btn-sm btn-danger remove-workout">Supprimer</button>
                                    </div>

                                    <div class="exercises-container">
                                        <?php foreach ($workout['exercises'] ?? [] as $exerciseIndex => $exercise): ?>
                                            <div class="card mb-2 p-2 exercise-block" data-exercise-index="<?= $exerciseIndex ?>">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <strong>Exercice <?= $exerciseIndex + 1 ?></strong>
                                                    <button type="button" class="btn btn-sm btn-danger remove-exercise">Supprimer</button>
                                                </div>

                                                <div class="mb-2">
                                                    <select class="form-select exercise-select" name="workouts[<?= $workoutIndex ?>][exercises][<?= $exerciseIndex ?>][id_exercice]" required>
                                                        <?php foreach ($exercises ?? [] as $ex): ?>
                                                            <option value="<?= $ex['id'] ?>" <?= $ex['id'] == $exercise['id_exercice'] ? 'selected' : '' ?>>
                                                                <?= esc($ex['name']) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <div class="series-container">
                                                    <?php foreach ($exercise['series'] ?? [] as $seriesIndex => $series): ?>
                                                        <div class="d-flex gap-2 mb-2 series-block">
                                                            <input type="number" class="form-control" name="workouts[<?= $workoutIndex ?>][exercises][<?= $exerciseIndex ?>][series][<?= $seriesIndex ?>][reps]" placeholder="Répétitions" value="<?= $series['reps'] ?>">
                                                            <input type="number" class="form-control" name="workouts[<?= $workoutIndex ?>][exercises][<?= $exerciseIndex ?>][series][<?= $seriesIndex ?>][weight]" placeholder="Charge" value="<?= $series['weight'] ?>">
                                                            <button type="button" class="btn btn-danger remove-series">Supprimer</button>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-secondary add-series">Ajouter une série</button>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <button type="button" class="btn btn-sm btn-primary add-exercise">Ajouter un exercice</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
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
        initAjaxSelect2('#user', {
            url: '<?= base_url('admin/user/search') ?>',
            placeholder: "Rechercher un utilisateur ...",
            searchFields: "username",
            delay: 250
        });

        <?php if (isset($program['id'])): ?>
        function generateSeriesInputs(workoutIndex, exerciseIndex, series = []) {
            let html = '';
            if(series.length > 0){
                series.forEach((s, i) => {
                    html += `<div class="d-flex gap-2 mb-2 series-block">
                    <input type="number" class="form-control" name="workouts[${workoutIndex}][exercises][${exerciseIndex}][series][${i}][reps]" placeholder="Répétitions" value="${s.reps}">
                    <input type="number" class="form-control" name="workouts[${workoutIndex}][exercises][${exerciseIndex}][series][${i}][weight]" placeholder="Charge" value="${s.weight}">
                    <button type="button" class="btn btn-danger remove-series">Supprimer</button>
                </div>`;
                });
            } else {
                html += `<div class="d-flex gap-2 mb-2 series-block">
                <input type="number" class="form-control" name="workouts[${workoutIndex}][exercises][${exerciseIndex}][series][0][reps]" placeholder="Répétitions">
                <input type="number" class="form-control" name="workouts[${workoutIndex}][exercises][${exerciseIndex}][series][0][weight]" placeholder="Charge">
                <button type="button" class="btn btn-danger remove-series">Supprimer</button>
            </div>`;
            }
            return html;
        }

        $(document).on('click', '.add-exercise', function(){
            let workoutBlock = $(this).closest('.workout-block');
            let exercisesContainer = $(this).siblings('.exercises-container');
            let exerciseIndex = exercisesContainer.children().length;
            let workoutIndex = workoutBlock.data('index');

            let options = `<?php foreach ($exercises ?? [] as $ex): ?><option value="<?= $ex['id'] ?>"><?= esc($ex['name']) ?></option><?php endforeach; ?>`;
            let seriesHtml = generateSeriesInputs(workoutIndex, exerciseIndex);

            exercisesContainer.append(`
            <div class="card mb-2 p-2 exercise-block" data-exercise-index="${exerciseIndex}">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <strong>Exercice ${exerciseIndex+1}</strong>
                    <button type="button" class="btn btn-sm btn-danger remove-exercise">Supprimer</button>
                </div>
                <div class="mb-2">
                    <select class="form-select" name="workouts[${workoutIndex}][exercises][${exerciseIndex}][id_exercice]" required>
                        ${options}
                    </select>
                </div>
                <div class="series-container">${seriesHtml}</div>
                <button type="button" class="btn btn-sm btn-secondary add-series">Ajouter une série</button>
            </div>
        `);
        });

        $(document).on('click', '.add-series', function(){
            let exerciseBlock = $(this).closest('.exercise-block');
            let seriesContainer = exerciseBlock.find('.series-container');
            let seriesIndex = seriesContainer.children().length;
            let workoutIndex = $(this).closest('.workout-block').data('index');
            let exerciseIndex = exerciseBlock.data('exercise-index');

            seriesContainer.append(`<div class="d-flex gap-2 mb-2 series-block">
            <input type="number" class="form-control" name="workouts[${workoutIndex}][exercises][${exerciseIndex}][series][${seriesIndex}][reps]" placeholder="Répétitions">
            <input type="number" class="form-control" name="workouts[${workoutIndex}][exercises][${exerciseIndex}][series][${seriesIndex}][weight]" placeholder="Charge">
            <button type="button" class="btn btn-danger remove-series">Supprimer</button>
        </div>`);
        });

        $(document).on('click', '.remove-series', function(){ $(this).closest('.series-block').remove(); });
        $(document).on('click', '.remove-exercise', function(){ $(this).closest('.exercise-block').remove(); });
        $(document).on('click', '.remove-workout', function(){ $(this).closest('.workout-block').remove(); });

        $('#addWorkout').click(function(){
            let workoutIndex = $('#workoutsContainer .workout-block').length;
            $('#workoutsContainer').append(`
            <div class="card mb-3 workout-block" data-index="${workoutIndex}">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5>Séance #${workoutIndex+1}</h5>
                        <button type="button" class="btn btn-sm btn-danger remove-workout">Supprimer</button>
                    </div>
                    <div class="exercises-container"></div>
                    <button type="button" class="btn btn-sm btn-primary add-exercise">Ajouter un exercice</button>
                </div>
            </div>
        `);
        });
        <?php endif; ?>
    });
</script>
