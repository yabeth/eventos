@include('Vistas.Header')
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.1/font/bootstrap-icons.min.css"> -->
<!-- <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&display=swap" rel="stylesheet"> -->
<!-- <link rel="stylesheet" href="{{ asset('css/facultad.css') }}"> -->
<link rel="stylesheet" href="https://www.flaticon.es/iconos-gratis/enlace">
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

    .container {
        max-width: 100%;
        padding: 5px 0;
    }

    .card {
        width: 100%;
        margin-bottom: 5px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
</style>

<body>
    <div class="container mt-2">
        <div class="card">
            <div class="card-header bg-primary text-white text-center">
                <h5 class="card-title mb-1">GESTION DE FACULTADES</h5>
            </div>
            <div class="container">
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head">
                            <button href="#addEmployeeModl" class="btn btn-primary" data-toggle="modal"><i class="bi bi-plus-circle"></i> AGREGAR NUEVO</button>
                        </div>
                        <div class="ibox-head">
                            <div class="ibox-title">Lista de facultades registradas</div>
                        </div>
                        <div class="table-container mt-2">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="my-table" cellspacing="0" width="100%">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th>N°</th>
                                            <th>Facultad</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($facultads as $index => $facultad)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $facultad->nomfac}}</td>
                                            <td>
                                                <div class="action-buttons justify-content-center text-center">
                                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit{{$facultad->idfacultad}}"><i class="bi bi-pencil"></i></button>
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{$facultad->idfacultad}}"><i class="bi bi-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- crear Modal HTML -->
    <div id="addEmployeeModl" class="modal fade" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="{{ route('Rut.facu.store') }}" method="post">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h4 class="modal-title" id="addEmployeeModlLabel">Agregar nueva facultad</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nomfac" class="form-label">Facultad</label>
                            <input type="text" class="form-control" name="nomfac" id="nomfac" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" aria-hidden="true" id="btnCancelar">Limpiar</button>
                        <button type="submit" style="cursor:pointer;" class="btn btn-success" name="save">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- edit Modal HTML -->
    @foreach ($facultads as $facultad)
    <div id="edit{{ $facultad->idfacultad }}" class="modal fade" tabindex="-1" aria-labelledby="editModalLabel">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="{{ route('Rut.facu.update', $facultad->idfacultad) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="editModalLabel">Editar facultad</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nomfac" class="form-label">Facultad</label>
                            <input type="text" class="form-control" name="nomfac" id="nomfac" value="{{ $facultad->nomfac }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" style="cursor:pointer;" class="btn btn-success" name="update">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @endforeach

    <!-- Modal Eliminar -->

    @foreach ($facultads as $facultad)
    <div id="delete{{ $facultad->idfacultad }}" class="modal fade" tabindex="-1" aria-labelledby="deleteModalLabel">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0">
                <div class="modal-header border-0 bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmar eliminación
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="bi bi-trash fs-1 text-danger d-block mb-3"></i>
                    <p class="mb-0">¿Estás seguro de que deseas eliminar?</p>
                    <p class="fw-bold text-dark">{{ $facultad->nomfac }}</p>
                </div>
                <div class="modal-footer border-0 justify-content-center gap-2">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <form action="{{ route('Rut.facu.destroy', $facultad->idfacultad) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <script src="assets/js/facultad.js"></script>
    
    <script>
        document.getElementById('btnCancelar').addEventListener('click', function() {
            document.getElementById('nomfac').value = '';
        });


        function searchTable() {
            var query = $('#search-input').val(); // Captura el valor del input de búsqueda
            $.ajax({
                url: "{{ route('buscar.facultad') }}", // URL que apunta al método del controlador
                type: 'GET',
                data: {
                    search: query // Envía el término de búsqueda como parámetro
                },
                success: function(data) {
                    $('tbody').html(data); // Actualiza el contenido de la tabla con los resultados
                },
                error: function(xhr, status, error) {
                    console.error("Error en la búsqueda:", error); // Maneja cualquier error
                }
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('success'))
    <script>
        Swal.fire({
            title: '¡Éxito!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'Aceptar'
        });
    </script>
    @endif



    <!-- Incluye los archivos CSS y JS de DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

    <style>
        .dataTables_length {
            float: right;
            margin-right: 10px;
        }

        .dataTables_length label {
            display: flex;
            align-items: center;
        }

        .dataTables_filter {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .dataTables_filter label {
            display: flex;
            align-items: center;
            margin-right: 10px;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('swal_error'))
            Swal.fire({
                title: '¡Error!',
                text: "{{ session('swal_error') }}",
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
            @endif
        });
    </script>
    @if(session('success'))
    <script>
        Swal.fire({
            title: '¡Éxito!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'Aceptar'
        });
    </script>
    @endif

    <script>
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
    </script>

    @include('Vistas.Footer')