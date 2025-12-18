@include('Vistas.Header')

<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" rel="stylesheet">

<style>
    body {
        background-color: #f8f9fa;
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

    .table-container {
        background: white;
        padding: 10px;
        border-radius: 8px;
    }

    #tablaCertificados {
        font-size: 11px;
    }

    #tablaBuscarCertificados {
        font-size: 11px;
    }

    .modal-certi-parti {
        max-width: 70%;
    }

    .btn-group-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 15px;
    }

    /* Estilo para certificados normales */

    .icon-box {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .sticky-top {
        position: sticky;
        top: 0;
        z-index: 10;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .persona-row {
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .persona-row:hover {
        background-color: #f8f9fa;
        transform: translateX(2px);
    }

    .persona-row.selected {
        background-color: #d1ecf1;
    }

    .avatar-circle {
        font-weight: bold;
        flex-shrink: 0;
    }

    .table-responsive::-webkit-scrollbar {
        width: 8px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .form-check-input:checked {
        background-color: #17a2b8;
        border-color: #17a2b8;
    }

    .modal-xl {
        max-width: 1200px;
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }
    }

    #personasSeleccionadas.updated {
        animation: pulse 0.3s ease;
    }
</style>

<div class="container mt-2">
    <div class="card">
        <div class="card-header bg-primary text-white text-center">
            <h5 class="card-title mb-0">GESTIÓN DE CERTIFICADOS</h5>
        </div>
        <div class="card-body ibox">
            <div class="row mb-3">
                {{-- Columna izquierda: Combo de eventos y botones debajo --}}
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="ideven" class="form-label">Eventos: <span class="text-danger">*</span></label>
                        <select id="ideven" name="ideven" class="form-select" required>
                            <option value="" selected disabled>-- Seleccione un evento --</option>
                            @if(isset($eventos) && $eventos->count() > 0)
                            @foreach ($eventos as $even)
                            <option value="{{ $even->idevento }}">{{ $even->eventnom }}</option>
                            @endforeach
                            @else
                            <option value="" disabled>No hay eventos disponibles</option>
                            @endif
                        </select>
                    </div>

                    {{-- Botones debajo del combo con mejor espaciado --}}
                    <div class="d-flex gap-3 mt-2">
                        <button type="button" class="btn btn-primary" id="btnGestionarCertificados" disabled>
                            <i class="bi bi-gear"></i> G.F/Tken/N° Certi
                        </button>
                        <!-- <button type="button" class="btn btn-warning" id="btnActualizarTabla" disabled>
                            <i class="bi bi-arrow-clockwise"></i> Actualizar Lista
                        </button> -->
                        <button type="button" class="btn btn-danger" id="btnCulminarCertificado" disabled>
                            <i class="bi bi-check-circle"></i> Culminar Certificado
                        </button>
                    </div>
                </div>

                {{-- Columna derecha: Botones de acción verticales --}}
                <div class="col-md-4">
                    <label class="form-label d-block">&nbsp;</label>
                    <div class="d-flex flex-column gap-2">
                        <button type="button" class="btn btn-info" id="btnGenerarNormales" disabled>
                            <i class="bi bi-award"></i> Generar Certificados Normales
                        </button>
                        <button type="button" class="btn btn-warning" id="btnBuscarcerti">
                            <i class="bi bi-arrow-clockwise"></i> Buscar Certi por Participante
                        </button>
                        <button type="button" class="btn btn-default" id="btnCambiarEstado" disabled>
                            <i class="bi bi-pencil-square"></i> Cambiar estado Certificado
                        </button>
                    </div>
                </div>
            </div>

            <div class="table-container">
                <h6 class="mb-3">Lista de Certificados</h6>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" id="tablaCertificados" style="width:100%">
                        <thead class="table-info">
                            <tr>
                                <th>N°</th>
                                <th>DNI</th>
                                <th>N° Certi</th>
                                <th>Nombres</th>
                                <th>Teléfono</th>
                                <th>Correo</th>
                                <th>Estado</th>
                                <th>Tipo Certificado</th>
                                <th>Tiempo Capa</th>
                                <th>Cuaderno</th>
                                <th>Folio</th>
                                <th>N° Reg</th>
                                <th>Token</th>
                                <th>Descripción</th>
                                <th>PDF</th>
                                <th>% Asist</th>
                                <th>Inser N° Certi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Generar Certificados Normales --}}
<div class="modal fade" id="modalGenerarNormales" tabindex="-1" aria-labelledby="modalGenerarNormalesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-blue text-white border-0">
                <div class="d-flex align-items-center">
                    <div>
                        <h5 class="modal-title mb-0" id="modalGenerarNormalesLabel">Generar Certificados Normales</h5>
                        <small class="opacity-75">Certificación de participantes especiales</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <form id="formGenerarNormales">
                    @csrf
                    <input type="hidden" id="eventoIdNormal" name="idevento">

                    <div class="card border-primary mb-4">
                        <div class="card-header bg-info bg-opacity-10 border-info">
                            <h6 class="mb-0">
                                <i class="bi bi-calendar-event text-info"></i> Información del Evento
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-bookmark-fill text-info"></i> Evento Seleccionado
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="bi bi-calendar3"></i>
                                        </span>
                                        <input type="text" id="eventoNombreNormal" class="form-control bg-light" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="idtipcertiNormal" class="form-label fw-semibold">
                                        <i class="bi bi-award-fill text-primary"></i> Tipo de Certificado
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" id="idtipcertiNormal" name="idtipcerti" required>
                                        <option value="" disabled selected>Seleccione un tipo...</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Por favor seleccione un tipo de certificado.
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="tiempocapaNormal" class="form-label fw-semibold">
                                        <i class="bi bi-clock-fill text-primary"></i> Tiempo de Capacitación
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-hourglass-split"></i>
                                        </span>
                                        <input type="text" class="form-control" id="tiempocapaNormal"
                                            name="tiempocapa" placeholder="Ej: 40 horas académicas" required>
                                        <div class="invalid-feedback">
                                            Ingrese el tiempo de capacitación.
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="card border-info">
                                        <div class="card-header bg-info bg-opacity-10 py-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0 fw-bold text-dark">
                                                    <i class="bi bi-file-text me-2"></i> Descripción del Certificado
                                                </h6>
                                                <button type="button" class="btn btn-info btn-sm" id="btnGenerarDescripcionNormal">
                                                    <i class="bi bi-magic"></i> Generar Automático
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold small text-muted">
                                                    <i class="bi bi-eye"></i> Vista Previa:
                                                </label>
                                                <div class="alert alert-light border py-2 mb-0" id="vistaDescripcionNormal" style="font-size: 0.9rem; line-height: 1.6;">
                                                    <em class="text-muted">Completa los campos y presiona "Generar Automático"</em>
                                                </div>
                                            </div>

                                            <label for="descrNormales" class="form-label fw-semibold">
                                                <i class="bi bi-pencil-square text-primary"></i> Descripción (Editable)
                                            </label>
                                            <textarea class="form-control" id="descrNormales" name="descr"
                                                rows="4" placeholder="Presiona 'Generar Automático' o escribe tu propia descripción"></textarea>
                                            <small class="text-muted">
                                                <i class="bi bi-info-circle"></i>
                                                Esta descripción se aplicará a todos los certificados generados.
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-success">
                        <div class="card-header bg-success bg-opacity-10 border-success">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">
                                    <i class="bi bi-people-fill text-success"></i> Seleccionar Personas
                                </h6>
                                <span class="badge bg-success" id="personasSeleccionadas">
                                    <i class="bi bi-check-circle"></i> 0 seleccionadas
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-search"></i>
                                    </span>
                                    <input type="text" id="buscarPersona" class="form-control"
                                        placeholder="Buscar por DNI o nombre...">
                                    <button class="btn btn-outline-secondary" type="button" id="btnLimpiarBusqueda">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                    <button class="btn btn-info" id="btnperson" type="button">Ag. Person.
                                        <i class="bi bi-person"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive" style="max-height: 350px; overflow-y: auto;">
                                <table class="table table-hover table-sm align-middle">
                                    <thead class="table-light sticky-top">
                                        <tr>
                                            <th class="text-center" style="width: 60px;">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input type="checkbox" id="selectAllPersonas"
                                                        class="form-check-input" title="Seleccionar todos">
                                                </div>
                                            </th>
                                            <th style="width: 120px;">
                                                <i class="bi bi-card-text"></i> DNI
                                            </th>
                                            <th>
                                                <i class="bi bi-person"></i> Nombres y Apellidos
                                            </th>
                                            <th style="width: 200px;">
                                                <i class="bi bi-envelope"></i> Correo
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="listaPersonas">
                                        @if(isset($personas))
                                        @foreach($personas as $persona)
                                        <tr class="persona-row"
                                            data-dni="{{ $persona->dni }}"
                                            data-nombre="{{ strtolower($persona->nombre . ' ' . $persona->apell) }}"
                                            data-email="{{ strtolower($persona->email ?? '') }}">
                                            <td class="text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input type="checkbox" name="personas[]"
                                                        value="{{ $persona->idpersona }}"
                                                        class="form-check-input persona-checkbox">
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">{{ $persona->dni }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-circle bg-info bg-opacity-10 text-blue rounded-circle d-flex align-items-center justify-content-center me-2"
                                                        style="width: 32px; height: 32px; font-size: 12px;">
                                                        {{ strtoupper(substr($persona->nombre, 0, 1)) }}{{ strtoupper(substr($persona->apell, 0, 1)) }}
                                                    </div>
                                                    <span>{{ $persona->nombre }} {{ $persona->apell }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <i class="bi bi-envelope"></i> {{ $persona->email ?? 'N/A' }}
                                                </small>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">
                                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                                No hay personas registradas
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <div id="noResultados" class="text-center text-muted py-3" style="display: none;">
                                <i class="bi bi-search fs-1 d-block mb-2"></i>
                                <p>No se encontraron resultados para tu búsqueda</p>
                            </div>

                            <div class="mt-3 d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-outline-success" id="btnSeleccionarTodos">
                                    <i class="bi bi-check-all"></i> Seleccionar Todos
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger" id="btnDeseleccionarTodos">
                                    <i class="bi bi-x-circle"></i> Deseleccionar Todos
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer bg-light border-0">
                <button type="button" class="btn btn-light border" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Cancelar
                </button>
                <button type="button" class="btn btn-info" id="btnConfirmarNormales">
                    <i class="bi bi-check-circle"></i> Generar Certificados
                </button>
            </div>
        </div>
    </div>
</div>



{{-- Modal Ingresar Número --}}
<div class="modal fade" id="modalIngresarNumero" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Ingresar Número de Certificado</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formIngresarNumero">
                    @csrf
                    <input type="hidden" id="certificadoId" name="idCertif">
                    <div class="mb-3">
                        <label for="numeroCertificado" class="form-label">Número</label>
                        <input type="text" class="form-control" id="numeroCertificado" name="nro" placeholder="001-2025-UNASAM" value="000-2025-UNASAM" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnGuardarNumero">
                    <i class="bi bi-save"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalGestionCertificados" tabindex="-1" aria-labelledby="modalGestionCertificadosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-ui-dialog-content modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bi bi-award me-2"></i> Gestión de Certificados
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="checkActivarFolio">
                    <label class="form-check-label fw-bold" for="checkActivarFolio">Generar Folio General</label>
                </div>
                <div class="card border-success mb-3">
                    <div class="card-header bg-success bg-opacity-10 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold text-dark">
                            <i class="bi bi-shield-lock me-2"></i> Token y Número de Certificado
                        </h6>
                    </div>
                    <div class="card-body">
                        <form id="formTokenCertificado">
                            <input type="hidden" id="eventoIdTokenCert" name="idevento">

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Seleccione qué desea generar:</label>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="checkGenerarToken">
                                    <label class="form-check-label fw-semibold" for="checkGenerarToken">
                                        <i class="bi bi-key text-warning"></i> Generar Tokens únicos
                                    </label>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="checkGenerarNumero">
                                    <label class="form-check-label fw-semibold" for="checkGenerarNumero">
                                        <i class="bi bi-card-text text-success"></i> Generar Números de Certificado
                                    </label>
                                </div>
                            </div>

                            <div id="sectionToken" class="d-none mb-3">
                                <div class="alert alert-warning py-2 mb-0">
                                    <i class="bi bi-info-circle"></i>
                                    Se generarán tokens únicos automáticamente para todos los certificados sin token.
                                </div>
                            </div>

                            <div id="sectionCertificado" class="d-none mb-3">
                                <div class="border border-success rounded p-3 bg-light">
                                    <div class="mb-3">
                                        <label for="prefijo" class="form-label fw-semibold">Prefijo:</label>
                                        <input type="text" class="form-control" id="prefijo" name="prefijo"
                                            maxlength="10" value="UNASAM">
                                        <small class="text-muted">Máximo 10 caracteres. Ejemplo: CERT001, CERT002...</small>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="button" class="btn btn-success" id="btnGuardarTokenCert">
                                    <i class="bi bi-save"></i> Generar Token/Certificado
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div id="seccionFolioCompleta" class="d-none">
                    <div class="card border-primary">
                        <div class="card-header bg-primary bg-opacity-10">
                            <h6 class="mb-0 fw-bold text-danger">
                                <i class="bi bi-journal-text me-2"></i> Folio General
                            </h6>
                        </div>
                        <div class="card-body">
                            <form id="formGeneralFolio">
                                <input type="hidden" id="eventoIdFolio" name="idevento">

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Cuaderno <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="cuaderno" placeholder="Ej: I, A, B..." required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tiempo de Capacitación <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="tiempoCapacitacion" placeholder="Ej: 20 horas académicas" required>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <label class="form-label d-block fw-semibold">Modo de asignación de folio y registro</label>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="modoFolio" id="modoAuto" value="auto" checked>
                                            <label class="form-check-label" for="modoAuto">Automático</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="modoFolio" id="modoManual" value="manual">
                                            <label class="form-check-label" for="modoManual">Manual</label>
                                        </div>
                                    </div>

                                    <div id="seccionAuto" class="col-md-12 border rounded p-3 bg-light">
                                        <p class="text-muted m-0">
                                            El sistema asignará automáticamente el folio y el número de registro.
                                            <br>Máximo 32 registros por folio.
                                        </p>
                                    </div>

                                    <div id="seccionManual" class="col-md-12 border rounded p-3 bg-light" style="display:none;">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label">Folio <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" id="folioManual" placeholder="Ej: 4">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Registro desde <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" id="registroDesde" placeholder="Ej: 1">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Registro hasta <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" id="registroHasta" placeholder="Ej: 10">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-3">
                                        <div class="card border-info">
                                            <div class="card-header bg-info bg-opacity-10 py-2">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="mb-0 fw-bold text-dark">
                                                        <i class="bi bi-file-text me-2"></i> Descripción del Certificado
                                                    </h6>
                                                    <button type="button" class="btn btn-info btn-sm" id="btnGenerarDescripcion">
                                                        <i class="bi bi-magic"></i> Generar Automático
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold small text-muted">
                                                        <i class="bi bi-eye"></i> Vista Previa:
                                                    </label>
                                                    <div class="alert alert-light border py-2 mb-0" id="vistaDescripcion" style="font-size: 0.9rem; line-height: 1.6;">
                                                        <em class="text-muted">La descripción se generará automáticamente cuando presiones "Generar Automático"</em>
                                                    </div>
                                                </div>

                                                <label for="descrNormal" class="form-label fw-semibold">
                                                    <i class="bi bi-pencil-square text-primary"></i> Descripción (Editable)
                                                </label>
                                                <textarea class="form-control text-danger" id="descrNormal" name="descr" rows="4"
                                                    placeholder="Presiona 'Generar Automático' o escribe tu propia descripción">
                                                </textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <!-- <div class="text-end mt-3">
                                    <button type="button" class="btn btn-primary" id="btnGuardarFolio">
                                        <i class="bi bi-save"></i> Guardar Folio y Descripción
                                    </button>
                                </div> -->

                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Cerrar
                </button>
                <button type="button" class="btn btn-primary" id="btnGuardarFolio">
                    <i class="bi bi-save"></i> Guardar Folio y Descripción
                </button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Generar o Ingresar Token Individual-->
<div class="modal fade" id="modalToken" tabindex="-1" aria-labelledby="modalTokenLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalTokenLabel"><i class="bi bi-key-fill me-2"></i>Generar o Ingresar Token</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="idCertifToken">

                <div class="mb-3">
                    <label for="tokenInput" class="form-label fw-semibold">Token</label>
                    <div class="input-group">
                        <input type="text" id="tokenInput" class="form-control" placeholder="Ingresa o genera un token">
                        <button class="btn btn-outline-secondary" type="button" id="btnGenerarAuto">
                            <i class="bi bi-magic"></i> Generar
                        </button>
                    </div>
                </div>

                <div class="alert alert-info small">
                    Puedes generar un token automático o escribir uno manualmente.
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary" id="btnGuardarToken">
                    <i class="bi bi-check-circle"></i> Guardar Token
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA BUSCAR O MOSTRAR CERTIFICADOS POR PARTICIPANTES -->

<div class="modal fade" id="modalBuscarCertificado" tabindex="-1" aria-labelledby="modalBuscarCertificadoLabel" aria-hidden="true">
    <div class="modal-dialog modal-certi-parti">
        <div class="modal-content">

            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title">
                    <i class="bi bi-search me-2"></i> Buscar Certificados por Participante
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="formBuscarCertificado">
                    @csrf
                    <div class="mb-3">
                        <label for="dniParticipante" class="form-label fw-bold">DNI del Participante:</label>
                        <input type="text" id="dniParticipante" name="dniParticipante" class="form-control" placeholder="Ingrese el DNI del participante">
                    </div>
                </form>
            </div>
            <div class="table-container">
                <h6 class="mb-3">Lista de Participantes con Certificados</h6>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" id="tablaBuscarCertificados" style="width:100%">
                        <thead class="table-info">
                            <tr>
                                <th>N°</th>
                                <th>Evento</th>
                                <th>N° Certi</th>
                                <th>DNI</th>
                                <th>Nombres</th>
                                <th>Teléfono</th>
                                <th>Correo</th>
                                <th>Estado</th>
                                <th>PDF</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</div>

<!-- MODAL PARA CREAR PERSONAS -->
<div class="modal fade" id="modalAgregarPersona" tabindex="-1" aria-labelledby="tituloAgregarPersona" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">

            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="tituloAgregarPersona">
                    <i class="bi bi-person-plus-fill me-2"></i> Agregar Persona
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="formAgregarPersona">
                @csrf
                <div class="modal-body">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">DNI <span class="text-danger">*</span></label>
                            <input type="text" name="dni" maxlength="8" class="form-control" required placeholder="Ingresar DNI">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" class="form-control" required placeholder="Ingrese el nombre">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Apellidos <span class="text-danger">*</span></label>
                            <input type="text" name="apell" class="form-control" required placeholder="Ingrese el Apellido">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Teléfono <span class="text-danger">*</span></label>
                            <input type="text" name="tele" maxlength="11" class="form-control" required placeholder="Ingrese el telefono">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Correo <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" required placeholder="Ingrese el correo">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Género <span class="text-danger">*</span></label>
                            <select name="idgenero" id="idgeneroField" class="form-select" required></select>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label">Dirección <span class="text-danger">*</span></label>
                            <input type="text" name="direc" class="form-control" required placeholder="Ingresar la direccion">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-check-circle me-1"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal para Subir Documento -->
<div class="modal fade" id="modalSubirDocumento" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bi bi-cloud-upload me-2"></i>Subir Documento del Certificado
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formSubirDocumento" enctype="multipart/form-data">
                    <input type="hidden" id="certificado_id" name="certificado_id">
                    <div class="mb-4">
                        <label class="form-label fw-bold text-center d-block">¿Cómo deseas agregar el documento?</label>
                        <div class="btn-group w-100 justify-content-center" role="group">
                            <input type="radio" class="btn-check" name="tipo_subida" id="tipo_archivo" value="archivo" checked>
                            <label class="btn btn-outline-primary" for="tipo_archivo">
                                <i class="bi bi-file-earmark-pdf"></i> Subir Archivo PDF
                            </label>

                            <input type="radio" class="btn-check" name="tipo_subida" id="tipo_gdrive" value="gdrive">
                            <label class="btn btn-outline-success" for="tipo_gdrive">
                                <i class="bi bi-google"></i> URL de Google Drive
                            </label>
                        </div>
                    </div>

                    <div id="zona-archivo" class="upload-zone">
                        <div class="mb-3">
                            <label class="form-label">Seleccionar archivo PDF</label>
                            <input type="file" class="form-control" id="pdf_file" name="pdf_file" accept=".pdf">
                            <div class="form-text">
                                <i class="bi bi-info-circle"></i> Tamaño máximo: 10 MB
                            </div>
                        </div>
                        <div id="preview-archivo" class="alert alert-info d-none">
                            <i class="bi bi-file-pdf-fill"></i>
                            <span id="nombre-archivo"></span>
                            <span id="tamano-archivo" class="text-muted"></span>
                        </div>
                    </div>

                    <div id="zona-gdrive" class="upload-zone" style="display:none;">
                        <div class="mb-3">
                            <label class="form-label">URL de Google Drive</label>
                            <input type="url" class="form-control" id="gdrive_url" name="gdrive_url"
                                placeholder="https://drive.google.com/file/d/1ABC123.../view">
                            <div class="form-text">
                                <i class="bi bi-info-circle"></i> Asegúrate que el archivo tenga permisos de visualización pública
                            </div>
                        </div>
                        <!-- <div class="alert alert-warning">
                            <strong>Cómo compartir desde Google Drive:</strong>
                            <ol class="mb-0 mt-2">
                                <li>Abre el archivo en Google Drive</li>
                                <li>Click en "Compartir"</li>
                                <li>Cambia a "Cualquiera con el enlace"</li>
                                <li>Copia y pega la URL aquí</li>
                            </ol>
                        </div> -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar
                </button>
                <button type="button" class="btn btn-primary" id="btnGuardarDocumento">Guardar Documento
                </button>
            </div>
        </div>
    </div>
</div>



<!-- ESTILOS OPCIONALES -->
<style>
    .modal-content {
        border-radius: 15px;
    }

    .form-label {
        color: #0d6efd;
        font-weight: 600;
    }

    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    #dniParticipante {
        border: 2px solid #dee2e6;
        transition: border-color 0.3s;
    }

    #dniParticipante:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    /* ESTILO PARA ARCHIVOS */
    .upload-zone {
        padding: 20px;
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        background-color: #f8f9fa;
        transition: all 0.3s;
    }

    .upload-zone:hover {
        border-color: #0d6efd;
        background-color: #e7f1ff;
    }

    #zona-gdrive {
        border-color: #198754;
    }

    #zona-gdrive:hover {
        border-color: #146c43;
        background-color: #d1e7dd;
    }

    .btn-check:checked+label {
        font-weight: bold;
    }
</style>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        let eventoSeleccionado = null;
        let eventoNombre = '';

        $('#ideven').on('change', function() {
            eventoSeleccionado = $(this).val();
            eventoNombre = $(this).find('option:selected').text();
            $('#btnGenerarAsistencia, #btnGenerarNormales, #btnActualizarTabla, #btnGestionarCertificados, #btnCambiarEstado, #btnCulminarCertificado').prop('disabled', false);
            loadCertificados(eventoSeleccionado);
        });

        let tablaBuscarCertificados;
        let timeoutBusqueda;

        $('#btnBuscarcerti').on('click', function() {
            $('#modalBuscarCertificado').modal('show');
            $('#loca').modal()
        });

        function inicializarTabla() {
            if ($.fn.DataTable.isDataTable('#tablaBuscarCertificados')) {
                $('#tablaBuscarCertificados').DataTable().destroy();
            }

            tablaBuscarCertificados = $('#tablaBuscarCertificados').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                },
                responsive: true,
                data: [],
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'evento',
                        defaultContent: 'Sin evento'
                    },
                    {
                        data: 'numero_certificado',
                        defaultContent: 'N/A'
                    },
                    {
                        data: 'dni'
                    },
                    {
                        data: 'nombres_completos'
                    },
                    {
                        data: 'telefono',
                        defaultContent: 'N/A'
                    },
                    {
                        data: 'email',
                        defaultContent: 'N/A'
                    }, {
                        data: 'estado',
                        render: function(data, type, row) {
                            if (!data) return '<span class="text-muted">Sin estado</span>';

                            switch (data.toLowerCase()) {
                                case 'entregado':
                                    return `<span class="badge bg-info">${data}</span>`;

                                case 'firmado':
                                    return `<button class="btn btn-xs btn-success w-80 btn-estado"
                                            data-id="${row.idCertif}"
                                            data-estado="${row.idestcer}">
                                            Firmado
                                        </button>`;
                                case 'impreso':
                                    return `<span class="badge bg-warning">${data}</span>`;

                                default:
                                    return `<span class="badge bg-danger">${data}</span>`;
                            }
                        }
                    },
                    {
                        data: 'pdf',
                        render: function(data) {
                            if (data && data.trim() !== '') {
                                return `<a href="${data}" target="_blank" class="btn btn-sm btn-primary">
                                        <i class="bi bi-file-pdf"></i> Ver
                                    </a>`;
                            }
                            return '<span class="text-muted">No disponible</span>';
                        }
                    }
                ]
            });
        }

        $('#dniParticipante').on('input', function(e) {
            let dni = $(this).val().trim();

            clearTimeout(timeoutBusqueda);

            if (dni.length === 0) {
                tablaBuscarCertificados.clear().draw();
                return;
            }

            timeoutBusqueda = setTimeout(function() {
                if (dni.length >= 2) {
                    buscarCertificados(dni);
                    bindEstadoButtons();
                }
            }, 500);
        });

        $('#dniParticipante').on('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                clearTimeout(timeoutBusqueda);
                let dni = $(this).val().trim();
                if (dni.length >= 1) {
                    buscarCertificados(dni);
                    bindEstadoButtons();
                }
            }
        });

        function buscarCertificados(dni) {
            $.ajax({
                url: '{{ route("certificados.buscarPorDni") }}',
                method: 'POST',
                data: {
                    dniParticipante: dni,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    tablaBuscarCertificados.clear().draw();
                    $('#tablaBuscarCertificados tbody').html(
                        '<tr><td colspan="10" class="text-center">' +
                        '<div class="spinner-border spinner-border-sm text-primary" role="status">' +
                        '<span class="visually-hidden">Cargando...</span>' +
                        '</div> Buscando certificados...' +
                        '</td></tr>'
                    );
                },
                success: function(response) {
                    console.log('Respuesta:', response);

                    if (response.success) {
                        tablaBuscarCertificados.clear().rows.add(response.data).draw();

                        if (response.total === 0) {
                            $('#tablaBuscarCertificados tbody').html(
                                '<tr><td colspan="10" class="text-center text-muted">' +
                                '<i class="bi bi-search"></i> No se encontraron certificados para el DNI: ' + dni +
                                '</td></tr>'
                            );
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Ocurrió un error al buscar los certificados.',
                            timer: 2000
                        });
                        tablaBuscarCertificados.clear().draw();
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr);

                    let mensaje = 'Error al procesar la solicitud';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        mensaje = xhr.responseJSON.message;
                    } else if (xhr.status === 404) {
                        mensaje = 'La ruta no fue encontrada. Verifica tu controlador.';
                    } else if (xhr.status === 500) {
                        mensaje = 'Error en el servidor. Revisa los logs de Laravel.';
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: mensaje,
                        timer: 3000
                    });

                    tablaBuscarCertificados.clear().draw();
                }
            });
        }

        $('#modalBuscarCertificado').on('shown.bs.modal', function() {
            inicializarTabla();
            $('#dniParticipante').val('').focus();
        });

        $('#modalBuscarCertificado').on('hidden.bs.modal', function() {
            clearTimeout(timeoutBusqueda);
            $('#dniParticipante').val('');
            if (tablaBuscarCertificados) {
                tablaBuscarCertificados.clear().draw();
            }
        });

        // SCRIP PARA CAMBIAR DE ESTADO POR EVENTO DE LOS CERTIFICADOS

        $('#btnCambiarEstado').on('click', function() {

            if (!eventoSeleccionado) {
                Swal.fire("Aviso", "Seleccione un evento primero", "warning");
                return;
            }

            Swal.fire({
                title: "¿Cambiar estado de los certificados?",
                text: "Los estados avanzarán solo hasta el estado 'Firmado'.",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Sí, continuar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: "{{ route('certificados.cambiarEstado') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            idevento: eventoSeleccionado
                        },
                        success: function(response) {

                            if (response.success) {
                                Swal.fire("Éxito", response.message, "success");
                                loadCertificados(eventoSeleccionado);
                            } else {
                                Swal.fire("Aviso", response.message, "info");
                            }
                        },
                        error: function() {
                            Swal.fire("Error", "Ocurrió un problema al cambiar los estados", "error");
                        }
                    });
                }
            });
        });


        // Generar Certificados normales ¨¨ MODIFICAR
        let datosEventoNormal = null;

        $('#btnGenerarNormales').on('click', function() {
            if (!eventoSeleccionado) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Sin evento',
                    text: 'Seleccione un evento primero',
                    confirmButtonColor: '#ffc107'
                });
                return;
            }

            $('#eventoNombreNormal').val(eventoNombre);
            $('#eventoIdNormal').val(eventoSeleccionado);
            $('.persona-checkbox').prop('checked', false);
            actualizarContador();
            cargarDatosEventoNormal(eventoSeleccionado);

            $('#modalGenerarNormales').modal('show');
        });

        function cargarDatosEventoNormal(idevento) {
            $.ajax({
                url: '{{ route("certificado.obtenerDatosEvento") }}',
                type: 'POST',
                data: {
                    idevento: idevento,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        datosEventoNormal = response.evento;
                        console.log('Datos del evento cargados:', datosEventoNormal);
                    } else {
                        console.error('Error al cargar datos:', response.message);
                    }
                },
                error: function(xhr) {
                    console.error('Error AJAX:', xhr);
                }
            });
        }

        $('#btnGenerarDescripcionNormal').on('click', function() {
            const tiempoCapacitacion = $('#tiempocapaNormal').val().trim();

            if (!tiempoCapacitacion) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campo requerido',
                    text: 'Por favor, ingresa primero el "Tiempo de Capacitación"',
                    confirmButtonColor: '#0dcaf0'
                });
                $('#tiempocapaNormal').focus();
                return;
            }

            if (!datosEventoNormal) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudieron cargar los datos del evento. Intenta cerrar y abrir el modal nuevamente.',
                    confirmButtonColor: '#dc3545'
                });
                return;
            }



            const cargoSeleccionado = $('#idtipcertiNormal option:selected').text();
            const descripcionGenerada = `Por haber 'Editar campo' ${cargoSeleccionado} en el ${datosEventoNormal.tema}: ${datosEventoNormal.nombre_evento}, Organizado por la Universidad Nacional Santiago Antúnez de Mayolo, con una duración de ${tiempoCapacitacion}, el día ${datosEventoNormal.fecha_formateada}.`;

            // console.log('Descripción generada:', descripcionGenerada);

            $('#vistaDescripcionNormal').html(`<span class="text-dark">${descripcionGenerada}</span>`);


            const textarea = document.getElementById('descrNormales');
            if (textarea) {
                textarea.value = descripcionGenerada;
                console.log('Textarea actualizado');
            } else {
                console.error('No se encontró el textarea');
            }

            $('#descrNormales').val(descripcionGenerada);

            console.log('Valor final en textarea:', $('#descrNormales').val());

            Swal.fire({
                icon: 'success',
                title: '¡Descripción Generada!',
                text: 'Puedes editarla antes de guardar',
                timer: 1500,
                showConfirmButton: false
            });
        });

        $('#descrNormales').on('input', function() {
            const texto = $(this).val().trim();
            if (texto) {
                $('#vistaDescripcionNormal').html(`<span class="text-dark">${texto}</span>`);
            } else {
                $('#vistaDescripcionNormal').html('<em class="text-muted">Escribe o genera la descripción</em>');
            }
        });

        function cargarTiposCertificado() {
            $.ajax({
                url: '{{ route("certificados.getTipos") }}',
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        let options = '<option value="" disabled selected>Seleccione un tipo...</option>';
                        response.data.forEach(function(tipo) {
                            options += `<option value="${tipo.idcargo}">${tipo.cargo}</option>`;
                        });
                        $('#idtipcertiNormal').html(options);
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudieron cargar los tipos de certificado',
                        timer: 2000
                    });
                }
            });
        }

        $('#modalGenerarNormales').on('show.bs.modal', function() {
            cargarTiposCertificado();
            actualizarContador();
        });

        $('#buscarPersona').on('input', function() {
            let busqueda = $(this).val().toLowerCase().trim();
            let resultados = 0;

            $('.persona-row').each(function() {
                let dni = $(this).data('dni').toString().toLowerCase();
                let nombre = $(this).data('nombre');
                let email = $(this).data('email');

                if (dni.includes(busqueda) || nombre.includes(busqueda) || email.includes(busqueda)) {
                    $(this).show();
                    resultados++;
                } else {
                    $(this).hide();
                }
            });

            if (resultados === 0 && busqueda !== '') {
                $('#noResultados').show();
            } else {
                $('#noResultados').hide();
            }
        });

        $('#btnLimpiarBusqueda').on('click', function() {
            $('#buscarPersona').val('');
            $('.persona-row').show();
            $('#noResultados').hide();
        });

        $('#selectAllPersonas').on('change', function() {
            let isChecked = $(this).prop('checked');
            $('.persona-row:visible .persona-checkbox').prop('checked', isChecked);
            actualizarEstiloFilas();
            actualizarContador();
        });

        $('#btnSeleccionarTodos').on('click', function() {
            $('.persona-row:visible .persona-checkbox').prop('checked', true);
            $('#selectAllPersonas').prop('checked', true);
            actualizarEstiloFilas();
            actualizarContador();
        });

        $('#btnDeseleccionarTodos').on('click', function() {
            $('.persona-checkbox').prop('checked', false);
            $('#selectAllPersonas').prop('checked', false);
            actualizarEstiloFilas();
            actualizarContador();
        });

        $(document).on('click', '.persona-row', function(e) {
            if (!$(e.target).is('input[type="checkbox"]')) {
                let checkbox = $(this).find('.persona-checkbox');
                checkbox.prop('checked', !checkbox.prop('checked'));
                actualizarEstiloFilas();
                actualizarContador();
            }
        });

        $(document).on('change', '.persona-checkbox', function() {
            actualizarEstiloFilas();
            actualizarContador();
        });

        function actualizarEstiloFilas() {
            $('.persona-row').each(function() {
                if ($(this).find('.persona-checkbox').prop('checked')) {
                    $(this).addClass('selected');
                } else {
                    $(this).removeClass('selected');
                }
            });
        }

        function actualizarContador() {
            let total = $('.persona-checkbox:checked').length;
            let badge = $('#personasSeleccionadas');
            badge.html(`<i class="bi bi-check-circle"></i> ${total} seleccionada${total !== 1 ? 's' : ''}`);
            badge.addClass('updated');
            setTimeout(() => badge.removeClass('updated'), 300);
        }

        $('#btnConfirmarNormales').on('click', function() {
            let form = $('#formGenerarNormales')[0];
            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos incompletos',
                    text: 'Por favor complete todos los campos obligatorios',
                    timer: 2000
                });
                return;
            }
            const descripcion = $('#descrNormales').val().trim();
            if (!descripcion) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Descripción vacía',
                    text: 'Por favor, genera o escribe una descripción antes de continuar',
                    confirmButtonColor: '#ffc107'
                });
                return;
            }

            let personasSeleccionadas = $('.persona-checkbox:checked').length;

            if (personasSeleccionadas === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Sin personas seleccionadas',
                    text: 'Debe seleccionar al menos una persona para generar certificados',
                    timer: 2000
                });
                return;
            }
            Swal.fire({
                title: '¿Confirmar generación?',
                html: `
                <div class="text-start">
                    <p>Se generarán <strong>${personasSeleccionadas}</strong> certificado(s).</p>
                    <hr>
                    <p class="small text-muted"><strong>Descripción:</strong><br>${descripcion.substring(0, 100)}...</p>
                </div>
            `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#17a2b8',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, generar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    generarCertificados();
                }
            });
        });

        function generarCertificados() {
            let formData = new FormData($('#formGenerarNormales')[0]);

            $.ajax({
                url: '{{ route("certificados.generarNormales") }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    Swal.fire({
                        title: 'Generando certificados...',
                        html: '<div class="spinner-border text-info" role="status"></div>',
                        allowOutsideClick: false,
                        showConfirmButton: false
                    });
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Certificados generados!',
                        html: response.message || 'Los certificados se generaron correctamente',
                        confirmButtonColor: '#17a2b8'
                    }).then(() => {
                        $('#modalGenerarNormales').modal('hide');

                        if (typeof loadCertificados === 'function') {
                            loadCertificados(eventoSeleccionado);
                        }
                    });
                },
                error: function(xhr) {
                    let mensaje = 'Error al generar certificados';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        mensaje = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: mensaje,
                        confirmButtonColor: '#dc3545'
                    });
                }
            });
        }

        $('#modalGenerarNormales').on('hidden.bs.modal', function() {
            $('#formGenerarNormales')[0].reset();
            $('#formGenerarNormales').removeClass('was-validated');
            $('.persona-checkbox').prop('checked', false);
            $('#selectAllPersonas').prop('checked', false);
            actualizarEstiloFilas();
            actualizarContador();
            $('#buscarPersona').val('');
            $('.persona-row').show();
            $('#noResultados').hide();

            // Limpiar descripción
            $('#descrNormales').val('');
            $('#vistaDescripcionNormal').html('<em class="text-muted">Completa los campos y presiona "Generar Automático"</em>');
            datosEventoNormal = null;
        });

        // SCRIP PARA CARGAR LA TABLA DE CERTIFICADOS
        $('#btnActualizarTabla').on('click', function() {
            if (eventoSeleccionado) loadCertificados(eventoSeleccionado);
        });

        function loadCertificados(eventId) {
            $.ajax({
                url: '{{ url("/filter-by-eventos") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    event_id: eventId
                },
                success: function(certificados) {
                    if ($.fn.DataTable.isDataTable('#tablaCertificados')) {
                        $('#tablaCertificados').DataTable().destroy();
                    }

                    $('#tablaCertificados tbody').empty();
                    let num = 1;

                    $.each(certificados, function(index, cert) {
                        let persona = null;
                        let porcentaje = 0;
                        if (cert.certiasiste?.asistencia?.inscripcion?.persona) {
                            persona = cert.certiasiste.asistencia.inscripcion.persona;
                            porcentaje = cert.porcentaje_calculado || 0;
                        } else if (cert.certinormal?.persona) {
                            persona = cert.certinormal.persona;
                            porcentaje = 100;
                        } else {
                            return;
                        }

                        let estado = cert.estado_certificado?.nomestadc || 'Pendiente';
                        let cargo = cert.cargo?.cargo || 'N/A';
                        let tipo = cert.cargo?.tipo_certificado?.tipocertifi || 'N/A';

                        let estadoBoton = '';
                        if (cert.idestcer == 4) {
                            estadoBoton = `<button class="btn btn-xs btn-info w-80 btn-estado" data-id="${cert.idCertif}" data-estado="4" disabled>Entregado
                            </button>`;
                        } else if (cert.idestcer == 3) {
                            estadoBoton = `<button class="btn btn-xs btn-success w-80 btn-estado" data-id="${cert.idCertif}" data-estado="${cert.idestcer || 3}">Firmado
                            </button>`;
                        } else if (cert.idestcer == 2) {
                            estadoBoton = `<button class="btn btn-xs btn-warning w-80 btn-estado" data-id="${cert.idCertif}" data-estado="2" disabled>Impreso
                            </button>`;
                        } else {
                            estadoBoton = `<button class="btn btn-xs btn-danger w-80 btn-estado" data-id="${cert.idCertif}" data-estado="1" disabled>Por Imprimir
                            </button>`;
                        }

                        let pdfCell = '';
                        if (cert.pdf_url) {
                            let isDrive = cert.pdff && cert.pdff.includes('drive.google.com');
                            let isExternal = cert.pdff && (cert.pdff.includes('http://') || cert.pdff.includes('https://'));

                            if (isDrive) {
                                pdfCell = `<a href="${cert.pdf_url}" target="_blank" class="btn btn-xs btn-success">
                                            <i class="bi bi-google"></i> Ver Drive
                                        </a>
                                        <button class="btn btn-xs btn-warning subir-documento" data-id="${cert.idCertif}">
                                            <i class="bi bi-pencil"></i>
                                        </button>`;
                            } else if (isExternal) {
                                pdfCell = `<a href="${cert.pdf_url}" target="_blank" class="btn btn-xs btn-info">
                                            <i class="bi bi-link-45deg"></i> Ver URL
                                        </a>
                                        <button class="btn btn-xs btn-warning subir-documento" data-id="${cert.idCertif}">
                                            <i class="bi bi-pencil"></i>
                                        </button>`;
                            } else {
                                pdfCell = `<a href="${cert.pdf_url}" target="_blank" class="btn btn-xs btn-info">
                                            <i class="bi bi-file-pdf"></i> Ver PDF
                                        </a>
                                        <button class="btn btn-xs btn-warning subir-documento" data-id="${cert.idCertif}">
                                            <i class="bi bi-pencil"></i>
                                        </button>`;
                            }
                        } else {
                            pdfCell = `<button class="btn btn-xs btn-primary subir-documento" data-id="${cert.idCertif}">
                                        <i class="bi bi-cloud-upload"></i> Subir Doc.
                                    </button>`;
                        }

                        let tokenDisplay = cert.tokenn ?
                            `<span class="text-success fw-semibold">${cert.tokenn}</span>` :
                            `<button class="btn btn-sm btn-outline-primary open-token-modal" data-id="${cert.idCertif}">
                            <i class="bi bi-key"></i> Generar / Ingresar Token
                        </button>`;

                        let row = `<tr>
                            <td>${num}</td>
                            <td>${persona.dni || 'N/A'}</td>
                            <td>${cert.nro || 'No asignado'}</td>
                            <td>${persona.apell || ''} ${persona.nombre || ''}</td>
                            <td>${persona.tele || 'N/A'}</td>
                            <td>${persona.email || 'N/A'}</td>
                            <td>${estadoBoton}</td>
                            <td>${cargo}</td>
                            <td>${cert.tiempocapa || 'N/A'}</td>
                            <td>${cert.cuader || 'N/A'}</td>
                            <td>${cert.foli || 'N/A'}</td>
                            <td>${cert.numregis || 'N/A'}</td>
                            <td>${tokenDisplay}</td>
                            <td>${cert.descr || 'Sin descripción'}</td>
                            <td>${pdfCell}</td>
                            <td><span class="badge bg-primary">${porcentaje}%</span></td>
                            <td>
                                <button class="btn btn-xs btn-primary ingresar-numero" data-id="${cert.idCertif}">
                                    Ingresar N°
                                </button>
                            </td>
                        </tr>`;

                        $('#tablaCertificados tbody').append(row);
                        num++;
                    });

                    $('#tablaCertificados').DataTable({
                        responsive: true,
                        language: {
                            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                        },
                        order: [
                            [0, 'asc']
                        ],
                        pageLength: 10
                    });
                    bindTokenModal();
                    bindButtonEvents();
                    bindEstadoButtons();
                    bindSubirDocumento();
                },
                error: function(xhr) {
                    console.error("Error:", xhr.responseText);
                    alert('Error al cargar certificados');
                }
            });
        }

        function bindEstadoButtons() {
            $(document).off('click', '.btn-estado').on('click', '.btn-estado', function() {
                let btn = $(this);
                let idCertif = btn.data('id');
                let estadoActual = btn.data('estado');

                if (estadoActual == 4) {
                    return;
                }

                Swal.fire({
                    title: '¿Entregar certificado?',
                    text: 'Se marcará como entregado y se registrará la fecha actual',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sí, entregar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        cambiarEstadoCertificado(idCertif, btn);
                    }
                });
            });
        }

        function cambiarEstadoCertificado(idCertif, btn) {
            $.ajax({
                url: '{{ route("certificado.cambiarEstado") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    idCertif: idCertif
                },
                beforeSend: function() {
                    btn.prop('disabled', true).html('<i class="spinner-border spinner-border-sm"></i> Procesando...');
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Entregado!',
                            text: response.message || 'Certificado marcado como entregado',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        btn.removeClass('btn-success')
                            .addClass('btn-info')
                            .html('Entregado')
                            .data('estado', 4)
                            .prop('disabled', true);

                        let fechaActual = new Date().toLocaleString('es-PE', {
                            year: 'numeric',
                            month: '2-digit',
                            day: '2-digit',
                            hour: '2-digit',
                            minute: '2-digit'
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'No se pudo actualizar el estado',
                            confirmButtonColor: '#d33'
                        });

                        btn.prop('disabled', false).html('<i class="bi bi-clock-history"></i> Por Imprimir');
                    }
                },
                error: function(xhr) {
                    let errorMsg = 'Error al cambiar el estado';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Error de conexión',
                        text: errorMsg,
                        confirmButtonColor: '#d33'
                    });

                    btn.prop('disabled', false).html('<i class="bi bi-clock-history"></i> Por Imprimir');
                }
            });
        }


        function bindTokenModal() {
            $(document).off('click', '.open-token-modal').on('click', '.open-token-modal', function() {
                const idCertif = $(this).data('id');
                $('#idCertifToken').val(idCertif);
                $('#tokenInput').val('');
                $('#modalToken').modal('show');
            });

            $('#btnGenerarAuto').off('click').on('click', function() {
                const tokenGenerado = self.crypto.randomUUID();
                $('#tokenInput').val(tokenGenerado);

                Swal.fire({
                    icon: 'success',
                    title: 'Token generado',
                    text: 'El token se ha generado correctamente. Ahora puedes guardarlo.',
                    confirmButtonColor: '#198754'
                });
            });

            $('#btnGuardarToken').off('click').on('click', function() {
                const idCertif = $('#idCertifToken').val();
                const token = $('#tokenInput').val().trim();

                if (!token) {
                    Swal.fire('Advertencia', 'Por favor, ingresa o genera un token.', 'warning');
                    return;
                }

                Swal.fire({
                    title: '¿Guardar token?',
                    text: 'Se asignará este token al certificado seleccionado.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, guardar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#198754'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ url("/certificados/generar-token") }}/' + idCertif,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                tokenn: token
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: '¡Token guardado!',
                                        text: response.token,
                                        confirmButtonColor: '#198754'
                                    });

                                    $(`button[data-id="${idCertif}"].open-token-modal`)
                                        .replaceWith(`<span class="text-success fw-semibold">${response.token}</span>`);

                                    $('#modalToken').modal('hide');
                                    loadCertificados(eventoSeleccionado);
                                } else {
                                    Swal.fire('Error', response.message || 'No se pudo guardar el token.', 'error');
                                }
                            },
                            error: function(xhr) {
                                Swal.fire('Error', 'Ocurrió un error en el servidor.', 'error');
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });
            });
        }

        function bindButtonEvents() {
            $('.ingresar-numero').off('click').on('click', function() {
                let certId = $(this).data('id');
                $('#certificadoId').val(certId);
                $('#numeroCertificado').val('000-2025-UNASAM');
                $('#modalIngresarNumero').modal('show');
            });
        }

        $('#btnGuardarNumero').on('click', function() {
            let certId = $('#certificadoId').val();
            let numero = $('#numeroCertificado').val();

            if (!numero) return alert('Ingrese el número de certificado');

            $.ajax({
                url: '{{ route("certificados.actualizarNumero") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    idCertif: certId,
                    nro: numero
                },
                beforeSend: function() {
                    $('#btnGuardarNumero').prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> Guardando...');
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Número actualizado!',
                            text: 'Número de certificado se actualizo correctamente',
                            confirmButtonColor: '#198754'
                        });
                        $('#modalIngresarNumero').modal('hide');
                        loadCertificados(eventoSeleccionado);
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                    Swal.fire('Error', 'Ocurrio un error al actualizar el número', 'error');
                    // alert('Error: ' + (xhr.responseJSON?.message || 'Error al actualizar'));
                },
                complete: function() {
                    $('#btnGuardarNumero').prop('disabled', false).html('<i class="bi bi-save"></i> Guardar');
                }
            });
        });


        // SCRIP PARA SUBIR ARCHIVOS

        function bindSubirDocumento() {
            $(document).off('click', '.subir-documento');
            $(document).off('change', 'input[name="tipo_subida"]');
            $(document).off('change', '#pdf_file');
            $(document).off('click', '#btnGuardarDocumento');

            $(document).on('click', '.subir-documento', function() {
                let certId = $(this).data('id');
                $('#certificado_id').val(certId);
                $('#formSubirDocumento')[0].reset();
                $('#preview-archivo').addClass('d-none');
                $('#modalSubirDocumento').modal('show');
            });

            $(document).on('change', 'input[name="tipo_subida"]', function() {
                if ($(this).val() === 'archivo') {
                    $('#zona-archivo').slideDown();
                    $('#zona-gdrive').slideUp();
                    $('#gdrive_url').val('');
                } else {
                    $('#zona-archivo').slideUp();
                    $('#zona-gdrive').slideDown();
                    $('#pdf_file').val('');
                    $('#preview-archivo').addClass('d-none');
                }
            });

            $(document).on('change', '#pdf_file', function() {
                if (this.files && this.files[0]) {
                    let file = this.files[0];
                    let fileSize = (file.size / 1024 / 1024).toFixed(2);

                    if (fileSize > 10) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Archivo muy grande',
                            text: 'El archivo excede el límite de 10 MB',
                            confirmButtonColor: '#d33'
                        });
                        $(this).val('');
                        $('#preview-archivo').addClass('d-none');
                        return;
                    }

                    $('#nombre-archivo').text(file.name);
                    $('#tamano-archivo').text(' (' + fileSize + ' MB)');
                    $('#preview-archivo').removeClass('d-none');
                }
            });

            // Guardar documento
            $(document).on('click', '#btnGuardarDocumento', function() {
                let certId = $('#certificado_id').val();
                let tipoSubida = $('input[name="tipo_subida"]:checked').val();
                let formData = new FormData();

                formData.append('_token', '{{ csrf_token() }}');
                formData.append('certificado_id', certId);
                formData.append('tipo_subida', tipoSubida);

                if (tipoSubida === 'archivo') {
                    let file = $('#pdf_file')[0].files[0];
                    if (!file) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Falta archivo',
                            text: 'Por favor selecciona un archivo PDF',
                            confirmButtonColor: '#3085d6'
                        });
                        return;
                    }
                    formData.append('pdf_file', file);
                } else {
                    let url = $('#gdrive_url').val().trim();
                    if (!url) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Falta URL',
                            text: 'Por favor ingresa la URL de Google Drive',
                            confirmButtonColor: '#3085d6'
                        });
                        return;
                    }
                    if (!url.includes('drive.google.com')) {
                        Swal.fire({
                            icon: 'error',
                            title: 'URL inválida',
                            text: 'Por favor ingresa una URL válida de Google Drive',
                            confirmButtonColor: '#d33'
                        });
                        return;
                    }
                    formData.append('gdrive_url', url);
                }

                $('#btnGuardarDocumento').prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm me-2"></span>Guardando...'
                );

                $.ajax({
                    url: '{{ url("/certificados/subir-documento") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Documento guardado!',
                                text: 'El documento se ha subido correctamente',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                $('#modalSubirDocumento').modal('hide');
                                loadCertificados(eventoSeleccionado);
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'No se pudo guardar el documento',
                                confirmButtonColor: '#d33'
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        let errorMsg = 'Error al subir el documento';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMsg,
                            confirmButtonColor: '#d33'
                        });
                    },
                    complete: function() {
                        $('#btnGuardarDocumento').prop('disabled', false).html(
                            '<i class="bi bi-check-circle"></i> Guardar Documento'
                        );
                    }
                });
            });
        }


        // SCRIP PARA TOKEN/ N° CERTIFICADO Y EL FOLIO EN GENERAL y la descripcion

        const LIMITE = 32;
        let totalAsignados = 0;
        let datosEventoActual = null;

        $('#btnGestionarCertificados').on('click', function() {
            if (!eventoSeleccionado) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Seleccione un evento',
                    text: 'Debe elegir un evento primero.',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            resetearModalUnificado();
            $('#modalGestionCertificados').modal('show');
        });

        function resetearModalUnificado() {
            console.log('Reseteando modal unificado...');
            $('#eventoIdTokenCert').val(eventoSeleccionado);
            $('#checkGenerarToken').prop('checked', false);
            $('#checkGenerarNumero').prop('checked', false);
            $('#sectionToken').addClass('d-none');
            $('#sectionCertificado').addClass('d-none');
            $('#prefijo').val('UNASAM');

            $('#checkActivarFolio').prop('checked', false);

            $('.card.border-success').removeClass('d-none');
            $('#seccionFolioCompleta').addClass('d-none');

            $('#cuaderno').val('');
            $('#tiempoCapacitacion').val('');
            $('#folioManual').val('');
            $('#registroDesde').val('');
            $('#registroHasta').val('');
            $('#descrNormal').val('');

            $('#vistaDescripcion').html('<em class="text-muted">La descripción se generará automáticamente cuando presiones "Generar Automático"</em>');

            $('#modoAuto').prop('checked', true);
            $('#modoManual').prop('checked', false);
            $('#seccionAuto').show();
            $('#seccionManual').hide();
            $('#seccionAuto').html('');

            datosEventoActual = null;
            totalAsignados = 0;

            console.log('✅ Modal reseteado correctamente');
        }

        $('#modalGestionCertificados').on('hidden.bs.modal', function() {
            console.log('🚪 Modal cerrado - ejecutando reseteo completo');
            resetearModalUnificado();
        });

        $('#modalGestionCertificados').on('show.bs.modal', function() {
            if (eventoSeleccionado) {
                cargarDatosEventoParaDescripcion(eventoSeleccionado);
            }

            if ($('#checkActivarFolio').is(':checked')) {
                // obtenerUltimosFolios();
            }
        });

        function cargarDatosEventoParaDescripcion(idevento) {
            $.ajax({
                url: '{{ route("certificado.obtenerDatosEvento") }}',
                type: 'POST',
                data: {
                    idevento: idevento,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        datosEventoActual = response.evento;
                        console.log('Datos del evento cargados:', datosEventoActual);
                    }
                },
                error: function(xhr) {
                    console.error('Error al cargar datos del evento:', xhr);
                }
            });
        }

        $('#btnGenerarDescripcion').on('click', function() {
            const tiempoCapacitacion = $('#tiempoCapacitacion').val().trim();

            if (!tiempoCapacitacion) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campo requerido',
                    text: 'Por favor, ingresa primero el "Tiempo de Capacitación"',
                    confirmButtonColor: '#0dcaf0'
                });
                $('#tiempoCapacitacion').focus();
                return;
            }

            if (!datosEventoActual) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudieron cargar los datos del evento. Intenta cerrar y abrir el modal nuevamente.',
                    confirmButtonColor: '#dc3545'
                });
                return;
            }

            const descripcionGenerada = generarDescripcionConcatenada(tiempoCapacitacion);

            $('#vistaDescripcion').html(`<span class="text-dark">${descripcionGenerada}</span>`);

            $('#descrNormal').val(descripcionGenerada);

            Swal.fire({
                icon: 'success',
                title: '¡Descripción Generada!',
                text: 'Puedes editarla antes de guardar',
                timer: 1500,
                showConfirmButton: false
            });
        });

        function generarDescripcionConcatenada(tiempoCapacitacion) {
            const descripcion = `Por haber Participado en ${datosEventoActual.tema}: ${datosEventoActual.nombre_evento}, Organizado por la Universidad Nacional Santiago Antúnez de Mayolo, con una duración de ${tiempoCapacitacion}, el día ${datosEventoActual.fecha_formateada}.`;
            return descripcion;
        }

        $('#descrNormal').on('input', function() {
            const texto = $(this).val().trim();
            if (texto) {
                $('#vistaDescripcion').html(`<span class="text-dark">${texto}</span>`);
            } else {
                $('#vistaDescripcion').html('<em class="text-muted">Escribe o genera la descripción</em>');
            }
        });

        $('#checkActivarFolio').on('change', function() {
            if ($(this).is(':checked')) {
                console.log('✅ Activando modo Folio');
                $('#seccionFolioCompleta').removeClass('d-none');
                $('.card.border-success').addClass('d-none');
                // obtenerUltimosFolios();
            } else {
                console.log('❌ Desactivando modo Folio');
                $('#seccionFolioCompleta').addClass('d-none');
                $('.card.border-success').removeClass('d-none');

                $('#cuaderno').val('');
                $('#tiempoCapacitacion').val('');
                $('#folioManual').val('');
                $('#registroDesde').val('');
                $('#registroHasta').val('');
                $('#descrNormal').val('');
                $('#vistaDescripcion').html('<em class="text-muted">La descripción se generará automáticamente</em>');
                $('#seccionAuto').html('');
            }
        });

        $('#checkGenerarToken').on('change', function() {
            if ($(this).is(':checked')) {
                $('#sectionToken').removeClass('d-none');
            } else {
                $('#sectionToken').addClass('d-none');
            }
        });

        $('#checkGenerarNumero').on('change', function() {
            if ($(this).is(':checked')) {
                $('#sectionCertificado').removeClass('d-none');
            } else {
                $('#sectionCertificado').addClass('d-none');
                $('#prefijo').val('UNASAM');
            }
        });

        function calcularFolioAutomatico() {
            let folioInicio = Math.ceil((totalAsignados + 1) / LIMITE);
            let registroInicio = (totalAsignados + 1) % LIMITE;

            if (registroInicio === 0) registroInicio = LIMITE;

            $("#seccionAuto").html(`
            <div class="alert alert-info mb-0">
                <strong><i class="bi bi-info-circle"></i> Asignación Automática</strong>
                <hr class="my-2">
                <p class="mb-0 text-muted small">
                    Máximo ${LIMITE} registros por folio
                </p>
            </div>
        `);
        }

        $("input[name='modoFolio']").on("change", function() {
            const modo = $(this).val();

            if (modo === "auto") {
                $("#seccionAuto").show();
                $("#seccionManual").hide();
                calcularFolioAutomatico();
            } else {
                $("#seccionAuto").hide();
                $("#seccionManual").show();
                $("#folioManual").val("");
                $("#registroDesde").val("");
                $("#registroHasta").val("");
            }
        });

        $('#btnGuardarTokenCert').on('click', function() {
            const tokenChecked = $('#checkGenerarToken').is(':checked');
            const numeroChecked = $('#checkGenerarNumero').is(':checked');

            if (!tokenChecked && !numeroChecked) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Seleccione una opción',
                    text: 'Debe seleccionar al menos Token o Número de Certificado.',
                    confirmButtonColor: '#ffc107'
                });
                return;
            }

            if (numeroChecked && !$('#prefijo').val().trim()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Falta el prefijo',
                    text: 'Debe ingresar un prefijo para generar los números.',
                    confirmButtonColor: '#ffc107'
                });
                return;
            }

            let mensaje = 'Se generará:<br><br>';
            if (tokenChecked) mensaje += 'Tokens únicos<br>';
            if (numeroChecked) mensaje += 'Números de certificado (' + $('#prefijo').val().toUpperCase() + ')<br>';

            Swal.fire({
                title: '¿Confirmar generación?',
                html: mensaje,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, generar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    procesarGeneracionTokenCert(tokenChecked, numeroChecked);
                }
            });
        });

        function procesarGeneracionTokenCert(generarToken, generarNumero) {
            const idevento = $('#eventoIdTokenCert').val();
            const prefijo = $('#prefijo').val().trim().toUpperCase();

            Swal.fire({
                title: 'Generando...',
                text: 'Por favor, espere.',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            $('#btnGuardarTokenCert').prop('disabled', true).html('<i class="spinner-border spinner-border-sm"></i> Generando...');

            let promesas = [];

            if (generarToken) {
                promesas.push(
                    $.ajax({
                        url: '{{ route("certificados.generarTokens") }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            idevento: idevento
                        }
                    })
                );
            }

            if (generarNumero) {
                promesas.push(
                    $.ajax({
                        url: '{{ route("certificadonumero.numcerocerti") }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            idevento: idevento,
                            prefijo: prefijo
                        }
                    })
                );
            }

            Promise.all(promesas)
                .then(results => {
                    Swal.close();

                    let mensajes = [];
                    results.forEach(response => {
                        if (response.success) {
                            mensajes.push(' ' + response.message);
                        } else {
                            mensajes.push('Error: ' + response.message);
                        }
                    });

                    Swal.fire({
                        icon: 'success',
                        title: '¡Completado!',
                        html: mensajes.join('<br>'),
                        confirmButtonColor: '#28a745'
                    }).then(() => {
                        $('#modalGestionCertificados').modal('hide');
                        if (typeof loadCertificados === 'function') {
                            loadCertificados(eventoSeleccionado);
                        }
                    });
                })
                .catch(error => {
                    Swal.close();
                    console.error('Error:', error);

                    let errorMsg = 'Ocurrió un error al generar. Revise la consola.';
                    if (error.responseJSON && error.responseJSON.message) {
                        errorMsg = error.responseJSON.message;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: errorMsg,
                        confirmButtonColor: '#dc3545'
                    });
                })
                .finally(() => {
                    $('#btnGuardarTokenCert').prop('disabled', false).html('<i class="bi bi-save"></i> Generar Token/Certificado');
                });
        }

        $('#btnGuardarFolio').on('click', function() {
            const cuaderno = $('#cuaderno').val().trim();
            const tiempoCapacitacion = $('#tiempoCapacitacion').val().trim();
            const descripcion = $('#descrNormal').val().trim();
            const modo = $("input[name='modoFolio']:checked").val();

            if (!cuaderno || !tiempoCapacitacion) {
                Swal.fire({
                    icon: 'error',
                    title: 'Campos requeridos',
                    text: 'Complete Cuaderno y Tiempo de Capacitación',
                    confirmButtonColor: '#d33'
                });
                return;
            }

            if (!descripcion) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Descripción vacía',
                    text: 'Por favor, genera o escribe una descripción antes de guardar',
                    confirmButtonColor: '#ffc107'
                });
                return;
            }

            let datosGuardar = {
                cuaderno: cuaderno,
                tiempoCapacitacion: tiempoCapacitacion,
                descripcion: descripcion,
                modo: modo,
                idevento: eventoSeleccionado,
                _token: '{{ csrf_token() }}'
            };

            if (modo === 'manual') {
                const folioManual = $('#folioManual').val();
                const registroDesde = $('#registroDesde').val();
                const registroHasta = $('#registroHasta').val();

                if (!folioManual || !registroDesde || !registroHasta) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Datos incompletos',
                        text: 'Complete todos los campos del modo manual',
                        confirmButtonColor: '#d33'
                    });
                    return;
                }

                if (parseInt(registroDesde) > parseInt(registroHasta)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en rangos',
                        text: 'El registro desde debe ser menor o igual al registro hasta',
                        confirmButtonColor: '#d33'
                    });
                    return;
                }

                datosGuardar.folio = folioManual;
                datosGuardar.registroDesde = registroDesde;
                datosGuardar.registroHasta = registroHasta;
            }

            Swal.fire({
                title: '¿Confirmar guardado?',
                html: `<div class="text-start text-center">
                        <p><strong>Cuaderno:</strong> ${cuaderno} - <strong>Modo:</strong> ${modo === 'auto' ? 'Automático' : 'Manual'}</p>
                        <hr>
                        <p class="small text-muted"><strong>Descripción:</strong><br>${descripcion.substring(0, 150)}...</p>
                    </div>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, guardar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#0d6efd',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    procesarGuardadoFolio(datosGuardar);
                }
            });
        });

        function procesarGuardadoFolio(datosGuardar) {
            $.ajax({
                url: '{{ route("certificado.guardarFolio") }}',
                type: 'POST',
                data: datosGuardar,
                dataType: 'json',
                beforeSend: function() {
                    $('#btnGuardarFolio').prop('disabled', true).html('<i class="spinner-border spinner-border-sm"></i> Guardando...');
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Guardado Exitoso!',
                            html: response.message,
                            confirmButtonColor: '#28a745',
                            timer: 2000
                        }).then(() => {
                            $('#modalGestionCertificados').modal('hide');
                            if (typeof loadCertificados === 'function') {
                                loadCertificados(eventoSeleccionado);
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'No se pudo guardar',
                            confirmButtonColor: '#d33'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    let errorMsg = 'No se pudo conectar con el servidor';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    } else if (xhr.status === 422 && xhr.responseJSON.errors) {
                        let errores = Object.values(xhr.responseJSON.errors).flat();
                        errorMsg = errores.join('<br>');
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Error de conexión',
                        html: errorMsg,
                        confirmButtonColor: '#d33'
                    });

                    console.error('Error AJAX:', error);
                },
                complete: function() {
                    $('#btnGuardarFolio').prop('disabled', false).html('<i class="bi bi-save"></i> Guardar Folio y Descripción');
                }
            });
        }

        // SCRIP PARA CREAR PERSONAS

        // ABRIR MODAL Y CARGAR GENEROS
        $('#btnperson').on('click', function() {

            const modal = new bootstrap.Modal(document.getElementById('modalAgregarPersona'));
            modal.show();

            $('#idgeneroField').html('<option>Cargando...</option>');

            $.ajax({
                url: "{{ route('generos.listar') }}",
                type: "GET",
                dataType: "json",
                success: function(response) {

                    if (response.success) {
                        let options = '<option value="">Seleccione género</option>';

                        response.data.forEach(function(gen) {
                            options += `<option value="${gen.idgenero}">${gen.nomgen}</option>`;
                        });

                        $('#idgeneroField').html(options);

                    } else {
                        alert("Error: " + response.message);
                    }
                },
                error: function() {
                    alert("No se pudo cargar los géneros");
                }
            });

        });

        // GUARDAR PERSONA
        $('#formAgregarPersona').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('personas.guardar') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {

                    if (response.success) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Registrado',
                            text: 'Persona registrada correctamente',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        let modal = bootstrap.Modal.getInstance(document.getElementById('modalAgregarPersona'));
                        modal.hide();
                        cargarPersonas();
                        $('#formAgregarPersona')[0].reset();

                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Error inesperado',
                            text: 'Ocurrió un problema inesperado.'
                        });
                    }
                },
                error: function(xhr) {

                    if (xhr.status === 422) {
                        let errores = xhr.responseJSON.errors;
                        let mensaje = "";

                        Object.keys(errores).forEach(campo => {
                            mensaje += errores[campo] + "<br>";
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Errores de validación',
                            html: mensaje
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error del servidor',
                            text: 'Inténtelo más tarde.'
                        });
                    }
                }
            });
        });

        function cargarPersonas() {
            $("#listaPersonas").load(" #listaPersonas > *");
        }


        // Función para culminar el evento

        $('#btnCulminarCertificado').on('click', function() {
            if (!eventoSeleccionado) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Atención',
                    text: 'Por favor, seleccione un evento primero',
                    confirmButtonText: 'Entendido'
                });
                return;
            }

            Swal.fire({
                title: '¿Está seguro de culminar este evento?',
                html: `<p><strong>Evento:</strong> ${eventoNombre}</p>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bi bi-check-circle"></i> Sí, culminar evento',
                cancelButtonText: '<i class="bi bi-x-circle"></i> Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    culminarEvento();
                }
            });
        });

        function culminarEvento() {
            Swal.fire({
                title: 'Procesando...',
                html: '<p>Culminando el evento</p><p class="text-muted">Por favor espere</p>',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: '{{ route("evento.finalizado") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    event_id: eventoSeleccionado
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Evento Culminado!',
                            html: `<p>${response.message}</p>
                           <p class="text-muted">${response.evento || ''}</p>`,
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor: '#28a745'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'No se pudo culminar el evento',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Error al culminar el evento';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    console.error('Error:', xhr.responseText);

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#d33'
                    });
                }
            });
        }
    });
</script>



@include('Vistas.Footer')
@include('Vistas.Scrip')