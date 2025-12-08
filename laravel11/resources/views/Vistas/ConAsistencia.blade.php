@include('Vistas.Header')
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" rel="stylesheet">

<style>
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

    .stats-badge {
        font-size: 15px;
        font-weight: 600;
        padding: 8px 14px;
        border-radius: 8px;
        border: 1px solid #198754;
        background-color: rgba(25, 135, 84, 0.07);
        color: #198754;
    }

    .action-btn {
        border-radius: 8px;
        padding: 8px 18px;
        font-weight: 600;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
        transition: 0.2s;
    }

    .action-btn:hover {
        transform: scale(1.02);
    }

    .badge-presente {
        background-color: #198754;
        color: white;
        padding: 5px 12px;
        border-radius: 5px;
        font-weight: 600;
    }

    .badge-ausente {
        background-color: #dc3545;
        color: white;
        padding: 5px 12px;
        border-radius: 5px;
        font-weight: 600;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 30px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #dc3545;
        transition: .4s;
        border-radius: 30px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 22px;
        width: 22px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked+.slider {
        background-color: #198754;
    }

    input:checked+.slider:before {
        transform: translateX(30px);
    }

    .btn-asistencia:hover {
        transform: scale(1.12);
        transition: 0.2s ease-in-out;
    }
</style>

<div class="container mt-3">
    <div class="card border-0 rounded-4 overflow-hidden">
        <div class="card-header bg-primary bg-opacity-90 text-white text-center py-2">
            <h5 class="mb-0 fw-semibold">
                <i class="bi bi-person-check me-2"></i>REGISTRO DE ASISTENCIA
            </h5>
        </div>
        <div class="card-body px-4">
            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label fw-semibold text-secondary">
                        <i class="bi bi-calendar2-event me-1"></i> Evento
                    </label>
                    <select class="form-select rounded-3 border-success border-opacity-50" id="eventoSelectAsistencia">
                        <option value="" selected disabled>Seleccione un evento...</option>
                        @foreach($eventos as $evento)
                        <option value="{{ $evento->idevento }}">{{ $evento->eventnom }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">
                        <i class="bi bi-list-ul me-1"></i> Subevento Activo
                    </label>
                    <input type="text" class="form-control rounded-3 border-success border-opacity-50"
                        id="subevento" placeholder="Seleccione un evento primero..." readonly>
                    <input type="hidden" id="idsubevent">
                </div>
            </div>

            <div class="d-flex justify-content-between mb-2">
                <div class="flex-wrap justify-content-start gap-3">
                    <button class="btn btn-success text-white action-btn" id="btnGuardarAsistencias" disabled>
                        <i class="bi bi-save me-1"></i> Guardar Asistencia
                    </button>
                    <button class="btn btn-danger text-white action-btn" id="btnCulminarSubevento" disabled>
                        <i class="bi bi-check-circle-fill me-1"></i> Culminar Asistencia
                    </button>
                    <button class="btn btn-primary text-white action-btn" id="btnGenerarCertificados" disabled>
                        <i class="bi bi-award-fill me-1"></i> Generar Certificados
                    </button>
                </div>
                <div class="flex-wrap justify-content-start align-items-center mb-3">
                    <div class="d-flex flex-wrap gap-1 media-right">
                        <div class="stats-badge">Inscritos: <span id="totalInscritos">0</span></div>
                        <div class="stats-badge">Presentes: <span id="totalPresentes">0 (0%)</span></div>
                        <div class="stats-badge">Ausentes: <span id="totalAusentes">0 (0%)</span></div>
                    </div>
                </div>
            </div>

            <div class="alert alert-info d-none" id="alertCertificados" role="alert">
                <i class="bi bi-info-circle-fill me-2"></i>
                <strong>Información:</strong> <span id="mensajeCertificados"></span>
            </div>

            <div class="mb-2">
                <h6 class="fw-font-semibold mb-3 font-14 ibox-title">Lista de Participantes</h6>
            </div>
            
            <div class="table-responsive">
                <table class="table align-middle table-hover rounded-3 overflow-hidden" id="tablaAsistencia">
                    <thead class="table-info">
                        <tr>
                            <th class="ps-3" width="50">#</th>
                            <th>DNI</th>
                            <th>Participante</th>
                            <th width="150" class="text-center">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        let tablaAsistencia = null;
        let participantesData = [];

        function inicializarTabla() {
            if (tablaAsistencia) {
                tablaAsistencia.destroy();
                $('#tablaAsistencia tbody').empty();
            }

            tablaAsistencia = $('#tablaAsistencia').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
                    emptyTable: "No hay participantes inscritos",
                    zeroRecords: "No se encontraron participantes"
                },
                pageLength: 25,
                order: [
                    [2, 'asc']
                ],
                drawCallback: function() {
                    console.log('Tabla dibujada con ' + this.api().rows().count() + ' filas');
                }
            });
        }

        function actualizarEstadisticas() {
            const total = participantesData.length;
            const presentes = participantesData.filter(p => p.idtipasis == 1).length;
            const ausentes = participantesData.filter(p => p.idtipasis == 2).length;

            const porcPresentes = total > 0 ? ((presentes / total) * 100).toFixed(1) : 0;
            const porcAusentes = total > 0 ? ((ausentes / total) * 100).toFixed(1) : 0;

            $('#totalInscritos').text(total);
            $('#totalPresentes').text(`${presentes} (${porcPresentes}%)`);
            $('#totalAusentes').text(`${ausentes} (${porcAusentes}%)`);
        }

        $(document).on('click', '.btn-asistencia', function() {
            const idincrip = $(this).data('idincrip');
            let estadoActual = $(this).attr('data-estado'); // "P" o "A"

            const nuevoEstado = estadoActual === 'P' ? 'A' : 'P';
            const nuevoColor = nuevoEstado === 'P' ? 'btn-info' : 'btn-danger';
            const nuevoTipo = nuevoEstado === 'P' ? 1 : 2; // 1 = Presente, 2 = Ausente

            $(this)
                .removeClass('btn-info btn-danger')
                .addClass(nuevoEstado === 'P' ? 'btn-info' : 'btn-danger')
                .text(nuevoEstado)
                .attr('data-estado', nuevoEstado);

            const index = participantesData.findIndex(p => p.idincrip == idincrip);
            if (index !== -1) {
                participantesData[index].idtipasis = nuevoTipo;
            }

            actualizarEstadisticas();
        });

        // Seleccionar evento
        $('#eventoSelectAsistencia').change(function() {
            const idevento = $(this).val();

            if (!idevento) return;

            console.log('Evento seleccionado:', idevento);

            if (tablaAsistencia) {
                tablaAsistencia.clear().draw();
            }
            participantesData = [];
            $('#subevento').val('');
            $('#idsubevent').val('');
            $('#btnGuardarAsistencias').prop('disabled', true);
            $('#btnCulminarSubevento').prop('disabled', true);
            actualizarEstadisticas();

            $.ajax({
                url: '{{ route("asistencia.subeventoActivo") }}',
                method: 'POST',
                data: {
                    idevento: idevento,
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function() {
                    Swal.fire({
                        title: 'Cargando...',
                        text: 'Buscando subevento activo de hoy',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(response) {
                    console.log('Respuesta subevento:', response);

                    if (response.success) {
                        const subevento = response.subevento;
                        const descripcion = `${subevento.Descripcion} - ${subevento.fechsubeve} (${subevento.horini} - ${subevento.horfin})`;

                        $('#subevento').val(descripcion);
                        $('#idsubevent').val(subevento.idsubevent);

                        console.log('Cargando participantes del subevento:', subevento.idsubevent);

                        cargarParticipantes(subevento.idsubevent);
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Sin subeventos hoy',
                            text: response.message,
                            // footer: 'Asegúrese de que hay subeventos programados para la fecha actual'
                        });
                    }
                },
                error: function(xhr) {
                    console.error('Error al obtener subevento:', xhr);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al obtener el subevento activo: ' + (xhr.responseJSON?.message || xhr.statusText)
                    });
                }
            });
        });

        // Cargar participantes
        function cargarParticipantes(idsubevent) {
            $.ajax({
                url: '{{ route("asistencia.participantes") }}',
                method: 'POST',
                data: {
                    idsubevent: idsubevent,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.close();

                    if (response.success) {
                        participantesData = response.participantes;

                        console.log('Participantes recibidos:', participantesData.length);

                        if (tablaAsistencia) {
                            tablaAsistencia.destroy();
                            $('#tablaAsistencia tbody').empty();
                        }

                        tablaAsistencia = $('#tablaAsistencia').DataTable({
                            responsive: true,
                            language: {
                                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
                                emptyTable: "No hay participantes inscritos",
                                zeroRecords: "No se encontraron participantes"
                            },
                            pageLength: 25,
                            order: [
                                [2, 'asc']
                            ],
                            data: [],
                            columns: [{
                                    data: null,
                                    render: function(data, type, row, meta) {
                                        return meta.row + 1;
                                    }
                                },
                                {
                                    data: 'dni'
                                },
                                {
                                    data: null,
                                    render: function(data) {
                                        return `${data.nombre} ${data.apell}`;
                                    }
                                },
                                {
                                    data: null,
                                    render: function(data) {
                                        const esPresente = data.idtipasis == 1;
                                        const letra = esPresente ? 'P' : 'A';
                                        const color = esPresente ? 'info' : 'danger';
                                        return `
                                    <div class="text-center">
                                        <button class="btn btn-${color} btn-asistencia rounded-circle text-white"
                                        style="width:15px; height:15px; font-weight:300; font-size:14px;"
                                        data-idincrip="${data.idincrip}"
                                        data-estado="${letra}">
                                            ${letra}
                                        </button>
                                    </div>
                                    `;
                                    }
                                }
                            ]
                        });

                        tablaAsistencia.rows.add(participantesData).draw();

                        console.log('Filas en la tabla:', tablaAsistencia.rows().count());

                        actualizarEstadisticas();

                        $('#btnGuardarAsistencias').prop('disabled', false);
                        $('#btnCulminarSubevento').prop('disabled', false);

                        Swal.fire({
                            icon: 'success',
                            title: 'Cargado',
                            text: `${participantesData.length} participantes encontrados`,
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Sin participantes',
                            text: response.message || 'No hay participantes inscritos en este subevento'
                        });
                    }
                },
                error: function(xhr) {
                    Swal.close();
                    console.error('Error al cargar participantes:', xhr);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al cargar participantes: ' + (xhr.responseJSON?.message || xhr.statusText)
                    });
                }
            });
        }

        // Guardar asistencias
        $('#btnGuardarAsistencias').click(function() {
            const idsubevent = $('#idsubevent').val();

            if (!idsubevent) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'Seleccione un evento primero'
                });
                return;
            }

            const asistencias = participantesData.map(p => ({
                idincrip: p.idincrip,
                idtipasis: p.idtipasis
            }));

            $.ajax({
                url: '{{ route("asistencia.guardar") }}',
                method: 'POST',
                data: {
                    idsubevent: idsubevent,
                    asistencias: asistencias,
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function() {
                    Swal.fire({
                        title: 'Guardando...',
                        text: 'Por favor espere',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: response.message,
                            timer: 2000
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'Error al guardar asistencias'
                    });
                }
            });
        });

        // Culminar asistencia
        $('#btnCulminarSubevento').click(function() {
            const idsubevent = $('#idsubevent').val();
            const idevento = $('#eventoSelectAsistencia').val();

            if (!idsubevent) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'Seleccione un evento primero'
                });
                return;
            }

            Swal.fire({
                title: '¿Culminar asistencia?',
                text: 'Esta acción marcará la asistencia como finalizada',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, culminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("asistencia.culminar") }}',
                        method: 'POST',
                        data: {
                            idsubevent: idsubevent,
                            _token: '{{ csrf_token() }}'
                        },
                        beforeSend: function() {
                            Swal.fire({
                                title: 'Procesando...',
                                text: 'Por favor espere',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Culminado!',
                                    text: response.message,
                                    timer: 2000
                                }).then(() => {
                                    $('#btnGuardarAsistencias').prop('disabled', true);
                                    $('#btnCulminarSubevento').prop('disabled', true);

                                    verificarEventoCompleto(idevento);
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON?.message || 'Error al culminar asistencia'
                            });
                        }
                    });
                }
            });
        });

        // Verificar si el evento está completo para generar certificados
        function verificarEventoCompleto(idevento) {
            $.ajax({
                url: '{{ route("asistencia.verificarEvento") }}',
                method: 'POST',
                data: {
                    idevento: idevento,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        console.log('Verificación de evento:', response);

                        if (response.eventoCompleto) {
                            $('#btnGenerarCertificados').prop('disabled', false).show();
                            $('#alertCertificados').removeClass('d-none');
                            $('#mensajeCertificados').html(
                                `¡Todos los ${response.totalSubeventos} subeventos han sido culminados! ` +
                                `Ahora puede generar los certificados para los participantes.`
                            );
                        } else {
                            $('#btnGenerarCertificados').prop('disabled', true).show();
                            $('#alertCertificados').removeClass('d-none').addClass('alert-warning').removeClass('alert-info');
                            $('#mensajeCertificados').html(
                                `Faltan ${response.subeventosPendientes} subevento(s) por culminar. ` +
                                `Total: ${response.subeventosCulminados}/${response.totalSubeventos} completados.`
                            );
                        }
                    }
                },
                error: function(xhr) {
                    console.error('Error al verificar evento:', xhr);
                }
            });
        }


        // Listener para detectar cambio de evento en el combo
        $('#eventoSelectAsistencia').on('change', function() {
            const idevento = $(this).val();

            if (!idevento) {
                $('#btnGenerarCertificados').prop('disabled', true).show();
                $('#alertCertificados').addClass('d-none');
                return;
            }
            verificarEventoCompleto(idevento);
        });

        // Generar certificados
        $('#btnGenerarCertificados').click(function() {
            const idevento = $('#eventoSelectAsistencia').val();

            if (!idevento) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'Seleccione un evento primero'
                });
                return;
            }

            Swal.fire({
                title: 'Generar Certificados',
                html: `
                <p>Se generarán certificados para todos los participantes que cumplan el porcentaje mínimo de asistencia.</p>
                <div class="mb-3 text-start">
                    <label for="porcentajeMinimo" class="form-label fw-semibold">Porcentaje mínimo de asistencia:</label>
                    <input type="number" class="form-control" id="porcentajeMinimo" value="65" min="0" max="100">
                    <small class="text-muted">Solo recibirán certificado quienes tengan este porcentaje o más.</small>
                </div>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0d6efd',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Generar Certificados',
                cancelButtonText: 'Cancelar',
                preConfirm: () => {
                    const porcentaje = document.getElementById('porcentajeMinimo').value;
                    if (!porcentaje || porcentaje < 0 || porcentaje > 100) {
                        Swal.showValidationMessage('Ingrese un porcentaje válido entre 0 y 100');
                        return false;
                    }
                    return {
                        porcentaje: porcentaje
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const porcentajeMinimo = result.value.porcentaje;

                    $.ajax({
                        url: '{{ route("asistencia.generarCertificados") }}',
                        method: 'POST',
                        data: {
                            idevento: idevento,
                            porcentaje_minimo: porcentajeMinimo,
                            _token: '{{ csrf_token() }}'
                        },
                        beforeSend: function() {
                            Swal.fire({
                                title: 'Generando certificados...',
                                html: 'Por favor espere mientras se procesan los certificados',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                        },
                        success: function(response) {
                            if (response.success) {
                                let mensajeHtml = `
                                <div class="text-start text-center">
                                    <p><strong>Certificados generados:</strong> ${response.certificadosGenerados}</p>
                                    <p><strong>Total de participantes aptos:</strong> ${response.totalParticipantes}</p>
                            `;

                                if (response.certificadosExistentes > 0) {
                                    mensajeHtml += `<p class="text-warning"><strong>Ya existían:</strong> ${response.certificadosExistentes}</p>`;
                                }

                                if (response.errores && response.errores.length > 0) {
                                    mensajeHtml += `<p class="text-danger"><strong>Errores:</strong></p><ul>`;
                                    response.errores.forEach(error => {
                                        mensajeHtml += `<li class="small">${error}</li>`;
                                    });
                                    mensajeHtml += `</ul>`;
                                }

                                mensajeHtml += `</div>`;

                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Certificados Generados!',
                                    html: mensajeHtml,
                                    confirmButtonText: 'Aceptar',
                                    width: '450px'
                                }).then(() => {
                                    $('#btnGenerarCertificados').prop('disabled', true).show();
                                    $('#alertCertificados').addClass('d-none');
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                html: xhr.responseJSON?.message || 'Error al generar certificados',
                                confirmButtonText: 'Aceptar'
                            });
                        }
                    });
                }
            });
        });

        inicializarTabla();
    });
</script>

@include('Vistas.Footer')