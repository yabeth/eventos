@include('Vistas.Header')
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.1/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"> -->
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->

<meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.1);
        --border-radius: 12px;
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
        box-shadow: var(--shadow-sm);
    }

    .form-label {
        color: #0d6efd;
        font-weight: 600;
    }

    #inscripcionTable {
        font-size: 12px;
    }

    .dataTables_wrapper .row {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .dataTables_wrapper .row:first-child {
        justify-content: space-between;
    }

    .dataTables_wrapper .row:last-child {
        justify-content: space-between;
        margin-top: 15px;
    }

    .dataTables_wrapper .dataTables_length {
        display: flex;
        align-items: center;
        margin: 0;
        padding: 0;
    }

    .dataTables_wrapper .dataTables_length label {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
        font-weight: 500;
        white-space: nowrap;
    }

    .dataTables_wrapper .dataTables_length select {
        width: 70px !important;
        display: inline-block;
        padding: 5px 10px;
        margin: 0 5px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .dataTables_wrapper .dataTables_filter {
        display: flex;
        align-items: center;
        margin: 0;
        padding: 0;
        text-align: right;
    }

    .dataTables_wrapper .dataTables_filter label {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
        font-weight: 500;
        white-space: nowrap;
    }

    .dataTables_wrapper .dataTables_filter input {
        width: 250px !important;
        display: inline-block;
        padding: 5px 10px;
        margin: 0;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .dataTables_wrapper .dataTables_info {
        padding: 0;
        margin: 0;
        font-size: 14px;
        color: #666;
    }

    .dataTables_wrapper .dataTables_paginate {
        padding: 0;
        margin: 0;
    }

    .dataTables_wrapper .col-sm-6,
    .dataTables_wrapper .col-sm-5,
    .dataTables_wrapper .col-sm-7,
    .dataTables_wrapper .col-sm-12 {
        padding: 0;
    }

    .table-container {
        overflow-x: auto;
    }

    /* Prevenir múltiples backdrops */
    .modal-backdrop {
        z-index: 1040 !important;
    }

    .modal {
        z-index: 1050 !important;
    }

    .swal2-container {
        z-index: 10000 !important;
    }
</style>

<body>
    <div class="container mt-2">
        <div class="card">
            <div class="card-header bg-primary text-white text-center">
                <h5 class="card-title mb-0">GESTIÓN DE INSCRIPCIÓN</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-9">
                        <div class="d-flex gap-3 align-items-center mb-3">
                            <label for="ideven" class="form-label mb-0">Evento:</label>
                            <select id="ideven" name="ideven" class="form-control" required>
                                <option value="" disabled selected>Seleccione una opción</option>
                                @foreach ($eventos as $even)
                                <option value="{{$even->idevento}}">{{$even->eventnom}}</option>
                                @endforeach
                            </select>

                            <button class="btn btn-success" data-toggle="modal" data-target="#addEmployeeModal">
                                <i class="material-icons"></i> <span>Agregar participante</span>
                            </button>
                        </div>

                        <div class="d-flex gap-2 mb-3">
                            <input type="text" disabled id="evenselec" class="form-control" placeholder="Evento seleccionado" value="">
                            <div class="col-md-3">
                                <button class="btn btn-info w-100">
                                    <i class="bi bi-file-earmark-text"></i> Reporte general
                                </button>
                            </div>
                        </div>

                        <div class="input-group">
                            <label for="buscarTabla" class="form-label mb-0 me-2 align-self-center">Buscar:</label>
                            <input type="text" id="buscarTabla" class="form-control" placeholder="Buscar...">
                            <button class="btn btn-outline-secondary" id="botonBuscar" type="button">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <form action="" method="get" class="row g-3">
                            <div class="col-12">
                                <label for="fecinic" class="form-label fw-bold">
                                    <i class="bi bi-calendar-event me-1"></i> Fecha inicio
                                </label>
                                <input type="date" name="fecinic" class="form-control">
                            </div>
                            <div class="col-12">
                                <label for="fecfin" class="form-label fw-bold">
                                    <i class="bi bi-calendar-check me-1"></i> Fecha fin
                                </label>
                                <input type="date" name="fecfin" class="form-control">
                            </div>
                            <div class="col-12">
                                <button class="btn btn-info w-100">
                                    <i class="bi bi-printer me-1"></i> Reporte por fecha
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-12 border-bottom mb-3"></div>

                <!-- Tabla de inscritos -->
                <div class="table-container">
                    <h6 class="mb-3">Lista de Inscritos</h6>
                    <div class="table-responsive">
                        <table id="inscripcionTable" class="table table-striped table-bordered table-hover">
                            <thead class="table-info">
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
                                <!-- Datos dinámicos -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Agregar Participante -->
    <div id="addEmployeeModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="employeeForm" action="{{ route('Rut.inscri.store') }}" method="post">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h4 class="modal-title">Agregar nuevo participante</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="dni" class="fw-bold">DNI <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="dni" name="dni" required>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="nombre" class="fw-bold">Nombres <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="email" class="fw-bold">Correo electrónico <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="tip_usu" class="fw-bold">Género <span class="text-danger">*</span></label>
                                        <select id="tip_usu" name="idgenero" class="form-control" required>
                                            <option value="">-- Seleccione el genero --</option>
                                            @foreach ($generos as $gen)
                                            <option value="{{ $gen->idgenero }}">{{ $gen->nomgen }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="apell" class="fw-bold">Apellidos <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="apell" name="apell" required>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="tele" class="fw-bold">Teléfono <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="tele" name="tele" required>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="direc" class="fw-bold">Dirección <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="direc" name="direc" required>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="escuela" class="fw-bold">Escuela <span class="text-danger">*</span></label>
                                        <select id="idescuela" name="idescuela" class="form-control" required>
                                            <option value="">-- Seleccione la escuela --</option>
                                            @foreach ($escuelas as $escu)
                                            <option value="{{ $escu->idescuela }}">{{ $escu->nomescu }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="hidden" id="idevento" name="idevento" value="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Participante -->
    @foreach ($inscripciones as $incrip)
    <div class="modal fade" id="edit{{$incrip->idincrip}}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Editar participante</h5>
                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('Rut.inscri.update', $incrip->idincrip) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="dni" class="form-label">DNI</label>
                                    <input type="text" class="form-control" name="dni" value="{{ $incrip->persona->dni }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombres</label>
                                    <input type="text" class="form-control" name="nombre" value="{{ $incrip->persona->nombre }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="correo" class="form-label">Correo electrónico</label>
                                    <input type="email" class="form-control" name="email" value="{{ $incrip->persona->email }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tip_usu" class="form-label">Género</label>
                                    <select name="idgenero" class="form-control" required>
                                        @foreach ($generos as $gen)
                                        <option value="{{$gen->idgenero}}" {{ $gen->idgenero == $incrip->persona->genero->idgenero ? 'selected' : '' }}>
                                            {{$gen->nomgen}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="apell" class="form-label">Apellidos</label>
                                    <input type="text" class="form-control" name="apell" value="{{ $incrip->persona->apell }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="telef" class="form-label">Teléfono</label>
                                    <input type="text" class="form-control" name="tele" value="{{ $incrip->persona->tele }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="direc" class="form-label">Dirección</label>
                                    <input type="text" class="form-control" name="direc" value="{{ $incrip->persona->direc }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="idescuela" class="form-label">Escuela</label>
                                    <select name="idescuela" class="form-control" required>
                                        @foreach ($escuelas as $escu)
                                        <option value="{{$escu->idescuela}}" {{ $escu->idescuela == $incrip->idescuela ? 'selected' : '' }}>
                                            {{$escu->nomescu}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Evento</label>
                                    <input type="text" class="form-control" value="{{ $incrip->subevento->evento->eventnom ?? 'Sin evento' }}" readonly style="background-color: #e9ecef;">
                                    <small class="text-muted">El evento no puede ser modificado</small>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach


    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let dataTable = null;
        let isProcessing = false;

        function updateSelectedEvent() {
            const selectedEventId = $('#ideven').val();
            const selectedEventText = $('#ideven').find('option:selected').text();
            $('#evenselec').val(selectedEventText || 'Seleccione un evento');
            $('#idevento').val(selectedEventId);
        }

        function fetchData() {
            const eventId = $('#ideven').val();
            const searchTerm = $('#buscarTabla').val();

            if (!eventId) {
                initializeDataTable([]);
                return;
            }

            $.ajax({
                url: '{{ route("filter.by.event") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    event_id: eventId,
                    searchTerm: searchTerm
                },
                success: function(response) {
                    if (response.success && response.data) {
                        initializeDataTable(response.data);
                    } else {
                        initializeDataTable([]);
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudieron cargar los datos. ' + (xhr.responseJSON?.message || error)
                    });
                    initializeDataTable([]);
                }
            });
        }

        function limpiarCampos() {
            $('#nombre, #apell, #tele, #email, #direc').val('');
            $('#idescuela, #tip_usu').val('');
        }

        $(document).ready(function() {
            initializeDataTable([]);

            const savedEventId = sessionStorage.getItem('selectedEventId');
            if (savedEventId) {
                $('#ideven').val(savedEventId);
                updateSelectedEvent();
                fetchData();
            }

            $('#ideven').on('change', function() {
                const newEventId = $(this).val();
                if (!newEventId) {
                    initializeDataTable([]);
                    return;
                }
                sessionStorage.setItem('selectedEventId', newEventId);
                updateSelectedEvent();
                fetchData();
            });

            $('#buscarTabla').on('keyup', function() {
                if (dataTable) dataTable.search($(this).val()).draw();
            });

            $('#buscarTabla').on('keypress', function(e) {
                if (e.which === 13) {
                    e.preventDefault();
                    if (dataTable) dataTable.search($(this).val()).draw();
                }
            });

            $('#botonBuscar').on('click', function() {
                if (dataTable) dataTable.search($('#buscarTabla').val()).draw();
            });

            $('#dni').on('keyup', function() {
                const dni = $(this).val();
                if (dni.length === 0) {
                    limpiarCampos();
                    return;
                }
                if (dni.length === 8) {
                    $.ajax({
                        url: 'participant/' + dni,
                        method: 'GET',
                        success: function(response) {
                            if (response && response.success) {
                                $('#nombre').val(response.data.nombre);
                                $('#apell').val(response.data.apell);
                                $('#tele').val(response.data.tele);
                                $('#email').val(response.data.email);
                                $('#direc').val(response.data.direc);
                                $('#tip_usu').val(response.data.idgenero);
                                if (response.data.idescuela) {
                                    $('#idescuela').val(response.data.idescuela).trigger('change');
                                }
                            } else {
                                limpiarCampos();
                            }
                        },
                        error: function() {
                            limpiarCampos();
                        }
                    });
                } else {
                    limpiarCampos();
                }
            });

            $('#addEmployeeModal').on('hidden.bs.modal', function() {
                const form = $(this).find('form')[0];
                if (form) form.reset();
                limpiarCampos();
            });
        });

        function initializeDataTable(data) {
            if ($.fn.DataTable.isDataTable('#inscripcionTable')) {
                $('#inscripcionTable').DataTable().clear().destroy();
            }

            $('#inscripcionTable tbody').empty();

            if (!Array.isArray(data) || data.length === 0) {
                $('#inscripcionTable tbody').append('<tr><td colspan="9" class="text-center">No hay datos disponibles</td></tr>');
                return;
            }

            const fragment = document.createDocumentFragment();
            let numeroRegistro = 1;

            data.forEach((inscrip) => {
                if (!inscrip || !inscrip.persona) return;

                const tr = document.createElement('tr');
                tr.id = 'row' + inscrip.idincrip;
                tr.innerHTML = `
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
                </td>`;
                fragment.appendChild(tr);
                numeroRegistro++;
            });

            $('#inscripcionTable tbody')[0].appendChild(fragment);

            dataTable = $('#inscripcionTable').DataTable({
                order: [
                    [0, "asc"]
                ],
                columnDefs: [{
                    targets: 8,
                    orderable: false
                }],
                language: {
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ registros",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    infoEmpty: "Mostrando 0 a 0 de 0 registros",
                    infoFiltered: "(filtrado de _MAX_ registros totales)",
                    zeroRecords: "No se encontraron resultados",
                    emptyTable: "No hay datos disponibles",
                    paginate: {
                        next: "Siguiente",
                        previous: "Anterior"
                    }
                },
                pageLength: 10,
                destroy: true,
                responsive: true,
                autoWidth: false
            });
        }

        // ACTUALIZAR
        $(document).on('click', '.update-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const idincrip = $(this).data('id');
            const modalSelector = `#edit${idincrip}`;

            $(`${modalSelector} form`).off('submit');
            $(modalSelector).modal('show');

            $(`${modalSelector} form`).on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
                const submitButton = form.find('button[type="submit"]');
                const idescuela = form.find('select[name="idescuela"]').val();

                if (!idescuela) {
                    Swal.fire('Error', 'Debe seleccionar una escuela', 'error');
                    return false;
                }

                submitButton.prop('disabled', true)
                    .html('<span class="spinner-border spinner-border-sm"></span> Guardando...');

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        $(modalSelector).modal('hide');
                        $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open').css('padding-right', '');

                        fetchData();

                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: response.message || 'Actualizado correctamente',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr) {
                        Swal.fire('Error', xhr.responseJSON?.message || 'No se pudo actualizar', 'error');
                    },
                    complete: function() {
                        submitButton.prop('disabled', false).html('Guardar cambios');
                    }
                });

                return false;
            });
        });

        // AGREGAR NUEVO PARTICIPANTE
        document.getElementById('employeeForm').addEventListener('submit', function(e) {
            e.preventDefault();

            if (isProcessing) return;
            isProcessing = true;

            const form = this;
            const formData = new FormData(form);
            const selectedEventId = $('#ideven').val();

            Swal.fire({
                title: 'Cargando...',
                text: 'Procesando solicitud...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) throw new Error('Error en la respuesta del servidor');
                    return response.json();
                })
                .then(data => {
                    if (data.showAlert) {
                        Swal.close();
                        return Swal.fire({
                            title: 'Confirmación',
                            text: "Esta persona está registrada en otra escuela. ¿Desea actualizar la inscripción?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Sí, actualizar',
                            cancelButtonText: 'Cancelar'
                        }).then(result => {
                            if (result.isConfirmed) {
                                Swal.fire({
                                    title: 'Actualizando...',
                                    allowOutsideClick: false,
                                    didOpen: () => Swal.showLoading()
                                });
                                const updateFormData = new FormData(form);
                                updateFormData.append('decision', 'S');
                                return fetch(form.action, {
                                        method: 'POST',
                                        body: updateFormData
                                    })
                                    .then(response => response.json())
                                    .then(data => ({
                                        title: '¡Éxito!',
                                        text: data.message || 'Actualizado correctamente',
                                        icon: 'success'
                                    }));
                            }
                            return {
                                title: 'Cancelado',
                                text: 'La inscripción se mantiene sin cambios',
                                icon: 'info'
                            };
                        });
                    }
                    return {
                        title: '¡Éxito!',
                        text: data.message || 'Registrado correctamente',
                        icon: 'success'
                    };
                })
                .then(alertConfig => {
                    Swal.close();
                    return Swal.fire({
                        ...alertConfig,
                        timer: alertConfig.icon === 'success' ? 2000 : undefined,
                        showConfirmButton: alertConfig.icon !== 'success'
                    });
                })
                .then(() => {
                    $('#addEmployeeModal').modal('hide');
                    $('.modal-backdrop').remove();
                    $('body').removeClass('modal-open').css('padding-right', '');
                    form.reset();
                    limpiarCampos();
                    sessionStorage.setItem('selectedEventId', selectedEventId);
                    location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.close();
                    $('.modal-backdrop').remove();
                    $('body').removeClass('modal-open').css('padding-right', '');
                    Swal.fire('Error', 'Problema al procesar: ' + error.message, 'error');
                })
                .finally(() => {
                    isProcessing = false;
                });
        });

        // ELIMINAR
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const row = $(this).closest('tr');
            const idincrip = $(this).data('id');
            const nombrePersona = row.find('td:eq(2)').text();
            const eventName = $('#ideven').find('option:selected').text();

            Swal.fire({
                title: '¿Estás seguro?',
                html: `
            <div style="text-align: center;">
                <p style="font-size: 16px;">Eliminarás a:</p>
                <p style="font-size: 18px; font-weight: bold; color: #dc3545; margin: 10px 0;">
                    ${nombrePersona}
                </p>
                <p style="font-size: 14px;">de <strong>TODOS los subeventos</strong> del programa:</p>
                <p style="font-size: 16px; font-weight: bold; color: #0056b3; margin: 10px 0;">
                    ${eventName}
                </p>
            </div>
        `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bi bi-trash-fill"></i> Sí, eliminar',
                cancelButtonText: '<i class="bi bi-x-circle"></i> Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Eliminando...',
                        html: '<div class="spinner-border text-danger" role="status"></div>',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => Swal.showLoading()
                    });

                    $.ajax({
                        url: 'Rut-inscri/' + idincrip,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Eliminado!',
                                    text: response.message || 'Eliminado correctamente',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    fetchData();
                                });
                            } else {
                                Swal.fire('Error', response.message || 'No se pudo eliminar', 'error');
                            }
                        },
                        error: function(xhr) {
                            const errorMessage = xhr.responseJSON?.message || 'No se pudo eliminar';
                            Swal.fire('Error', errorMessage, 'error');
                        }
                    });
                }
            });
        });
    </script>



    @include('Vistas.Footer')