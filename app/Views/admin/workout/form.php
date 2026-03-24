<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">
                    <?= !empty($workout_details) ? 'Modifier la séance' : 'Nouvelle séance' ?>
                    – <?= esc($program['name']) ?>
                </h1>
                <a href="<?= base_url('admin/program/edit/'.$program['id']) ?>" class="btn btn-secondary">
                    Retour
                </a>
            </div>
            <?= form_open('admin/program/workout/save'); ?>
            <input type="hidden" name="id_program" value="<?= $program['id'] ?>">
            <div class="card-body">

                <div class="mb-3 form-floating">
                    <input type="date" class="form-control" id="day" name="day"
                           value="<?= $selected_date ?? '' ?>" required>
                    <label for="day">Date de la séance</label>
                </div>
                <hr>
                <h4 class="mb-3">Exercices</h4>
<!--                                    <pre>-->
<!--                                        --><?php //= print_r($workout_details); ?>
<!--                                    </pre>-->
                <div id="exercisesContainer">
                    <?php if (!empty($workout_details)): ?>
                        <?php foreach ($workout_details as $nb => $workout): ?>
                            <div class="row rowExercise mb-3" data-nb="<?= $nb ?>">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-md-8 mb-2">
                                                    <select class="form-select selectExercise">
                                                        <option value="<?= esc($workout['id_exercice']) ?>" selected>
                                                            <?= esc($workout['name']['name']) ?>
                                                        </option>
                                                    </select>
                                                    <input type="hidden" name="exercises[<?= $nb ?>][id_exercice]" value="<?= $workout['id_exercice'] ?>">
                                                    <input type="hidden" name="exercises[<?= $nb ?>][order]" value="<?= $nb + 1 ?>">
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <div class="form-floating">
                                                        <input type="number"
                                                               class="form-control"
                                                               name="exercises[<?= $nb ?>][rest_time]"
                                                               value="<?= $workout['name']['rest_time'] ?>"
                                                               placeholder="Temps de repos (s)"
                                                               required>
                                                        <label>Repos (s)</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 mb-2 d-flex justify-content-center align-items-center">
                                <span class="deleteExercise fs-4" style="cursor: pointer;" title="Supprimer l'exercice">
                                    <i class="fa-solid fa-trash"></i>
                                </span>
                                                </div>
                                            </div>
                                            <div class="rowInfoExercise mt-3">
                                                <?php if (!empty($workout['series'])): ?>
                                                    <?php foreach ($workout['series'] as $i => $serie): ?>
                                                        <div class="row">
                                                            <div class="col-md-5 mb-2">
                                                                <div class="form-floating">
                                                                    <input value="<?= $serie['reps'] ?>"
                                                                           type="number"
                                                                           class="form-control"
                                                                           name="exercises[<?= $nb ?>][series][<?= $i ?>][reps]"
                                                                           placeholder="Répétitions"
                                                                           required>
                                                                    <label>Répétitions</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 mb-2">
                                                                <div class="form-floating">
                                                                    <input value="<?= $serie['weight'] ?>"
                                                                           type="number"
                                                                           class="form-control"
                                                                           name="exercises[<?= $nb ?>][series][<?= $i ?>][weight]"
                                                                           placeholder="Poids (kg)"
                                                                           required>
                                                                    <label>Poids (kg)</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1 mb-2 d-flex justify-content-center align-items-center">
                                            <span class="deleteSerie fs-4" style="cursor: pointer;" title="Supprimer la série">
                                                <i class="fa-solid fa-trash"></i>
                                            </span>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </div>
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-primary addSerie mt-2">
                                                <i class="fas fa-plus"></i> Ajouter une série
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <span id="addExercise" class="btn btn-primary mt-3">
                        <i class="fas fa-plus"></i> Ajouter un exercice
                    </span>
            </div>

            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Bilan de la séance</h5>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Note (1 à 5) :</label>
                            <select name="rating" class="form-select form-select-sm">
                                <?php for($i=1; $i<=5; $i++): ?>
                                    <option value="<?= $i ?>" <?= (isset($workout_log['rating']) && $workout_log['rating'] == $i) ? 'selected' : ($i == 3 && !isset($workout_log['rating']) ? 'selected' : '') ?>>
                                        <?= $i ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="col-md-8 mb-3">
                            <label class="form-label fw-bold">Fatigue :</label>
                            <div class="d-flex gap-3 mt-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="fatigue" value="0" id="f0" <?= (isset($workout_log['fatigue']) && $workout_log['fatigue'] == 0) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="f0">Faible</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="fatigue" value="1" id="f1" <?= (isset($workout_log['fatigue']) && $workout_log['fatigue'] == 1) ? 'checked' : (!isset($workout_log['fatigue']) ? 'checked' : '') ?>>
                                    <label class="form-check-label" for="f1">Moyenne</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="fatigue" value="2" id="f2" <?= (isset($workout_log['fatigue']) && $workout_log['fatigue'] == 2) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="f2">Élevée</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-2">
                        <label class="form-label fw-bold">Commentaire :</label>
                        <textarea name="comment" class="form-control" rows="3" placeholder="Vos impressions..."><?= esc($workout_log['comment'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>

            <div class="card-footer text-end">
                <button type="submit" class="btn btn-success text-white">
                    Enregistrer la séance
                </button>
                <a href="<?= base_url('admin/program/edit/'.$program['id']) ?>" class="btn btn-secondary">Annuler</a>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<!-- JS -->
<script>
    $(document).ready(function(){

        // --- GESTION DE L'AJOUT D'UN EXERCICE ---
        $('#addExercise').on('click', function(){// Au clic sur 'Ajouter Exercice'.
            let nb = $('.rowExercise').length; // Récupère l'index (0, 1, 2...).
            const row = `
            <div class="row rowExercise mb-3" data-nb="${nb}">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8 mb-2">
                                    <select class="form-select selectExercise"></select>
                                </div>
                                <div class="col-md-3 mb-2" id="restTimeContainer_${nb}"></div>
                                <div class="col-md-1 mb-2 d-flex justify-content-center align-items-center">
                                    <span class="deleteExercise fs-4" style="cursor: pointer;" title="Supprimer l'exercice'">
                                        <i class="fa-solid fa-trash"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="rowInfoExercise mt-3"></div>
                            <button type="button"
                                    class="btn btn-sm btn-outline-primary addSerie mt-2">
                                <i class="fas fa-plus"></i> Ajouter une série
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            `;
            $('#exercisesContainer').append(row); // Ajoute la carte au conteneur.
            initAjaxSelect2('#exercisesContainer .rowExercise:last-child .selectExercise', {
                // Initialise le champ de recherche 'Select2' avec l'URL de recherche.
                url: base_url + '/admin/exercise/search',
                placeholder: "Rechercher un exercice ...",
                searchFields : 'name',
                delay: 250,
            });
        });

        // --- Gestion de la suppression des blocs d'exos ---
        $('#exercisesContainer').on('click', '.deleteExercise', function(){
            $(this).closest('.rowExercise').remove(); // Trouve le bloc d'exercice parent le plus proche et le supprime
        });

        // --- Gestion de la suppression des series ---
        $('#exercisesContainer').on('click', '.deleteSerie', function(){
            $(this).closest('.row').remove(); // Trouve la ligne (<div> class="row") qui contient les inputs et la corbeille, et la supprime.
        });

        // --- Gestion de l'ajout d'une série ---
        $('#exercisesContainer').on('click', '.addSerie', function () {

            const exerciseBlock = $(this).closest('.rowExercise');
            const nb = exerciseBlock.data('nb');
            const rowInfo = exerciseBlock.find('.rowInfoExercise');

            // Calcul du prochain index de série
            const serieIndex = rowInfo.find('.row').length;

            const row = `
        <div class="row">
            <div class="col-md-5 mb-2">
                <div class="form-floating">
                    <input type="number"
                           class="form-control"
                           name="exercises[${nb}][series][${serieIndex}][reps]"
                           placeholder="Répétitions"
                           required>
                    <label>Répétitions</label>
                </div>
            </div>
            <div class="col-md-6 mb-2">
                <div class="form-floating">
                    <input type="number"
                           class="form-control"
                           name="exercises[${nb}][series][${serieIndex}][weight]"
                           placeholder="Poids (kg)"
                           required>
                    <label>Poids (kg)</label>
                </div>
            </div>
            <div class="col-md-1 mb-2 d-flex justify-content-center align-items-center">
                <span class="deleteSerie fs-4" style="cursor:pointer">
                    <i class="fa-solid fa-trash"></i>
                </span>
            </div>
        </div>
    `;

            rowInfo.append(row);
        });

        // --- GESTION DE LA SÉLECTION D'UN EXERCICE ---
        $('#exercisesContainer').on('select2:select','.selectExercise', function(){ // Quand un exercice est sélectionné dans la liste déroulante.
            const id = parseInt($(this).val()); // Récupère l'ID de l'exercice.
            const nb = $(this).closest('.rowExercise').data('nb'); // Récupère l'index de la ligne actuelle.

            const rowInfo = $(this).closest('.rowExercise').find('.rowInfoExercise'); // Cible l'endroit pour afficher les séries.
            const restTimeContainer = $(this).closest('.rowExercise').find(`#restTimeContainer_${nb}`);
            rowInfo.html(''); // Vide la zone avant d'ajouter les détails.
            restTimeContainer.html(''); // Vide l'ancienne zone du temps de repos (pour le cas où on change d'exercice)

            const hiddenIdInput = `<input type="hidden" name="exercises[${nb}][id_exercice]" value="${id}">`;
            $(this).after(hiddenIdInput)
            const hiddenOrderInput = `<input type="hidden" name="exercises[${nb}][order]" value="${nb+1}">`;
            $(this).after(hiddenOrderInput)
            $.ajax({
                // Fait une requête au serveur pour obtenir les détails de l'exercice (séries, poids...).
                type : 'GET',
                url : base_url + 'admin/exercise/info/' + id,
                success : function(data){
                    // Si la requête réussit.
                    if (!data.error) {
                        // Affichage du champ avec le temps de repos.
                        const restTimeField = `
                            <div class="form-floating">
                                <input value="${data.rest_time}" type="number" class="form-control" name="exercises[${nb}][rest_time]" id="restTime_${nb}" placeholder="Temps de repos (s)" required>
                                <label for="restTime_${nb}">Repos (s)</label>
                            </div>
                        `;
                        restTimeContainer.html(restTimeField);
                        for (let i = 0; i < data.nber_series; i++){
                            // Boucle pour créer un bloc d'input pour chaque série.
                            const row = `
                        <div class="row">
                            <div class="col-md-5 mb-2">
                                <div class="form-floating">
                                    <input value="${data.reps}" type="number" class="form-control" name="exercises[${nb}][series][${i}][reps]" id="" placeholder="Répétitions" required>
                                    <label for="">Repetition</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="form-floating">
                                    <input value="${data.Weight}" type="number" class="form-control" name="exercises[${nb}][series][${i}][weight]" id="" placeholder="Poids (kg)" required>
                                    <label for="">Poids (kg)</label>
                                </div>
                            </div>
                            <div class="col-md-1 mb-2 d-flex justify-content-center align-items-center">
                                <span class="deleteSerie fs-4" style="cursor: pointer;" title="Supprimer la série">
                                    <i class="fa-solid fa-trash"></i>
                                </span>
                            </div>
                        </div>
                        `; // Code HTML des champs (Reps, Poids, Repos) pré-remplis.
                            rowInfo.append(row); // Ajoute ces champs à la page.
                        }
                    }
                },
                error : function(err){
                    // En cas d'erreur de requête.
                    console.log(err);
                }
            });
        });
    });
</script>