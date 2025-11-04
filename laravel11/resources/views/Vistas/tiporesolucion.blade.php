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

    </style>
<body>
<h1>Tipo de resoluciones</h1>
<hr class="linea">
<div id="">
    <div class="container-fluid mt-3">
        <div class="row mb-3">
            <div class="col-md-2">
                <button  href="#addEmployeeModl" class="btn btn-primary" data-toggle="modal"><i class="bi bi-plus-circle"></i> AGREGAR NUEVO</button>
            </div>
         
        </div>
        <br>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="my-table" cellspacing="0" width="100%">
                <thead class="bg-dark text-white">
                    <tr>   
                         <th>N°</th>        
                        <th>Tipo de resolución</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tiporesoluciones as $index => $tip) 
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $tip->nomtiprs}}</td>
                        <td>
                            <div class="action-buttons">
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit{{$tip->idTipresol}}"><i class="bi bi-pencil"></i></button>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"  data-target="#delete{{$tip->idTipresol}}"><i class="bi bi-trash"></i></button>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('Rut.tipreso.store') }}" method="post">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title" id="addEmployeeModalLabel">Agregar nuevo tipo de Resolución</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nomtiprs" class="form-label">Tipo de Resolución</label>
                        <input type="text" class="form-control" name="nomtiprs" id="nomtiprs" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button"  class="btn btn-warning"  id="btnCancelar">Limpiar</button>
                    <button type="submit" style="cursor:pointer;" class="btn btn-success" name="save">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

   <!-- edit Modal HTML -->
   @foreach ($tiporesoluciones as $tip) 
<div id="edit{{ $tip->idTipresol }}" class="modal fade" tabindex="-1" aria-labelledby="editModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('Rut.tipreso.update', $tip->idTipresol) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editModalLabel">Editar tipo de resolución</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nomtiprs" class="form-label">Tipo de resolución</label>
                        <input type="text" class="form-control" name="nomtiprs" id="nomtiprs" value="{{ $tip->nomtiprs}}" required>
                    </div>
                </div>
                <div class="modal-footer">
                   <button type="submit" style="cursor:pointer;" class="btn btn-success" name="update">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endforeach

<!-- Modal Eliminar -->

@foreach ($tiporesoluciones as $tip) 
<div id="delete{{ $tip->idTipresol}}" class="modal fade" tabindex="-1" aria-labelledby="deleteModalLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('Rut.tipreso.destroy', $tip->idTipresol) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Eliminar tipo de resolución</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Estás seguro de eliminar a <strong>{{ $tip->nomtiprs}}</strong>?
                </div>
                <div class="modal-footer text-center">
                    <button type="button" style="cursor:pointer;" class="btn btn-warning" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                    <button type="submit" style="cursor:pointer;" class="btn btn-danger">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
    <script src="assets/js/facultad.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->

  <!-- <script>
    function searchTable() {
        var query = $('#search-input').val(); // Captura el valor del input de búsqueda
        $.ajax({
            url: "{{ route('buscar.facultad') }}", // URL que apunta al método del controlador
            type: 'GET',
            data: {
                search: query // Envía el término de búsqueda como parámetro
            },
            success: function(data) {
                $('tbody').html(data); // Actualiza el contenido de la tabla con los resultados
            },
            error: function(xhr, status, error) {
                console.error("Error en la búsqueda:", error); // Maneja cualquier error
            }
        });
    }

</script> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>  

document.getElementById('btnCancelar').addEventListener('click', function() {
        document.getElementById('nomtiprs').value = ''; 
    });
  
        document.addEventListener('DOMContentLoaded', function() {  
            @if (session('success'))  
                Swal.fire({  
                    icon: 'success',  
                    title: '¡Éxito!',  
                    text: '{{ session('success') }}',  
                    confirmButtonText: 'Aceptar'  
                });  
            @endif  

            @if (session('error'))  
                Swal.fire({  
                    icon: 'error',  
                    title: 'Error',  
                    text: '{{ session('error') }}',  
                    confirmButtonText: 'Aceptar'  
                });  
            @endif  
        });  
    </script>  




<!-- Incluye los archivos CSS y JS de DataTables -->
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

<script>
    
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