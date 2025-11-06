@include('Vistas.Header')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.1/font/bootstrap-icons.min.css"> 
<style>
    
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

.table-responsive {
    overflow-x: auto; 
    white-space: nowrap;
}


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
<div id="">
<h1>Eventos</h1>
<hr class="linea">
<div class="container-fluid mt-3">
    <div class="row mb-3 d-flex align-items-center">
        <div class="col-md-2">
            <button href="#addEmployeeModl" class="btn btn-primary" data-toggle="modal">
                <i class="bi bi-plus-circle"></i> AGREGAR NUEVO
            </button>
        </div>
        <div class="col-md-2">
        <form action="{{ route('reportevento') }}" method="get" target="_blank">
    <button class="btn btn-success">
        <i class="bi bi-file-earmark-text"></i> Reporte de eventos
    </button>
</form>

        </div>
        <div class="col-md-8 d-flex align-items-start">  
    <div class="p-4 rounded border" style="background: linear-gradient(135deg, #d1e7ff, #eaf8ff); box-shadow: 0 1px 1px rgba(0,0,0,0.2); padding-top: 0;">  
        <form action="{{ route('eventofecha') }}" method="get" class="d-flex w-100" style="margin-top: 0;" target="_blank" >  
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
@if(session('error'))
            <div class="alert alert-danger">
                {{ session('err
       <div class="table-container">  or') }}
            </div>
        @endif
    </div>
</div>
       <br>
       <table class="table table-striped table-bordered table-hover" id="my-table" cellspacing="0" width="100%" class="table">
    <thead class="bg-dark text-white">
        <tr>
            <th>N°</th>
            <th>Evento</th>
            <th>Descripción</th>
            <th>Tipo de evento</th>
            <th>Fecha de apertura</th>
            <th>Fecha de cierre</th>
            <th>Tema de Evento</th>
            <th>Estado</th>
            <th>Resolución</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($eventos as $index => $event)
        <tr>
            <td>{{ $index + 1 }}</td> 
            <td>{{ $event->eventnom }}</td>
            <td>{{ $event->descripción }}</td>
            <td>{{ $event->tipoEvento->nomeven }}</td>
            <td>{{ $event->fecini }}</td>
            <td>{{ $event->horain }}</td>
            <td>{{ $event->horcul }}</td>
   
            <td>{{ $event->EstadoEvento->nomestado }}</td>
            <td style="text-align: center;">
    @if ($event->resoluciaprob && file_exists(storage_path('app/public/' . $event->resoluciaprob->ruta)))
        <a href="{{ asset('storage/' . $event->resoluciaprob->ruta) }}" target="_blank" class="btn" style="background-color: #87CEEB; color: white; font-size: 14px; border-radius: 10px; padding: 5px 10px; border: none; text-align: center; text-decoration: none; display: inline-block;">Ver</a>
    @else
        <a href="#" onclick="showNoResolutionAlert(event)" class="btn" style="background-color: #f26852 ; color: white; font-size: 14px; border-radius: 10px; padding: 5px 10px; border: none; text-align: center; text-decoration: none; display: inline-block;">Ver</a>
    @endif
</td>
            <td>
                <div class="action-buttons">
                    <button type="button" style="cursor:pointer;" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit{{$event->idevento}}"><i class="bi bi-pencil"></i></button>
                    <button type="button" style="cursor:pointer;" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{$event->idevento}}"><i class="bi bi-trash"></i></button>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

</div> 

     <!-- crear Modal HTML -->
<div id="addEmployeeModl" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered"> 
        <div class="modal-content">
            <form  action="{{ route('Rut.evento.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addEventModalLabel">Agregar Nuevo Evento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="tip_usu fw-bold">Tipo de Evento</label>
                            <select id="tip_usu" name="idTipoeven" class="form-control" required>
                                <option value="" disabled selected>Seleccione una opción</option>
                                @foreach ($tipoeventos as $tipoevento)
                                    <option value="{{ $tipoevento->idTipoeven }}">{{ $tipoevento->nomeven }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="eventnom fw-bold">Nombre del Evento</label>
                            <input type="text" id="eventnom" name="eventnom" class="form-control" placeholder="Ingrese el nombre del evento" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="descripcion fw-bold">Descripción</label>
                            <textarea id="descripcion" name="descripción" class="form-control" rows="3" placeholder="Describa el evento" required></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="fecini fw-bold">Fecha de apertura</label>
                            <input type="date" id="fecini" name="fecini" class="form-control" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="horain fw-bold">Fecha de cierre</label>
                            <input type="date" id="horain" name="horain" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-row">
                       <div class="form-group col-md-6">
                            <label for="tip_usu fw-bold">Tema de Evento</label>
                            <select id="tip_usu" name="idTipoeven" class="form-control" required>
                                <option value="" disabled selected>Seleccione una opción</option>
                                @foreach ($tipoeventos as $tipoevento)
                                    <option value="{{ $tipoevento->idTipoeven }}">{{ $tipoevento->nomeven }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="btnCancelar">Limpiar</button>
                    <button type="submit" style="cursor: pointer;" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

   <!-- edit Modal HTML -->
@foreach($eventos as $evento)
<div id="edit{{ $evento->idevento }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered"> <!-- Modal centrado verticalmente -->
        <div class="modal-content">
            <form action="{{ route('Rut.evento.update', $evento->idevento) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editEventModalLabel">Editar Evento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="idTipoeven">Tipo de Evento</label>
                            <select name="idTipoeven" class="form-control" required>
                                @foreach ($tipoeventos as $tipoevento)
                                    <option value="{{ $tipoevento->idTipoeven }}" {{ $tipoevento->idTipoeven == $evento->idTipoeven ? 'selected' : '' }}>
                                        {{ $tipoevento->nomeven }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="eventnom">Nombre del Evento</label>
                            <input type="text" id="eventnom" name="eventnom" class="form-control" value="{{ $evento->eventnom }}" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="descripcion">Descripción</label>
                            <textarea id="descripcion" name="descripción" class="form-control" rows="3" required>{{ $evento->descripción }}</textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="fecini">Fecha</label>
                            <input type="date" id="fecini" name="fecini" class="form-control" value="{{ $evento->fecini }}" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="horain">Hora de Inicio</label>
                            <input type="time" id="horain" name="horain" class="form-control" value="{{ $evento->horain }}" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="horcul">Hora de Culminación</label>
                            <input type="time" id="horcul" name="horcul" class="form-control" value="{{ $evento->horcul }}" required>
                        </div>
                    </div>
                    <div class="form-row">
                    <div class="form-group col-md-6">
                            <label for="lugar">Lugar</label>
                            <input type="text" id="lugar" name="lugar" class="form-control" value="{{ $evento->lugar}}" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="ponente">Ponente</label>
                            <input type="text" id="ponente" name="ponente" class="form-control" value="{{ $evento->ponente }}" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" style="cursor: pointer;" class="btn btn-success">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endforeach


 <!-- delete Modal HTML -->
 @foreach($eventos as $evento)
<div id="delete{{$evento->idevento}}" class="modal fade" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-center">
            <form action="{{ route('Rut.evento.destroy', $evento->idevento) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header border-0 justify-content-center pb-1">
                    <div class="modal-title">
                        <i class="bi bi-exclamation-circle" style="font-size: 80px; color: #f4c542;"></i>
                    </div>
                </div>
                <div class="modal-body pt-2 pb-3">
                    <h4 class="mb-1">Confirmar</h4>
                    <p class="mb-3">¿Estás seguro que deseas eliminar el evento?</p>
                    <span><strong> {{$evento->eventnom}}?   </strong></span>
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



    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
   
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">  
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11">

</script>  
   <script>
 document.getElementById('btnCancelar').addEventListener('click', function() {
        document.getElementById('tip_usu').value = '';  
        document.getElementById('eventnom').value = ''; 
        document.getElementById('descripcion').value = '';  
        document.getElementById('fecini').value = '';  
        document.getElementById('horain').value = '';  
        document.getElementById('horcul').value = '';  
        document.getElementById('lugar').value = '';  
        document.getElementById('ponente').value = ''; 
    });
function showNoResolutionAlert(event) {
    event.preventDefault();
    Swal.fire({
        title: 'Aviso',
        text: 'No cuenta con Resolución',
        icon: 'warning',
        confirmButtonText: 'Entendido'
    });
}


@if(session('error'))
    <script>
        alert("{{ session('error') }}");
    </script>
@endif


        
    function searchTable() {
    var query = $('#search-input').val(); 
    $.ajax({
        url: "{{ route('buscar.evento') }}", 
        type: 'GET',
        data: {
            search: query 
        },
        success: function(data) {
            $('tbody').html(data); 
        },
        error: function(xhr, status, error) {
            console.error("Error en la búsqueda:", error);
        }
    });
}

</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
    Swal.fire({
        title: '¡Éxito!',
        text: "{{ session('success') }}",
        icon: 'success',
        confirmButtonText: 'Aceptar'
    });
</script>
@endif


<!-- Incluye los archivos CSS y JS de DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
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
</style>
<script>

@if(session('swal_error'))
    Swal.fire({
        title: '¡Error!',
        text: "{{ session('swal_error') }}",
        icon: 'error',
        confirmButtonText: 'Aceptar'
    });
@endif

@if(session('swal_success'))
    Swal.fire({
        title: '¡Éxito!',
        text: "{{ session('swal_success') }}",
        icon: 'success',
        confirmButtonText: 'Aceptar'
    });
@endif

    $(document).ready(function() {
        $('#my-table').DataTable({
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
    });
</script>
@include('Vistas.Footer')