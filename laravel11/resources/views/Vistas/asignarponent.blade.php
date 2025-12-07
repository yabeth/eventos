@include('Vistas.Header')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

    body {
        overflow-x: hidden;
    }

    .container {
        max-width: 100%;
        padding: 5px 0;
    }

    .card {
        width: 100%;
        margin-bottom: 5px;
        background-color: #ffffff;
        border-radius: 10px;
        border: 1px solid #e9e9e9;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
    }

    #certificado {
        font-size: 13px;
    }

    .select-container {
        margin-bottom: 15px;
        width: 100%;
    }

    .form-select {
        width: 100%;
        padding: 10px 30px 10px 12px;
        font-size: 15px;
        border: 2px solid #587affff;
        border-radius: 5px;
        background-color: white;
        appearance: none;
        /* background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2317a2b8' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e"); */
        /* background-repeat: no-repeat; */
        background-position: right 12px center;
        background-size: 16px 12px;
        cursor: pointer;
    }

    .form-select:focus {
        outline: none;
        border-color: #138496;
        box-shadow: 0 0 0 0.25rem rgba(23, 162, 184, 0.25);
    }

    .form-label {
        color: #2c3e50;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .dataTables_wrapper .dataTables_filter input {
        border: 2px solid #17a2b8 !important;
        border-radius: 6px !important;
        padding: 8px 12px !important;
        margin-left: 8px !important;
        min-width: 250px !important;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        outline: none !important;
        border-color: #138496 !important;
        box-shadow: 0 0 0 0.25rem rgba(23, 162, 184, 0.25) !important;
    }

    .main-container {
        display: flex;
        gap: 20px;
        transition: all 0.3s ease;
        max-width: 100%;
        overflow-x: hidden;
    }

    .table-container {
        flex: 1;
        transition: all 0.3s ease;
        min-width: 0;
    }

    .table-container.shrink {
        flex: 0 0 50%;
        max-width: 50%;
    }

    .form-panel {
        flex: 0 0 48%;
        max-width: 48%;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        padding: 25px;
        display: none;
        animation: slideIn 0.3s ease;
        overflow-y: auto;
        max-height: 90vh;
        position: relative;
    }

    .form-panel.active {
        display: block;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(20px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .form-panel h4 {
        color: #2c3e50;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 3px solid #3160faff;
        font-weight: 600;
    }

    .form-group label {
        font-weight: 500;
        color: #34495e;
        margin-bottom: 5px;
    }

    .form-control {
        border-radius: 5px;
        border: 1px solid #dce4ec;
        padding: 10px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #17a2b8;
        box-shadow: 0 0 0 0.2rem rgba(23, 162, 184, 0.25);
    }

    .btn-add-ponente {
        background: #17a2b8;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-add-ponente:hover {
        background: #138496;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(23, 162, 184, 0.4);
    }

    .ponentes-list {
        margin-top: 25px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .ponente-item {
        background: white;
        padding: 15px;
        margin-bottom: 10px;
        border-radius: 5px;
        border-left: 4px solid #17a2b8;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease;
    }

    .ponente-item:hover {
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        transform: translateX(5px);
    }

    .ponente-info {
        flex: 1;
    }

    .ponente-name {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 5px;
    }

    .ponente-details {
        font-size: 0.9em;
        color: #7f8c8d;
    }

    .btn-delete-ponente {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-delete-ponente:hover {
        transform: scale(1.05);
        box-shadow: 0 3px 10px rgba(245, 87, 108, 0.4);
    }

    .btn-primary {
        background: #17a2b8;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: #138496;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(23, 162, 184, 0.4);
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

    .badge-ponente {
        background: #17a2b8;
        padding: 5px 10px;
        border-radius: 15px;
        color: white;
        font-size: 0.85em;
        margin-left: 10px;
    }

    .close-panel {
        position: absolute;
        top: 15px;
        right: 15px;
        background: #e74c3c;
        color: white;
        border: none;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 18px;
        line-height: 1;
        transition: all 0.3s ease;
        z-index: 10;
    }

    .close-panel:hover {
        transform: rotate(90deg);
        background: #c0392b;
    }

    .table-responsive {
        overflow-x: auto;
    }


    /* Botón de editar ponente */
    .btn-edit-ponente {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.9em;
    }

    .btn-edit-ponente:hover {
        transform: scale(1.05);
        box-shadow: 0 3px 10px rgba(102, 126, 234, 0.4);
    }

    .ponente-item>div:last-child {
        display: flex;
        gap: 10px;
    }

    .me-2 {
        margin-right: 0.5rem;
    }

    #btnCancelarEdicion {
        background: #6c757d;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    #btnCancelarEdicion:hover {
        background: #5a6268;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(108, 117, 125, 0.4);
    }
</style>


<body>
    <div class="container mt-2">
        <div class="card border-0 rounded-4 overflow-hidden">
            <div class="card-header bg-primary bg-opacity-90 text-white text-center py-2">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-person-check me-2"></i>ASIGNAR PONENTES
                </h5>
            </div>
            <div class="card-body px-4">
                <div class="row mb-3">
                    <div class="col-12 col-md-8 col-lg-6">
                        <label for="ideven" class="fw-bold">Seleccione un evento:</label>
                        <select id="ideven" name="ideven" class="form-select" required>
                            <option value="">-- Seleccione un evento --</option>
                            @foreach ($eventos as $even)
                            <option value="{{$even->idevento}}">{{$even->eventnom}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="main-container">
                    <!-- Tabla de certificados -->
                    <div class="table-container" id="tableContainer">
                        <div class="card shadow">
                            <div class="card-header text-dark">
                                <h5 class="mb-0 fw-bold">Lista de certificados</h5>
                            </div>
                            <div class="table-responsive">
                                <table id="certificado" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th>N°</th>
                                            <th>Descripción</th>
                                            <th>Fecha</th>
                                            <th>Hora de apertura</th>
                                            <th>Hora de cierre</th>
                                            <th>Modalidad</th>
                                            <th>Espacio</th>
                                            <th>Ponentes</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Panel lateral para gestionar ponentes -->
                    <div class="form-panel" id="formPanel">
                        <button class="close-panel" id="closePanel">&times;</button>

                        <h4><i class="bi bi-person-plus-fill"></i> Gestionar Ponentes</h4>

                        <div class="alert alert-info">
                            <strong>Evento:</strong> <span id="eventoDescripcion">-</span>
                        </div>

                        <form id="formPonente">
                            <input type="hidden" id="idsubevent" name="idsubevent">

                            <div class="form-group mb-3">
                                <label for="dni">DNI / Documento *</label>
                                <input type="text" class="form-control" id="dni" name="dni"
                                    placeholder="Ingrese DNI" maxlength="8" required>
                                <small class="text-muted">El sistema autocompletará al ingresar 8 dígitos</small>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="nombre">Nombres *</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre"
                                            placeholder="Nombre completos" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="apell">Apellidos *</label>
                                        <input type="text" class="form-control" id="apell" name="apell"
                                            placeholder="Apellidos completos" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="tele">Teléfono</label>
                                        <input type="tel" class="form-control" id="tele" name="tele"
                                            placeholder="999 999 999" maxlength="9">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="genero">Género <span class="required text-danger px-1">*</span></label>
                                        <select id="genero" name="idgenero" class="form-control" required>
                                            <option value="" disabled selected>Seleccione un género</option>
                                            @foreach ($generos as $gen)
                                            <option value="{{ $gen->idgenero }}">{{ $gen->nomgen }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="email">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="correo@ejemplo.com" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="direc">Dirección</label>
                                    <textarea class="form-control" id="direc" name="direc"
                                        rows="2" placeholder="Dirección completa"></textarea>
                                </div>

                                <button type="submit" class="btn btn-add-ponente w-100">
                                    <i class="bi bi-plus-circle"></i> Agregar Ponente
                                </button>
                                <button type="button" id="btnCancelarEdicion" class="btn btn-secondary w-100 mt-2" style="display:none;">
                                    <i class="bi bi-x-circle"></i> Cancelar Edición
                                </button>
                        </form>

                        <!-- Lista de ponentes agregados -->
                        <div class="ponentes-list" id="ponentesList">
                            <h5 class="mb-3"><i class="bi bi-list-check"></i> Ponentes Registrados</h5>
                            <div id="ponentesItems">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/facultad.js"></script>
    <script>
        $(document).ready(function() {
            // Inicializar DataTable
            const table = $('#certificado').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
                },
                responsive: true
            });

            // FILTRAR TABLA POR EVENTO SELECCIONADO
            $('#ideven').on('change', function() {
                const eventoId = $(this).val();

                if (eventoId) {
                    Swal.fire({
                        title: 'Cargando...',
                        text: 'Filtrando ponentes del evento',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    $.ajax({
                        url: "{{ route('ponentes.filtrar') }}",
                        method: "GET",
                        data: {
                            idevento: eventoId
                        },
                        success: function(response) {
                            table.clear();

                            if (response.subeventos && response.subeventos.length > 0) {
                                response.subeventos.forEach((sub, index) => {
                                    let lista = "";

                                    if (sub.asignarponentes && sub.asignarponentes.length > 0) {
                                        sub.asignarponentes.forEach((asig, i) => {
                                            lista += `${i + 1}. ${asig.persona.apell} ${asig.persona.nombre}<br>`;
                                        });
                                    } else {
                                        lista = `<span class="text-muted">Sin ponentes asignados</span>`;
                                    }

                                    table.row.add([
                                        index + 1,
                                        sub.Descripcion,
                                        sub.fechsubeve,
                                        sub.horini,
                                        sub.horfin,
                                        sub.canal.modalidad.modalidad,
                                        sub.canal.canal,
                                        lista,
                                        `<button type="button" class="btn btn-primary px-3 btn-open-panel"
                                    data-idsubevent="${sub.idsubevent}"
                                    data-descripcion="${sub.Descripcion}">
                                    <i class="bi bi-people-fill"></i> Ponentes
                                </button>`
                                    ]);
                                });

                                table.draw();
                                Swal.close();

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Filtrado exitoso',
                                    text: `Se encontraron ${response.subeventos.length} subeventos`,
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            } else {
                                table.draw();
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Sin resultados',
                                    text: 'No hay subeventos registrados para este evento'
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'No se pudo cargar la información'
                            });
                        }
                    });
                }
            });

            // Abrir panel lateral
            $(document).on('click', '.btn-open-panel', function() {
                const idsubevent = $(this).data('idsubevent');
                const descripcion = $(this).data('descripcion');

                $('#idsubevent').val(idsubevent);
                $('#eventoDescripcion').text(descripcion);

                $('#formPanel').addClass('active');
                $('#tableContainer').addClass('shrink');

                // Limpiar modo edición
                $('#formPonente')[0].reset();
                $('#formPonente').removeData('editing').removeData('idasig-ponente');
                $('#formPonente h4').html('<i class="bi bi-person-plus-fill"></i> Gestionar Ponentes');
                $('#btnCancelarEdicion').hide();

                cargarPonentesExistentes(idsubevent);
            });

            // Función para cargar ponentes existentes
            function cargarPonentesExistentes(idsubevent) {
                $.ajax({
                    url: "{{ route('ponentes.cargar') }}",
                    method: 'GET',
                    data: {
                        idsubevent: idsubevent
                    },
                    success: function(response) {
                        $('#ponentesItems').empty();

                        if (response.ponentes && response.ponentes.length > 0) {
                            response.ponentes.forEach(function(ponente) {
                                const item = `<div class="ponente-item" data-idasig="${ponente.idasig}">
                            <div class="ponente-info">
                                <div class="ponente-name">${ponente.apell} ${ponente.nombre}</div>
                                <div class="ponente-details">
                                    <i class="bi bi-person-badge"></i> DNI: ${ponente.dni} | 
                                    <i class="bi bi-envelope"></i> ${ponente.email} | 
                                    <i class="bi bi-telephone"></i> ${ponente.tele || 'N/A'}
                                </div>
                            </div>
                            <div>
                                <button type="button" class="btn-edit-ponente me-2" 
                                    data-idasig="${ponente.idasig}"
                                    data-dni="${ponente.dni}"
                                    data-nombre="${ponente.nombre}"
                                    data-apell="${ponente.apell}"
                                    data-tele="${ponente.tele || ''}"
                                    data-email="${ponente.email}"
                                    data-genero="${ponente.idgenero}"
                                    data-direc="${ponente.direc || ''}">
                                    <i class="bi bi-pencil"></i> Editar
                                </button>
                                <button type="button" class="btn-delete-ponente" 
                                    data-idasig="${ponente.idasig}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>`;

                                $('#ponentesItems').append(item);
                            });
                        } else {
                            $('#ponentesItems').html('<p class="text-center text-muted">No hay ponentes registrados</p>');
                        }
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr);
                        $('#ponentesItems').html('<p class="text-center text-danger">Error al cargar ponentes</p>');
                    }
                });
            }

            // Cerrar panel lateral
            $('#closePanel').on('click', function() {
                $('#formPanel').removeClass('active');
                $('#tableContainer').removeClass('shrink');
                $('#formPonente')[0].reset();
                $('#formPonente').removeData('editing').removeData('idasig-ponente');
                $('#formPonente h4').html('<i class="bi bi-person-plus-fill"></i> Gestionar Ponentes');
                $('#btnCancelarEdicion').hide();
            });

            // Solo números en DNI y búsqueda automática
            $('#dni').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');

                if (this.value.length === 8) {
                    buscarPorDNI(this.value);
                } else if (this.value.length < 8) {
                    $('#nombre, #apell, #tele, #email, #genero, #direc').val('');
                }
            });

            // Solo números en teléfono
            $('#tele').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            // Función para buscar por DNI
            function buscarPorDNI(dni) {
                $.ajax({
                    url: "{{ route('persona.buscar.dni') }}",
                    method: 'GET',
                    data: {
                        dni: dni
                    },
                    success: function(response) {
                        if (response.encontrado) {
                            $('#nombre').val(response.nombre);
                            $('#apell').val(response.apell);
                            $('#tele').val(response.tele);
                            $('#email').val(response.email);
                            $('#genero').val(response.idgenero);
                            $('#direc').val(response.direc);

                            Swal.fire({
                                icon: 'info',
                                title: 'Persona encontrada',
                                text: 'Datos cargados automáticamente',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }
                    }
                });
            }

            // Agregar o actualizar ponente
            $('#formPonente').on('submit', function(e) {
                e.preventDefault();

                const isEditing = $('#formPonente').data('editing');
                const idasigPonente = $('#formPonente').data('idasig-ponente');

                const formData = {
                    idsubevent: $('#idsubevent').val(),
                    idasig: isEditing ? idasigPonente : null,
                    dni: $('#dni').val(),
                    nombre: $('#nombre').val(),
                    apell: $('#apell').val(),
                    tele: $('#tele').val(),
                    email: $('#email').val(),
                    genero: $('#genero').val(),
                    direc: $('#direc').val(),
                    _token: '{{ csrf_token() }}'
                };

                const url = isEditing ?
                    "{{ route('ponentes.actualizar') }}" :
                    "{{ route('ponentes.agregar') }}";

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: isEditing ? '¡Ponente actualizado!' : '¡Ponente agregado!',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        });

                        $('#formPonente')[0].reset();
                        $('#formPonente').removeData('editing').removeData('idasig-ponente');
                        $('#formPonente h4').html('<i class="bi bi-person-plus-fill"></i> Gestionar Ponentes');
                        $('#btnCancelarEdicion').hide();

                        cargarPonentesExistentes($('#idsubevent').val());

                        // Recargar la tabla si hay un evento seleccionado
                        const eventoId = $('#ideven').val();
                        if (eventoId) {
                            $('#ideven').trigger('change');
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = 'No se pudo procesar la solicitud';

                        if (xhr.responseJSON) {
                            if (xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            } else if (xhr.responseJSON.errors) {
                                const errors = xhr.responseJSON.errors;
                                errorMsg = Object.values(errors).flat().join('<br>');
                            }
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            html: errorMsg
                        });
                    }
                });
            });

            // Editar ponente
            $(document).on('click', '.btn-edit-ponente', function() {
                const btn = $(this);

                // Cargar datos en el formulario
                $('#dni').val(btn.data('dni'));
                $('#nombre').val(btn.data('nombre'));
                $('#apell').val(btn.data('apell'));
                $('#tele').val(btn.data('tele'));
                $('#email').val(btn.data('email'));
                $('#genero').val(btn.data('genero'));
                $('#direc').val(btn.data('direc'));

                // Marcar como edición
                $('#formPonente').data('editing', true);
                $('#formPonente').data('idasig-ponente', btn.data('idasig'));
                $('#formPonente h4').html('<i class="bi bi-pencil-fill"></i> Editar Ponente');

                // Cambiar texto del botón submit y mostrar cancelar
                $('.btn-add-ponente').html('<i class="bi bi-check-circle"></i> Actualizar Ponente');
                $('#btnCancelarEdicion').show();

                // Scroll al formulario
                $('#formPonente')[0].scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });

                Swal.fire({
                    icon: 'info',
                    title: 'Modo edición',
                    text: 'Modifique los datos y presione "Actualizar Ponente"',
                    timer: 2000,
                    showConfirmButton: false
                });
            });

            // Cancelar edición
            $(document).on('click', '#btnCancelarEdicion', function() {
                $('#formPonente')[0].reset();
                $('#formPonente').removeData('editing').removeData('idasig-ponente');
                $('#formPonente h4').html('<i class="bi bi-person-plus-fill"></i> Gestionar Ponentes');
                $('.btn-add-ponente').html('<i class="bi bi-plus-circle"></i> Agregar Ponente');
                $('#btnCancelarEdicion').hide();
            });

            // Eliminar ponente
            $(document).on('click', '.btn-delete-ponente', function() {
                const idasig = $(this).data('idasig');
                const item = $(this).closest('.ponente-item');

                Swal.fire({
                    title: '¿Está seguro?',
                    text: "¿Desea eliminar este ponente del evento?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('ponentes.eliminar') }}",
                            method: 'DELETE',
                            data: {
                                idasig: idasig,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                item.fadeOut(300, function() {
                                    $(this).remove();

                                    if ($('#ponentesItems .ponente-item').length === 0) {
                                        $('#ponentesItems').html('<p class="text-center text-muted">No hay ponentes registrados</p>');
                                    }
                                });

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Eliminado',
                                    text: 'El ponente ha sido eliminado',
                                    timer: 1500,
                                    showConfirmButton: false
                                });

                                const eventoId = $('#ideven').val();
                                if (eventoId) {
                                    $('#ideven').trigger('change');
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr.responseJSON?.message || 'No se pudo eliminar el ponente'
                                });
                            }
                        });
                    }
                });
            });
        });

        // Mensajes de sesión
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
    </script>
    @include('Vistas.Footer')