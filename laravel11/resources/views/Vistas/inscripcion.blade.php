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

                <!-- ===== FILTROS SUPERIORES ===== -->
                <div class="row g-2 mb-3">

                    <!-- Selector Evento + Reporte -->
                    <div class="col-lg-6 col-md-6 col-12">
                        <form action="{{ route('reportinscripcionporevento') }}" method="GET">
                            <div class="input-group">
                                <select id="ideven" name="ideven" class="form-select form-control" required>
                                    <option value="" disabled selected>📋 Seleccione un evento</option>
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

                    <!-- Reporte General -->
                    <div class="col-lg-3 col-md-3 col-6">
                        <form action="{{ route('reportinscripcion') }}" method="GET">
                            <button class="btn btn-info w-100">
                                <i class="bi bi-file-earmark-bar-graph"></i> Reporte General
                            </button>
                        </form>
                    </div>

                    <!-- Agregar Participante -->
                    <div class="col-lg-3 col-md-3 col-6">
                        <button class="btn btn-primary w-100 flex-grow-1" data-toggle="modal" data-target="#addEmployeeModal">
                            <i class="bi bi-person-plus-fill"></i> Agregar Participante
                        </button>
                    </div>

                </div>

                <!-- ===== FILTRO POR FECHA ===== -->
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

                <!-- ===== BUSCADOR + LABEL EVENTO ===== -->
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
                            if (response && response.success) {
                                self.fillParticipantFields(response.data);
                            } else {
                                self.clearParticipantFields();
                            }
                        },
                        error: function() {
                            self.clearParticipantFields();
                        }
                    });
                }
            },

            fillParticipantFields: function(data) {
                $('#nombre').val(data.nombre || '');
                $('#apell').val(data.apell || '');
                $('#tele').val(data.tele || '');
                $('#email').val(data.email || '');
                $('#direc').val(data.direc || '');

                if (data.idgenero) {
                    $('select[name="idgenero"]').val(data.idgenero);
                }

                if (data.idescuela) {
                    $('#idescuela').val(data.idescuela).trigger('change');
                }
            },

            clearParticipantFields: function() {
                $('#nombre, #apell, #tele, #email, #direc, #idescuela').val('');
            },

            clearForm: function() {
                $('#employeeForm')[0].reset();
                this.clearParticipantFields();

                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                $('body').css('padding-right', '');
            },

            // ==================== UTILIDADES PARA MODALES ====================
            closeModalSafely: function(modalId) {
                $(modalId).modal('hide');

                setTimeout(function() {
                    $('.modal-backdrop').remove();
                    $('body').removeClass('modal-open');
                    $('body').css('padding-right', '');
                    $('body').css('overflow', '');
                }, 300);
            },

            // ==================== EDICIÓN DE PARTICIPANTE ====================
            handleEdit: function(event) {
                event.preventDefault();
                event.stopPropagation();

                var self = this;
                var idincrip = $(event.currentTarget).data('id');
                var modal = $('#edit' + idincrip);

                modal.find('form').off('submit');

                modal.modal('show');

                modal.find('form').on('submit', function(e) {
                    self.submitEditForm(e, idincrip);
                });
            },

            submitEditForm: function(event, idincrip) {
                event.preventDefault();

                var self = this;
                var form = $(event.target);
                var submitButton = form.find('button[type="submit"]');
                var idescuela = form.find('select[name="idescuela"]').val();

                if (!idescuela) {
                    this.showError('Debe seleccionar una escuela');
                    return false;
                }

                submitButton.prop('disabled', true)
                    .html('<span class="spinner-border spinner-border-sm me-1"></span>Guardando...');

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        self.closeModalSafely('#edit' + idincrip);

                        self.showSuccess(response.message || 'Registro actualizado correctamente');
                        self.fetchData();
                    },
                    error: function(error) {
                        var errorMsg = error.responseJSON && error.responseJSON.message ?
                            error.responseJSON.message :
                            'No se pudo actualizar el registro';
                        self.showError(errorMsg);
                    },
                    complete: function() {
                        submitButton.prop('disabled', false).html('Guardar cambios');
                    }
                });

                return false;
            },

            // ==================== ELIMINACIÓN DE PARTICIPANTE ====================
            handleDelete: function(event) {
                event.preventDefault();
                event.stopPropagation();

                var self = this;
                var row = $(event.currentTarget).closest('tr');
                var idincrip = $(event.currentTarget).data('id');
                var nombrePersona = row.find('td:eq(2)').text();
                var eventName = $('#ideven').find('option:selected').text();

                Swal.fire({
                    title: '¿Estás seguro?',
                    html: this.buildDeleteConfirmationHTML(nombrePersona, eventName),
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then(function(result) {
                    if (result.isConfirmed) {
                        self.deleteParticipant(idincrip, row);
                    }
                });
            },

            buildDeleteConfirmationHTML: function(nombre, evento) {
                return '<div style="text-align: center;">' +
                    '<p style="font-size: 16px;">Estás a punto de eliminar a:</p>' +
                    '<p style="font-size: 18px; font-weight: bold; color: #dc3545; margin: 10px 0;">' +
                    nombre + '</p>' +
                    '<p style="font-size: 14px;">de <strong>TODOS los subeventos</strong> del programa:</p>' +
                    '<p style="font-size: 16px; font-weight: bold; color: #0056b3; margin: 10px 0;">' +
                    evento + '</p></div>';
            },

            deleteParticipant: function(idincrip, row) {
                var self = this;
                this.showLoading('Eliminando...');

                $.ajax({
                    url: 'Rut-inscri/' + idincrip,
                    type: 'DELETE',
                    success: function(response) {
                        if (response.success) {
                            self.showSuccess(response.message || 'La persona fue eliminada correctamente');

                            var eventId = $('#ideven').val();
                            if (eventId) {
                                self.fetchData();
                            } else {
                                row.fadeOut(400, function() {
                                    $(this).remove();
                                });
                            }
                        }
                    },
                    error: function(error) {
                        var errorMsg = error.responseJSON && error.responseJSON.message ?
                            error.responseJSON.message :
                            'No se pudo eliminar el registro';
                        self.showError(errorMsg);
                    }
                });
            },

            // ==================== CARGA DE DATOS ====================
            loadInitialData: function() {
                var eventId = $('#ideven').val();
                if (eventId) {
                    this.fetchData();
                } else {
                    this.initializeDataTable([]);
                }
            },

            fetchData: function() {
                var self = this;
                var eventId = $('#ideven').val();
                var searchTerm = $('#buscarTabla').val();

                if (!eventId) {
                    this.initializeDataTable([]);
                    return;
                }

                $.ajax({
                    url: '{{ route("filter.by.event") }}',
                    type: 'POST',
                    data: {
                        event_id: eventId,
                        searchTerm: searchTerm
                    },
                    success: function(response) {
                        if (response.success && response.data) {
                            self.initializeDataTable(response.data);
                        } else {
                            self.initializeDataTable([]);
                        }
                    },
                    error: function(error) {
                        console.error('Error al cargar datos:', error);
                        self.showError('No se pudieron cargar los datos');
                        self.initializeDataTable([]);
                    }
                });
            },

            // ==================== DATATABLE ====================
            initializeDataTable: function(data) {
                var self = this;

                if (self.dataTable && $.fn.DataTable.isDataTable('#inscripcionTable')) {
                    self.dataTable.destroy();
                    self.dataTable = null;
                }

                var tbody = $('#inscripcionTable tbody');
                tbody.empty();

                if (!Array.isArray(data) || data.length === 0) {
                    tbody.append(
                        '<tr><td colspan="8" class="text-center py-3 text-muted">No hay datos disponibles</td></tr>'
                    );
                    return;
                }

                var fragment = document.createDocumentFragment();

                for (var i = 0; i < data.length; i++) {
                    var inscrip = data[i];
                    if (!inscrip || !inscrip.persona) continue;

                    var tr = self.createTableRow(inscrip, i + 1);
                    fragment.appendChild(tr);
                }

                tbody[0].appendChild(fragment);

                // Inicializar DataTable sin duplicar instancias
                setTimeout(function() {
                    self.dataTable = $('#inscripcionTable').DataTable({
                        order: [
                            [0, "asc"]
                        ],
                        columnDefs: [{
                                targets: 7,
                                orderable: false
                            }
                        ],
                        dom: 'ltrip',
                        pageLength: 10,
                        language: {
                            search: "",
                            lengthMenu: "Mostrar _MENU_ registros",
                            info: "Mostrando _START_ a _END_ de _TOTAL_ inscritos",
                            paginate: {
                                next: "Siguiente",
                                previous: "Anterior"
                            }
                        }
                    });
                }, 0);
            },

            createTableRow: function(inscrip, numero) {
                var tr = document.createElement('tr');
                tr.id = 'row' + inscrip.idincrip;

                tr.innerHTML =
                    '<td>' + numero + '</td>' +
                    '<td>' + inscrip.persona.dni + '</td>' +
                    '<td>' + inscrip.persona.apell + ' ' + inscrip.persona.nombre + '</td>' +
                    '<td>' + inscrip.persona.tele + '</td>' +
                    '<td>' + inscrip.persona.email + '</td>' +
                    '<td>' + (inscrip.persona.genero ? inscrip.persona.genero.nomgen : '-') + '</td>' +
                    '<td>' + (inscrip.escuela ? inscrip.escuela.nomescu : '-') + '</td>' +
                    '<td>' +
                    '<div class="action-buttons">' +
                    '<button type="button" class="btn btn-warning btn-sm update-btn" data-id="' + inscrip.idincrip + '">' +
                    '<i class="bi bi-pencil"></i>' +
                    '</button> ' +
                    '<button type="button" class="btn btn-danger btn-sm delete-btn" data-id="' + inscrip.idincrip + '">' +
                    '<i class="bi bi-trash"></i>' +
                    '</button>' +
                    '</div>' +
                    '</td>';

                return tr;
            },

            showLoading: function(message) {
                message = message || 'Cargando...';
                Swal.fire({
                    title: message,
                    html: '<div class="spinner-custom mx-auto"></div>',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: function() {
                        Swal.showLoading();
                    }
                });
            },

            showSuccess: function(message, timer) {
                timer = timer || 2000;
                return Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: message,
                    timer: timer,
                    showConfirmButton: !timer
                });
            },

            showError: function(message) {
                return Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: message
                });
            },

            showInfo: function(message) {
                return Swal.fire({
                    icon: 'info',
                    title: 'Información',
                    text: message
                });
            },

            showConfirmation: function(message) {
                return Swal.fire({
                    title: 'Confirmación',
                    text: message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, actualizar',
                    cancelButtonText: 'No, cancelar'
                });
            }
        };

        // ==================== INICIALIZACIÓN ====================
        $(document).ready(function() {
            InscripcionManager.init();
            
        });
    </script>
</body>

@include('Vistas.Footer')