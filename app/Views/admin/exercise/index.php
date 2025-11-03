<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Liste des exercices</h3>
                <a href="<?= base_url('/admin/exercise/new') ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nouvel exercice
                </a>
            </div>
            <div class="card-body">
                <table id="exercisesTable" class="table table-sm table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Catégorie</th>
                        <th>Description</th>
                        <th>Répétitions</th>
                        <th>Séries</th>
                        <th>Temps repos</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- Données chargées via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var baseUrl = "<?= base_url(); ?>";
        var table = $('#exercisesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= base_url('datatable/searchdatatable') ?>',
                type: 'POST',
                data: { model: 'ExerciseModel' }
            },
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'category_name' },
                { data: 'description' },
                { data: 'reps' },
                { data: 'nber_series' },
                { data: 'rest_time' },
                {
                    data: null,
                    orderable: false,
                    render: function(data, type, row) {
                        return `
                            <div class="btn-group" role="group">
                                <a href="<?= base_url('/admin/exercise/') ?>${row.id}" class="btn btn-sm btn-warning" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <span class="btn btn-sm btn-danger" title="Supprimer" onclick="deleteExercise(${row.id})">
                                    <i class="fas fa-trash"></i>
                                </span>
                            </div>
                        `;
                    }
                }
            ],
            order: [[0, 'desc']],
            pageLength: 10,
            language: {
                url: baseUrl + 'js/datatable/datatable-2.1.4-fr-FR.json',
            }
        });

        window.refreshTable = function() { table.ajax.reload(null, false); };
    });

    function deleteExercise(id) {
        Swal.fire({
            title: `Êtes-vous sûr ?`,
            text: `Voulez-vous vraiment supprimer cet exercice ?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: "#6c757d",
            confirmButtonText: `Oui, supprimé !`,
            cancelButtonText: "Annuler",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + 'admin/exercise/delete',
                    type: 'POST',
                    data: { id: id },
                    success: function(response) {
                        if(response.success) {
                            refreshTable();
                            Swal.fire({
                                icon: 'success',
                                title: 'Succès',
                                text: response.message,
                                timer: 1500,
                                timerProgressBar: true,
                                showConfirmButton: false,
                            });
                        }
                    }
                });
            }
        });
    }
</script>