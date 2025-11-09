@include('Vistas.Header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.1/font/bootstrap-icons.min.css">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

    .table-container {
        width: 100%;
        overflow: auto;
    }

    table {
        border: 1px solid grey;
        overflow-x: auto;
        display: block;
    }


    th {
        padding: 30px;
        background: #666;
    }

    td {
        padding: 30px;
        background: #999;
    }


    h1 {
        font-size: 9vw;

        margin-top: 20px;
        font-weight: 600;
        font-size: 18px;
        text-align: center;

        background: linear-gradient(45deg,
                #000000,
                #1c1c1c,
                #383838,
                #545454,
                #707070,
                #888888,
                #a9a9a9,
                #d3d3d3);

        .table-responsive {
            overflow-x: auto;
            white-space: nowrap;
        }


        font-family: 'Roboto',
        sans-serif;
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











      .subevento-card {
    border: 2px solid #e0e0e0;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 25px;
    background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 100%);
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    position: relative;
    transition: all 0.3s ease;
    }

    .subevento-card:hover {
    box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    transform: translateY(-2px);
    }

    .subevento-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 15px 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    font-weight: bold;
    font-size: 1.1em;
    display: flex;
    justify-content: space-between;
    align-items: center;
    }

    .subevento-actions {
    display: flex;
    gap: 8px;
    }

    .btn-action {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
    font-size: 16px;
    }

   .btn-edit {
    background: #4CAF50;
    color: white;
   }

   .btn-edit:hover {
    background: #45a049;
    transform: scale(1.1);
   }

   .btn-delete {
    background: #f44336;
    color: white;
   }

   .btn-delete:hover {
    background: #da190b;
    transform: scale(1.1);
   }

   .modalidad-btn {
    padding: 12px 24px;
    border: 2px solid #ddd;
    background: white;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s;
    margin-right: 10px;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 8px;
   }

   .modalidad-btn i {
    font-size: 1.2em;
   }

   .modalidad-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
   }

   .modalidad-btn.active {
    border-color: #667eea;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
  }

  .canales-table {
    max-height: 220px;
    overflow-y: auto;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    background: white;
  }

  .canales-table::-webkit-scrollbar {
    width: 8px;
  }

   .canales-table::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
  }

   .canales-table::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
   }

   .canales-table::-webkit-scrollbar-thumb:hover {
    background: #555;
   }

   .canal-row {
    padding: 12px 15px;
    border-bottom: 1px solid #eee;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 10px;
   }

   .canal-row:last-child {
    border-bottom: none;
   }

   .canal-row:hover {
    background: #e3f2fd;
   }

    .canal-row.selected {
    background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
    color: white;
   }

   .canal-row.selected small {
    color: rgba(255,255,255,0.9) !important;
   }

   .btn-nuevo-canal {
    border: 2px dashed #667eea;
    color: #667eea;
    background: white;
    transition: all 0.3s;
    font-weight: 500;
   }

   .btn-nuevo-canal:hover {
    background: #f0f4ff;
    border-color: #5568d3;
    transform: translateY(-2px);
    }

    #btnAddMore {
    border: 3px dashed #667eea;
    border-radius: 15px;
    padding: 15px 40px;
    font-weight: bold;
    transition: all 0.3s;
    }

    #btnAddMore:hover {
    background: #667eea;
    color: white;
    border-style: solid;
    transform: scale(1.05);
    }

    .badge-modalidad {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.85em;
    font-weight: 600;
    }

    /* Evitar scroll del fondo cuando modal está abierto */
    body.modal-open {
    overflow: hidden;
    }

    .modal {
    overflow-y: auto;
    }

   .modal-open .modal {
    overflow-x: hidden;
    overflow-y: auto;
   }
</style>

<style>
    .container {
        max-width: 100%;
        padding: 5px 0;
        box-sizing: border-box;
        margin: 0 auto;
    }

    .card {
        width: 100%;
        margin-bottom: 5px;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
</style>

<div class="container mt-1">
    <div class="card">
        <div class="card-header text-center">
            <h5 class="card-title">SUB EVENTOS</h5>
        </div>
        <div class="container">
            <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="d-flex flex-wrap align-items-center justify-content-between mb-1 ibox-head">
                        <a href="#addEmployeeModl" class="btn btn-primary" data-toggle="modal">
                            <i class="bi bi-plus-circle"></i> Actividades de eventos
                        </a>
                        <form action="{{ route('reportevento') }}" method="get" target="_blank" class="mb-2">
                            <button class="btn btn-success">
                                <i class="bi bi-file-earmark-text"></i> Reporte de eventos
                            </button>
                        </form>
                        <form action="{{ route('eventofecha') }}" method="get" class="d-flex flex-wrap align-items-end mb-2" target="_blank" style="gap: 10px;">
                            <div>
                                <label for="fecinic" class="form-label mb-0">Fecha inicio</label>
                                <input type="date" name="fecinic" class="form-control form-control-sm">
                            </div>
                            <div>
                                <label for="fecfin" class="form-label mb-0">Fecha fin</label>
                                <input type="date" name="fecfin" class="form-control form-control-sm">
                            </div>
                            <div>
                                <button class="btn btn-success">
                                    <i class="bi bi-printer"></i> Reporte por fecha
                                </button>
                            </div>
                        </form>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="ibox-head">
                        <div class="ibox-title">Lista de eventos</div>
                    </div>
       <div class="dataTables_wrapper no-footer">
       <table class="table table-hover table-bordered" id="my-table">
        <thead class="bg-info thead-inverse text-left" style="font-size: 11px;">
            <tr>
                <th>N°</th>
                <th>Evento</th>
                <th>Descripción</th>
                <th>Fecha</th>
                <th>Hora de apertura</th>
                <th>Hora de cierre</th>
                <th>Modalidad</th>
                <th>Canal</th>
                <th>URL</th>
                <th>Ponentes</th>
                <th>Acción</th>
            </tr>
          </thead>
           <tbody>
            @php
                $eventosAgrupados = $subevents->groupBy('evento.eventnom');
                $contador = 1;
            @endphp

            @foreach ($eventosAgrupados as $eventoNombre => $subeventos)
                @foreach ($subeventos as $index => $sub)
                    <tr>
                        <td>{{ $contador }}</td>

                        @if ($index == 0)
                            <td rowspan="{{ $subeventos->count() }}" class="align-middle text-center">
                                {{ $eventoNombre }}
                            </td>
                        @endif

                        <td>{{ $sub->Descripcion }}</td>
                        <td>{{ $sub->fechsubeve }}</td>
                        <td>{{ $sub->horini }}</td>
                        <td>{{ $sub->horfin }}</td>
                        <td>{{ $sub->canal->modalidad->modalidad }}</td>
                        <td>{{ $sub->canal->canal}}</td>
                        <td>{{ $sub->url}}</td>
                        <td>
                            @forelse($sub->asignarponentes as $index => $asig)
                            {{ $index + 1 }}. {{ $asig->persona->nombre }}<br>
                            @empty
                            <span class="text-muted">Sin ponentes asignados</span>
                            @endforelse
                        </td>
                        <td>
                            <div class="action-buttons text-center">
                                <button type="button" style="cursor:pointer;" class="btn text-info px-1 d-inline" data-toggle="modal" data-target="#edit{{$sub->idsubevent}}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button type="button" style="cursor:pointer;" class="btn text-info px-1 d-inline" data-toggle="modal" data-target="#delete{{$sub->idsubevent}}">
                                    <i class="bi bi-trash"></i>
                                </button>
                             <button type="button" style="cursor:pointer;" class="btn btn-primary px-3 d-inline" data-toggle="modal" data-target="#addPonenteModal">
                                    <i class="bi bi-person-plus"></i> 
                             </button>
                            </div>
                        </td>
                    </tr>
                       @php $contador++; @endphp
                     @endforeach
                    @endforeach
                    </tbody>
                   </table>
                  </div>

                </div>
            </div>
        </div>
    </div>
</div>



<!-- crear Modal HTML -->
<div id="addEmployeeModl" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('Rut.subevent.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addEventModalLabel">
                        <i class="bi bi-calendar-event"></i> Agregar Sub Eventos
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <!-- Selector de Evento Principal -->
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label for="evento_principal" class="fw-bold"> Evento Principal: 
                                <span class="text-danger"></span>
                            </label>
                            <select id="evento_principal" name="idTipoeven" class="form-control" required>
                                <option value="" disabled selected>Seleccione</option>
                                @foreach ($eventos as $evento)
                                <option value="{{ $evento->idevento }}">{{ $evento->eventnom }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Contador de Sub-eventos -->
                        <div class="form-group col-md-4" id="contador_container" style="display: none;">
                            <label for="num_subeventos" class="fw-bold">
                                Cantidad de Sub-eventos: 
                                <span class="text-danger">*</span>
                            </label>
                            <input type="number" id="num_subeventos" class="form-control" min="1" max="10" placeholder="Ejm: 2">
                        </div>
                    </div>

                    <hr id="separator" style="display: none;">

                    <!-- Contenedor Dinámico de Sub-eventos -->
                    <div id="subeventos_container"></div>

                    <!-- Botón para añadir más sub-eventos -->
                    <div id="btn_add_more_container" style="display: none;" class="text-center mb-3">
                        <button type="button" class="btn btn-outline-primary btn-lg" id="btnAddMore">
                            <i class="bi bi-plus-circle"></i> Añadir más Sub-eventos
                        </button>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btnCancelar">
                        <i class="bi bi-x-circle"></i> Limpiar
                    </button>
                    <button type="submit" class="btn btn-success" id="btnGuardar" style="display: none;">
                        <i class="bi bi-save"></i> Guardar Todos los Sub-eventos
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Agregar Nuevo Canal -->
<div id="modalNuevoCanal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
             <form action="{{ route('Rut.subevent.store') }}" method="POST">
                @csrf
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="bi bi-broadcast"></i> Agregar Nuevo Canal
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="nuevo_canal_nombre">
                        <i class="bi bi-tag"></i> Nombre del Canal:
                    </label>
                    <input type="text" id="nuevo_canal_nombre" class="form-control" 
                        placeholder="Ej: YouTube Live, Zoom Room 1, Auditorio Principal">
                </div>
                <div class="form-group" id="url_container">
                    <label for="nuevo_canal_url">
                        <i class="bi bi-link-45deg"></i> URL/Enlace:
                    </label>
                    <input type="url" id="nuevo_canal_url" class="form-control" placeholder="https://...">
                </div>
                <div class="form-group" id="ubicacion_container" style="display: none;">
                    <label for="nuevo_canal_ubicacion">
                        <i class="bi bi-geo-alt"></i> Ubicación:
                    </label>
                    <input type="text" id="nuevo_canal_ubicacion" class="form-control" 
                        placeholder="Ej: Edificio A, Piso 2, Sala 101">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnAgregarCanal">
                    <i class="bi bi-check-circle"></i> Agregar Canal
                </button>
            </div>
        </form>
        </div>
    </div>
</div>

<!-- Modal para Gestionar Ponentes -->
<div id="addPonenteModal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="bi bi-person-badge"></i> Gestionar Ponente - Sub-evento <span id="numero-subevento"></span>
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario de Ponente -->
                <form id="formPonente">
                    <input type="hidden" id="ponente_edit_index">
                    
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="ponente_dni">
                                <i class="bi bi-card-text"></i> DNI: <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="ponente_dni" class="form-control" 
                                placeholder="12345678" maxlength="8" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="ponente_nombres">
                                <i class="bi bi-person"></i> Nombres: <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="ponente_nombres" class="form-control" 
                                placeholder="Juan Carlos" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="ponente_apellidos">
                                <i class="bi bi-person"></i> Apellidos: <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="ponente_apellidos" class="form-control" 
                                placeholder="García López" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="ponente_telefono">
                                <i class="bi bi-telephone"></i> Teléfono: <span class="text-danger">*</span>
                            </label>
                            <input type="tel" id="ponente_telefono" class="form-control" 
                                placeholder="987654321" maxlength="9" required>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="ponente_email">
                                <i class="bi bi-envelope"></i> Email: <span class="text-danger">*</span>
                            </label>
                            <input type="email" id="ponente_email" class="form-control" 
                                placeholder="correo@ejemplo.com" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="ponente_genero">
                                <i class="bi bi-gender-ambiguous"></i> Género: <span class="text-danger">*</span>
                            </label>
                            <select id="ponente_genero" class="form-control" required>
                                <option value="">Seleccione</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                                <option value="O">Otro</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="ponente_direccion">
                                <i class="bi bi-house"></i> Dirección: <span class="text-danger">*</span>
                            </label>
                            <textarea id="ponente_direccion" class="form-control" rows="2" 
                                placeholder="Av. Principal 123, Distrito, Ciudad" required></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btnAgregarPonente">
                    <i class="bi bi-plus-circle"></i> Agregar
                </button>
                <button type="button" class="btn btn-warning" id="btnEditarPonente">
                    <i class="bi bi-pencil-square"></i> Editar
                </button>
                <button type="button" class="btn btn-danger" id="btnEliminarPonente">
                    <i class="bi bi-trash"></i> Eliminar
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11">

</script>
<script>
    document.getElementById('btnCancelar').addEventListener('click', function() {
        document.getElementById('tip_usu').value = '';
        document.getElementById('eventnom').value = '';
        document.getElementById('descripcion').value = '';
        document.getElementById('fecini').value = '';
        document.getElementById('horain').value = '';
        document.getElementById('horcul').value = '';
        document.getElementById('lugar').value = '';
        document.getElementById('ponente').value = '';
    });

    function showNoResolutionAlert(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Aviso',
            text: 'No cuenta con Resolución',
            icon: 'warning',
            confirmButtonText: 'Entendido'
        });
    }


    @if(session('error')) <
        script >
        alert("{{ session('error') }}");
</script>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
<script>
    @if(session('swal_error'))
    Swal.fire({
        title: '¡Error!',
        text: "{{ session('swal_error') }}",
        icon: 'error',
        confirmButtonText: 'Aceptar'
    });
    @endif

    @if(session('swal_success'))
    Swal.fire({
        title: '¡Éxito!',
        text: "{{ session('swal_success') }}",
        icon: 'success',
        confirmButtonText: 'Aceptar'
    });
    @endif

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







   
document.addEventListener('DOMContentLoaded', function() {
    const eventoSelect = document.getElementById('evento_principal');
    const contadorContainer = document.getElementById('contador_container');
    const numSubeventosInput = document.getElementById('num_subeventos');
    const subeventosContainer = document.getElementById('subeventos_container');
    const btnGuardar = document.getElementById('btnGuardar');
    const separator = document.getElementById('separator');
    const btnCancelar = document.getElementById('btnCancelar');
    const btnAddMoreContainer = document.getElementById('btn_add_more_container');
    
    let contadorSubeventos = 0;
    
    // Mapeo de modalidades a IDs de la base de datos
    const modalidadIds = {
        'virtual': 2,
        'presencial': 3,
        'semipresencial': 4
    };

    // Cuando se selecciona un evento
    eventoSelect.addEventListener('change', function() {
        if (this.value) {
            contadorContainer.style.display = 'block';
            numSubeventosInput.value = '';
            subeventosContainer.innerHTML = '';
            btnGuardar.style.display = 'none';
            separator.style.display = 'none';
            btnAddMoreContainer.style.display = 'none';
            contadorSubeventos = 0;
        }
    });

    // Cuando se ingresa la cantidad de sub-eventos
    numSubeventosInput.addEventListener('input', function() {
        const cantidad = parseInt(this.value);
        if (cantidad > 0 && cantidad <= 10) {
            subeventosContainer.innerHTML = '';
            contadorSubeventos = 0;
            generarSubeventos(cantidad);
            separator.style.display = 'block';
            btnGuardar.style.display = 'inline-block';
            btnAddMoreContainer.style.display = 'block';
        } else {
            subeventosContainer.innerHTML = '';
            btnGuardar.style.display = 'none';
            separator.style.display = 'none';
            btnAddMoreContainer.style.display = 'none';
        }
    });

    // Botón para añadir más sub-eventos
    document.getElementById('btnAddMore').addEventListener('click', function() {
        Swal.fire({
            title: '¿Cuántos sub-eventos agregar?',
            input: 'number',
            inputAttributes: {
                min: 1,
                max: 5,
                step: 1
            },
            inputValue: 1,
            showCancelButton: true,
            confirmButtonText: 'Agregar',
            cancelButtonText: 'Cancelar',
            inputValidator: (value) => {
                if (!value || value < 1 || value > 5) {
                    return 'Ingrese un número entre 1 y 5';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                generarSubeventos(parseInt(result.value));
            }
        });
    });

    function generarSubeventos(cantidad) {
        for (let i = 1; i <= cantidad; i++) {
            contadorSubeventos++;
            const subeventoHTML = `
                <div class="subevento-card" data-subevento="${contadorSubeventos}" data-index="${contadorSubeventos}">
                    <div class="subevento-header">
                        <span>
                            <i class="bi bi-calendar-check"></i> Sub-evento ${contadorSubeventos}
                        </span>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="fw-bold">
                                <i class="bi bi-chat-left-text"></i> Descripción: 
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="subeventos[${contadorSubeventos}][descripcion]" 
                                class="form-control descripcion-input" rows="2" 
                                placeholder="Describa el sub-evento ${contadorSubeventos}" required></textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="fw-bold">
                                <i class="bi bi-calendar-date"></i> Fecha: 
                                <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="subeventos[${contadorSubeventos}][fecha]" 
                                class="form-control fecha-input" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="fw-bold">
                                <i class="bi bi-clock"></i> Hora Apertura: 
                                <span class="text-danger">*</span>
                            </label>
                            <input type="time" name="subeventos[${contadorSubeventos}][hora_inicio]" 
                                class="form-control hora-inicio-input" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="fw-bold">
                                <i class="bi bi-clock-history"></i> Hora Cierre: 
                                <span class="text-danger">*</span>
                            </label>
                            <input type="time" name="subeventos[${contadorSubeventos}][hora_fin]" 
                                class="form-control hora-fin-input" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="fw-bold">
                                <i class="bi bi-link-45deg"></i> URL (opcional):
                            </label>
                            <input type="url" name="subeventos[${contadorSubeventos}][url]" 
                                class="form-control url-input" 
                                placeholder="https://ejemplo.com/transmision">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="fw-bold">
                            <i class="bi bi-gear"></i> Modalidad: 
                            <span class="text-danger">*</span>
                        </label>
                        <div class="d-flex flex-wrap align-items-center">
                            <button type="button" class="modalidad-btn mb-2" data-modalidad="virtual" data-idmodal="2" data-subevento="${contadorSubeventos}">
                                <i class="bi bi-laptop"></i> Virtual
                            </button>
                            <button type="button" class="modalidad-btn mb-2" data-modalidad="semipresencial" data-idmodal="4" data-subevento="${contadorSubeventos}">
                                <i class="bi bi-person-video2"></i> Semipresencial
                            </button>
                            <button type="button" class="modalidad-btn mb-2" data-modalidad="presencial" data-idmodal="3" data-subevento="${contadorSubeventos}">
                                <i class="bi bi-people"></i> Presencial
                            </button>
                        </div>
                        <input type="hidden" name="subeventos[${contadorSubeventos}][modalidad]" class="modalidad-input" required>
                    </div>

                    <div class="canal-section" style="display: none;">
                        <label class="fw-bold">
                            <i class="bi bi-broadcast-pin"></i> Canal: 
                            <span class="text-danger">*</span>
                        </label>
                        <div class="canales-table mb-2">
                            <div class="canales-list" data-subevento="${contadorSubeventos}">
                                <div class="canal-row text-muted">
                                    <i class="bi bi-info-circle"></i> Seleccione una modalidad primero
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="subeventos[${contadorSubeventos}][canal_id]" class="canal-input" required>
                        <input type="hidden" name="subeventos[${contadorSubeventos}][canal_nombre]" class="canal-nombre-input">
                    </div>
                </div>
            `;
            subeventosContainer.insertAdjacentHTML('beforeend', subeventoHTML);
        }

        inicializarEventos();
    }

    function inicializarEventos() {
        // Eventos para botones de modalidad
        document.querySelectorAll('.modalidad-btn').forEach(btn => {
            // Remover listeners previos
            btn.replaceWith(btn.cloneNode(true));
        });

        document.querySelectorAll('.modalidad-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const subevento = this.dataset.subevento;
                const modalidad = this.dataset.modalidad;
                const idModalidad = this.dataset.idmodal;
                const card = this.closest('.subevento-card');
                
                // Activar botón seleccionado
                card.querySelectorAll('.modalidad-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                // Guardar ID de modalidad
                card.querySelector('.modalidad-input').value = idModalidad;
                
                // Limpiar canal seleccionado
                card.querySelector('.canal-input').value = '';
                card.querySelector('.canal-nombre-input').value = '';
                
                // Mostrar sección de canales
                const canalSection = card.querySelector('.canal-section');
                canalSection.style.display = 'block';
                
                // Cargar canales según modalidad desde la BD
                cargarCanales(subevento, idModalidad, modalidad);
            });
        });
    }

// Función para cargar canales desde la base de datos
function cargarCanales(subevento, idModalidad, modalidadNombre) {
    const canalesList = document.querySelector(`.canales-list[data-subevento="${subevento}"]`);
    const canalSection = canalesList.closest('.canal-section');
    
    canalesList.innerHTML = '<div class="canal-row text-muted"><i class="bi bi-hourglass-split"></i> Cargando canales...</div>';
    canalSection.style.display = 'block';
    
    // Obtener la base URL desde Laravel
    const baseUrl = '{{ url("/even") }}';
    const url = `${baseUrl}/canales/por-modalidad/${idModalidad}`;
    
    console.log('URL de petición:', url);
    console.log('ID Modalidad:', idModalidad);
    
    // Petición AJAX a Laravel
    fetch(url, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        credentials: 'same-origin'
    })
    .then(response => {
        console.log('Status:', response.status);
        
        if (!response.ok) {
            return response.text().then(text => {
                throw new Error(`HTTP ${response.status}: ${text}`);
            });
        }
        return response.json();
    })
    .then(canales => {
        console.log('Canales recibidos:', canales);
        
        canalesList.innerHTML = '';
        
        if (canales.error) {
            canalesList.innerHTML = `
                <div class="canal-row text-danger">
                    <i class="bi bi-exclamation-triangle"></i> 
                    <div style="flex: 1;">Error: ${canales.error}</div>
                </div>
            `;
            return;
        }
        
        if (!Array.isArray(canales) || canales.length === 0) {
            canalesList.innerHTML = `
                <div class="canal-row text-muted">
                    <i class="bi bi-info-circle"></i> 
                    <div style="flex: 1;">No hay canales disponibles para esta modalidad</div>
                </div>
            `;
            return;
        }
        
        // Renderizar canales
        canales.forEach(canal => {
            let icon = 'bi-broadcast';
            if (modalidadNombre === 'virtual') {
                icon = 'bi-camera-video';
            } else if (modalidadNombre === 'presencial') {
                icon = 'bi-geo-alt-fill';
            } else if (modalidadNombre === 'semipresencial') {
                icon = 'bi-person-video2';
            }
            
            const canalHTML = `
                <div class="canal-row" data-canal-id="${canal.id}" data-canal-nombre="${canal.nombre}">
                    <i class="bi ${icon}"></i>
                    <div style="flex: 1;">
                        <strong>${canal.nombre}</strong>
                        <br><small class="text-muted">${canal.modalidad}</small>
                    </div>
                </div>
            `;
            canalesList.insertAdjacentHTML('beforeend', canalHTML);
        });
        
        // Agregar eventos de selección
        agregarEventosSeleccion(canalesList);
    })
    .catch(error => {
        console.error('Error completo:', error);
        canalesList.innerHTML = `
            <div class="canal-row text-danger">
                <i class="bi bi-x-circle"></i> 
                <div style="flex: 1;">
                    Error al cargar canales.<br>
                    <small>${error.message}</small><br>
                    <small style="font-size: 10px;">URL: ${url}</small>
                </div>
            </div>
        `;
    });
}


    // Función para agregar eventos de selección a los canales
    function agregarEventosSeleccion(canalesList) {
        canalesList.querySelectorAll('.canal-row[data-canal-id]').forEach(row => {
            row.addEventListener('click', function() {
                const card = this.closest('.subevento-card');
                
                // Quitar selección previa
                card.querySelectorAll('.canal-row').forEach(r => r.classList.remove('selected'));
                
                // Agregar selección actual
                this.classList.add('selected');
                
                // Guardar valores
                card.querySelector('.canal-input').value = this.dataset.canalId;
                card.querySelector('.canal-nombre-input').value = this.dataset.canalNombre;
                
                console.log('Canal seleccionado:', {
                    id: this.dataset.canalId,
                    nombre: this.dataset.canalNombre
                });
            });
        });
    }

    // Botón Limpiar
    btnCancelar.addEventListener('click', function() {
        Swal.fire({
            title: '¿Está seguro?',
            text: "Se perderán todos los datos ingresados",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, limpiar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('evento_principal').value = '';
                contadorContainer.style.display = 'none';
                numSubeventosInput.value = '';
                subeventosContainer.innerHTML = '';
                btnGuardar.style.display = 'none';
                separator.style.display = 'none';
                btnAddMoreContainer.style.display = 'none';
                contadorSubeventos = 0;
                
                Swal.fire({
                    icon: 'success',
                    title: 'Limpiado',
                    text: 'Formulario limpiado correctamente',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    });

    // Validación antes de enviar el formulario
    document.querySelector('form').addEventListener('submit', function(e) {
        const cards = document.querySelectorAll('.subevento-card');
        let errores = [];
        
        cards.forEach((card, index) => {
            const descripcion = card.querySelector('.descripcion-input').value.trim();
            const fecha = card.querySelector('.fecha-input').value;
            const horaInicio = card.querySelector('.hora-inicio-input').value;
            const horaFin = card.querySelector('.hora-fin-input').value;
            const modalidad = card.querySelector('.modalidad-input').value;
            const canalId = card.querySelector('.canal-input').value;
            
            if (!descripcion) errores.push(`Sub-evento ${index + 1}: Falta descripción`);
            if (!fecha) errores.push(`Sub-evento ${index + 1}: Falta fecha`);
            if (!horaInicio) errores.push(`Sub-evento ${index + 1}: Falta hora de inicio`);
            if (!horaFin) errores.push(`Sub-evento ${index + 1}: Falta hora de fin`);
            if (!modalidad) errores.push(`Sub-evento ${index + 1}: Falta seleccionar modalidad`);
            if (!canalId) errores.push(`Sub-evento ${index + 1}: Falta seleccionar canal`);
        });
        
        if (errores.length > 0) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Faltan datos requeridos',
                html: errores.join('<br>'),
                confirmButtonText: 'Entendido'
            });
        }
    });

    // Prevenir scroll del body cuando el modal está abierto
    $('#addEmployeeModl').on('shown.bs.modal', function () {
        $('body').addClass('modal-open');
    });

    $('#addEmployeeModl').on('hidden.bs.modal', function () {
        $('body').removeClass('modal-open');
    });
});


</script>
@include('Vistas.Footer')