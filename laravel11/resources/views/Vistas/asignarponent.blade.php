@include('Vistas.Header')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

    :root {
        --primary: #2563eb;
        --primary-dark: #1e40af;
        --bg-soft: #f8fafc;
        --danger: #dc2626;
    }

    body {
        font-family: 'Roboto', sans-serif;
        background: var(--bg-soft);
        overflow-x: hidden;
    }

    .container {
        max-width: 100%;
        padding: 10px;
    }

    /* CARD */
    .card {
        width: 100%;
        border-radius: 18px;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    /* ===== DATATABLES CONTROLS ALIGN ===== */
    .dataTables_wrapper {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    /* Fila superior */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        display: flex;
        align-items: center;
    }

    /* Contenedor superior */
    .dataTables_wrapper .top,
    .dataTables_wrapper .dataTables_filter {
        width: 100%;
    }

    /* Alinear todo en una sola fila */
    .dataTables_wrapper .dataTables_filter {
        justify-content: flex-end;
    }

    .dataTables_wrapper .dataTables_length {
        justify-content: flex-start;
    }

    /* Inputs */
    .dataTables_wrapper select,
    .dataTables_wrapper input {
        height: 30px;
    }

    /* Buscar */
    .dataTables_wrapper .dataTables_filter label {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Mostrar entradas */
    .dataTables_wrapper .dataTables_length label {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Responsive */
    @media (max-width: 768px) {

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            justify-content: center;
        }
    }


    /* SELECT */
    .form-select {
        border-radius: 10px;
        border: 2px solid var(--primary);
        padding: 10px;
        font-weight: 500;
    }

    .form-select:focus {
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.25);
        border-color: var(--primary-dark);
    }

    /* LAYOUT */
    .main-container {
        display: flex;
        gap: 20px;
    }

    .table-container {
        flex: 1;
        min-width: 0;
    }

    /* TABLA */
    #certificado {
        font-size: 13px;
    }

    table thead {
        background: linear-gradient(135deg, #33446eff, #334a6fff);
    }

    table thead th {
        color: #fff;
        font-weight: 600;
        text-align: center;
    }

    .table tbody tr {
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: #f1f5f9;
        transform: scale(1.002);
    }

    

    /* PANEL */
    .form-panel {
        flex: 0 0 48%;
        background: linear-gradient(180deg, #ffffff, #f8fafc);
        border-radius: 18px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        padding: 25px;
        display: none;
        position: relative;
        max-height: 90vh;
        overflow-y: auto;
        border-left: 6px solid var(--primary);
    }

    .form-panel.active {
        display: block;
        animation: slideIn 0.3s ease;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(25px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .form-panel h4 {
        font-weight: 700;
        color: var(--primary-dark);
        border-bottom: 2px dashed var(--primary);
        padding-bottom: 10px;
    }

    .close-panel {
        position: absolute;
        top: 15px;
        right: 15px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: var(--danger);
        color: white;
        border: none;
        font-size: 18px;
    }

    /* INPUTS */
    .form-control {
        border-radius: 10px;
        /* padding: 10px; */
    }

    /* BOTONES */
    .btn-add-ponente {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: 999px;
        border: none;
        color: white;
        font-weight: 500;
        padding: 12px;
    }

    #btnCancelarEdicion {
        border-radius: 999px;
    }

    /* PONENTES */
    .ponentes-list {
        margin-top: 25px;
    }

    .ponente-item {
        background: white;
        padding: 15px;
        border-radius: 12px;
        border-left: 5px solid var(--primary);
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        transition: all 0.2s ease;
    }

    .ponente-item:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 12px rgba(0, 0, 0, 0.1);
    }

    .btn-edit-ponente,
    .btn-delete-ponente {
        border-radius: 999px;
        padding: 6px 14px;
        font-size: 0.85rem;
        border: none;
        color: white;
    }

    .btn-edit-ponente {
        background: linear-gradient(135deg, #6366f1, #4f46e5);
    }

    .btn-delete-ponente {
        background: linear-gradient(135deg, #f43f5e, #dc2626);
    }

    /* RESPONSIVE */
    @media (max-width: 992px) {
        .main-container {
            flex-direction: column;
        }

        .form-panel {
            max-width: 100%;
        }
    }
</style>


<body>
    <div class="container mt-2">
        <div class="card border-0 rounded-4 overflow-hidden">
            <div class="card-header bg-primary bg-opacity-90 text-white text-center py-2">
                <h5 class="mb-0 fw-bold"></i>ASIGNAR PONENTES
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
                                    <thead>
                                        <tr>
                                            <th>N°</th>
                                            <th>Descripción</th>
                                            <th>Fecha</th>
                                            <th>H. apertura</th>
                                            <th>H. cierre</th>
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
                                    <i class="bi bi-pencil"></i>
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