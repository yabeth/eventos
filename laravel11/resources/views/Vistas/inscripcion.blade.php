@include('Vistas.Header')

<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.1/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');

    body {
        font-family: 'Roboto', sans-serif;
        background: #f8f9fa;
        min-height: 100vh;
    }
</style>

<body>
    <div class="container-fluid mt-2">

        <div class="card border-0 shadow">
            <div class="card-header bg-primary text-white text-center py-2">
                <h5 class="mb-0">GESTIÓN DE INSCRIPCIÓN</h5>
            </div>

            <div class="card-body">

                <!-- ===== ALERTAS ===== -->
                <div class="row">
                    <div class="col-12">
                        @if(session('error'))
                        <div class="alert alert-danger d-flex align-items-center">
                            <i class="bi bi-exclamation-circle-fill me-2"></i>
                            {{ session('error') }}
                        </div>
                        @endif
                    </div>
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-lg-6 col-md-6 col-12">
                        <form action="{{ route('reportinscripcionporevento') }}" method="GET">
                            <div class="input-group">
                                <select id="ideven" name="ideven" class="form-select form-control" required>
                                    <option value="" disabled selected>Seleccione un evento</option>
                                    @foreach ($eventos as $even)
                                    <option value="{{ $even->idevento }}">{{ $even->eventnom }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-success">
                                    <i class="bi bi-file-earmark-text"></i> Reporte
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-3 col-md-3 col-6">
                        <form action="{{ route('reportinscripcion') }}" method="GET">
                            <button class="btn btn-info w-100">
                                <i class="bi bi-file-earmark-bar-graph"></i> Reporte General
                            </button>
                        </form>
                    </div>

                    <div class="col-lg-3 col-md-3 col-6">
                        <button class="btn btn-primary w-100 flex-grow-1" data-toggle="modal" data-target="#addEmployeeModal">
                            <i class="bi bi-person-plus-fill"></i> Agregar Participante
                        </button>
                    </div>

                </div>

                <div class="card shadow-sm mb-3">
                    <div class="card-body py-3">
                        <form action="{{ route('incritosfecha') }}" method="GET" class="row g-2 align-items-end">

                            <div class="col-md-4 col-12">
                                <label class="form-label fw-bold"><i class="bi bi-calendar me-1"></i> Fecha inicio</label>
                                <input type="date" name="fecinic" class="form-control">
                            </div>

                            <div class="col-md-4 col-12">
                                <label class="form-label fw-bold"><i class="bi bi-calendar-check me-1"></i> Fecha fin</label>
                                <input type="date" name="fecfin" class="form-control">
                            </div>

                            <div class="col-md-4 col-12">
                                <button class="btn btn-primary w-100">
                                    <i class="bi bi-printer"></i> Reporte por fecha
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

                <div class="row g-2 mb-3 align-items-center">

                    <div class="col-md-6 col-12">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-0"><i class="bi bi-search"></i></span>
                            <input type="text" id="buscarTabla" class="form-control" placeholder="Buscar por DNI, nombre, email...">
                        </div>
                    </div>

                    <div class="col-md-6 text-md-end text-center">
                        <span class="badge bg-secondary fs-6 px-3 py-2" id="evenselec">
                            <i class="bi bi-calendar-event me-1"></i> Selecciona un evento
                        </span>
                    </div>

                </div>

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold">Lista de participantes inscritos</h6>
                </div>
                <!-- ===== TABLA ===== -->
                <div class="table-responsive">
                    <table id="inscripcionTable" class="table table-hover align-middle">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>N°</th>
                                <th>DNI</th>
                                <th>Participante</th>
                                <th>Teléfono</th>
                                <th>Email</th>
                                <th>Género</th>
                                <th>Escuela</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="text-center"></tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>


    <!-- Add Participant Modal -->
    <div id="addEmployeeModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content modal-content-custom">
                <form id="employeeForm" action="{{ route('Rut.inscri.store') }}" method="post">
                    @csrf
                    <div class="modal-header modal-header-custom bg-primary text-white">
                        <h4 class="modal-title">
                            <i class="bi bi-person-plus-fill me-2"></i>Agregar Nuevo Participante
                        </h4>
                        <button type="button" class="btn-close btn-close-white" data-dismiss="modal"></button>
                    </div>

                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">DNI <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-custom" name="dni" id="dni" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Apellidos <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-custom" name="apell" id="apell" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nombres <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-custom" name="nombre" id="nombre" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Teléfono <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-custom" name="tele" id="tele" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control form-control-custom" name="email" id="email" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Dirección <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-custom" name="direc" id="direc" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Género <span class="text-danger">*</span></label>
                                <select name="idgenero" class="form-control form-control-custom" required>
                                    <option value="">Seleccione...</option>
                                    @foreach ($generos as $gen)
                                    <option value="{{ $gen->idgenero }}">{{ $gen->nomgen }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Escuela <span class="text-danger">*</span></label>
                                <select name="idescuela" id="idescuela" class="form-control form-control-custom" required>
                                    <option value="">Seleccione...</option>
                                    @foreach ($escuelas as $escu)
                                    <option value="{{ $escu->idescuela }}">{{ $escu->nomescu }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" id="idevento" name="idevento">
                        </div>
                    </div>

                    <div class="modal-footer border-0 p-4">
                        <button type="button" class="btn btn-secondary btn-custom" data-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i>Cerrar
                        </button>
                        <button type="submit" class="btn btn-success btn-custom">
                            <i class="bi bi-check-circle me-1"></i>Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modals -->
    @foreach ($inscripciones as $incrip)
    <div class="modal fade" id="edit{{$incrip->idincrip}}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content modal-content-custom">
                <div class="modal-header modal-header-custom bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil-square me-2"></i>Editar Participante
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('Rut.inscri.update', $incrip->idincrip) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">DNI</label>
                                <input type="text" class="form-control form-control-custom" name="dni" value="{{ $incrip->persona->dni }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Apellidos</label>
                                <input type="text" class="form-control form-control-custom" name="apell" value="{{ $incrip->persona->apell }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nombres</label>
                                <input type="text" class="form-control form-control-custom" name="nombre" value="{{ $incrip->persona->nombre }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Teléfono</label>
                                <input type="text" class="form-control form-control-custom" name="tele" value="{{ $incrip->persona->tele }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" class="form-control form-control-custom" name="email" value="{{ $incrip->persona->email }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Dirección</label>
                                <input type="text" class="form-control form-control-custom" name="direc" value="{{ $incrip->persona->direc }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Género</label>
                                <select name="idgenero" class="form-control form-control-custom" required>
                                    @foreach ($generos as $gen)
                                    <option value="{{$gen->idgenero}}" {{ $gen->idgenero == $incrip->persona->genero->idgenero ? 'selected' : '' }}>
                                        {{$gen->nomgen}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Escuela</label>
                                <select name="idescuela" class="form-control form-control-custom" required>
                                    @foreach ($escuelas as $escu)
                                    <option value="{{$escu->idescuela}}" {{ $escu->idescuela == $incrip->idescuela ? 'selected' : '' }}>
                                        {{$escu->nomescu}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Evento (Informativo)</label>
                                <input type="text" class="form-control form-control-custom"
                                    value="{{ $incrip->subevento->evento->eventnom ?? 'Sin evento' }}"
                                    readonly style="background-color: #f3f4f6;">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>El evento no puede ser modificado
                                </small>
                            </div>
                        </div>
                        <div class="modal-footer border-0 px-0 pt-4">
                            <button type="button" class="btn btn-secondary btn-custom" data-dismiss="modal">
                                <i class="bi bi-x-circle me-1"></i>Cerrar
                            </button>
                            <button type="submit" class="btn btn-primary btn-custom">
                                <i class="bi bi-check-circle me-1"></i>Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Delete Modals -->
    @foreach ($inscripciones as $incrip)
    <!-- <div id="delete{{$incrip->idincrip}}" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content modal-content-custom text-center">
                <form action="{{route('Rut.inscri.destroy', $incrip->idincrip)}}" method="POST">
                    @csrf
                    @method('delete')
                    <div class="modal-body p-5">
                        <div class="mb-4">
                            <i class="bi bi-exclamation-triangle" style="font-size: 5rem; color: #f59e0b;"></i>
                        </div>
                        <h4 class="mb-3">¿Estás seguro?</h4>
                        <p class="text-muted">Esta acción eliminará el registro permanentemente</p>
                    </div>
                    <div class="modal-footer border-0 justify-content-center pb-4">
                        <button type="button" class="btn btn-secondary btn-custom" data-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-gradient-danger btn-custom">
                            <i class="bi bi-trash me-1"></i>Eliminar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div> -->
    @endforeach

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // ==================== GESTIÓN DE INSCRIPCIONES ====================
        const InscripcionManager = {
            dataTable: null,
            isProcessing: false,

            // INICIALIZACIÓN
            init: function() {
                this.setupAjax();
                this.setupEventListeners();
                this.restoreSessionData();
                this.loadInitialData();
            },

            // CONFIGURACIÓN 
            setupAjax: function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            },

            setupEventListeners: function() {
                var self = this;

                $('#ideven').on('change', function() {
                    self.handleEventChange();
                });

                $('#buscarTabla').on('input', function() {
                    self.handleSearch();
                });

                $('#employeeForm').on('submit', function(e) {
                    self.handleFormSubmit(e);
                });

                $('#dni').on('keyup', function(e) {
                    self.searchParticipantByDNI(e);
                });

                $(document).on('click', '.update-btn', function(e) {
                    self.handleEdit(e);
                });
                $(document).on('click', '.delete-btn', function(e) {
                    self.handleDelete(e);
                });

                $('#addEmployeeModal').on('hidden.bs.modal', function() {
                    self.clearForm();
                });
            },

            // ==================== GESTIÓN DE SESIÓN ====================
            restoreSessionData: function() {
                var savedEventId = sessionStorage.getItem('selectedEventId');
                var savedSearchTerm = sessionStorage.getItem('searchTerm');

                if (savedEventId) {
                    $('#ideven').val(savedEventId);
                    this.updateSelectedEvent();
                }

                if (savedSearchTerm) {
                    $('#buscarTabla').val(savedSearchTerm);
                }
            },

            updateSelectedEvent: function() {
                var eventId = $('#ideven').val();
                var eventText = $('#ideven').find('option:selected').text();

                $('#evenselec').html('<i class="bi bi-calendar-event me-2"></i>' + (eventText || 'Ninguno'));
                $('#idevento').val(eventId);

                if (eventId) {
                    sessionStorage.setItem('selectedEventId', eventId);
                }
            },

            // ==================== MANEJO DE EVENTOS UI ====================
            handleEventChange: function() {
                var eventId = $('#ideven').val();
                sessionStorage.setItem('selectedEventId', eventId);
                this.updateSelectedEvent();
                this.fetchData();
            },

            handleSearch: function() {
                var searchTerm = $('#buscarTabla').val();
                sessionStorage.setItem('searchTerm', searchTerm);
                this.fetchData();
            },

            // ==================== FORMULARIO DE PARTICIPANTE ====================
            handleFormSubmit: function(event) {
                event.preventDefault();

                if (this.isProcessing) {
                    console.log('Ya hay una operación en curso');
                    return;
                }

                var self = this;
                this.isProcessing = true;
                var form = event.target;
                var formData = new FormData(form);

                this.showLoading('Procesando...');

                fetch(form.action, {
                        method: 'POST',
                        body: formData
                    })
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(data) {
                        if (data.showAlert) {
                            return self.showConfirmation(
                                'Esta persona está registrada en otra escuela. ¿Desea actualizar la inscripción?'
                            ).then(function(result) {
                                if (result.isConfirmed) {
                                    return self.updateParticipantSchool(form, formData);
                                } else {
                                    self.showInfo('La inscripción se mantiene en la escuela original');
                                    return Promise.reject('cancelled');
                                }
                            });
                        } else {
                            self.showSuccess(data.message || 'Se registró correctamente');
                            return self.reloadData(form);
                        }
                    })
                    .catch(function(error) {
                        if (error !== 'cancelled') {
                            self.showError('Error al procesar la solicitud: ' + error.message);
                        }
                    })
                    .finally(function() {
                        self.isProcessing = false;
                    });
            },

            updateParticipantSchool: function(form, formData) {
                var self = this;
                formData.append('decision', 'S');

                return fetch(form.action, {
                        method: 'POST',
                        body: formData
                    })
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(data) {
                        self.showSuccess(data.message || 'Se actualizó correctamente');
                        return self.reloadData(form);
                    });
            },

            reloadData: function(form) {
                var self = this;

                this.closeModalSafely('#addEmployeeModal');

                form.reset();

                var eventId = $('#ideven').val();
                if (eventId) {
                    return self.fetchData();
                } else {
                    location.reload();
                    return Promise.resolve();
                }
            },

            // ==================== BÚSQUEDA DE PARTICIPANTE ====================
            searchParticipantByDNI: function(event) {
                var self = this;
                var dni = $(event.target).val();

                if (dni.length === 0) {
                    this.clearParticipantFields();
                    return;
                }

        if (dni.length === 8) {  
            $.ajax({  
                url: 'participant/' + dni,  
                method: 'GET',  
                success: function(response) {
                    console.log("Respuesta completa:", response.data);
                    
                    if (response && response.success) {
                        $('#nombre').val(response.data.nombre);
                        $('#apell').val(response.data.apell);
                        $('#tele').val(response.data.tele);
                        $('#email').val(response.data.email);
                        $('#direc').val(response.data.direc);
                        $('#tip_usu').val(response.data.idgenero);
                        
                        // Verificar si idescuela está presente
                        console.log("¿Tiene idescuela?", response.data.hasOwnProperty('idescuela'));
                        console.log("Valor de idescuela:", response.data.idescuela);
                        
                        if (response.data.idescuela) {
                            console.log("Intentando establecer idescuela:", response.data.idescuela);
                            
                            // Seleccionar manualmente la opción correcta
                            $('#idescuela option').each(function() {
                                if ($(this).val() == response.data.idescuela) {
                                    $(this).prop('selected', true);
                                    console.log("Opción seleccionada:", $(this).text());
                                    return false; // Salir del bucle
                                }
                            });
                            
                            // Forzar la actualización del combo
                            $('#idescuela').trigger('change');
                        } else {
                            console.log("No se encontró idescuela en la respuesta");
                        }
                    } else {
                        limpiarCampos();
                    }
                },  
                error: function(jqXHR, textStatus, errorThrown) {  
                    limpiarCampos();  
                    console.error("Error en la llamada AJAX: " + textStatus + " - " + errorThrown);
                }  
            });  
        } else {  
            limpiarCampos();   
        }  
    });  

    function limpiarCampos() {  
        $('#nombre').val('');  
        $('#apell').val('');  
        $('#tele').val('');  
        $('#email').val('');  
        $('#direc').val('');  
        $('#idescuela').val('');  
    }  
});

// Configuración inicial al cargar la página
$(document).ready(function() {  
    console.log("Iniciando carga de página...");
    
    // Recuperar valores guardados
    const savedEventId = sessionStorage.getItem('selectedEventId');
    if (savedEventId) {
        console.log('Encontrado evento guardado:', savedEventId);
        $('#ideven').val(savedEventId);
        updateSelectedEvent(); // Solo actualizar los textos del evento seleccionado
    }
    
    // Recuperar el término de búsqueda guardado
    const savedSearchTerm = sessionStorage.getItem('searchTerm');
    if (savedSearchTerm && $('#buscarTabla').length) {
        console.log('Encontrado término de búsqueda guardado:', savedSearchTerm);
        $('#buscarTabla').val(savedSearchTerm);
    }
    
    // Configurar eventos de interfaz
    setupEventHandlers();
});

// Configurar manejadores de eventos
function setupEventHandlers() {
    $('#ideven').change(function() {  
        const newEventId = $(this).val();
        console.log('Nuevo evento seleccionado:', newEventId);
        sessionStorage.setItem('selectedEventId', newEventId);
        
        // Recargar la página completa en lugar de actualizar solo la tabla
        window.location.href = window.location.pathname + '?t=' + new Date().getTime();
    });  

    // Para el buscador, también recargar la página completa
    $('#buscarTabla').on('change', function() {  
        const searchTerm = $(this).val();
        console.log('Nuevo término de búsqueda:', searchTerm);
        sessionStorage.setItem('searchTerm', searchTerm);
        
        // Recargar la página completa
        window.location.href = window.location.pathname + '?t=' + new Date().getTime();
    });
    
    // Agregar manejo de eventos para botones de actualizar y eliminar
    $(document).on('click', '.update-btn', function() {
        const id = $(this).data('id');
        console.log('Botón actualizar pulsado para ID:', id);
        // Agregar lógica de actualización aquí
    });
    
    $(document).on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        console.log('Botón eliminar pulsado para ID:', id);
        // Agregar lógica de eliminación aquí
    });
}
//store 



   // Update  
var table;

$(document).ready(function() {
    initializeDataTable([]);
    
   function fetchData() {
    var eventId = $('#ideven').val();
    var searchTerm = $('#buscarTabla').val();
    
    if (!eventId) {
        console.log('No hay evento seleccionado');
        initializeDataTable([]);
        return;
    }
    
    console.log('Filtrando por evento:', eventId, 'Búsqueda:', searchTerm);
    
    $.ajax({
        url: '{{ route('filter.by.event') }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            event_id: eventId,
            searchTerm: searchTerm
        },
        success: function(response) {
            console.log('Respuesta recibida:', response);
            
            if (response.success && response.data) {
                initializeDataTable(response.data);
                console.log(`${response.count} inscripciones cargadas`);
            } else {
                console.warn('Respuesta sin datos');
                initializeDataTable([]);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar datos:', error);
            console.error('Respuesta completa:', xhr.responseText);
            
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudieron cargar los datos. ' + (xhr.responseJSON?.message || error)
            });
            
            initializeDataTable([]);
        }
    });
}

$(document).on('click', '.update-btn', function(e) {
    e.preventDefault();
    e.stopPropagation();
    
    var idincrip = $(this).data('id');
    console.log('Abriendo modal de edición para ID:', idincrip);
    
    //Limpiar handlers previos para evitar duplicados
    $(`#edit${idincrip} form`).off('submit');
    
    // Mostrar modal
    $(`#edit${idincrip}`).modal('show');
    
    // Agregar handler de submit
    $(`#edit${idincrip} form`).on('submit', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var submitButton = form.find('button[type="submit"]');
        
        // Validar que se haya seleccionado una escuela
        var idescuela = form.find('select[name="idescuela"]').val();
        if (!idescuela) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Debe seleccionar una escuela'
            });
            return false;
        }
        
        console.log('Enviando actualización:', {
            idincrip: idincrip,
            dni: form.find('input[name="dni"]').val(),
            idescuela: idescuela
        });
        
        // Deshabilitar botón durante el envío
        submitButton.prop('disabled', true)
            .html('<span class="spinner-border spinner-border-sm me-1"></span>Guardando...');
        
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log('Respuesta exitosa:', response);
                
                // Cerrar modal
                $(`#edit${idincrip}`).modal('hide');
                
                //Recargar datos
                var eventId = $('#ideven').val();
                if (eventId) {
                    console.log('Recargando datos del evento:', eventId);
                    fetchData();
                } else {
                    console.warn('No hay evento seleccionado');
                    location.reload();
                }
                
                // Mostrar mensaje de éxito
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: response.message || 'Registro actualizado correctamente',
                    showConfirmButton: false,
                    timer: 2000
                });
            },
            error: function(xhr) {
                console.error('Error en actualización:', xhr);
                
                var errorMessage = 'No se pudo actualizar el registro';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage
                });
            },
            complete: function() {
                // Restaurar botón
                submitButton.prop('disabled', false)
                    .html('Guardar cambios');
            }
        });
        
        return false;
    });
});

         $('#ideven').change(fetchData);
    
         $('#buscarTabla').on('input', fetchData);
    
        fetchData();
        });

       function initializeDataTable(data) {
        if ($.fn.DataTable.isDataTable('#inscripcionTable')) {
        $('#inscripcionTable').DataTable().destroy();
       }
        $('#inscripcionTable tbody').empty();
         let numeroRegistro = 1;
          data.forEach(function(inscrip) {
        var row = `
            <tr id="row${inscrip.idincrip}">
                <td>${numeroRegistro}</td>
                <td>${inscrip.persona.dni}</td>
                <td>${inscrip.persona.apell} ${inscrip.persona.nombre}</td>
                <td>${inscrip.persona.tele}</td>
                <td>${inscrip.persona.email}</td>
                <td>${inscrip.persona.direc}</td>
                <td>${inscrip.persona.genero.nomgen}</td>
                <td>${inscrip.escuela.nomescu}</td>
                <td>
                    <div class="action-buttons">
                        <button type="button" class="btn btn-warning btn-sm update-btn" data-id="${inscrip.idincrip}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="${inscrip.idincrip}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
           $('#inscripcionTable tbody').append(row);
           numeroRegistro++;
         });
    
           table = $('#inscripcionTable').DataTable({
        "order": [[0, "asc"]],
        "columnDefs": [{
            "targets": 8,
            "orderable": false
        }],
        "language": {
            "search": "",
            "lengthMenu": "Mostrar _MENU_ registros",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "paginate": {
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
        "dom": 'ltrip'
    });
}
//delete
    
//delete

// Función GLOBAL fetchData (debe estar FUERA de document.ready)
function fetchData() {
    var eventId = $('#ideven').val();
    var searchTerm = $('#buscarTabla').val();
    
    if (!eventId) {
        console.log('No hay evento seleccionado');
        initializeDataTable([]);
        return;
    }
    
    console.log('Filtrando por evento:', eventId, 'Búsqueda:', searchTerm);
    
    $.ajax({
        url: '{{ route('filter.by.event') }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            event_id: eventId,
            searchTerm: searchTerm
        },
        success: function(response) {
            console.log('Respuesta recibida:', response);
            
            if (response.success && response.data) {
                initializeDataTable(response.data);
                console.log(` ${response.count} inscripciones cargadas`);
            } else {
                console.warn('Respuesta sin datos');
                initializeDataTable([]);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar datos:', error);
            
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudieron cargar los datos'
            });
            
            initializeDataTable([]);
        }
    });
}
    
// Eliminar persona de TODOS los subeventos del evento
$(document).on('click', '.delete-btn', function(e) {
    e.preventDefault();
    e.stopPropagation();
    
    var row = $(this).closest('tr');
    var idincrip = $(this).data('id');
    
    // Obtener el nombre de la persona de la fila
    var nombrePersona = row.find('td:eq(2)').text();
    var eventName = $('#ideven').find('option:selected').text();
    
    console.log('🗑️ Eliminando persona:', nombrePersona, 'del evento:', eventName);
    
    Swal.fire({
        title: '¿Estás seguro?',
        html: `
            <div style="text-align: center;">
                <p style="font-size: 16px;">Estás a punto de eliminar a:</p>
                <p style="font-size: 18px; font-weight: bold; color: #dc3545; margin: 10px 0;">
                    ${nombrePersona}
                </p>
                <p style="font-size: 14px;">de <strong>TODOS los subeventos</strong> del programa:</p>
                <p style="font-size: 16px; font-weight: bold; color: #0056b3; margin: 10px 0;">
                    ${eventName}
                </p>
                <div style="background-color: #fff3cd; border-radius: 5px; padding: 10px; margin-top: 15px;">
                    <p style="color: #856404; margin: 0;">
                        Esto eliminará las inscripciones
                    </p>
                </div>
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="bi bi-trash-fill"></i> Sí, eliminar',
        cancelButtonText: '<i class="bi bi-x-circle"></i> Cancelar',
        reverseButtons: true,
        focusCancel: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Mostrar loading
            Swal.fire({
                title: 'Eliminando...',
                html: '<div class="spinner-border text-danger" role="status"></div>',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            $.ajax({
                url: 'Rut-inscri/' + idincrip,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log('Eliminación exitosa:', response);
                    
                    if (response.success) {
                        // Cerrar el Swal de loading y mostrar éxito
                        Swal.fire({
                            icon: 'success',
                            title: '¡Eliminado!',
                            html: `<p>${response.message || 'La persona fue eliminada correctamente'}</p>`,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            // DESPUÉS de cerrar el mensaje, recargar datos
                            var eventId = $('#ideven').val();
                            if (eventId) {
                                console.log(' Recargando datos del evento:', eventId);
                                fetchData(); //Llamar a la función GLOBAL
                            } else {
                                console.log('No hay evento, eliminando fila visualmente');
                                row.fadeOut(400, function() {
                                    $(this).remove();
                                });
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'No se pudo eliminar el registro'
                        });
                    }
                },
                error: function(xhr) {
                    console.error(' Error al eliminar:', xhr);
                    
                    var errorMessage = 'No se pudo eliminar el registro';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage
                    });
                }
            });
        }
    });
    
    return false;
});
</script>

</script>


 

<script>
 


</script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        Swal.fire({
            title: '¡Éxito!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'Aceptar'
        });
    @endif

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





@include('Vistas.Footer')