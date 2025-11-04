@include('Vistas.Header')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.1/font/bootstrap-icons.min.css"> 

<link rel="stylesheet" href="{{ asset('css/informe.css') }}">
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

.container {
            max-width: 100%; 
            padding: 0 5px;
        }

        .card {
            width: 100%; 
        }

    </style>
<body>

<div id="tabla-informe">
    <div class="container-fluid mt-3">
        <div class="card">
            <div class="card-header">
                <h5 class="text-center">Informes de Certificados</h5>
            </div>
            <div class="container">
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head">
                            <button href="#addEmployeeModl" class="btn btn-primary" data-toggle="modal"><i class="bi bi-plus-circle"></i> AGREGAR NUEVO</button>
                            <div class="input-group float-right" style="width: 450px;">
                                <input type="text" id="search-input" class="form-control" placeholder="Buscar" onkeyup="searchTable()">
                                <button class="btn btn-outline-secondary" type="button"><i class="bi bi-search"></i></button>
                            </div>
                        </div>
                        <br>
                        <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th>N°</th>
                                    <th>Fecha de presentación</th>
                                    <th>Tipo de informe</th>
                                    <th>Evento</th>
                                    <th>Archivo</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($informes as $index => $infor)
                                <tr>
                                    <td>{{ $index + 1 }}</td> 
                                    <td>{{ $infor->fecpres}}</td>
                                    <td>{{ $infor->tipoinforme->nomtinform}}</td> 
                                    <td>{{ $infor->evento->eventnom}}</td> 
                                    @if (file_exists(storage_path('app/public/' . $infor->rta)))
                                    <td style="text-align: center;">
                                    <a href="{{ asset('storage/' . $infor->rta) }}" target="_blank"  class="btn" style="background-color: #87CEEB; color: white; font-size: 14px; border-radius: 10px; padding: 5px 10px; border: none; text-align: center; text-decoration: none; display: inline-block;">Ver</a>
                                    </td>
                                      @else
                                    <td style="text-align: center;">
                                    <a href="#" onclick="showFileNotAvailableAlert(event)" class="btn" style="background-color: #87CEEB; color: white; font-size: 14px; border-radius: 10px; padding: 5px 10px; border: none; text-align: center; text-decoration: none; display: inline-block;">Ver</a>
                                   </td>
                                  @endif
                                    <td>
                                        <div class="btn-group action-buttons">
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" href="#edit{{$infor->idinforme}}"><i class="bi bi-pencil"></i></button>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" href="#delete{{$infor->idinforme}}"><i class="bi bi-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</div>
   <!-- crear Modal HTML -->
   <div id="addEmployeeModl" class="modal fade">
    <div class="modal-dialog modal-lg"> <!-- Cambiado a modal-lg para ancho mayor -->
        <div class="modal-content">
        <form action="{{ route('Rut.infor.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-header bg-primary text-white">           
                    <h4 class="modal-title">Agregar informe de un evento</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: white;">&times;</button>
                </div>
                <div class="modal-body">          
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Evento</label>
                            <select  name="idevento" class="form-control" required>
                            <option value="" disabled selected>Seleccione una opción</option> 
                            @foreach ($eventoss as $even) 
                            <option value="{{$even->idevento}}">{{$even->eventnom}}</option>
                            @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group col-md-6">

                            <label for="tip_usu fw-bold">Tipo de informe</label>
                            <select id="idTipinfor" name="idTipinfor" class="form-control" required>
                                <option value="" disabled selected>Seleccione una opción</option>
                                @foreach ($tipoinformes as $tipoinforme)
                                    <option value="{{ $tipoinforme->idTipinfor }}">{{ $tipoinforme->nomtinform }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>  
                    <div class="form-row">
                    <div class="form-group col-md-6">
                            <label>Archivo</label>
                            <input class="form-control form-control-sm" id="formFileSm" type="file" name="rta" required>
                        </div>
                    <div class="form-group col-md-6">
                            <label>Fecha</label>
                             <input type="date" name="fecpres" class="form-control" required>
                           
                        </div>
                    </div>    
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-warning" data-dismiss="modal" value="CANCELAR">
                    <button type="submit" class="btn btn-success" name="save">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div> 

@foreach($informes as $infor) 
<div id="edit{{$infor->idinforme}}" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('Rut.infor.update', $infor->idinforme) }}" method="POST" enctype="multipart/form-data"> <!-- Importante agregar enctype -->
                @csrf  
                @method('PUT')  
                <div class="modal-header bg-primary text-white">          
                    <h4 class="modal-title">Editar</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: white;">&times;</button>
                </div>
                <div class="modal-body">          
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Evento</label>
                            <select   name="idevento" class="form-control" required>
                                @foreach ($eventos as $eve) 
                                    <option value="{{$eve->idevento}}" {{ $infor->evento->idevento == $eve->idevento ? 'selected' : '' }}>  
                                        {{$eve->eventnom}}  
                                    </option>  
                                @endforeach  
                            </select>  
                        </div>
                        
                        <div class="form-group col-md-6">

                        <label for="idTipinfor">Tipo de informe<</label>
                            <select name="idTipinfor" class="form-control" required>
                                @foreach ($tipoinformes as $tipoinforme)
                                    <option value="{{ $tipoinforme->idTipinfor }}" {{ $tipoinforme->idTipinfor == $infor->idTipinfor ? 'selected' : '' }}>
                                        {{ $tipoinforme->nomtinform }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>  

                    <div class="form-row">
                    <div class="form-group col-md-6">
    <label>Archivo</label>
    <input class="form-control form-control-sm" id="formFileSm" type="file" name="rta">
    @if($infor->rta)
        <small>Archivo actual: <a href="{{ asset('storage/' . $infor->rta) }}" target="_blank">{{ basename($infor->rta) }}</a></small>
    @endif
</div>

                        <div class="form-group col-md-6">
                            <label>Fecha</label>
                            <input type="date" name="fecpres" class="form-control" value="{{ $infor->fecpres }}" required>
                        </div>
                    </div>   
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-warning" data-dismiss="modal" value="CANCELAR">
                    <button type="submit" class="btn btn-success" name="update">Editar</button>
                </div>
            </form>
        </div>
    </div>
</div> 
@endforeach
@foreach($informes as $infor) 
<div id="delete{{$infor->idinforme}}" class="modal fade">
   <div class="modal-dialog modal-lg"> <!-- Cambiado a modal-lg para ancho mayor -->
        <div class="modal-content">
        <form action="{{route('Rut.infor.destroy', $infor->idinforme)}}" method="post">
                @csrf
                @method('delete')
                <div class="modal-body">          
               Estás seguro de eliminar ? </strong>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
  
  
  <script>

    function searchTable() {
    var query = $('#search-input').val(); 
    $.ajax({
        url: "{{ route('buscar.informe') }}", 
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

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

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

<script>

document.addEventListener('DOMContentLoaded', function () {
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
    });
    


    $(document).ready(function() {
        $('#example-table').DataTable({
            "order": [[0, "asc"]],
            "columnDefs": [
                {
                    "targets": 1,
                    "orderable": false
                }
            ],
            "language": {
                "search": "",
                "lengthMenu": "Mostrar _MENU_ registros",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "paginate": {
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            "dom": 'ltrip',
        });
    });
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


@include('Vistas.Footer')