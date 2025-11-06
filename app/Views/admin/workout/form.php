<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <h3 class="h3">Nouvelle séance pour le programme : <?= esc($program['name']) ?></h3>
            </div>

            <form action="<?= base_url('admin/workout/save') ?>" method="post">
                <input type="hidden" name="id_program" value="<?= $program['id'] ?>">

                <div class="card-body">
                    <!-- Date de la séance -->
                    <div class="mb-3 form-floating">
                        <input type="date" class="form-control" id="day" name="day" placeholder="Date" required>
                        <label for="day">Date de la séance</label>
                    </div>

                    <hr>
                    <h5>Exercices</h5>

                    <div id="exercisesContainer"></div>
                    <button type="button" id="addExercise" class="btn btn-sm btn-primary mb-3">Ajouter un exercice</button>
                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-success">Enregistrer la séance</button>
                    <a href="<?= base_url('admin/program/edit/'.$program['id']) ?>" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function() {
        let exIndex = 0;

        $('#addExercise').click(function() {
            $('#exercisesContainer').append(`
                <div class="card mb-2 p-2 exercise-block">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <strong>Exercice ${exIndex + 1}</strong>
                        <button type="button" class="btn btn-sm btn-danger remove-exercise">Supprimer</button>
                    </div>

                    <select name="exercises[${exIndex}][id_exercice]" class="form-select mb-2" required>
                        <option value="">-- Choisir un exercice --</option>
                        <?php foreach ($exercises as $ex): ?>
                            <option value="<?= $ex['id'] ?>"><?= esc($ex['name']) ?></option>
                        <?php endforeach; ?>
                    </select>

                    <div class="series-container mb-2">
                        <div class="d-flex gap-2 mb-2 series-block">
                            <input type="number" class="form-control" name="exercises[${exIndex}][series][0][reps]" placeholder="Répétitions">
                            <input type="number" class="form-control" name="exercises[${exIndex}][series][0][weight]" placeholder="Charge (kg)">
                        </div>
                    </div>

                    <button type="button" class="btn btn-sm btn-secondary add-series">+ Ajouter une série</button>
                </div>
            `);
            exIndex++;
        });

        $(document).on('click', '.remove-exercise', function() {
            $(this).closest('.exercise-block').remove();
        });

        $(document).on('click', '.add-series', function() {
            const seriesContainer = $(this).siblings('.series-container');
            const exIndex = $(this).closest('.exercise-block').index();
            const sIndex = seriesContainer.find('.series-block').length;
            seriesContainer.append(`
                <div class="d-flex gap-2 mb-2 series-block">
                    <input type="number" class="form-control" name="exercises[${exIndex}][series][${sIndex}][reps]" placeholder="Répétitions">
                    <input type="number" class="form-control" name="exercises[${exIndex}][series][${sIndex}][weight]" placeholder="Charge (kg)">
                    <button type="button" class="btn btn-danger remove-series">X</button>
                </div>
            `);
        });

        $(document).on('click', '.remove-series', function() {
            $(this).closest('.series-block').remove();
        });
    });
</script>
