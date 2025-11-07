@include('Vistas.Header')

<div class="container-fluid mt-4">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-award"></i> Tipos de Agradecimiento</h5>
            <button class="btn btn-light btn-sm" data-toggle="modal" data-target="#addModal">
                <i class="bi bi-plus-circle"></i> Agregar Nuevo
            </button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="my-table" class="table table-hover table-bordered align-middle">
                    <thead class="bg-dark text-white text-center">
                        <tr>
                            <th>N°</th>
                            <th>Tipo de Agradecimiento</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tipresolucagrd as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item->tipoagradeci }}</td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm me-1" data-toggle="modal" data-target="#edit{{ $item->idtipagr }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-id="{{ $item->idtipagr }}" onclick="confirmDelete(this.dataset.id)">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>

                        {{-- Modal Editar --}}
                        <div class="modal fade" id="edit{{ $item->idtipagr }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <form method="POST" action="{{ route('tipresolucionagrad.update', $item->idtipagr) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning text-dark">
                                            <h5 class="modal-title">Editar Tipo</h5>
                                            <button type="button" class="btn-close" data-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <label>Nombre del Tipo:</label>
                                            <input type="text" name="tipoagradeci" class="form-control" value="{{ $item->tipoagradeci }}" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-warning">Actualizar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- Modal Eliminar --}}
                        <div class="modal fade" id="delete{{ $item->idtipagr }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <form id="delete-form-{{ $item->idtipagr }}"
                                    action="{{ route('tipresolucionagrad.destroy', $item->idtipagr) }}"
                                    method="POST" style="display:none;">
                                    <strong>{{ $item->tipoagradeci }}</strong>
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal Agregar --}}
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('tipresolucionagrad.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Agregar Tipo de Agradecimiento</h5>
                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label>Nombre del Tipo: <span class="text-danger">*</span></label>
                    <input type="text" name="tipoagradeci" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#tipres-table').DataTable({
            responsive: true,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            },
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'excel',
                    className: 'btn btn-success btn-sm',
                    text: '<i class="bi bi-file-earmark-excel"></i> Excel'
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-danger btn-sm',
                    text: '<i class="bi bi-file-earmark-pdf"></i> PDF'
                },
                {
                    extend: 'csv',
                    className: 'btn btn-info btn-sm',
                    text: '<i class="bi bi-filetype-csv"></i> CSV'
                },
                {
                    extend: 'print',
                    className: 'btn btn-secondary btn-sm',
                    text: '<i class="bi bi-printer"></i> Imprimir'
                }
            ]
        });
    });
</script>
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    // Inicializar DataTable
    $(document).ready(function() {
        $('#my-table').DataTable({
            "order": [
                [0, "asc"]
            ],
            "columnDefs": [{
                "targets": 1,
                "orderable": false
            }],
            "language": {
                "search": "Buscar: ",
                "lengthMenu": "Mostrar _MENU_ registros",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "paginate": {
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            "initComplete": function() {
                $('.dataTables_filter input').css('width', '300px');
            }
        });
    });

    // Función para confirmar eliminación
    function confirmDelete(id) {
        Swal.fire({
            title: 'Confirmar',
            text: '¿Estás seguro de eliminar este registro?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            customClass: {
                popup: 'rounded-4 shadow-lg'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${id}`).submit();
            }
        });
    }
</script>

@if(session('success'))
    <script>
        Swal.fire({
                title: '¡Éxito!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#3085d6',
            });
    </script>
@endif

@include('Vistas.Footer')