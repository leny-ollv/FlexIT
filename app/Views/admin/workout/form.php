<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">
                    Nouvelle séance – <?= esc($program['name']) ?>
                </h1>
                <a href="<?= base_url('admin/program/edit/'.$program['id']) ?>" class="btn btn-secondary">
                    Retour
                </a>
            </div>
            <form action="<?= base_url('admin/program/workout/save') ?>" method="post">
                <input type="hidden" name="id_program" value="<?= $program['id'] ?>">
                <div class="card-body">
                    <div class="mb-3 form-floating">
                        <input type="date" class="form-control" id="day" name="day" required>
                        <label for="day">Date de la séance</label>
                    </div>
                    <hr>
                    <h4 class="mb-3">Exercices</h4>
                    <div id="exercisesContainer"></div>
                    <button type="button" id="addExercise" class="btn btn-primary mt-3">
                        + Ajouter un exercice
                    </button>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-success text-white">
                        Enregistrer la séance
                    </button>
                    <a href="<?= base_url('admin/program/edit/'.$program['id']) ?>" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JS -->
<script>
    $(function() {
        let exIndex = 0;

        // Génère une ligne de série (rép + poids + bouton supprimer)
        function generateSeriesLine(exIndex, sIndex, reps = '') {
            return `
            <div class="series-line row g-2 mb-2 align-items-center">
                <div class="col-md-5">
                    <div class="form-floating">
                        <input type="number" class="form-control"
                               name="exercises[${exIndex}][series][${sIndex}][reps]"
                               value="${reps}" placeholder="Répétitions">
                        <label>Répétitions</label>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="form-floating">
                        <input type="number" class="form-control"
                               name="exercises[${exIndex}][series][${sIndex}][weight]"
                               placeholder="Poids (kg)">
                        <label>Poids (kg)</label>
                    </div>
                </div>

                <div class="col-md-2 d-grid">
                    <button type="button" class="btn btn-danger btn-sm remove-series">Supprimer</button>
                </div>
            </div>
        `;
        }

        // Ajout d'un exercice
        $('#addExercise').on('click', function() {
            $('#exercisesContainer').append(`
            <div class="card p-3 mt-3 exercise-block" data-index="${exIndex}">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Exercice ${exIndex + 1}</h5>
                    <button type="button" class="btn btn-sm btn-danger remove-exercise">Supprimer</button>
                </div>

                <!-- Select exercice -->
                <div class="form-floating mb-3">
                    <select name="exercises[${exIndex}][id_exercice]" class="form-select exercise-select" required>
                        <option value="">-- Choisir un exercice --</option>
                        <?php foreach ($exercises as $ex): ?>
                            <option value="<?= $ex['id'] ?>"><?= esc($ex['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label>Exercice</label>
                </div>

                <!-- Repos spécifique à cet exercice -->
                <div class="form-floating mb-3">
                    <input type="number" class="form-control rest-time"
                           name="exercises[${exIndex}][rest]"
                           placeholder="Temps de repos en secondes">
                    <label>Temps de repos (secondes)</label>
                </div>

                <!-- Container séries -->
                <div class="series-container"></div>

                <!-- Ajouter série manuellement -->
                <button type="button" class="btn btn-outline-primary btn-sm mt-2 add-series">+ Ajouter une série</button>
            </div>
        `);

            exIndex++;
        });

        // Supprimer un exercice entier
        $(document).on('click', '.remove-exercise', function() {
            $(this).closest('.exercise-block').remove();
            // Optionnel : renuméroter les titres si nécessaire
        });

        // Ajouter une série manuelle (bouton + Ajouter une série)
        $(document).on('click', '.add-series', function() {
            const block = $(this).closest('.exercise-block');
            const index = block.data('index');
            const seriesContainer = block.find('.series-container');
            const sIndex = seriesContainer.children('.series-line').length;

            seriesContainer.append(generateSeriesLine(index, sIndex, ''));
        });

        // Supprimer une série
        $(document).on('click', '.remove-series', function() {
            $(this).closest('.series-line').remove();
        });

        // Lorsque l'on choisit un exercice, on récupère les infos (reps, nber_series, rest) via AJAX
        $(document).on('change', '.exercise-select', function() {
            const id = $(this).val();
            const block = $(this).closest('.exercise-block');
            const index = block.data('index');
            const seriesContainer = block.find('.series-container');

            // Vider les séries précédentes
            seriesContainer.empty();

            // Reset rest-time field
            block.find('.rest-time').val('');

            if (!id) return;

            $.ajax({
                url: "<?= base_url('admin/exercise/info/') ?>" + id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    // Si ta table a un champ pour le repos par exo, je recommande d'exposer son nom ici.
                    // Exemple : data.rest ou data.rest_time
                    // On essaie les deux pour être tolérant :
                    const restVal = data.rest ?? data.rest_time ?? '';
                    block.find('.rest-time').val(restVal);

                    const repsDefault = data.reps ?? '';
                    const nb = parseInt(data.nber_series ?? data.nber_series ?? 0, 10) || 0;

                    // Générer les lignes de séries (rép pré-rempli, poids vide)
                    for (let i = 0; i < nb; i++) {
                        seriesContainer.append(generateSeriesLine(index, i, repsDefault));
                    }
                },
                error: function(xhr, status, err) {
                    // Affiche réponse serveur dans console pour debug
                    console.error('Erreur AJAX:', status, err);
                    console.log(xhr.responseText);
                    alert('Erreur lors du chargement de l\'exercice (voir console).');
                }
            });
        });

    });
</script>
