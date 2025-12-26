@include('Vistas.Header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.1/font/bootstrap-icons.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
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

    .subevento-card {
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
        background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 100%);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        position: relative;
        transition: all 0.3s ease;
    }

    .subevento-card:hover {
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
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
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
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
        color: rgba(255, 255, 255, 0.9) !important;
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

    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
        cursor: pointer;
    }

    .action-btn-group {
        display: flex;
        gap: 5px;
        justify-content: center;
    }

    .btn-sm-action {
        padding: 5px 10px;
        font-size: 14px;
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


    .sticky-top {
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .btn-gestionar-canales {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    .canal-actions {
        display: flex;
        gap: 5px;
        justify-content: center;
    }
</style>

<div class="container mt-1">
    <div class="card">
        <div class="card-header text-center bg-primary text-white">
            <h5 class="card-title mb-0">SUB EVENTOS</h5>
        </div>
        <div class="container">
            <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="d-flex flex-wrap align-items-center justify-content-between mb-1 ibox-head">
                        <a href="#addEmployeeModl" class="btn btn-primary" data-toggle="modal">
                            <i class="bi bi-plus-circle"></i> Actividades de eventos
                        </a>
                        
                        <a href="{{ route('reprTodosLosSubeventos') }}" target="_blank" class="btn btn-success">
                            <i class="bi bi-printer"></i> Reporte Subeventos
                        </a>
                    </div>

                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    <div class="ibox-head">
                        <div class="ibox-title">Lista de Actividades de un Evento</div>
                    </div>
                    <div class="ibox-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle" id="my-table">
                                <thead class="table-info text-black">
                                    <tr>
                                        <th>N°</th>
                                        <th>Evento</th>
                                        <th>Descripción</th>
                                        <th>Fecha</th>
                                        <th>Apertura</th>
                                        <th>Cierre</th>
                                        <th>Modalidad</th>
                                        <th>Espacio</th>
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
                                        <td rowspan="{{ $subeventos->count() }}" class="align-middle fw-bold bg-light">
                                            {{ $eventoNombre }}
                                        </td>
                                        @endif

                                        <td>{{ $sub->Descripcion }}</td>
                                        <td>{{ $sub->fechsubeve }}</td>
                                        <td>{{ $sub->horini }}</td>
                                        <td>{{ $sub->horfin }}</td>
                                        <td>{{ $sub->canal->modalidad->modalidad }}</td>
                                        <td>{{ $sub->canal->canal }}</td>
                                        <td class="text-center">
                                            @if(!empty($sub->url))
                                                <div class="dropdown d-inline-block">
                                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle rounded-pill"
                                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-link-45deg me-1"></i> Enlace
                                                    </button>

                                                    <ul class="dropdown-menu dropdown-menu-end shadow">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ $sub->url }}" target="_blank">
                                                                <i class="bi bi-box-arrow-up-right me-2"></i> Abrir enlace
                                                            </a>
                                                        </li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <button
                                                                type="button"
                                                                class="dropdown-item copy-btn"
                                                                data-url="{{ $sub->url }}">
                                                                <i class="bi bi-clipboard me-2"></i> Copiar enlace
                                                            </button>
                                                        </li>

                                                        <li>
                                                            <span class="dropdown-item-text small text-muted">
                                                                {{ Str::limit($sub->url, 45) }}
                                                            </span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>

                                        <td>
                                            @forelse($sub->asignarponentes as $i => $asig)
                                            <span class="badge bg-primary">
                                                {{ $i + 1 }}. {{ $asig->persona->apell }} {{ $asig->persona->nombre }}
                                            </span><br>
                                            @empty
                                            <span class="text-muted fst-italic">Sin ponentes</span>
                                            @endforelse
                                        </td>

                                        <td class="action-buttons">
                                            <button type="button" class="btn btn-outline-warning btn-sm" data-toggle="modal" data-target="#edit{{$sub->idsubevent}}" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#delete{{$sub->idsubevent}}" title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </button>
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
</div>




<div id="addEmployeeModl" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-ui-dialog-content modal-dialog-scrollable">
        <div class="modal-content shadow-lg">
            <div class="modal-header bg-blue text-white border-0">
                <div class="d-flex align-items-center">
                    <div>
                        <h5 class="modal-title mb-0" id="modalGenerarNormalesLabel">Generar Actividades Paralelas</h5>
                        <small class="opacity-75">Subeventos</small>
                    </div>
                </div>
                <button type="button" class="close btn-close-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body p-4">
                <form id="formSubevent" action="{{ route('Rut.subevent.store') }}" method="POST">
                    @csrf
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


                        <div class="text-center mb-3" id="btn_gestionar_canales_container" style="display: none;">
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalGestionCanales" data-dismiss="modal">
                                <i class="bi bi-broadcast"></i> Gestionar Canales
                            </button>
                        </div>

                        <!-- Botón para añadir más sub-eventos -->
                        <div id="btn_add_more_container" style="display: none;" class="text-center mb-3">
                            <button type="button" class="btn btn-outline-primary btn-lg" id="btnAddMore">
                                <i class="bi bi-plus-circle"></i> Añadir más Sub-eventos
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light border-0">
                <button type="button" class="btn btn-secondary" id="btnCancelar">
                    <i class="bi bi-x-circle"></i> Limpiar
                </button>
                <button type="submit" class="btn btn-success" id="btnGuardar" form="formSubevent" style="display: none;">
                    <i class="bi bi-save"></i> Guardar Todos los Sub-eventos
                </button>
            </div>
        </div>
    </div>
</div>

<!-- edit Modal HTML -->
@foreach($subevents as $sub)
<div id="edit{{ $sub->idsubevent }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('Rut.subevent.update', $sub->idsubevent) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editEventModalLabel">Editar Sub Evento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">

                        <div class="form-group col-md-6">
                            <label for="fechsubeve">Fecha: <span class="required text-danger">*</span></label>
                            <input type="date" id="fechsubeve" name="fechsubeve" class="form-control" value="{{ $sub->fechsubeve }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="horini">Hora de apertura: <span class="required text-danger">*</span></label>
                            <input type="time" id="horini" name="horini" class="form-control" value="{{ $sub->horini }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="horfin">Hora de cierre: <span class="required text-danger">*</span></label>
                            <input type="time" id="horfin" name="horfin" class="form-control" value="{{ $sub->horfin }}" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="url">URL: <span class="required text-danger"></span></label>
                            <input type="text" id="url" name="url" class="form-control" value="{{ $sub->url }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="Descripcion">Descripción: <span class="required text-danger">*</span></label>
                            <textarea id="Descripcion" name="Descripcion" class="form-control" rows="3" required>{{ $sub->Descripcion }}</textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="idmodal">Modalidad: <span class="required text-danger">*</span></label>
                            <select name="idmodal" class="form-control" required>
                                @foreach ($modalidades as $mod)
                                <option value="{{ $mod->idmodal }}" {{ $mod->idmodal == $sub->canal->idmodal ? 'selected' : '' }}>{{ trim($mod->modalidad) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="idcanal">Canal: <span class="required text-danger">*</span></label>
                            <select name="idcanal" class="form-control" required>
                                @foreach ($canales as $can)
                                <option value="{{ $can->idcanal }}" {{ $can->idcanal == $sub->idcanal ? 'selected' : '' }}>
                                    {{ $can->canal }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                </div>

                <div class="modal-footer">
                    <button type="submit" style="cursor: pointer;" class="btn btn-success">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- delete Modal HTML -->
@foreach($subevents as $sub)
<div id="delete{{$sub->idsubevent}}" class="modal fade" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-center">
            <form action="{{ route('subevent.destroy', $sub->idsubevent) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header border-0 justify-content-center pb-1">
                    <div class="modal-title">
                        <i class="bi bi-exclamation-circle" style="font-size: 80px; color: #f4c542;"></i>
                    </div>
                </div>
                <div class="modal-body pt-2 pb-3">
                    <h4 class="mb-1">Confirmar</h4>
                    <p class="mb-3">¿Estás seguro que deseas eliminar el evento?</p>
                </div>
                <div class="modal-footer border-0 justify-content-center pt-0 pb-3">
                    <button type="button" style="cursor:pointer;" class="btn btn-warning" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                    <button type="submit" style="cursor:pointer;" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Modal de Gestión de Canales -->
<div id="modalGestionCanales" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl"> <!-- Cambiado a modal-xl para más espacio -->
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <div>
                    <h5 class="modal-title mb-0">
                        <i class="bi bi-broadcast"></i> Gestión de Canales
                    </h5>
                    <small class="opacity-75">Administre los canales disponibles para los eventos</small>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Botón Crear Canal -->
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-success" id="btnAbrirCrearCanal">
                        <i class="bi bi-plus-circle"></i> Crear Nuevo Canal
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="cargarTodosLosCanales()">
                        <i class="bi bi-arrow-clockwise"></i> Recargar
                    </button>
                </div>

                <!-- Tabla de Canales con estilo similar a tu tabla principal -->
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle shadow-sm">
                        <thead class="bg-info text-white text-center" style="font-size: 11px;">
                            <tr>
                                <th width="5%">N°</th>
                                <th width="40%">Canal</th>
                                <th width="30%">Modalidad</th>
                                <th width="25%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaCanalesBody">
                            <tr>
                                <td colspan="4" class="text-center">
                                    <i class="bi bi-hourglass-split"></i> Cargando canales...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Crear/Editar Canal -->
<div id="modalFormCanal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="tituloFormCanal">
                    <i class="bi bi-plus-circle"></i> Crear Canal
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="formCanal">
                <div class="modal-body">
                    <input type="hidden" id="idcanal_form" name="idcanal">

                    <div class="form-group">
                        <label for="canal_modalidad">
                            <i class="bi bi-gear"></i> Modalidad:
                            <span class="text-danger">*</span>
                        </label>
                        <select id="canal_modalidad" name="idmodal" class="form-control" required>
                            <option value="">Seleccione modalidad...</option>
                            <option value="2">Virtual</option>
                            <option value="3">Presencial</option>
                            <option value="4">Semipresencial</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="canal_nombre">
                            <i class="bi bi-tag"></i> Nombre del Canal:
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="canal_nombre" name="canal" class="form-control"
                            placeholder="Ej: Auditorio Principal, Google Meet, Zoom Room 1" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Guardar Canal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Eliminar Canal -->
<div id="modalEliminarCanal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header border-0 justify-content-center pb-1">
                <div class="modal-title">
                    <i class="bi bi-exclamation-circle" style="font-size: 80px; color: #f4c542;"></i>
                </div>
            </div>
            <div class="modal-body pt-2 pb-3">
                <h4 class="mb-1">Confirmar Eliminación</h4>
                <p class="mb-1">¿Está seguro de eliminar este canal?</p>
                <p class="text-muted mb-0">Canal: <strong id="nombre-canal-eliminar"></strong></p>
                <p class="text-danger mt-2"><small>Esta acción no se puede deshacer</small></p>
            </div>
            <div class="modal-footer border-0 justify-content-center pt-0 pb-3">
                <input type="hidden" id="idcanal_eliminar">
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Cancelar
                </button>
                <button type="button" class="btn btn-danger" id="btnConfirmarEliminar">
                    <i class="bi bi-trash"></i> Eliminar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.copy-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const url = this.dataset.url;
            const originalHTML = this.innerHTML;

            navigator.clipboard.writeText(url).then(() => {
                this.innerHTML = '<i class="bi bi-check-lg me-2"></i> Copiado';
                this.classList.add('text-success');

                setTimeout(() => {
                    this.innerHTML = originalHTML;
                    this.classList.remove('text-success');
                }, 1800);
            });
        });
    });
});
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
        const modalidadIds = {'virtual': 2,'presencial': 3,'semipresencial': 4};

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
                document.getElementById('btn_gestionar_canales_container').style.display = 'block';
            } else {
                subeventosContainer.innerHTML = '';
                btnGuardar.style.display = 'none';
                separator.style.display = 'none';
                btnAddMoreContainer.style.display = 'none';
                document.getElementById('btn_gestionar_canales_container').style.display = 'none';
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

            // CORRECCIÓN: Usar ruta relativa simple
            const url = `canales/por-modalidad/${idModalidad}`;

            console.log('URL de petición:', url);
            console.log('ID Modalidad:', idModalidad);

            // Petición AJAX a Laravel
            fetch(url, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    console.log('Status:', response.status);

                    if (!response.ok) {
                        return response.text().then(text => {
                            throw new Error(`HTTP ${response.status}: ${text.substring(0, 200)}`);
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
                    <small>${error.message}</small>
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
                    document.getElementById('btn_gestionar_canales_container').style.display = 'none';
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
        $('#addEmployeeModl').on('shown.bs.modal', function() {
            $('body').addClass('modal-open');
        });

        $('#addEmployeeModl').on('hidden.bs.modal', function() {
            $('body').removeClass('modal-open');
        });
    });




    $(document).ready(function() {
        $('#addEmployeeModlp').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Botón que abrió el modal
            var idsubevent = button.data('idsubevent'); // Extraer info del atributo data-*
            var descripcion = button.data('descripcion');

            var modal = $(this);
            modal.find('#idsubevent_input').val(idsubevent);
            modal.find('#numero-subevento').text('- ' + descripcion);

            console.log('ID Subevento capturado:', idsubevent);
        });

        // Limpiar formulario al cerrar
        $('#addEmployeeModlp').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
            $('#idsubevent_input').val('');
        });
    });

    let idSubeventoActual = null;

    // Función para cargar ponentes del subevento
    function cargarPonentesDelSubevento(idsubevent) {
        idSubeventoActual = idsubevent;
        $('#idsubevent_crear').val(idsubevent);

        const tablaPonentes = $('#tablaPonentes');
        tablaPonentes.html(`
        <tr>
            <td colspan="7" class="text-center">
                <i class="bi bi-hourglass-split"></i> Cargando ponentes...
            </td>
        </tr>
    `);

        // Construir URL con variable global
        const url = (typeof rutaPonentes !== 'undefined' ? rutaPonentes : '/ponentes-por-subevento') + `/${idsubevent}`;

        console.log('URL de petición:', url);

        fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log('Ponentes recibidos:', data);

                if (!data.ponentes || data.ponentes.length === 0) {
                    tablaPonentes.html(`
                <tr>
                    <td colspan="7" class="text-center text-muted">
                        <i class="bi bi-info-circle"></i> No hay ponentes asignados a este sub-evento
                    </td>
                </tr>
            `);
                    return;
                }

                let html = '';
                data.ponentes.forEach((ponente, index) => {
                    html += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${ponente.dni}</td>
                    <td>${ponente.nombre} ${ponente.apell}</td>
                    <td>${ponente.tele}</td>
                    <td>${ponente.email}</td>
                    <td>${ponente.genero}</td>
                    <td>
                        <div class="action-btn-group">
                            <button type="button" class="btn btn-sm btn-warning btn-sm-action" 
                                    onclick="abrirModalEditar(${ponente.idasig}, '${ponente.dni}', '${ponente.nombre}', '${ponente.apell}', '${ponente.tele}', '${ponente.email}', '${ponente.direc}', ${ponente.idgenero})">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger btn-sm-action" 
                                    onclick="abrirModalEliminar(${ponente.idasig}, '${ponente.nombre} ${ponente.apell}')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>`;
                });

                tablaPonentes.html(html);
            })
            .catch(error => {
                console.error('Error:', error);
                tablaPonentes.html(`
            <tr>
                <td colspan="7" class="text-center text-danger">
                    <i class="bi bi-x-circle"></i> Error al cargar ponentes
                </td>
            </tr>
        `);
            });
    }

    // Función para abrir modal de editar
    function abrirModalEditar(idasig, dni, nombre, apell, tele, email, direc, idgenero) {
        $('#idasig_editar').val(idasig);
        $('#dni_editar').val(dni);
        $('#nombre_editar').val(nombre);
        $('#apell_editar').val(apell);
        $('#tele_editar').val(tele);
        $('#email_editar').val(email);
        $('#direc_editar').val(direc);
        $('#idgenero_editar').val(idgenero);

        // Configurar la acción del formulario
        $('#formEditarPonente').attr('action', `/Rut-asignarponent/${idasig}`);

        $('#gestionPonentesModal').modal('hide');
        $('#editarPonenteModal').modal('show');
    }

    // Función para abrir modal de eliminar
    function abrirModalEliminar(idasig, nombreCompleto) {
        $('#nombre-ponente-eliminar').text(nombreCompleto);
        $('#formEliminarPonente').attr('action', `/asignarponent/${idasig}`);

        $('#gestionPonentesModal').modal('hide');
        $('#eliminarPonenteModal').modal('show');
    }

    // Event listeners
    $(document).ready(function() {
        // Al abrir modal principal
        $('#gestionPonentesModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var idsubevent = button.data('idsubevent');
            var descripcion = button.data('descripcion');

            $('#descripcion-subevento').text(descripcion);
            idSubeventoActual = idsubevent;
        });

        // Al abrir modal crear
        $('#crearPonenteModal').on('show.bs.modal', function() {
            $('#idsubevent_crear').val(idSubeventoActual);
        });

        // Al cerrar modal editar, reabrir el principal
        $('#editarPonenteModal').on('hidden.bs.modal', function() {
            $('#gestionPonentesModal').modal('show');
            cargarPonentesDelSubevento(idSubeventoActual);
        });

        // Al cerrar modal eliminar, reabrir el principal
        $('#eliminarPonenteModal').on('hidden.bs.modal', function() {
            $('#gestionPonentesModal').modal('show');
            cargarPonentesDelSubevento(idSubeventoActual);
        });

        // Al cerrar modal crear, reabrir el principal
        $('#crearPonenteModal').on('hidden.bs.modal', function() {
            $('#gestionPonentesModal').modal('show');
            cargarPonentesDelSubevento(idSubeventoActual);
        });
    });




















    // Variables globales para gestión de canales
    let modoEdicionCanal = false;

    $(document).ready(function() {
        // Cargar canales al abrir el modal
        $('#modalGestionCanales').on('show.bs.modal', function() {
            cargarTodosLosCanales();
        });

        // Abrir modal crear
        $('#btnAbrirCrearCanal').on('click', function() {
            modoEdicionCanal = false;
            $('#tituloFormCanal').html('<i class="bi bi-plus-circle"></i> Crear Nuevo Canal');
            $('#formCanal')[0].reset();
            $('#idcanal_form').val('');
            $('#modalGestionCanales').modal('hide');
            $('#modalFormCanal').modal('show');
        });

        // Submit formulario canal
        $('#formCanal').on('submit', function(e) {
            e.preventDefault();

            const idcanal = $('#idcanal_form').val();
            const datos = {
                canal: $('#canal_nombre').val(),
                idmodal: $('#canal_modalidad').val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            // Validación
            if (!datos.canal || !datos.idmodal) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos incompletos',
                    text: 'Por favor complete todos los campos obligatorios'
                });
                return;
            }

            let url, method;

            if (modoEdicionCanal) {
                url = `{{ url('canales') }}/${idcanal}`;
                method = 'PUT';
            } else {
                url = '{{ route("canales.store") }}';
                method = 'POST';
            }

            // Deshabilitar botón mientras se procesa
            const btnSubmit = $('#formCanal button[type="submit"]');
            btnSubmit.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> Guardando...');

            $.ajax({
                url: url,
                type: method,
                data: datos,
                success: function(response) {
                    $('#modalFormCanal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: response.message || 'Canal guardado correctamente',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        $('#modalGestionCanales').modal('show');
                        cargarTodosLosCanales();
                    });
                },
                error: function(xhr) {
                    let mensaje = 'Error al guardar el canal';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        mensaje = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: mensaje
                    });
                },
                complete: function() {
                    btnSubmit.prop('disabled', false).html('<i class="bi bi-save"></i> Guardar Canal');
                }
            });
        });

        // Confirmar eliminación
        $('#btnConfirmarEliminar').on('click', function() {
            const idcanal = $('#idcanal_eliminar').val();
            const btn = $(this);

            btn.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> Eliminando...');

            $.ajax({
                url: `{{ url('canales') }}/${idcanal}`,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#modalEliminarCanal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: '¡Eliminado!',
                        text: response.message || 'Canal eliminado correctamente',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        $('#modalGestionCanales').modal('show');
                        cargarTodosLosCanales();
                    });
                },
                error: function(xhr) {
                    let mensaje = 'No se pudo eliminar el canal';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        mensaje = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: mensaje
                    });
                    btn.prop('disabled', false).html('<i class="bi bi-trash"></i> Eliminar');
                }
            });
        });

        // Al cerrar modales secundarios
        $('#modalFormCanal, #modalEliminarCanal').on('hidden.bs.modal', function() {
            if ($('.swal2-container').length === 0) {
                $('#modalGestionCanales').modal('show');
            }
        });
    });

    // Función para cargar todos los canales
    function cargarTodosLosCanales() {
        const tbody = $('#tablaCanalesBody');
        tbody.html(`
        <tr>
            <td colspan="4" class="text-center">
                <div class="spinner-border spinner-border-sm text-primary" role="status">
                    <span class="sr-only">Cargando...</span>
                </div>
                <span class="ml-2">Cargando canales...</span>
            </td>
        </tr>
    `);

        // Cargar las 3 modalidades en paralelo
        Promise.all([
                fetch('{{ url("canales/por-modalidad/2") }}', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }).then(r => r.ok ? r.json() : []).catch(() => []),

                fetch('{{ url("canales/por-modalidad/3") }}', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }).then(r => r.ok ? r.json() : []).catch(() => []),

                fetch('{{ url("canales/por-modalidad/4") }}', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }).then(r => r.ok ? r.json() : []).catch(() => [])
            ])
            .then(resultados => {
                const todosCanales = [].concat(...resultados);

                // Ordenar por modalidad y nombre
                todosCanales.sort((a, b) => {
                    if (a.idmodal !== b.idmodal) {
                        return a.idmodal - b.idmodal;
                    }
                    return a.nombre.localeCompare(b.nombre);
                });

                console.log('Canales cargados:', todosCanales);
                renderizarCanales(todosCanales);
            })
            .catch(error => {
                console.error('Error al cargar canales:', error);
                tbody.html(`
            <tr>
                <td colspan="4" class="text-center text-danger">
                    <i class="bi bi-x-circle"></i> Error al cargar canales<br>
                    <small>${error.message}</small>
                </td>
            </tr>
        `);
            });
    }

    // Función para renderizar canales (estilo similar a tu tabla principal)
    function renderizarCanales(canales) {
        const tbody = $('#tablaCanalesBody');

        if (!canales || canales.length === 0) {
            tbody.html(`
            <tr>
                <td colspan="4" class="text-center text-muted py-4">
                    <i class="bi bi-inbox" style="font-size: 40px;"></i><br>
                    <strong>No hay canales registrados</strong><br>
                    <small>Haga clic en "Crear Nuevo Canal" para agregar uno</small>
                </td>
            </tr>
        `);
            return;
        }

        let html = '';
        canales.forEach((canal, index) => {
            const nombreSeguro = String(canal.nombre).replace(/'/g, "\\'").replace(/"/g, '&quot;');
            const modalidadBadge = getModalidadBadge(canal.modalidad);

            html += `
            <tr>
                <td class="text-center">${index + 1}</td>
                <td>${canal.nombre}</td>
                <td class="text-center">${modalidadBadge}</td>
                <td class="text-center">
                    <div class="action-buttons">
                        <button type="button" class="btn btn-warning px-2 py-1 d-inline-block" 
                                onclick="editarCanal(${canal.id}, '${nombreSeguro}', ${canal.idmodal})"
                                title="Editar canal">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button type="button" class="btn btn-danger px-2 py-1 d-inline-block ml-1" 
                                onclick="confirmarEliminarCanal(${canal.id}, '${nombreSeguro}')"
                                title="Eliminar canal">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
        });

        tbody.html(html);
    }

    // Función para obtener badge según modalidad
    function getModalidadBadge(modalidad) {
        const badges = {
            'Virtual': '<span class="badge badge-primary">Virtual</span>',
            'Presencial': '<span class="badge badge-success">Presencial</span>',
            'Semipresencial': '<span class="badge badge-info">Semipresencial</span>'
        };
        return badges[modalidad] || `<span class="badge badge-secondary">${modalidad}</span>`;
    }

    // Función para editar canal
    function editarCanal(id, nombre, idmodal) {
        modoEdicionCanal = true;
        $('#tituloFormCanal').html('<i class="bi bi-pencil"></i> Editar Canal');
        $('#idcanal_form').val(id);
        $('#canal_modalidad').val(idmodal);
        $('#canal_nombre').val(nombre);
        $('#modalGestionCanales').modal('hide');
        $('#modalFormCanal').modal('show');
    }

    // Función para confirmar eliminación
    function confirmarEliminarCanal(id, nombre) {
        $('#idcanal_eliminar').val(id);
        $('#nombre-canal-eliminar').text(nombre);
        $('#modalGestionCanales').modal('hide');
        $('#modalEliminarCanal').modal('show');
    }
</script>
@include('Vistas.Footer')