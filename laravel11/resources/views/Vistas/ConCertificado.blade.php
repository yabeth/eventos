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

<script>
    $(document).ready(function() {
        let eventoSeleccionado = null;
        let eventoNombre = '';

        $('#ideven').on('change', function() {
            eventoSeleccionado = $(this).val();
            eventoNombre = $(this).find('option:selected').text();
            $('#btnGenerarAsistencia, #btnGenerarNormales, #btnActualizarTabla, #btnGestionarCertificados').prop('disabled', false);
            loadCertificados(eventoSeleccionado);
        });

    
        // Generar Certificados de Asistencia ¨¨ MODIFICAR

        $('#btnGenerarNormales').on('click', function() {
            if (!eventoSeleccionado) return alert('Seleccione un evento');
            $('#eventoNombreNormal').val(eventoNombre);
            $('#eventoIdNormal').val(eventoSeleccionado);
            $('.persona-checkbox').prop('checked', false);
            actualizarContador();
            $('#modalGenerarNormales').modal('show');
        });

        $('#buscarPersona').on('keyup', function() {
            let searchTerm = $(this).val().toLowerCase();
            $('.persona-row').each(function() {
                let dni = $(this).data('dni').toString();
                let nombre = $(this).data('nombre');
                $(this).toggle(dni.includes(searchTerm) || nombre.includes(searchTerm));
            });
        });

        $('#selectAllPersonas').on('change', function() {
            $('.persona-checkbox:visible').prop('checked', $(this).is(':checked'));
            actualizarContador();
        });

        $(document).on('change', '.persona-checkbox', actualizarContador);

        function actualizarContador() {
            $('#personasSeleccionadas').text($('.persona-checkbox:checked').length + ' seleccionadas');
        }

        $('#btnConfirmarNormales').on('click', function() {
            let personasSeleccionadas = [];
            $('.persona-checkbox:checked').each(function() {
                personasSeleccionadas.push($(this).val());
            });

            if (personasSeleccionadas.length === 0) return alert('Seleccione al menos una persona');

            $.ajax({
                url: '{{ route("certinormal.generar") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    personas: personasSeleccionadas,
                    idevento: $('#eventoIdNormal').val(),
                    idtipcerti: $('#idtipcertiNormal').val(),
                    tiempocapa: $('#tiempocapaNormal').val(),
                    descr: $('#descrNormal').val()
                },
                beforeSend: function() {
                    $('#btnConfirmarNormales').prop('disabled', true).text('Generando...');
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        $('#modalGenerarNormales').modal('hide');
                        loadCertificados(eventoSeleccionado);
                    }
                },
                error: function(xhr) {
                    alert('Error: ' + (xhr.responseJSON?.message || 'Error desconocido'));
                },
                complete: function() {
                    $('#btnConfirmarNormales').prop('disabled', false).text('Generar');
                }
            });
        });

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
                        if (!cert.certiasiste?.asistencia?.inscripcion?.persona) return;

                        let persona = cert.certiasiste.asistencia.inscripcion.persona;
                        let estado = cert.estado_certificado?.nomestadc || 'Pendiente';
                        let tipo = cert.tipo_certificado?.tipocertifi || 'N/A';
                        let porcentaje = cert.certiasiste?.asistencia?.porceasis || 0;

                        let estadoBoton = '';
                        if (cert.idestcer == 2) {
                            estadoBoton = `<button class="btn btn-xs btn-success w-80 btn-estado" data-id="${cert.idCertif}" data-estado="2" disabled>Entregado
                            </button>`;
                        } else {
                            estadoBoton = `<button class="btn btn-xs btn-warning w-80 btn-estado" data-id="${cert.idCertif}" data-estado="${cert.idestcer || 1}">Pendiente
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
                            <td>${tipo}</td>
                            <td>${cert.tiempocapa || 'N/A'}</td>
                            <td>${cert.cuader || 'N/A'}</td>
                            <td>${cert.foli || 'N/A'}</td>
                            <td>${cert.numregis || 'N/A'}</td>
                            <td>${tokenDisplay}</td>
                            <td>${cert.descr || 'Sin descripción'}</td>
                            <td>${cert.pdff ? '<a href="' + cert.pdff + '" target="_blank" class="btn btn-xs btn-info">Ver PDF</a>' : 'Sin PDF'}</td>
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

                if (estadoActual == 2) {
                    return;
                }

                Swal.fire({
                    title: '¿Entregar certificado?',
                    text: 'Se marcará como entregado y se registrará la fecha actual',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="bi bi-check-circle"></i> Sí, entregar',
                    cancelButtonText: '<i class="bi bi-x-circle"></i> Cancelar'
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

                        btn.removeClass('btn-warning')
                            .addClass('btn-success')
                            .html('Entregado')
                            .data('estado', 2)
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

                        btn.prop('disabled', false).html('<i class="bi bi-clock-history"></i> Pendiente');
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

                    btn.prop('disabled', false).html('<i class="bi bi-clock-history"></i> Pendiente');
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
                $('#numeroCertificado').val('');
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
                        alert('Número actualizado correctamente');
                        $('#modalIngresarNumero').modal('hide');
                        loadCertificados(eventoSeleccionado);
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                    alert('Error: ' + (xhr.responseJSON?.message || 'Error al actualizar'));
                },
                complete: function() {
                    $('#btnGuardarNumero').prop('disabled', false).html('<i class="bi bi-save"></i> Guardar');
                }
            });
        });
        // =============================== Limite de registros por folio ===============================
        const LIMITE = 32;
        let totalAsignados = 0;

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
            $('#eventoIdTokenCert').val(eventoSeleccionado);
            $('#checkGenerarToken').prop('checked', false);
            $('#checkGenerarNumero').prop('checked', false);
            $('#sectionToken').addClass('d-none');
            $('#sectionCertificado').addClass('d-none');
            $('#prefijo').val('');

            $('#checkActivarFolio').prop('checked', false);
            $('#seccionFolioCompleta').addClass('d-none');

            $('#cuaderno').val('');
            $('#tiempoCapacitacion').val('');
            $('#folioManual').val('');
            $('#registroDesde').val('');
            $('#registroHasta').val('');
            $('#modoAuto').prop('checked', true);
            $('#seccionAuto').show();
            $('#seccionManual').hide();
        }

        $('#modalGestionCertificados').on('show.bs.modal', function() {
            if ($('#checkActivarFolio').is(':checked')) {
                obtenerUltimosFolios();
            }
        });

        $('#checkActivarFolio').on('change', function() {
            if ($(this).is(':checked')) {
                $('#seccionFolioCompleta').removeClass('d-none');
                $('.card.border-success').addClass('d-none');
                obtenerUltimosFolios();
            } else {
                $('#seccionFolioCompleta').addClass('d-none');
                $('.card.border-success').removeClass('d-none');
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
            }
        });

        function obtenerUltimosFolios() {
            $.ajax({
                url: '{{ route("certificado.obtenerUltimoFolio") }}',
                type: 'POST',
                data: {
                    idevento: eventoSeleccionado,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        totalAsignados = response.total || 0;

                        if ($("#modoAuto").is(":checked")) {
                            calcularFolioAutomatico();
                        }
                    } else {
                        console.error('Error al obtener folios:', response.message);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message,
                            confirmButtonColor: '#d33'
                        });
                    }
                },
                error: function(xhr) {
                    console.error('Error en la petición AJAX');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de conexión',
                        text: 'No se pudo conectar con el servidor',
                        confirmButtonColor: '#d33'
                    });
                }
            });
        }

        function calcularFolioAutomatico() {
            let folioInicio = Math.ceil((totalAsignados + 1) / LIMITE);
            let registroInicio = (totalAsignados + 1) % LIMITE;

            if (registroInicio === 0) registroInicio = LIMITE;

            $("#seccionAuto").html(`
                <div class="alert alert-info mb-0">
                    <strong><i class="bi bi-info-circle"></i> Asignación Automática</strong>
                    <hr class="my-2">
                    <p class="mb-1">
                        El sistema asignará folio y registro a <strong>TODOS</strong> los certificados 
                        del evento que aún no tienen asignación.
                    </p>
                    <p class="mb-1">
                        <strong>Certificados ya asignados:</strong> ${totalAsignados}
                    </p>
                    <p class="mb-1">
                        <strong>Siguiente folio/registro:</strong> ${folioInicio}/${registroInicio}
                    </p>
                    <p class="mb-0 text-muted small">
                        (Máximo ${LIMITE} registros por folio)
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
                    $('#modalGestionCertificados').modal('hide');
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

            // Generar Tokens únicos
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

            // Generar Números de Certificado
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
                            mensajes.push(' ' + response.message);
                        }
                    });

                    Swal.fire({
                        icon: 'success',
                        title: '¡Completado!',
                        html: mensajes.join('<br>'),
                        confirmButtonColor: '#28a745'
                    }).then(() => {
                        loadCertificados(eventoSeleccionado);
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
                    $('#btnGuardarTokenCert').prop('disabled', false).html('Generar Token/Certificado');
                });
        }

        $('#btnGuardarFolio').on('click', function() {
            const cuaderno = $('#cuaderno').val().trim();
            const tiempoCapacitacion = $('#tiempoCapacitacion').val().trim();
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

            let datosGuardar = {
                cuaderno: cuaderno,
                tiempoCapacitacion: tiempoCapacitacion,
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
                html: `Se guardará:<br><br>Cuaderno: ${cuaderno}<br>Tiempo: ${tiempoCapacitacion}<br>Modo: ${modo === 'auto' ? 'Automático' : 'Manual'}`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, guardar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#0d6efd',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    procesarGuardadoFolio(datosGuardar);
                    $('#modalGestionCertificados').modal('hide');
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
                            title: '¡Guardado!',
                            text: response.message || 'Folio guardado correctamente',
                            confirmButtonColor: '#28a745'
                        }).then(() => {
                            loadCertificados(eventoSeleccionado);
                            $('#modalGestionCertificados').modal('hide');
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
                    $('#btnGuardarFolio').prop('disabled', false).html('Guardar Folio');
                }
            });
        }

    });
</script>



@include('Vistas.Footer')
@include('Vistas.Scrip')