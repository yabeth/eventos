@include('Vistas.Header')
<meta name="csrf-token" content="{{csrf_token()}}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.1/font/bootstrap-icons.min.css">
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

    h1 {
        font-size: 9vw;
        margin-top: 20px;
        font-weight: 600;
        font-size: 18px;
        text-align: center;

        background: linear-gradient(45deg, #000000, #1c1c1c, #383838,
                #545454, #707070, #888888, #a9a9a9,
                #d3d3d3);
        font-family: 'Roboto', sans-serif;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-fill-color: transparent;

    }

    .linea {
        border: none;
        height: 0.8px;
        background-color: #888;
        width: 100%;
        margin-top: 10px;
        margin-bottom: 20px;
    }

    .hidden-display {
        display: none;
    }

    .container {
        max-width: 100%;
        padding: 5px 5px 5px 5px;
    }

    .card {
        width: 100%;
    }





    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

    .table-container {
        width: 100%;
        overflow: auto;
    }

    table {
        border: 1px solid grey;
        overflow-x: auto;
        display: block;
    }


    th {
        padding: 30px;
        background: #666;
    }

    td {
        padding: 30px;
        background: #999;
    }


    h1 {
        font-size: 9vw;

        margin-top: 20px;
        font-weight: 600;
        font-size: 18px;
        text-align: center;

        background: linear-gradient(45deg,
                #000000,
                #1c1c1c,
                #383838,
                #545454,
                #707070,
                #888888,
                #a9a9a9,
                #d3d3d3);

        .table-responsive {
            overflow-x: auto;
            white-space: nowrap;
        }


        font-family: 'Roboto',
        sans-serif;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-fill-color: transparent;

    }

    .linea {
        border: none;
        height: 0.8px;
        background-color: #888;
        width: 100%;
        margin-top: 10px;
        margin-bottom: 20px;
    }
</style>

<body>
    <!-- <h1 class="text-center mt-4">Certificados de eventos</h1>
<hr class="linea mb-4"> -->

    <div class="container mt-2">
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white text-center">
                <h5 class="mb-0">Gestión de certificados</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="ideven" class="form-label">Eventos</label>
                        <select id="ideven" name="ideven" class="form-select" required>
                            <option value="" disabled selected>Seleccione una opción</option>
                            @foreach ($eventos as $even)
                            <option value="{{$even->idevento}}">{{$even->eventnom}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="obser" class="form-label">Descripción</label>
                        <textarea name="obser" id="obser" rows="2" class="form-control" placeholder="Ingrese una descripción"></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8 d-flex align-items-center">
                        <button id="guardarcertifi" type="button" class="btn btn-success me-2">
                            <i class="bi bi-save"></i> Guardar descripción
                        </button>
                        <button href="#generarCertificados" class="btn btn-warning me-2" data-toggle="modal">
                            <i class="bi bi-plus-circle"></i> Generar n° de certificados
                        </button>
                        <form action="{{route('reportcertificado')}}" method="get" class="me-2">
                            <button class="btn btn-success">
                                <i class="bi bi-file-earmark-text"></i> Reporte
                            </button>
                        </form>
                        <form id="culminarCertifiForm" data-url-template="{{ route('Rut.reso.culeven', ['idevento' => ':idevento']) }}" class="d-inline">
                            @csrf
                            <button type="button" id="culminarCertifi" class="btn btn-primary">
                                Culminar certificación
                            </button>
                        </form>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="input-group">
                            <input type="text" id="buscar" class="form-control" placeholder="Buscar Participante">
                            <button id="btnBuscar" class="btn btn-outline-secondary" type="button">
                                <i class="bi bi-search"></i> Buscar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Lista de certificados</h5>
            </div>
            <div class="card-body">
                <table id="certificado" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>N°</th>
                            <th>DNI</th>
                            <th>N° de certificado</th>
                            <th>Participante</th>
                            <th>Teléfono</th>
                            <th>Correo electrónico</th>
                            <th>Estado</th>
                            <th>Insertar Número de certificado</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal para ingresar el número de certificado -->
    <div class="modal fade" id="modalCertificado" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="formCertificado" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCertificadoLabel">Ingresar Número de Certificado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="numeroCertificado">Número de Certificado</label>
                            <input type="text" class="form-control" id="numeroCertificado" name="nro" placeholder="Ingrese el número de certificado">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="guardarCertificado">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para ingresar el número de certificado -->
    <div class="modal fade" id="generarCertificados" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="formCertifico" action="{{route('certificadonum.numcer')}}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCertif">Ingresar Número de Certificado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group mt-3">
                            <label for="selected-event">Evento seleccionado:</label>
                            <label id="eventoo" name="eventoo" class="display-5 text-primary ml-3"></label>
                        </div>

                        <div class="form-group">
                            <label>Caracter</label>
                            <input type="text" class="form-control" step="1" name="carac" require>

                        </div>
                        <div class="form-container" style="display: flex; gap: 10px;">
                            <div class="form-group">
                                <label>Desde</label>
                                <input type="number" name="desde" class="form-control" min="1" step="1" value="1" required>
                            </div>
                            <div class="form-group">
                                <label>Hasta</label>
                                <input type="number" name="hasta" class="form-control" min="1" step="1" value="1" required>
                            </div>
                        </div>
                        <input type="hidden" id="idevento" name="idevento" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success" name="save">Generar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        .dataTables_length {
            float: right;
            margin-right: 10px;
        }

        .dataTables_length label {
            display: flex;
            align-items: center;
        }
    </style>


    @if(session()->has('success'))
    <script>
        Swal.fire({
            title: '¡Éxito!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'Aceptar'
        });
    </script>
    @endif

    @if(session()->has('error'))
    <script>
        Swal.fire({
            title: 'Error',
            text: "{{ session('error') }}",
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    </script>
    @endif


    <script>
        $(document).ready(function() {
            var selectedEventId;

            $('#ideven').on('change', function() {
                selectedEventId = $(this).val();
                if (selectedEventId) {
                    loadCertificados(selectedEventId);
                } else {
                    $('#certificado tbody').html('<tr><td colspan="8" class="text-center">Seleccione un evento para mostrar participantes.</td></tr>');
                }
            });

            let searchTimeout;

            $('#buscar').on('input', function() {
                clearTimeout(searchTimeout);
                const searchTerm = $(this).val().trim();

                searchTimeout = setTimeout(() => {
                    if (searchTerm === '') {
                        if (selectedEventId) {
                            loadCertificados(selectedEventId);
                        } else {
                            $('#certificado tbody').html('<tr><td colspan="8" class="text-center">Seleccione un evento para mostrar participantes.</td></tr>');
                        }
                    } else {
                        searchCertificados(searchTerm, null);
                    }
                }, 300);
            });

            function loadCertificados(eventId) {
                $.ajax({
                    url: 'filter-by-eve',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        event_id: eventId
                    },
                    success: function(certificados) {
                        if ($.fn.DataTable.isDataTable('#certificado')) {
                            $('#certificado').DataTable().destroy();
                        }

                        $('#certificado tbody').empty();
                        let numeroCertificado = 1;

                        $.each(certificados, function(index, certificado) {
                            var persona = certificado.asistencia.inscripcion.persona;
                            var certi = certificado;


                            var estadoText = certi.idestcer == 2 ? 'Entregado' : 'Pendiente';
                            var estadoClass = certi.idestcer == 2 ? 'btn-success' : 'btn-warning';

                            var row = `  
                        <tr>  
                            <td>${numeroCertificado}</td>  
                            <td>${persona.dni}</td>  
                            <td>${certi.nro || 'No asignado'}</td>  
                            <td>${persona.apell} ${persona.nombre}</td>  
                            <td>${persona.tele}</td>  
                            <td>${persona.email}</td>  
                            <td>  
                                <button class="btn btn-xs ${estadoClass} cambiar-estado" data-id="${certi.idCertif}" data-estado="${certi.idestcer}">  
                                    ${estadoText}  
                                </button>  
                            </td>  
                            <td>  
                                <button class="btn btn-xs btn-primary ingresar-numero" data-id="${certi.idCertif}">  
                                    Ingresar N° de certificado  
                                </button>  
                            </td>  
                        </tr>`;

                            $('#certificado tbody').append(row);
                            numeroCertificado++;
                        });

                        $('#certificado').DataTable({
                            responsive: true,
                            language: {
                                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                            }
                        });

                        bindButtonEvents();
                    },
                    error: function(xhr, status, error) {
                        console.error("Error al cargar certificados:", xhr.responseText);
                    }
                });
            }

            function searchCertificados(searchTerm, eventId) {
                $.ajax({
                    url: 'buscar/certi',
                    type: 'GET',
                    data: {
                        search: searchTerm,
                        event_id: eventId
                    },
                    success: function(response) {
                        // Agregar la columna de "Eventos" si no existe
                        if (!$('#certificado th:contains("Evento")').length) {
                            $('#certificado thead tr').append('<th>Evento</th>');
                        }

                        // Actualizar el contenido de la tabla
                        $('#certificado tbody').html(response);
                        bindButtonEvents();
                    },
                    error: function(xhr) {
                        console.error("Error en la búsqueda:", xhr.responseText);
                        $('#certificado tbody').html('No se encontraron resultados para la búsqueda.');
                    }
                });
            }



            $(document).ready(function() {
                $('#ideven').change(function() {
                    // Obtener el ID seleccionado
                    let eventoId = $(this).val();
                    console.log(`ID del evento seleccionado: ${eventoId}`);

                    let requestUrl = `event/${eventoId}`;
                    console.log(`URL de solicitud: ${requestUrl}`);

                    if (eventoId) {
                        $.ajax({
                            url: requestUrl,
                            method: 'GET',
                            success: function(data) {
                                console.log("Respuesta del servidor:", data);

                                // Asegurarte de que data.obser contiene el valor esperado
                                if (data.obser !== undefined) {
                                    $('#obser').val(data.obser);
                                } else {
                                    $('#obser').val('');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error("Error:", error);
                                console.log("Código de estado:", xhr.status);
                                console.log("Respuesta completa:", xhr.responseText);
                                console.log(`URL de solicitud: ${requestUrl}`); // Ver URL completa en consola
                                alert("Ocurrió un error al obtener la descripción.");
                            }
                        });
                    } else {
                        $('#obser').val('');
                    }
                });
            });



            function bindButtonEvents() {
                $('.cambiar-estado').off('click').on('click', function() {
                    var button = $(this);
                    var certificadoId = button.data('id');
                    var estadoActual = button.data('estado');
                    var nuevoEstado = estadoActual == 2 ? 3 : 2;
                    var nuevoEstadoTexto = nuevoEstado == 2 ? 'Entregado' : 'Pendiente';

                    Swal.fire({
                        title: `¿Estás seguro de que quieres cambiar el estado a ${nuevoEstadoTexto}?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, cambiar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: `Rut-certi/updat/${certificadoId}`,
                                type: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    idestcer: estadoActual
                                },
                                success: function(response) {
                                    Swal.fire({
                                        title: 'Éxito',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    });

                                    var nuevoEstado = estadoActual == 2 ? 3 : 2;
                                    var nuevoEstadoTexto = nuevoEstado == 2 ? 'Entregado' : 'Pendiente';
                                    button.data('estado', nuevoEstado);
                                    button.text(nuevoEstadoTexto);
                                    button.removeClass('btn-success btn-warning').addClass(nuevoEstado == 2 ? 'btn-success' : 'btn-warning');
                                },
                                error: function(xhr) {
                                    console.error("Error al cambiar el estado:", xhr.responseText);
                                }
                            });
                        }
                    });
                });

                $('.ingresar-numero').off('click').on('click', function() {
                    var certificadoId = $(this).data('id');

                    if ($('#modalCertificado').length) {
                        $('#modalCertificado').modal('show');
                    } else {
                        console.error('Modal no encontrado en el DOM');
                        return;
                    }
                    $('#numeroCertificado').val('');

                    $('#guardarCertificado').off('click').on('click', function() {
                        var newCertNumber = $('#numeroCertificado').val(); // Verifica que se obtiene correctamente

                        if (!newCertNumber) {
                            alert("Por favor ingresa un número de certificado.");
                            return; // Evitar enviar si está vacío
                        }




                        $.ajax({
                            url: `Rut-certi/update/${certificadoId}`,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                nro: newCertNumber // Este valor debe ser correcto
                            },
                            success: function(response) {
                                if (response.message) {
                                    // Si el servidor devuelve un mensaje claro en caso de éxito
                                    Swal.fire({
                                        title: 'Éxito',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    });
                                    $('#modalCertificado').modal('hide');
                                    loadCertificados(selectedEventId);
                                } else {
                                    // Si no hay un mensaje de éxito, consideramos que hubo un error inesperado
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'No se recibió una respuesta válida del servidor.',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            },
                            error: function(xhr) {
                                // Aquí manejamos los errores devueltos por el servidor
                                let errorMessage = 'Hubo un problema al actualizar el certificado.';

                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    // Si el servidor envía un mensaje de error claro
                                    errorMessage = xhr.responseJSON.message;
                                } else if (xhr.responseText) {
                                    // Si no hay un mensaje claro, mostrar el contenido del error crudo (opcional)
                                    console.error("Respuesta del servidor:", xhr.responseText);
                                }

                                Swal.fire({
                                    title: 'Error',
                                    text: errorMessage,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });



                    });

                });
            }
        });

        $(document).ready(function() {
            function updateSelectedEvent() {
                var selectedEventId = $('#ideven').val();
                var selectedEventText = $('#ideven').find('option:selected').text();
                $('#eventoo').text(selectedEventText || 'Ninguno');
                $('#evenselec').text(selectedEventText || 'Ninguno');
                $('#idevento').val(selectedEventId);
            }

            $('#ideven').on('change', function() {
                updateSelectedEvent();
            });

            updateSelectedEvent();


            $('#addEmployeeModal').on('submit', function() {
                var selectedEventId = $('#ideven').val();
                $('#idevento').val(selectedEventId);
            });
        });

        $(document).ready(function() {
            $('#culminarCertifi').on('click', function(e) {
                e.preventDefault();

                var eventoId = $('#ideven').val();

                if (eventoId) {
                    var form = $('#culminarCertifiForm');
                    var url = form.data('url-template').replace(':idevento', eventoId);

                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "¿Quieres culminar la certificación?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, culminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: url,
                                type: 'PUT',
                                data: {
                                    _token: $('meta[name="csrf-token"]').attr('content'),
                                    _method: 'PUT'
                                },
                                success: function(response) {
                                    Swal.fire('Éxito', response.message, 'success');
                                    console.log("Respuesta del servidor:", response);
                                    // Aquí puedes agregar código para actualizar la UI
                                },
                                error: function(xhr, status, error) {
                                    var errorMessage = '';
                                    if (xhr.responseJSON && xhr.responseJSON.error) {
                                        errorMessage = xhr.responseJSON.error;
                                    } else {
                                        errorMessage = 'Error desconocido al culminar el evento: ' + error;
                                    }
                                    console.error("Error completo:", xhr.responseText);
                                    Swal.fire('Error', errorMessage, 'error');
                                }
                            });
                        }
                    });
                } else {
                    Swal.fire('Error', 'Por favor, selecciona un evento antes de continuar.', 'error');
                }
            });
        });


        $(document).ready(function() {
            $('#guardarcertifi').on('click', function() {
                var obser = $('textarea[name="obser"]').val();
                var eventoId = $('#ideven').val();

                $.ajax({
                    url: `certificado/updateCertificacion/${eventoId}`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        obser: obser
                    },
                    success: function(response) {
                        Swal.fire({
                            title: '¡Actualización exitosa!',
                            text: 'Se actualizó correctamente.',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        });


                    },
                    error: function(xhr, status, error) {
                        console.error("Error al actualizar la certificación:", xhr.responseText);
                        alert("Error al actualizar la certificación. Por favor, inténtalo de nuevo.");
                    }
                });
            });
        });
    </script>
    @include('Vistas.Footer')