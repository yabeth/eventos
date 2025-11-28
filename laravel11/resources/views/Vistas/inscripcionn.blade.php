@include('Vistas.Header')

<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.1/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css"> 
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">  
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');

:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    --success-color: #10b981;
    --danger-color: #ef4444;
    --warning-color: #f59e0b;
    --info-gradient: linear-gradient(135deg, #d1e7ff, #eaf8ff);
    --shadow-sm: 0 2px 4px rgba(0,0,0,0.1);
    --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
    --shadow-lg: 0 10px 15px rgba(0,0,0,0.1);
    --border-radius: 12px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

body {
    font-family: 'Roboto', sans-serif;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
}

/* Header Styles */
.page-header {
    background: var(--primary-gradient);
    color: white;
    padding: 2.5rem 0;
    margin-bottom: 2rem;
    border-radius: 0 0 30px 30px;
    box-shadow: var(--shadow-lg);
}

.page-header h1 {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0;
    text-align: center;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
}

/* Card Styles */
.card-custom {
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-md);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    transition: var(--transition);
}

.card-custom:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

/* Button Styles */
.btn-custom {
    border-radius: 8px;
    padding: 0.6rem 1.5rem;
    font-weight: 500;
    transition: var(--transition);
    border: none;
    box-shadow: var(--shadow-sm);
}

.btn-custom:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.btn-gradient-primary {
    background: var(--primary-gradient);
    color: white;
}

.btn-gradient-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
}

.btn-gradient-info {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
}

.btn-gradient-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
}

.btn-gradient-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
}

/* Form Styles */
.form-control-custom {
    border-radius: 8px;
    border: 2px solid #e5e7eb;
    padding: 0.7rem 1rem;
    transition: var(--transition);
}

.form-control-custom:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

/* Table Styles */
.table-custom {
    background: white;
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow-md);
}

.table-custom thead {
    background: var(--primary-gradient);
    color: white;
}

.table-custom thead th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
    padding: 1rem;
}

.table-custom tbody tr {
    transition: var(--transition);
}

.table-custom tbody tr:hover {
    background: #f9fafb;
    transform: scale(1.01);
}

/* Search Bar */
.search-wrapper {
    position: relative;
}

.search-wrapper .form-control {
    padding-left: 2.5rem;
    border-radius: 50px;
    border: 2px solid #e5e7eb;
    transition: var(--transition);
}

.search-wrapper .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.search-wrapper i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
}

/* Modal Styles */
.modal-content-custom {
    border-radius: var(--border-radius);
    border: none;
    box-shadow: var(--shadow-lg);
}

.modal-header-custom {
    background: var(--primary-gradient);
    color: white;
    border-radius: var(--border-radius) var(--border-radius) 0 0;
    padding: 1.5rem;
}

.modal-header-custom .modal-title {
    font-weight: 600;
    font-size: 1.5rem;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
}

.action-buttons .btn {
    padding: 0.4rem 0.8rem;
    border-radius: 6px;
}

/* Alert Box */
.alert-custom {
    border-radius: var(--border-radius);
    border: none;
    box-shadow: var(--shadow-sm);
    padding: 1rem 1.5rem;
}

/* Date Filter Section */
.filter-section {
    background: var(--info-gradient);
    border-radius: var(--border-radius);
    padding: 1.5rem;
    box-shadow: var(--shadow-sm);
    margin-bottom: 1.5rem;
}

/* Event Label */
.event-label {
    background: white;
    padding: 0.8rem 1.5rem;
    border-radius: 50px;
    box-shadow: var(--shadow-sm);
    font-weight: 600;
    color: #667eea;
}

/* Loading Spinner */
.spinner-custom {
    border: 3px solid #f3f4f6;
    border-top: 3px solid #667eea;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Responsive */
@media (max-width: 768px) {
    .page-header h1 {
        font-size: 1.8rem;
    }
    
    .card-custom {
        padding: 1rem;
    }
    
    .action-buttons {
        flex-direction: column;
    }
}
</style>

<body>
    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <h1><i class="bi bi-clipboard-check me-2"></i>Inscripción a Eventos</h1>
        </div>
    </div>

    <div class="container-fluid px-4">
        <!-- Alert Messages -->
        @if(session('error'))
        <div class="alert alert-danger alert-custom">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
        </div>
        @endif

        <!-- Controls Section -->
        <div class="row mb-4">
            <!-- Event Selector & Report -->
            <div class="col-lg-6 mb-3">
                <div class="card-custom">
                    <form action="{{route('reportinscripcionporevento')}}" method="get">
                        <div class="input-group">
                            <select id="ideven" name="ideven" class="form-control form-control-custom" required>
                                <option value="" disabled selected>📋 Seleccione un evento</option> 
                                @foreach ($eventos as $even) 
                                    <option value="{{$even->idevento}}">{{$even->eventnom}}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-gradient-success btn-custom ms-2" type="submit">
                                <i class="bi bi-file-earmark-text me-1"></i>Reporte
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Add Participant & General Report -->
            <div class="col-lg-6 mb-3">
                <div class="d-flex gap-2">
                    <button class="btn btn-gradient-primary btn-custom flex-grow-1" data-toggle="modal" data-target="#addEmployeeModal">
                        <i class="material-icons" style="vertical-align: middle;">add_circle</i>
                        <span class="ms-1">Agregar Participante</span>
                    </button>
                    <form action="{{route('reportinscripcion')}}" method="get" class="flex-grow-1">
                        <button class="btn btn-gradient-info btn-custom w-100">
                            <i class="bi bi-file-earmark-text me-1"></i>Reporte General
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Date Filter Section -->
        <div class="filter-section">
            <form action="{{ route('incritosfecha') }}" method="get" class="row g-3 align-items-end">  
                <div class="col-md-4">  
                    <label for="fecinic" class="form-label fw-bold">
                        <i class="bi bi-calendar-event me-1"></i>Fecha inicio
                    </label>  
                    <input type="date" name="fecinic" class="form-control form-control-custom">  
                </div>  
                <div class="col-md-4">  
                    <label for="fecfin" class="form-label fw-bold">
                        <i class="bi bi-calendar-check me-1"></i>Fecha fin
                    </label>  
                    <input type="date" name="fecfin" class="form-control form-control-custom">  
                </div>  
                <div class="col-md-4">  
                    <button class="btn btn-gradient-success btn-custom w-100">  
                        <i class="bi bi-printer me-1"></i>Reporte por fecha  
                    </button>  
                </div>  
            </form>  
        </div>

        <!-- Search & Event Label -->
        <div class="row mb-4 align-items-center">
            <div class="col-md-8 mb-3">
                <div class="search-wrapper">
                    <i class="bi bi-search"></i>
                    <input type="text" id="buscarTabla" class="form-control" placeholder="Buscar por DNI, nombre, email...">
                </div>
            </div>
            <div class="col-md-4 mb-3 text-end">
                <span class="event-label" id="evenselec">
                    <i class="bi bi-calendar-event me-2"></i>Selecciona un evento
                </span>
            </div>
        </div>

        <!-- Table Section -->
        <div class="table-responsive">
            <table id="inscripcionTable" class="table table-custom table-hover">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>DNI</th>
                        <th>Participante</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Dirección</th>
                        <th>Género</th>
                        <th>Escuela</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dynamic Content -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Participant Modal -->
    <div id="addEmployeeModal" class="modal fade">  
        <div class="modal-dialog modal-lg">  
            <div class="modal-content modal-content-custom">  
                <form id="employeeForm" action="{{ route('Rut.inscri.store') }}" method="post">  
                    @csrf  
                    <div class="modal-header modal-header-custom">  
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
                        <button type="submit" class="btn btn-gradient-success btn-custom">
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
                <div class="modal-header modal-header-custom">
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
                            <button type="submit" class="btn btn-gradient-primary btn-custom">
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
    <div id="delete{{$incrip->idincrip}}" class="modal fade">
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
    </div>
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

        // ==================== INICIALIZACIÓN ====================
        init: function() {
            this.setupAjax();
            this.setupEventListeners();
            this.restoreSessionData();
            this.loadInitialData();
        },

        // ==================== CONFIGURACIÓN ====================
        setupAjax: function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        },

        setupEventListeners: function() {
            var self = this;
            
            // Cambio de evento
            $('#ideven').on('change', function() { self.handleEventChange(); });
            
            // Búsqueda
            $('#buscarTabla').on('input', function() { self.handleSearch(); });
            
            // Formulario de agregar
            $('#employeeForm').on('submit', function(e) { self.handleFormSubmit(e); });
            
            // Búsqueda por DNI
            $('#dni').on('keyup', function(e) { self.searchParticipantByDNI(e); });
            
            // Botones de acción (delegación)
            $(document).on('click', '.update-btn', function(e) { self.handleEdit(e); });
            $(document).on('click', '.delete-btn', function(e) { self.handleDelete(e); });
            
            // Limpiar formulario al cerrar
            $('#addEmployeeModal').on('hidden.bs.modal', function() { self.clearForm(); });
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
            
            // Cerrar modal de forma segura
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
            
            // Asegurar que el backdrop se elimine
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open');
            $('body').css('padding-right', '');
        },

        // ==================== UTILIDADES PARA MODALES ====================
        closeModalSafely: function(modalId) {
            $(modalId).modal('hide');
            
            // Timeout para asegurar que Bootstrap termine su animación
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
            
            // Limpiar handlers previos
            modal.find('form').off('submit');
            
            // Mostrar modal
            modal.modal('show');
            
            // Configurar nuevo handler
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
            
            // Deshabilitar botón
            submitButton.prop('disabled', true)
                .html('<span class="spinner-border spinner-border-sm me-1"></span>Guardando...');
            
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    // Cerrar modal de forma segura
                    self.closeModalSafely('#edit' + idincrip);
                    
                    self.showSuccess(response.message || 'Registro actualizado correctamente');
                    self.fetchData();
                },
                error: function(error) {
                    var errorMsg = error.responseJSON && error.responseJSON.message 
                        ? error.responseJSON.message 
                        : 'No se pudo actualizar el registro';
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
                confirmButtonText: '<i class="bi bi-trash-fill"></i> Sí, eliminar',
                cancelButtonText: '<i class="bi bi-x-circle"></i> Cancelar',
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
                evento + '</p>' +
                '<div style="background-color: #fff3cd; border-radius: 5px; padding: 10px; margin-top: 15px;">' +
                '<p style="color: #856404; margin: 0;">⚠️ Esto eliminará todas sus inscripciones y asistencias</p>' +
                '</div></div>';
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
                            row.fadeOut(400, function() { $(this).remove(); });
                        }
                    }
                },
                error: function(error) {
                    var errorMsg = error.responseJSON && error.responseJSON.message 
                        ? error.responseJSON.message 
                        : 'No se pudo eliminar el registro';
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
            
            // Destruir instancia anterior
            if (this.dataTable) {
                this.dataTable.destroy();
                this.dataTable = null;
            }
            
            // Limpiar tabla
            $('#inscripcionTable tbody').empty();

            if (!Array.isArray(data) || data.length === 0) {
                $('#inscripcionTable tbody').append(
                    '<tr><td colspan="9" class="text-center py-4">No hay datos disponibles</td></tr>'
                );
                return;
            }

            // Construir filas
            var fragment = document.createDocumentFragment();
            
            for (var i = 0; i < data.length; i++) {
                var inscrip = data[i];
                if (!inscrip || !inscrip.persona) continue;
                
                var tr = this.createTableRow(inscrip, i + 1);
                fragment.appendChild(tr);
            }
            
            $('#inscripcionTable tbody')[0].appendChild(fragment);

            // Inicializar DataTable
            setTimeout(function() {
                self.dataTable = $('#inscripcionTable').DataTable({
                    order: [[0, "asc"]],
                    columnDefs: [{ targets: 8, orderable: false }],
                    language: {
                        search: "",
                        lengthMenu: "Mostrar _MENU_ registros",
                        info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                        paginate: {
                            next: "Siguiente",
                            previous: "Anterior"
                        }
                    },
                    dom: 'ltrip',
                    pageLength: 10
                });
            }, 0);
        },

        createTableRow: function(inscrip, numero) {
            var tr = document.createElement('tr');
            tr.id = 'row' + inscrip.idincrip;
            
            tr.innerHTML = '<td>' + numero + '</td>' +
                '<td>' + inscrip.persona.dni + '</td>' +
                '<td>' + inscrip.persona.apell + ' ' + inscrip.persona.nombre + '</td>' +
                '<td>' + inscrip.persona.tele + '</td>' +
                '<td>' + inscrip.persona.email + '</td>' +
                '<td>' + inscrip.persona.direc + '</td>' +
                '<td>' + inscrip.persona.genero.nomgen + '</td>' +
                '<td>' + inscrip.escuela.nomescu + '</td>' +
                '<td>' +
                    '<div class="action-buttons">' +
                        '<button type="button" class="btn btn-warning btn-sm update-btn" data-id="' + inscrip.idincrip + '">' +
                            '<i class="bi bi-pencil"></i>' +
                        '</button>' +
                        '<button type="button" class="btn btn-danger btn-sm delete-btn" data-id="' + inscrip.idincrip + '">' +
                            '<i class="bi bi-trash"></i>' +
                        '</button>' +
                    '</div>' +
                '</td>';
            
            return tr;
        },

        // ==================== ALERTAS ====================
        showLoading: function(message) {
            message = message || 'Cargando...';
            Swal.fire({
                title: message,
                html: '<div class="spinner-custom mx-auto"></div>',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: function() { Swal.showLoading(); }
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
        
        // Mensajes de sesión
        @if(session('success'))
            Swal.fire({
                title: '¡Éxito!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'Aceptar',
                timer: 3000
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
</body>

@include('Vistas.Footer')