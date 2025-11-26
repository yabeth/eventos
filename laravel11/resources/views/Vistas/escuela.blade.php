@include('Vistas.Header')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://www.flaticon.es/iconos-gratis/enlace">
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f8f9fa;
        /* margin: 20px; */
    }

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

<div class="container mt-2">
    <div class="card">
        <div class="card-header bg-primary text-white text-center">
            <h5 class="card-title mb-1">GESTION DE ESCUELAS</h5>
        </div>
        <div class="container">
            <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head">
                        <button href="#addEmployeeModl" style="cursor: pointer;" class="btn btn-primary" data-toggle="modal">
                            <i class="bi bi-plus-circle"></i> AGREGAR NUEVO
                        </button>
                    </div>
                    <div class="ibox-head">
                        <div class="ibox-title">Lista de escuelas registradas</div>
                    </div>
                    <div class="table-container mt-2">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="my-table" cellspacing="0" width="100%">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th>N°</th>
                                        <th>Escuela</th>
                                        <th>Facultades</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($escuelas as $index => $escu)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $escu->nomescu }}</td>
                                        <td>{{ $escu->facultad->nomfac }}</td>
                                        <td class="justify-content-center text-center">
                                            <div class="action-buttons justify-content-center">
                                                <button type="button" class="btn btn-warning btn-sm me-2" data-toggle="modal" data-target="#edit{{$escu->idescuela}}">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{$escu->idescuela}}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('Rut.escu.store')}}" method="post">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title" id="addEmployeeModalLabel">Agregar escuela</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="facultad" class="form-label">Facultad</label>
                            <select name="idfacultad" id="facultad" class="form-select form-control" required>
                                <option value="" disabled selected>Seleccione una opción</option>
                                @foreach ($facultads as $facu)
                                <option value="{{$facu->idfacultad}}">{{$facu->nomfac}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="escuela" class="form-label">Escuela</label>
                            <input type="text" class="form-control" name="nomescu" id="escuela" placeholder="Ingrese el nombre de la escuela" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btnCancelar">Limpiar</button>
                    <button type="submit" style="cursor:pointer;" class="btn btn-success" name="save">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- edit Modal HTML -->
@foreach($escuelas as $escuela)
<div id="edit{{$escuela->idescuela}}" class="modal fade" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('Rut.escu.update', $escuela->idescuela) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title" id="editModalLabel">Editar Escuela</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="idfacultad" class="form-label">Facultad</label>
                        <select name="idfacultad" id="idfacultad" class="form-control" required>
                            @foreach ($facultads as $facu)
                            <option value="{{$facu->idfacultad}}" {{ $facu->idfacultad == $escuela->idfacultad ? 'selected' : '' }}>
                                {{$facu->nomfac}}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="nomescu" class="form-label">Escuela</label>
                        <input type="text" class="form-control" name="nomescu" id="nomescu" value="{{ $escuela->nomescu }}" required>
                    </div>
                </div>

                <!-- Footer del Modal -->
                <div class="modal-footer">
                    <button type="submit" style="cursor:pointer;" class="btn btn-success" name="update">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endforeach

<!-- delete Modal HTML -->
@foreach($escuelas as $escuela)
<div id="delete{{$escuela->idescuela}}" class="modal fade" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-center">
            <form action="{{ route('Rut.escu.destroy', $escuela->idescuela) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header border-0 justify-content-center pb-1">
                    <div class="modal-title">
                        <i class="bi bi-exclamation-circle" style="font-size: 80px; color: #f4c542;"></i>
                    </div>
                </div>
                <div class="modal-body pt-2 pb-3">
                    <h4 class="mb-1">Confirmar</h4>
                    <p class="mb-3">¿Estás seguro que deseas eliminar la escuela?</p>
                    <span><strong>{{ $escuela->nomescu }}</strong></span>
                </div>

                <!-- Footer del modal con menos espacio entre botones y contenido -->
                <div class="modal-footer border-0 justify-content-center pt-0 pb-3">
                    <button type="button" style="cursor:pointer;" class="btn btn-warning" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                    <button type="submit" style="cursor:pointer;" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    < script src = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" >
</script>
<script>
    document.getElementById('btnCancelar').addEventListener('click', function() {
        document.getElementById('escuela').value = '';
    });

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

    function searchTable() {
        var query = $('#search-input').val();
        $.ajax({
            url: "{{ route('buscar.escuela') }}",
            type: 'GET',
            data: {
                search: query
            },
            success: function(data) {
                $('tbody').html(data);
            },
            error: function(xhr, status, error) {
                console.error("Error en la búsqueda:", error);
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

<script>
    $(document).ready(function() {
        $('#my-table').DataTable({
            "order": [
                [0, "asc"]
            ],
            "columnDefs": [{
                "targets": 2,
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