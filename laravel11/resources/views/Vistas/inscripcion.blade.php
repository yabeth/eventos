

@include('Vistas.Header')
   <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css"> 
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">  
    
    <!-- Estilos para SweetAlert -->  
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

    </style>
<body>
<h1>Incripción a  eventos</h1>
<hr class="linea">
<div id="tabla-inscrip">
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="row mt-4">
            <div class="col-md-6">
                <form action="{{route('reportinscripcionporevento')}}" method="get">
                    <div class="input-group">
                        <select id="ideven" name="ideven" class="form-control" required>
                        <option value="" disabled selected>Seleccione una opción</option> 
                            @foreach ($eventos as $even) 
                                <option value="{{$even->idevento}}">{{$even->eventnom}}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <button class="btn btn-success" type="submit">
                                <i class="bi bi-file-earmark-text"></i> Reporte por evento
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-3 d-flex justify-content-end">
                <a href="#addEmployeeModal" class="btn btn-success btn-block" data-toggle="modal" data-target="#addEmployeeModal">
                    <i class="material-icons"></i> <span>Agregar nuevo participante</span>
                </a>
            </div>
            <div class="col-md-3">
                <form action="{{route('reportinscripcion')}}" method="get">
                    <button class="btn btn-info btn-block">
                        <i class="bi bi-file-earmark-text"></i> Reporte general
                    </button>
                </form>
            </div>

            <div class="row mt-6">
            <div class="p-4 rounded border" style="background: linear-gradient(135deg, #d1e7ff, #eaf8ff); box-shadow: 0 1px 1px rgba(0,0,0,0.2); padding-top: 0;">  
        <form action="{{ route('incritosfecha') }}" method="get" class="d-flex w-100" style="margin-top: 0;">  
            <div class="col-md-4">  
                <label for="fecinic">Fecha inicio</label>  
                <input type="date" name="fecinic" class="form-control">  
            </div>  
            <div class="col-md-4">  
                <label for="fecfin">Fecha fin</label>  
                <input type="date" name="fecfin" class="form-control">  
            </div>  
            <div class="col-md-4 d-flex align-items-end">  
                <button class="btn btn-success">  
                    <i class="bi bi-printer"></i>Reporte por fecha  
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
        </div>

        <!-- Search Bar Section -->
        <div class="row mt-3 align-items-center">
            <div class="col-md-8">
                <div class="input-group">
                    <input type="text" id="buscarTabla" class="form-control" placeholder="Buscar...">
                    <button class="btn btn-outline-secondary" id="botonBuscar" type="button">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>

            <div class="col-md-4 text-right">
                <label id="evenselec" class="h5">Selecciona un evento</label>
            </div>
        </div>
        <br>
        <!-- Table Section -->
        <div class="table-responsive">
            <table id="inscripcionTable" class="table table-striped table-bordered table-hover">
                <thead class="bg-dark text-white">
                    <tr>
                        <th>N°</th>
                        <th>DNI</th>
                        <th>Participante</th>
                        <th>Telefono</th>
                        <th>Email</th>
                        <th>Dirección</th>
                        <th>Genero</th>
                        <th>Escuela</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dynamic Rows Here -->
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Añadir Participante Modal HTML -->  
<div id="addEmployeeModal" class="modal fade">  
    <div class="modal-dialog modal-lg">  
        <div class="modal-content">  
            <form id="employeeForm" action="{{ route('Rut.inscri.store') }}" method="post">  
                @csrf  
                <div class="modal-header bg-primary text-white">  
                    <h4 class="modal-title">Agregar nuevo participante</h4>  
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>  
                </div>  
                
                <div class="modal-body">  
                    <div class="container-fluid">  
                        <div class="row">  
                            <!-- Primera columna -->  
                            <div class="col-md-6">  
                                <div class="form-group mb-2">  
                                    <label for="dni">DNI <span class="required text-danger px-1">*</span></label>  
                                    <input type="text" class="form-control" id="dni" name="dni" required>  
                                </div>  
                                <div class="form-group mb-2">  
                                    <label for="nombre">Nombres <span class="required text-danger px-1">*</span></label>  
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>  
                                </div>  
                                <div class="form-group mb-2">  
                                    <label for="email">Correo electrónico <span class="required text-danger px-1">*</span></label>  
                                    <input type="email" class="form-control" id="email" name="email" required>  
                                </div>  
                                <div class="form-group mb-2">  
                                    <label for="tip_usu">Género <span class="required text-danger px-1">*</span></label>  
                                    <select id="tip_usu" name="idgenero" class="form-control" required>  
                                        @foreach ($generos as $gen)   
                                            <option value="{{ $gen->idgenero }}">{{ $gen->nomgen }}</option>  
                                        @endforeach  
                                    </select>  
                                </div>  
                            </div>  

                            <!-- Segunda columna -->  
                            <div class="col-md-6">  
                                <div class="form-group mb-2">  
                                    <label for="apell">Apellidos <span class="required text-danger px-1">*</span></label>  
                                    <input type="text" class="form-control" id="apell" name="apell" required>  
                                </div>  
                                <div class="form-group mb-2">  
                                    <label for="tele">Teléfono <span class="required text-danger px-1">*</span></label>  
                                    <input type="text" class="form-control" id="tele" name="tele" required>  
                                </div>  
                                <div class="form-group mb-2">  
                                    <label for="direc">Dirección <span class="required text-danger px-1">*</span></label>  
                                    <input type="text" class="form-control" id="direc" name="direc" required>  
                                </div>  
                                <div class="form-group mb-2">  
                                    <label for="escuela">Escuela <span class="required text-danger px-1">*</span></label>  
                                    <select id="idescuela" name="idescuela" class="form-control" required>  
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

                <!-- Footer del modal -->  
                <div class="modal-footer">  
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>  
                    <button type="submit" style="cursor: pointer;" class="btn btn-success" name="save">Guardar</button>  
                </div>  
            </form>  
        </div>  
    </div>  
</div>  



<!-- Modificar Participante Modal HTML -->
@foreach ($inscripciones as $incrip)
<div class="modal fade" id="edit{{$incrip->idincrip}}" tabindex="-1" aria-labelledby="editModalLabel{{$incrip->idincrip}}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editModalLabel{{$incrip->idincrip}}">Editar participante</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('Rut.inscri.update', $incrip->idincrip) }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="dni" class="form-label">DNI</label>
                                <input type="text" class="form-control" id="dni" name="dni" value="{{ $incrip->persona->dni }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombres</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $incrip->persona->nombre }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="correo" name="email" value="{{ $incrip->persona->email }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="tip_usu" class="form-label">Género</label>
                                <select id="tip_usu" name="idgenero" class="form-select form-control" required>
                                    @foreach ($generos as $gen)
                                        @if($gen->idgenero == $incrip->persona->genero->idgenero)
                                            <option value="{{$gen->idgenero}}" selected>{{$gen->nomgen}}</option>
                                        @else
                                            <option value="{{$gen->idgenero}}">{{$gen->nomgen}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="apell" class="form-label">Apellidos</label>
                                <input type="text" class="form-control" id="apell" name="apell" value="{{ $incrip->persona->apell }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="telef" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="telef" name="tele" value="{{ $incrip->persona->tele }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="direc" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="direc" name="direc" value="{{ $incrip->persona->direc }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="idescuela" class="form-label">Escuela</label>
                                <select name="idescuela" id="idescuela" class="form-select form-control" required>
                                    @foreach ($escuelas as $escu)
                                        @if($escu->idescuela == $incrip->idescuela)
                                            <option value="{{$escu->idescuela}}" selected>{{$escu->nomescu}}</option>
                                        @else
                                            <option value="{{$escu->idescuela}}">{{$escu->nomescu}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="idevento" class="form-label">Evento</label>
                                <select name="idevento" class="form-select form-control" required>
                                    @foreach ($eventos as $even)
                                        @if($even->idevento == $incrip->idevento)
                                            <option value="{{$even->idevento}}" selected>{{$even->eventnom}}</option>
                                        @else
                                            <option value="{{$even->idevento}}">{{$even->eventnom}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" style = "cursor: pointer;" class="btn btn-primary" name="update">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Eliminar Participante Modal HTML -->
@foreach ($inscripciones as $incrip)
<div id="delete{{$incrip->idincrip}}" class="modal fade" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-center">
            <form id="deleteForm{{$incrip->idincrip}}" action="{{route('Rut.inscri.destroy', $incrip->idincrip)}}" method="POST">
                @csrf
                @method('delete')
                <div class="modal-header border-0 justify-content-center pb-1">
                    <div class="modal-title">
                        <i class="bi bi-exclamation-circle" style="font-size: 80px; color: #f4c542;"></i>
                    </div>
                </div>
                <div class="modal-body pt-2 pb-3">
                    <h4 class="mb-1">Confirmar</h4> 
                    <p class="mb-3">¿Estás seguro que deseas eliminar?</p>
                </div>
                <div class="modal-footer border-0 justify-content-center pt-0 pb-3">
                    <button type="button" style="cursor:pointer;" class="btn btn-warning" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                    <button type="submit" style="cursor:pointer;" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Configuración de AJAX para incluir el token CSRF  
$.ajaxSetup({  
    headers: {  
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  
    }  
});  

// Función para actualizar el evento seleccionado  
function updateSelectedEvent() {  
    console.log('Ejecutando updateSelectedEvent...');  
    var selectedEventId = $('#ideven').val();  
    var selectedEventText = $('#ideven').find('option:selected').text();  
    $('#eventoo').text(selectedEventText || 'Ninguno');  
    $('#evenselec').text(selectedEventText || 'Ninguno');  
    $('#idevento').val(selectedEventId);  
    console.log('Evento seleccionado actualizado:', selectedEventText);  
}  

// Variable para controlar si hay una operación en curso
let isProcessing = false;

// Manejo del envío del formulario  
document.getElementById('employeeForm').addEventListener('submit', function (event) {  
    event.preventDefault();  
    
    // Evitar múltiples envíos simultáneos
    if (isProcessing) {
        console.log('Ya hay una operación en curso. Ignorando este envío.');
        return;
    }
    
    isProcessing = true;
    console.log('Formulario enviado. Preparando datos...');  

    const form = this;  
    const formData = new FormData(form);  
    const selectedEventId = $('#ideven').val();  
    console.log('ID del evento seleccionado:', selectedEventId);  

    // Mostrar un spinner de carga  
    Swal.fire({  
        title: 'Cargando...',  
        text: 'Por favor, espera mientras se procesa la solicitud.',  
        allowOutsideClick: false,  
        didOpen: () => {  
            Swal.showLoading();  
        }  
    });  

    fetch(form.action, {  
        method: 'POST',  
        body: formData  
    })  
    .then(response => {  
        console.log('Respuesta recibida del servidor. Verificando estado...');  
        if (!response.ok) {  
            throw new Error('Error en la respuesta del servidor');  
        }  
        return response.json();  
    })  
    .then(data => {  
        console.log('Datos recibidos del servidor:', data);  

        if (data.showAlert) {  
            console.log('Mostrando alerta de confirmación...');  
            return Swal.fire({  
                title: 'Confirmación',  
                text: "Esta persona está registrada en otra escuela. ¿Desea actualizar la inscripción a la nueva escuela?",  
                icon: 'warning',  
                showCancelButton: true,  
                confirmButtonText: 'Sí, actualizar',  
                cancelButtonText: 'No, cancelar'  
            }).then(result => {
                if (result.isConfirmed) {
                    console.log('Usuario confirmó la actualización. Enviando datos de actualización...');  
                    const updateFormData = new FormData(form);  
                    updateFormData.append('decision', 'S');  
            
                    return fetch(form.action, {  
                        method: 'POST',  
                        body: updateFormData  
                    })  
                    .then(response => response.json())  
                    .then(data => {  
                        console.log('Datos recibidos después de la actualización:', data);  
                        return {
                            title: '¡Éxito!',  
                            text: data.message || 'Se actualizó correctamente',  
                            icon: 'success'
                        };
                    });
                } else {
                    console.log('Usuario canceló la actualización.');  
                    return {
                        title: 'Cancelado', 
                        text: 'La inscripción se mantiene en la escuela original', 
                        icon: 'info'
                    };
                }
            });
        } else {  
            return {
                title: '¡Éxito!',  
                text: data.message || 'Se registró correctamente',  
                icon: 'success'
            };
        }  
    })  
    .then(alertConfig => {  
        // Mostrar mensaje final
        return Swal.fire({
            ...alertConfig,
            timer: alertConfig.icon === 'success' ? 2000 : undefined,
            showConfirmButton: alertConfig.icon !== 'success'
        });
    })  
    .then(() => {  
        console.log('Cerrando modal y limpiando formulario...');  
        $('#addEmployeeModal').modal('hide');  
        form.reset();  
        
        // Guardar el ID del evento seleccionado en localStorage o sessionStorage
        sessionStorage.setItem('selectedEventId', selectedEventId);
        // Guardar el término de búsqueda si existe
        if ($('#buscarTabla').length) {
            sessionStorage.setItem('searchTerm', $('#buscarTabla').val());
        }
        
        // Recargar la página completa como ya estaba funcionando
        window.location.href = window.location.pathname + '?t=' + new Date().getTime();
    })  
    .catch(error => {  
        console.error('Error en el proceso:', error);  
        Swal.fire('Error', 'Hubo un problema al procesar la solicitud: ' + error.message, 'error');  
    })
    .finally(() => {
        // Siempre liberar el flag de procesamiento
        isProcessing = false;
    });  
});  

// Variable para almacenar la tabla DataTable
let dataTable = null;

// Función para inicializar DataTable cuando carga la página
function initializeDataTable(data) {  
    console.log('Inicializando DataTable...');  

    // Destruir la instancia de DataTable si existe
    if (dataTable) {  
        console.log('Destruyendo DataTable existente...');  
        dataTable.destroy();
        dataTable = null;
    }
    
    // Limpiar contenido de la tabla
    $('#inscripcionTable tbody').empty();  

    // Comprobar si hay datos para mostrar
    if (!Array.isArray(data) || data.length === 0) {  
        console.log('No hay datos para mostrar.');  
        $('#inscripcionTable tbody').append('<tr><td colspan="9" class="text-center">No hay datos disponibles</td></tr>');  
    } else {  
        // Usar DocumentFragment para mejorar el rendimiento de DOM
        const fragment = document.createDocumentFragment();
        let numeroRegistro = 1;  
        
        $.each(data, function (index, inscrip) {  
            if (!inscrip || !inscrip.persona) {
                console.error('Datos de inscripción inválidos:', inscrip);
                return;
            }
            
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
        
        // Añadir todos los elementos a la vez
        $('#inscripcionTable tbody')[0].appendChild(fragment);
    }  

    // Inicializar DataTable con configuración optimizada
    setTimeout(() => {
        dataTable = $('#inscripcionTable').DataTable({  
            "order": [[0, "asc"]],  
            "columnDefs": [{ "targets": 7, "orderable": false }],  
            "language": {  
                "search": "",  
                "lengthMenu": "Mostrar MENU registros",  
                "info": "Mostrando START a END de TOTAL registros",  
                "paginate": {  
                    "next": "Siguiente",  
                    "previous": "Anterior"  
                }  
            },  
            "dom": 'ltrip',
            "deferRender": true,
            "processing": true,
            "pageLength": 10,
            "stateSave": false  // Desactivar guardado de estado para mejorar rendimiento
        });
    }, 0);
}  

// Limpiar campos cuando se cierra el modal  
$('#addEmployeeModal').on('click', '.btn-secondary', function () {  
    $('#addEmployeeModal').find('form').trigger('reset');  
});  

// Función para realizar búsqueda de participantes  
$(document).ready(function () {  
    $('#dni').on('keyup', function() {  
        var dni = $(this).val();  
        console.log("DNI ingresado: " + dni);  

        if (dni.length === 0) {  
            limpiarCampos();  
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
        $('#tip_usu').val('');  
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
        
        $.ajax({
            url: '{{ route('filter.by.event') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                event_id: eventId,
                searchTerm: searchTerm
            },
            success: function(data) {
                console.log('Datos recibidos:', data);
                initializeDataTable(data);
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar datos:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudieron cargar los datos. Por favor, intente nuevamente.'
                });
            }
        });
       }

         $(document).on('click', '.update-btn', function(e) {
        e.preventDefault();
        
        var idincrip = $(this).data('id');
        console.log("ID del registro a actualizar:", idincrip);
        
        // Limpiar handlers previos
        $(`#edit${idincrip} form`).off('submit');
        
        // Mostrar modal
        $(`#edit${idincrip}`).modal('show');
        
        // Manejar envío del formulario
        $(`#edit${idincrip} form`).on('submit', function(e) {
            e.preventDefault();
            
            var form = $(this);
            var submitButton = form.find('button[type="submit"]');
            
            // Deshabilitar botón y mostrar spinner
            submitButton.prop('disabled', true)
                .append('<span class="spinner-border spinner-border-sm ms-1"></span>');
            
            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log("Respuesta del servidor:", response);
                    
                    // Cerrar modal
                    $(`#edit${idincrip}`).modal('hide');
                    
                    // Recargar datos
                    fetchData();
                    
                    // Mostrar mensaje de éxito
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: 'Registro actualizado correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error: function(xhr) {
                    console.error("Error en la actualización:", xhr);
                    
                    // Mostrar error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo actualizar el registro'
                    });
                },
                complete: function() {
                    // Restaurar botón
                    submitButton.prop('disabled', false)
                        .find('.spinner-border').remove();
                }
            });
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
    
$(document).on('click', '.delete-btn', function(e) {
    e.preventDefault();
    e.stopPropagation();
    
    var row = $(this).closest('tr');
    var idincrip = $(this).data('id');
    
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'Rut-inscri/' + idincrip,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        row.fadeOut(400, function() {
                            $(this).remove();
                        });
                        
                        Swal.fire(
                            '¡Eliminado!',
                            'El registro ha sido eliminado.',
                            'success'
                        );
                    }
                },
                error: function() {
                    Swal.fire(
                        'Error',
                        'No se pudo eliminar el registro.',
                        'error'
                    );
                }
            });
        }
    });
    
    return false;
});


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