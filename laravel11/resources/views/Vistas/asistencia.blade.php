
@include('Vistas.Header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" href="https://www.flaticon.es/iconos-gratis/enlace"> 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
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

background: linear-gradient(
  45deg,
  #000000,
  #1c1c1c,
  #383838,  
  #545454,  
  #707070,  
  #888888,  
  #a9a9a9,  
  #d3d3d3  
);


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
    .custom-select {
        width: 1000px; /* Cambia este valor al tamaño que desees */
    }

    </style>
<body>
<h1>Registro de asistencias</h1>
<hr class="linea">
    <div class="container">
        <div class="table-wrapper">
            <div class="table-title">
            <div class="container mt-3">
            <div class="row align-items-center mb-3">
    <div class="col-sm-12"> <!-- Cambiar el tamaño a col-sm-8 para más ancho -->
        <label class="label-inline">Evento</label>
        <form action="{{ route('reportasistencia') }}" method="get">
            <div class="input-group">
                <select id="ideven" name="ideven" class="form-control" required>
                    <option value="" disabled selected>Seleccione una opción</option>    
                    @foreach ($eventos as $even)
                        <option value="{{ $even->idevento }}">{{ $even->eventnom }}</option>
                    @endforeach
                </select>
                <button class="btn btn-primary ml-2" name="btnr" id="btnr">
                    <i class="bi bi-file-earmark-text"></i> Reporte
                </button>
            </div>
        </form>
    </div>
</div>
<div>
    <br>
@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif
</div>


        <div class="row align-items-center justify-content-end">
    <div class="col-sm-3 text-right">
        <form id="culminarCertifiForm" data-url-template="{{ route('Rut.asist.cambioestad', ['idevento' => ':idevento']) }}">
            @csrf
            <button type="button" id="culminarCertifi" class="btn btn-primary">Validar asistencia</button>
        </form>
    </div>

    <div class="col-sm-3 text-right">
        <button id="saveAllButton" type="button" class="btn btn-success">
            <i class="material-icons"></i> <span>GUARDAR REGISTRO</span>
        </button>
    </div>

    <div class="col-sm-3 text-right">
        <span class="badge badge-success">Presentes: <span id="count-present">0</span> (<span id="percent-present">0%</span>)</span>
        <span class="badge badge-danger">Ausentes: <span id="count-absent">0</span> (<span id="percent-absent">0%</span>)</span>
    </div>
</div>

        </div>
        <br>
        <br>

        <table id="asisTable" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
            <thead class="bg-dark text-white">
                <tr>
                    <th>N°</th>
                    <th>Participante</th>
                    <th style="width: 90px;">Acción</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí van los datos de los participantes -->
            </tbody>
        </table>
        <br>
    </div>
</div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
$(document).ready(function() {
    var changedAttendances = {};

   /* function updateCounters() {
        var presentCount = $('#asisTable .btn-success').length;
        var absentCount = $('#asisTable .btn-danger').length;
        var totalCount = presentCount + absentCount;
        
        var presentPercentage = totalCount > 0 ? (presentCount / totalCount * 100).toFixed(2) : 0;
        var absentPercentage = totalCount > 0 ? (absentCount / totalCount * 100).toFixed(2) : 0;

        $('#count-present').text(presentCount);
        $('#percent-present').text(presentPercentage + '%');
        $('#count-absent').text(absentCount);
        $('#percent-absent').text(absentPercentage + '%');
    }
*/

function updateCounters() {
    var table = $('#asisTable').DataTable();

    var allRows = table.rows().nodes();

    var presentCount = $(allRows).find('.btn-success').length;
    var absentCount = $(allRows).find('.btn-danger').length;
    var totalCount = presentCount + absentCount;

    var presentPercentage = totalCount > 0 ? (presentCount / totalCount * 100).toFixed(2) : 0;
    var absentPercentage = totalCount > 0 ? (absentCount / totalCount * 100).toFixed(2) : 0;

    $('#count-present').text(presentCount);
    $('#percent-present').text(presentPercentage + '%');
    $('#count-absent').text(absentCount);
    $('#percent-absent').text(absentPercentage + '%');
}




    // Inicializar DataTable
    var table = $('#asisTable').DataTable({
        "order": [[0, "asc"]],
        "columnDefs": [
            {
                "targets": 1,
                "orderable": false
            }
        ],
        "language": {
            "search": "Buscar: ",
            "lengthMenu": "Mostrar _MENU_ registros",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "paginate": {
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
            "initComplete": function() {
                $('.dataTables_filter input').css('width', '300px');
            }
    });


    // Evento para manejar el cambio en el select de eventos
    $('#ideven').change(function() {
        var eventId = $(this).val();
        $.ajax({
            url: 'filter-by-even',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                event_id: eventId
            },
            success: function(data) {
                table.clear();
                let numeroRegistro = 1;  
                $.each(data, function(index, asistencia) {
                    var buttonClass = asistencia.tipoasiste.idtipasis == 1 ? 'btn-success' : 'btn-danger';
                    var buttonText = asistencia.tipoasiste.idtipasis == 1 ? 'P' : 'A';
                    var row = [
                        `${numeroRegistro}`,
                        `${asistencia.inscripcion.persona.apell} ${asistencia.inscripcion.persona.nombre}`,
                        `<button class="btn btn-toggle ${buttonClass}" data-idasistnc="${asistencia.idasistnc}" type="button">
                            <span class="attendance-icon">${buttonText}</span>
                        </button>`
                    ];
                    table.row.add(row).draw();
                    numeroRegistro++; 
                });

                updateCounters();
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error al cargar las asistencias. Por favor, inténtelo nuevamente.', // Mensaje de error
                    confirmButtonText: 'OK'
                });
            }
        });
    });

    $(document).on('click', '.btn-toggle', function(e) {
        e.preventDefault(); 
        var $button = $(this);
        var idasistnc = $button.data('idasistnc');

        if ($button.hasClass('btn-success')) {
            $button.removeClass('btn-success').addClass('btn-danger');
            $button.find('.attendance-icon').text('A');
        } else {
            $button.removeClass('btn-danger').addClass('btn-success');
            $button.find('.attendance-icon').text('P');
        }
        changedAttendances[idasistnc] = $button.hasClass('btn-success') ? 1 : 2;

        updateCounters();
    });

    $('#saveAllButton').click(function() {
        if (Object.keys(changedAttendances).length === 0) {
            Swal.fire({
                icon: 'info',
                title: 'No hay cambios para guardar',
                text: 'Por favor, realice algún cambio antes de guardar.',
                confirmButtonText: 'OK'
            });
            return;
        }

        $.ajax({
            url: '{{ route("Rut.asistenc.updateMultiple") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                attendances: changedAttendances
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: 'Asistencias actualizadas correctamente.',
                    confirmButtonText: 'OK'
                });
                changedAttendances = {};
            },
            error: function(xhr, status, error) {
                console.error('Error al guardar las asistencias:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error al guardar las asistencias. Por favor, inténtelo nuevamente.',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
});



// function searchTable() {
//     var query = $('#search-input').val(); 
//     $.ajax({
//         url: "{{ route('buscar.asistencia') }}", 
//         type: 'GET',
//         data: {
//             search: query 
//         },
//         success: function(data) {
//             $('tbody').html(data); 
//         },
//         error: function(xhr, status, error) {
//             console.error("Error en la búsqueda:", error); 
//         }
//     });
// }



$(document).ready(function () {  
    function updateSelectedEvent() {  
        var selectedEventId = $('#ideven').val();
        var selectedEventText = $('#ideven').find('option:selected').text();  
        $('#eventoo').text(selectedEventText || 'Ninguno');  
        $('#evenselec').text(selectedEventText || 'Ninguno');  
        $('#idevento').val(selectedEventId);  // Actualiza el campo oculto
    }  

    $('#ideven').on('change', function () {  
        updateSelectedEvent();
    });  

    updateSelectedEvent();


    $('#addEmployeeModal').on('submit', function() {
        var selectedEventId = $('#ideven').val();
        $('#idevento').val(selectedEventId);
    });
    });
//     $(document).ready(function () {
//     $('#culminarCertifi').on('click', function (e) {
//         e.preventDefault();
        
//         var eventoId = $('#ideven').val();
        
//         if (eventoId) {
//             var form = $('#culminarCertifiForm');
//             var url = form.data('url-template').replace(':idevento', eventoId);
//             console.log("URL generada:", url); // Para verificar la URL
            
//             Swal.fire({
//                 title: '¿Estás seguro?',
//                 text: "¿Quieres validar la asistencia?",
//                 icon: 'warning',
//                 showCancelButton: true,
//                 confirmButtonColor: '#3085d6',
//                 cancelButtonColor: '#d33',
//                 confirmButtonText: 'Sí, validar',
//                 cancelButtonText: 'Cancelar'
//             }).then((result) => {
//                 if (result.isConfirmed) {
//                     $.ajax({
//                         url: url,
//                         type: 'PUT',
//                         data: {
//                             _token: $('meta[name="csrf-token"]').attr('content'),
//                             _method: 'PUT'
//                         },
//                         success: function(response) {
//                             Swal.fire('Éxito', response.message, 'success');
//                             console.log("Respuesta del servidor:", response);
//                         },
//                         error: function(xhr, status, error) {
//                             var errorMessage = xhr.responseJSON && xhr.responseJSON.error 
//                                                ? xhr.responseJSON.error 
//                                                : 'Error desconocido al culminar el evento: ' + error;
//                             console.error("Error completo:", xhr.responseText);
//                             Swal.fire('Error', errorMessage, 'error');
//                         }
//                     });
//                 }
//             });
//         } else {
//             Swal.fire('Error', 'Por favor, selecciona un evento antes de continuar.', 'error');
//         }
//     });
// });


$(document).ready(function () {
    $('#culminarCertifi').on('click', function (e) {
        e.preventDefault();
        
        var eventoId = $('#ideven').val();
        
        if (eventoId) {
            var form = $('#culminarCertifiForm');
            var url = form.data('url-template').replace(':idevento', eventoId);
            console.log("URL generada:", url); // Para verificar la URL
            
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Quieres validar la asistencia?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, validar',
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
                            Swal.fire('Éxito', response.message, 'success').then(() => {
                                location.reload(); // Recarga la página después de mostrar el mensaje de éxito
                            });
                            console.log("Respuesta del servidor:", response);
                        },
                        error: function(xhr, status, error) {
                            var errorMessage = xhr.responseJSON && xhr.responseJSON.error 
                                               ? xhr.responseJSON.error 
                                               : 'Error desconocido al culminar el evento: ' + error;
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


</script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>


@include('Vistas.Footer')
