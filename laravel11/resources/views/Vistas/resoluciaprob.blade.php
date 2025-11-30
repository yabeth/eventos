@include('Vistas.Header')
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css"> 
    <link rel="stylesheet" href="https://www.flaticon.es/iconos-gratis/enlace"> 
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
    </style>
    <style>
        .container {
            max-width: 100%; 
            padding: 0 0;
        }
        .card {
            width: 100%; 
        }
    </style>
<body>

<div id="tabla-resolucion">
    <div class="container mt-3">
        <div class="card">        
            <div class="card-header">
                <h5 class="text-center">Resolución de los eventos</h5>
            </div>
            <div class="container">
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="row mb-3">
                        <div class="col-md-2 d-flex justify-content-end">  
                        <button  href="#addEmployeeModl" class="btn btn-primary" data-toggle="modal"><i class="bi bi-plus-circle"></i> AGREGAR NUEVO</button>
                        </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" id="search-input" class="form-control" placeholder="Buscar" onkeyup="searchTable()">
                                    <button class="btn btn-outline-secondary" type="button"><i class="bi bi-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <br>

                        <div>
                            <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
                                <thead class="bg-dark text-white">
                                    <tr> 
                                        <th>N°</th>         
                                        <th>Evento</th>
                                        <th>Tipo de resolución</th>
                                        <th>Fecha de Aprobación</th>
                                        <th>Número</th>
                                        <th>Ruta</th>
                                        <th>N° de agradecimiento</th>
                                        <th>Tipo de agradecimiento</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($resoluciaprobs as $index =>$reso) 
                                    <tr>
                                        <td>{{ $index + 1 }}</td> 
                                        <td>{{ $reso->evento->eventnom}}</td>
                                        <td>{{ $reso->tiporesolucion->nomtiprs}}</td>
                                        <td>{{ $reso->fechapro}}</td>
                                        <td>{{ $reso->nrores}}</td>
                                    

                                        @if (file_exists(storage_path('app/public/' . $reso->ruta)))  
                                      <td style="text-align: center;">  
                                       <a href="{{ asset('storage/' . $reso->ruta) }}" target="_blank"  class="btn" style="background-color: #87CEEB; color: white; font-size: 14px; border-radius: 10px; padding: 5px 10px; border: none; text-align: center; text-decoration: none; display: inline-block;">Ver</a>
                                        @else  
                                      <td style="text-align: center;">
                                      <a href="#" onclick="showFileNotAvailableAlert(event)" class="btn btn-danger" style="color: red; font-size: 16px; border-radius: 20%;">Ver</a>
                                        </td>  
                                        @endif
                                         <td>{{ $reso->numresolagradcmt}}</td>
                                        <td>{{ $reso->TipresolucionAgrad->tipoagradeci}}</td>
                                        <td>
                                            <div class="btn-group action-buttons">
                                                <button type="button" class="tn btn-warning btn-sm" data-toggle="modal" data-target="#edit{{$reso->idreslaprb}}"><i class="bi bi-pencil"></i></button>
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"  data-target="#delete{{$reso->idreslaprb}}"><i class="bi bi-trash"></i></button>
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
</div>


<!-- crear Modal HTML -->  
<div id="addEmployeeModl" class="modal fade" tabindex="-1">  
    <div class="modal-dialog modal-lg">  
        <div class="modal-content">  
            <form action="{{ route('Rut.reso.store') }}" method="post" enctype="multipart/form-data">  
                @csrf  
                <div class="modal-header bg-primary text-white"> 
                    <h4 class="modal-title">Agregar resolución de eventos</h4>  
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;"></button>  
                </div>  
                <div class="modal-body">  
                    <div class="row">  
                        <div class="col-md-6">  
                            <div class="form-group">  
                                <label class="form-label">Tipo de resolución</label>  
                                <select id="idTipresol" name="idTipresol" class="form-control" required>  
                                    <option value="">Seleccione una opción</option>  
                                    @foreach ($tiporesoluciones as $tip)  
                                        <option value="{{ $tip->idTipresol }}">{{ $tip->nomtiprs }}</option>  
                                    @endforeach  
                                </select>  
                            </div>  
                            <div class="form-group">  
                                <label class="form-label">Evento</label>  
                                <select id="idevento" name="idevento" class="form-control" style="flex: 2; width: 100%;" required>  
                                    <option value="">Seleccione una opción</option>  
                                    @foreach ($eventoss as $even)  
                                        <option value="{{ $even->idevento }}">{{ $even->eventnom }}</option>  
                                    @endforeach  
                                </select>  
                            </div>  
                            <div class="form-group">  
                                <label class="form-label">Resolución</label>  
                                <input class="form-control form-control-sm" id="formFileSm" type="file" name="ruta" required>  
                            </div>  
                        </div>  
                        <div class="col-md-6">  
                            <div class="form-group">  
                                <label class="form-label">Nro</label>  
                                <input type="text" name="nrores" class="form-control" required>  
                            </div>  
                            <div class="form-group">  
                                <label class="form-label">Fecha de aprobación</label>  
                                <input type="date" name="fechapro" class="form-control" required>  
                            </div>  
                        </div>  

                          <div class="col-md-6">  
                            <div class="form-group">  
                                <label class="form-label">Nro de agradecimiento</label>  
                                <input type="text" name="numresolagradcmt" class="form-control" required>  
                            </div>  
                            <div class="form-group">  
                              <label class="form-label">Tipo de agradecimiento</label>  
                                <select id="idtipagr" name="idtipagr" class="form-control" required>  
                                    <option value="">Seleccione una opción</option>  
                                    @foreach ($TipresolucionAgrads as $tip)  
                                        <option value="{{ $tip->idtipagr }}">{{ $tip->tipoagradeci}}</option>  
                                    @endforeach  
                                </select>  
                            </div>  
                        </div>
                    </div>  
                </div>  
                <div class="modal-footer">  
                    <button type="submit" class="btn btn-success" name="save">Guardar</button>  
                </div>  
            </form>  
        </div>  
    </div>  
</div>

   <!-- edit Modal HTML -->
   @foreach ($resoluciaprobs as $reso)   
<div id="edit{{ $reso->idreslaprb }}" class="modal fade" tabindex="-1" aria-labelledby="editModalLabel">  
    <div class="modal-dialog modal-lg">  
        <div class="modal-content">  
            <form action="{{ route('Rut.reso.update', $reso->idreslaprb) }}" method="POST" enctype="multipart/form-data">  
                @csrf  
                @method('PUT')  
                
                <div class="modal-header bg-primary text-white">  
                    <h5 class="modal-title" id="editModalLabel">Editar</h5>  
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close" style="color: white;"></button>  
                </div>  

                <div class="modal-body">  
                    <div class="row">  
                        <div class="col-md-6">  
                            <div class="form-group">  
                                <label class="form-label">Tipo de resolución</label>  
                                <select id="idTipresol" name="idTipresol" class="form-control" required>  
                                    <option value="">Seleccione una opción</option>  
                                    @foreach ($tiporesoluciones as $tip)   
                                        <option value="{{ $tip->idTipresol }}" @if($tip->idTipresol == $reso->idTipresol) selected @endif>{{ $tip->nomtiprs }}</option>  
                                    @endforeach  
                                </select>  
                            </div>  
                            
                            <div class="form-group">  
                                <label class="form-label">Evento</label>  
                                <select id="idevento" name="idevento" class="form-control" style="width: 100%;" required>  
                                    <option value="">Seleccione una opción</option>  
                                    @foreach ($eventos as $even)   
                                        <option value="{{ $even->idevento }}" @if($even->idevento == $reso->idevento) selected @endif>{{ $even->eventnom }}</option>  
                                    @endforeach  
                                </select>  
                            </div>  

                            <div class="form-group">  
                                <label class="form-label">Resolución</label>  
                                <input class="form-control form-control-sm" id="formFileSm" type="file" name="ruta" onchange="updateFileName(this)">  
                                @if($reso->ruta)  
                                    <small>Archivo actual:  
                                        <a href="{{ asset('storage/' . $reso->ruta) }}" target="_blank">{{ basename($reso->ruta) }}</a>  
                                    </small>  
                                @endif  
                            </div>  
                        </div>  

                        <div class="col-md-6">  
                            <div class="form-group">  
                                <label class="form-label">Nro</label>  
                                <input type="text" name="nrores" class="form-control" value="{{ $reso->nrores }}">  
                            </div>  

                            <div class="form-group">  
                                <label class="form-label">Fecha de aprobación</label>  
                                <input type="date" name="fechapro" class="form-control" value="{{ $reso->fechapro }}" required>  
                            </div>  
                        </div>  

                        
                        <div class="col-md-6">  
                            <div class="form-group">  
                                <label class="form-label">N° de agradecimiento</label>  
                                <input type="text" name="numresolagradcmt" class="form-control" value="{{ $reso->numresolagradcmt}}" required>  
                            </div>  

                            <div class="form-group">  
                                 <label class="form-label">Tipo de agradecimiento</label>  
                                <select id="idtipagr" name="idtipagr" class="form-control" style="width: 100%;" required>  
                                    <option value="">Seleccione una opción</option>  
                                    @foreach ($TipresolucionAgrads as $tip)   
                                        <option value="{{ $tip->idtipagr }}" @if($tip->idtipagr == $reso->TipresolucionAgrad->idtipagr) selected @endif>{{ $tip->tipoagradeci}}</option>  
                                    @endforeach  
                                </select>  
                                 </div>  
                        </div>  
                    </div>  
                </div>  

                <div class="modal-footer">  
                     <button type="submit" class="btn btn-success" name="update">Editar</button>  
                </div>  
            </form>  
        </div>  
    </div>  
</div>  
@endforeach
<!-- Modal Eliminar -->

@foreach ($resoluciaprobs as $reso) 
<div id="delete{{ $reso->idreslaprb}}" class="modal fade" tabindex="-1" aria-labelledby="deleteModalLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('Rut.reso.destroy', $reso->idreslaprb) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Eliminar Resolución</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Estás seguro de eliminar?
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

  <script>



    function searchTable() {
    var query = $('#search-input').val(); 
    $.ajax({
        url: "{{ route('buscar.resolucion') }}", 
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

document.addEventListener('DOMContentLoaded', function() {  
    @if(session('swal_error'))  
        Swal.fire({  
            title: '¡Error!',  
            text: "{{ session('swal_error') }}",  
            icon: 'error',  
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