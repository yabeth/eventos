
@include('Vistas.Header')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css"> 
  <link rel="stylesheet" href="https://www.flaticon.es/iconos-gratis/enlace">  
</head>
<style>
    
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');
h1 {
  font-size: 9vw;
 
  margin-top: 20px;
  font-weight: 600;
  font-size: 18px; 
  text-align: center;   

background: linear-gradient(
  45deg,
  #000000,
  #1c1c1c,
  #383838,  
  #545454,  
  #707070,  
  #888888,  
  #a9a9a9,  
  #d3d3d3  
);
font-family: 'Roboto', sans-serif;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  text-fill-color: transparent;
 
} 
.linea {
  border: none;
  height: 0.8px; 
  background-color: #888; 
  width: 100%; 
  margin-top: 10px;
  margin-bottom: 20px; 
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
    </style>
<body>
<h1>Asignación de organizadores a eventos</h1>
<hr class="linea">
<div id="">
    <div class="container-fluid mt-3">
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Organizadores</h5>
                        <button href="#addEmployeeModl" style="cursor: pointer;" class="btn btn-primary" data-toggle="modal">
                    <i class="bi bi-plus-circle"></i>
                </button>
                    </div>
                    <br>
                    <div class="card-body p-0">
                        <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
                            <table class="table table-hover table-striped mb-0" id="my-table" cellspacing="0" width="100%">
                                <thead class="table-light">
                                    <tr>
                                        <th>N°</th>
                                        <th>Organizadores</th>
                                        <th>Tipo de organizadores</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($organizadors as $index => $org)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $org->nombreor }}</td>
                                        <td>{{ $org->tipoorg->nombre }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-info seleccionar-organizador" data-id="{{ $org->idorg}}" data-nombre="{{ $org->nombreor}}">
                                                <i class="bi bi-check-circle"></i> Seleccionar
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Selector de Eventos y Lista de Seleccionados -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Asignar a Evento</h5>
                    </div>
                    <div class="card-body">
    <form id="formAsignarOrganizador" action="{{ route('Rut.evenorg.store') }}" method="POST">
        @csrf <!-- Token CSRF para seguridad -->
        <div class="mb-3">
            <label for="selectEvento" class="form-label">Seleccione el Evento:</label>
            <select id="selectEvento" name="idevento" class="form-select" required>
                <option value="">Seleccione un evento </option>
                @foreach ($eventoss as $evento)
                <option value="{{ $evento->idevento }}">{{ $evento->eventnom }}</option>
                @endforeach
            </select>
        </div>
        
        <label class="form-label">Organizador seleccionado:</label>
        <input type="hidden" id="idorg" name="idorg" required>
        <div class="list-group mb-3" id="listaSeleccionados" style="max-height: 150px; overflow-y: auto;">
            <!-- Aquí se agregará el organizador seleccionado -->
        </div>
        
        <button type="submit" id="btnAgregarOrganizador" class="btn btn-success w-100" disabled>
            <i class="bi bi-plus-circle-fill"></i> Agregar Organizador al Evento
        </button>
    </form>
</div>
                </div>
            </div>
        </div>
        
        <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0" >Organizadores Asignados a Eventos</h5>
            </div><br>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered mb-0" id="my-tabl" cellspacing="0" width="100%">
                        <thead class="table-dark">
                            <tr>
                                <th>N°</th>
                                <th>Evento</th>
                                <th>Organizadores</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $index = 1; @endphp
                            @foreach ($eventosAgrupados as $idevento => $datos)
                            <tr>
                                <td>{{ $index++ }}</td>
                                <td>{{ $datos['evento']->eventnom }}</td>
                                <td>
                                    <ul class="list-unstyled mb-0">
                                        @foreach ($datos['organizadores'] as $org)
                                            <li>{{ $org['organizador']->nombreor }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton{{ $idevento }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="bi bi-gear"></i> Acciones
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $idevento }}">
                                            @foreach ($datos['organizadores'] as $org)
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit{{$idevento}}_{{$org['idorg']}}">
                                                    <i class="bi bi-pencil"></i> Editar {{ $org['organizador']->nombreor }}
                                                </a>
                                                <form action="{{ route('Rut.evenorg.destroy', ['idevento' => $idevento, 'idorg' => $org['idorg']]) }}" method="POST" class="form-eliminar">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="bi bi-trash"></i> Eliminar {{ $org['organizador']->nombreor }}
                                                    </button>
                                                </form>
                                                <div class="dropdown-divider"></div>
                                            @endforeach
                                        </div>
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


     <!-- Formulario de edición -->
     @foreach($eventoorganizadors as $evenorg)
    <div id="edit{{$evenorg->idevento}}_{{$evenorg->idorg}}" class="modal fade" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('Rut.evenorg.update', ['idevento' => $evenorg->idevento, 'idorg' => $evenorg->idorg]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-primary text-white">
                        <h4 class="modal-title" id="editModalLabel">Editar Relación Evento-Organizador</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="ideventon" class="form-label">Evento</label>
                            <select name="ideventon" id="ideventon" class="form-control" required>
                      @foreach ($eventos as $evento)
                        <option value="{{ $evento->idevento }}" {{ $evento->idevento == ($evenorg->idevento ?? null) ? 'selected' : '' }}>
                      {{ $evento->eventnom }}
                      </option>
                @endforeach
               </select>
                        </div>

                        <div class="mb-3">
                            <label for="idorgn" class="form-label">Organizador</label>
                            <select name="idorgn" id="idorgn" class="form-control" required>
                                @foreach ($organizadors as $org)
                                    <option value="{{$org->idorg}}" {{ $org->idorg == $evenorg->idorg ? 'selected' : '' }}>
                                        {{$org->nombreor}}
                                    </option>
                                @endforeach
                            </select>
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


   <!-- crear Modal HTML -->
   <div id="addEmployeeModl" class="modal fade" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('Rut.orga.store')}}" method="post">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title" id="addEmployeeModalLabel">Agregar organizador</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="tipoorg" class="form-label">Tipo de Organizador</label>
                            <select name="idtipo" id="tipoorg" class="form-select form-control" required>
                                <option value="" disabled selected>Seleccione una opción</option>
                                @foreach ($tipoorgs as $tipoorg) 
                                    <option value="{{$tipoorg->idtipo}}">{{$tipoorg->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="organizador" class="form-label">Organizador</label>
                            <input type="text" class="form-control" name="nombreor" id="organizador" placeholder="Organizador" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="submit" style="cursor:pointer;" class="btn btn-success" name="save">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

    </div>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css"> 
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>



    document.addEventListener('DOMContentLoaded', function () {
        const forms = document.querySelectorAll('.form-eliminar');

        forms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: '¿Estás seguro de eliminar esta relación?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });

    $(document).ready(function () {
        $('#formAsignarOrganizador').on('submit', function (e) {
            e.preventDefault(); 

            const formData = $(this).serialize();

            $.ajax({
                url: $(this).attr('action'), 
                method: 'POST', 
                data: formData, 
                success: function (response) {
                    
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: response.message || 'Organizadores asignados correctamente.',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        
                        location.reload(); 
                    });
                },
                error: function (xhr) {
                    const errorMessage = xhr.responseJSON?.message || 'Hubo un error al procesar la solicitud.';
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: errorMessage,
                        confirmButtonText: 'Aceptar'
                    });
                }
            });
        });
    });


    $(document).ready(function () {
        $('.seleccionar-organizador').on('click', function () {
            
            const idOrg = $(this).data('id');
            const nombreOrg = $(this).data('nombre');

            
            if ($(`#listaSeleccionados .list-group-item[data-id="${idOrg}"]`).length > 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Organizador duplicado',
                    text: 'Este organizador ya ha sido seleccionado.',
                    confirmButtonText: 'Entendido'
                });
                return; 
            }

           
            const nuevoOrganizador = `
                <div class="list-group-item d-flex justify-content-between align-items-center" data-id="${idOrg}">
                    ${nombreOrg}
                    <button class="btn btn-sm btn-danger eliminar-organizador" data-id="${idOrg}">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            `;

       
            $('#listaSeleccionados').append(nuevoOrganizador);

            const idsSeleccionados = $('#listaSeleccionados .list-group-item')
                .map(function () {
                    return $(this).data('id');
                })
                .get()
                .join(',');

            $('#idorg').val(idsSeleccionados);
            $('#btnAgregarOrganizador').prop('disabled', false);

            Swal.fire({
                icon: 'success',
                title: 'Organizador agregado',
                text: `${nombreOrg} ha sido agregado a la lista.`,
                confirmButtonText: 'Entendido'
            });
        });

        $(document).on('click', '.eliminar-organizador', function () {
            const idOrg = $(this).data('id');
            const nombreOrg = $(`#listaSeleccionados .list-group-item[data-id="${idOrg}"]`).text().trim();

            $(`#listaSeleccionados .list-group-item[data-id="${idOrg}"]`).remove();

        
            const idsSeleccionados = $('#listaSeleccionados .list-group-item')
                .map(function () {
                    return $(this).data('id');
                })
                .get()
                .join(',');

            $('#idorg').val(idsSeleccionados);

            
            if (idsSeleccionados === '') {
                $('#btnAgregarOrganizador').prop('disabled', true);
            }

           
            Swal.fire({
                icon: 'info',
                title: 'Organizador eliminado',
                text: `${nombreOrg} ha sido eliminado de la lista.`,
                confirmButtonText: 'Entendido'
            });
        });
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


    @if(session('swal_success'))
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: "{{ session('swal_success') }}",
            confirmButtonText: 'Aceptar'
        });
    @endif

    @if(session('swal_error'))
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: "{{ session('swal_error') }}",
            confirmButtonText: 'Aceptar'
        });
    @endif

    
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
            "order": [[0, "asc"]],
            "columnDefs": [
                {
                    "targets": 2,
                    "orderable": false
                }
            ],
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


    // Actualiza tu script para el DataTable
$(document).ready(function() {
    $('#my-tabl').DataTable({
        "order": [[0, "asc"]],
        "columnDefs": [
            {
                "targets": [2, 3],
                "orderable": false
            }
        ],
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