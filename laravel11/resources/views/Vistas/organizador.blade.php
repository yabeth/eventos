
@include('Vistas.Header')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css"> 
  <link rel="stylesheet" href="https://www.flaticon.es/iconos-gratis/enlace">  
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
    </style>
<body>
<h1>Organizadores</h1>
<hr class="linea">
<div id="">
    <div class="container-fluid mt-3">
        <div class="row mb-3">
            <div class="col-md-2">
                <button href="#addEmployeeModl" style="cursor: pointer;" class="btn btn-primary" data-toggle="modal">
                    <i class="bi bi-plus-circle"></i> AGREGAR NUEVO
                </button>
            </div>
            
        </div>
        <br>
        <div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="my-table" cellspacing="0" width="100%">
                <thead class="bg-dark text-white">
                    <tr>
                        <th>N°</th>
                        <th>Tipo de organizadores</th>
                        <th>Organizadores</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($organizadors as $index => $orga)
                    <tr> 
                        <td>{{ $index + 1 }}</td> 
                        <td>{{ $orga->tipoorg->nombre }}</td>   
                        <td>{{ $orga->nombreor }}</td>  
                        <td>
                            <div class="action-buttons">
                                <button type="button" class="btn btn-warning btn-sm me-2" data-toggle="modal" data-target="#edit{{$orga->idorg}}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{$orga->idorg}}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

     <!-- crear Modal HTML -->
<div id="addEmployeeModl" class="modal fade" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('Rut.orga.store')}}" method="post">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title" id="addEmployeeModalLabel">Agregar organizador</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="tipoorg" class="form-label">Tipo de Organizador</label>
                            <select name="idtipo" id="tipoorg" class="form-select form-control" required>
                                <option value="" disabled selected>Seleccione una opción</option>
                                @foreach ($tipoorgs as $tipoorg) 
                                    <option value="{{$tipoorg->idtipo}}">{{$tipoorg->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="organizador" class="form-label">Organizador</label>
                            <input type="text" class="form-control" name="nombreor" id="organizador" placeholder="Organizador" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="btnCancelar">Limpiar</button>
                    <button type="submit" style="cursor:pointer;" class="btn btn-success" name="save">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

   <!-- edit Modal HTML -->
   @foreach($organizadors as $organizador)
   <div id="edit{{$organizador->idorg}}" class="modal fade" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('Rut.orga.update', $organizador->idorg) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-primary text-white">            
                    <h4 class="modal-title" id="editModalLabel">Editar organizador</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="idtipo" class="form-label">Tipo de organizador</label>
                        <select name="idtipo" id="idtipo" class="form-control" required>
                            @foreach ($tipoorgs as $tipoorg)
                                <option value="{{$tipoorg->idtipo}}" {{ $tipoorg->idtipo == $organizador->idtipo ? 'selected' : '' }}>
                                    {{$tipoorg->nombre}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="nombreor" class="form-label">Organizador</label>
                        <input type="text" class="form-control" name="nombreor" id="nombreor" value="{{ $organizador->nombreor }}" required>
                    </div>  
                </div>
                
                <!-- Footer del Modal -->
                <div class="modal-footer">
                   <button type="submit" style="cursor:pointer;" class="btn btn-success" name="update">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endforeach

<!-- delete Modal HTML -->
@foreach($organizadors as $organizador)
<div id="delete{{$organizador->idorg}}" class="modal fade" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-center">
            <form action="{{ route('Rut.orga.destroy', $organizador->idorg) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header border-0 justify-content-center pb-1">
                    <div class="modal-title">
                        <i class="bi bi-exclamation-circle" style="font-size: 80px; color: #f4c542;"></i>
                    </div>
                </div>
                <div class="modal-body pt-2 pb-3"> 
                    <h4 class="mb-1">Confirmar</h4>
                    <p class="mb-3">¿Estás seguro que deseas eliminar al organizador?</p>
                    <span><strong>{{ $organizador->nombreor }}</strong></span>
                </div>

                <!-- Footer del modal con menos espacio entre botones y contenido -->
                <div class="modal-footer border-0 justify-content-center pt-0 pb-3">
                    <button type="button" style="cursor:pointer;" class="btn btn-warning" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                    <button type="submit" style="cursor:pointer;" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css"> 
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>

document.getElementById('btnCancelar').addEventListener('click', function() {
        document.getElementById('nombreor').value = ''; 
    });
  
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

<script>


    $(document).ready(function() {
        $('#my-table').DataTable({
            "order": [[0, "asc"]],
            "columnDefs": [
                {
                    "targets": 2,
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