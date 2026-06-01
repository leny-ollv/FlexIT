<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Liste des variations</h3>
                <a href="<?= base_url('/admin/exercisevariation/new') ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nouvelle Variation
                </a>
            </div>
            <div class="card-body">
                <table id="categoriesTable" class="table table-sm table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Difficulté</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- Les données seront chargées via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var baseUrl = "<?= base_url(); ?>";
        var table = $('#categoriesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= base_url('datatable/searchdatatable') ?>',
                type: 'POST',
                data: {
                    model: 'ExerciseVariationsModel'
                }
            },
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'description'},
                { data: 'difficulty_level'}
                {
                    data: null,
                    orderable: false,
                    render: function(data, type, row) {
                        return `
                        <div class="btn-group" role="group">
                            <a href="<?= base_url('/admin/exercisevariation/') ?>${row.id}" class="btn btn-sm btn-warning" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>
                            <span class="btn btn-sm btn-danger" title="Supprimer" onclick="deleteExerciseVariation(${row.id})">
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

        window.refreshTable = function() {
            table.ajax.reload(null, false);
        };
    });

    function deleteCategory(id) {
        Swal.fire({
            title: `Êtes-vous sûr ?`,
            text: `Voulez-vous vraiment supprimer cette variation ?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: "#6c757d",
            confirmButtonText: `Oui, supprimé !`,
            cancelButtonText: "Annuler",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url : base_url + 'admin/exercisevariation/delete',
                    type : 'POST',
                    data : { id : id },
                    success: function (response) {
                        if(response.success) {
                            refreshTable();
                            Swal.fire({
                                icon : 'success',
                                title : 'Succès',
                                text: response.message,
                                timer: 1500,
                                timerProgressBar: true,
                                showConfirmButton: false,
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Erreur lors de la suppression:', error);
                    }
                });
            }
        });
    }
</script>