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

    .btn-group-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 15px;
    }
</style>

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white text-center">
            <h5 class="card-title mb-0">GESTIÓN DE CERTIFICADOS</h5>
        </div>
        <div class="card-body">
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
                        <button type="button" class="btn btn-warning" id="btnCambiarEstado" disabled>
                            <i class="bi bi-pencil-square"></i> Cambiar estado
                        </button>
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
                        <button type="button" class="btn btn-warning" id="btnActualizarTabla" disabled>
                            <i class="bi bi-arrow-clockwise"></i> Actualizar Lista
                        </button>
                        <button type="button" class="btn btn-warning" id="btnBuscarcerti" disabled>
                            <i class="bi bi-arrow-clockwise"></i> Buscar Certi por Participante
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

{{-- Modal Generar Certificados de Asistencia --}}
<div class="modal fade" id="modalGenerarAsistencia" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Generar Certificados de Asistencia</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formGenerarAsistencia">
                    @csrf
                    <input type="hidden" id="eventoIdAsistencia" name="idevento">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Evento:</label>
                        <input type="text" id="eventoNombre" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="porcentaje_minimo" class="form-label">Porcentaje Mínimo (%)</label>
                        <input type="number" class="form-control" id="porcentaje_minimo" name="porcentaje_minimo" value="75" min="0" max="100" required>
                    </div>
                    <div class="mb-3">
                        <label for="tiempocapaAsist" class="form-label">Tiempo de Capacitación</label>
                        <input type="text" class="form-control" id="tiempocapaAsist" name="tiempocapa" placeholder="Ej: 40 horas">
                    </div>
                    <div class="mb-3">
                        <label for="idtipcertiAsist" class="form-label">Tipo de Certificado</label>
                        <input type="number" class="form-control" id="idtipcertiAsist" name="idtipcerti" value="1">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="btnConfirmarAsistencia">
                    <i class="bi bi-check-circle"></i> Generar
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Generar Certificados Normales --}}
<div class="modal fade" id="modalGenerarNormales" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Generar Certificados Normales</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formGenerarNormales">
                    @csrf
                    <input type="hidden" id="eventoIdNormal" name="idevento">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Evento:</label>
                        <input type="text" id="eventoNombreNormal" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="tiempocapaNormal" class="form-label">Tiempo de Capacitación</label>
                        <input type="text" class="form-control" id="tiempocapaNormal" name="tiempocapa" placeholder="Ej: 40 horas">
                    </div>
                    <div class="mb-3">
                        <label for="idtipcertiNormal" class="form-label">Tipo de Certificado</label>
                        <select class="form-select" id="idtipcertiNormal" name="idtipcerti" required>
                            <option value="2">Ponente</option>
                            <option value="3">Organizador</option>
                            <option value="4">Expositor</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="descrNormal" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descrNormal" name="descr" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Seleccionar Personas:</label>
                        <input type="text" id="buscarPersona" class="form-control mb-2" placeholder="Buscar...">
                        <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                            <table class="table table-sm">
                                <thead class="table-light sticky-top">
                                    <tr>
                                        <th><input type="checkbox" id="selectAllPersonas" class="form-check-input"></th>
                                        <th>DNI</th>
                                        <th>Nombres</th>
                                    </tr>
                                </thead>
                                <tbody id="listaPersonas">
                                    @if(isset($personas))
                                    @foreach($personas as $persona)
                                    <tr class="persona-row" data-dni="{{ $persona->dni }}" data-nombre="{{ strtolower($persona->nombre . ' ' . $persona->apell) }}">
                                        <td><input type="checkbox" name="personas[]" value="{{ $persona->idpersona }}" class="form-check-input persona-checkbox"></td>
                                        <td>{{ $persona->dni }}</td>
                                        <td>{{ $persona->nombre }} {{ $persona->apell }}</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <small class="text-muted" id="personasSeleccionadas">0 seleccionadas</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-info" id="btnConfirmarNormales">
                    <i class="bi bi-check-circle"></i> Generar
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
                        <input type="text" class="form-control" id="numeroCertificado" name="nro" placeholder="CERT-2024-001" required>
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

<!-- MODAL UNIFICADO PARA GESTIÓN COMPLETA DE CERTIFICADOS / TOKEN Y NÚMERO -->
<div class="modal fade" id="modalGestionCertificados" tabindex="-1" aria-labelledby="modalGestionCertificadosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
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
                    <label class="form-check-label fw-bold" for="checkActivarFolio">Generar Folio General
                    </label>
                </div>
                <div class="card border-success mb-3">
                    <div class="card-header bg-success bg-opacity-10 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold text-success">
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
                                            placeholder="Ej. CERT o CAST" maxlength="10">
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

                <!-- SECCIÓN 2: FOLIO GENERAL (Oculta por defecto) -->
                <div id="seccionFolioCompleta" class="d-none">
                    <div class="card border-primary">
                        <div class="card-header bg-primary bg-opacity-10">
                            <h6 class="mb-0 fw-bold text-primary">
                                <i class="bi bi-journal-text me-2"></i> Folio General
                            </h6>
                        </div>
                        <div class="card-body">
                            <form id="formGeneralFolio">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Cuaderno</label>
                                        <input type="text" class="form-control" id="cuaderno" placeholder="Ej: I, A, B..." required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tiempo de Capacitación</label>
                                        <input type="text" class="form-control" id="tiempoCapacitacion" placeholder="Ej: 40 horas" required>
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
                                            El sistema asignará automáticamente el folio y el número de registro
                                            según los últimos valores guardados en la base de datos.
                                            <br>Máximo 32 registros por folio.
                                        </p>
                                    </div>
                                    <div id="seccionManual" class="col-md-12 border rounded p-3 bg-light" style="display:none;">
                                        <div class="row g-3">

                                            <div class="col-md-4">
                                                <label class="form-label">Folio</label>
                                                <input type="number" class="form-control" id="folioManual" placeholder="Ej: 4">
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Registro desde</label>
                                                <input type="number" class="form-control" id="registroDesde" placeholder="Ej: 1">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Registro hasta</label>
                                                <input type="number" class="form-control" id="registroHasta" placeholder="Ej: 10">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end mt-3">
                                    <button type="button" class="btn btn-primary" id="btnGuardarFolio">
                                        <i class="bi bi-save"></i> Guardar Folio
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Cerrar
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
</style>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>



@include('Vistas.Footer')
@include('Vistas.Scrip')