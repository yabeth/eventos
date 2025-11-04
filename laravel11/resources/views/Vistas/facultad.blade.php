@include('Vistas.Header')
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css"> 
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.1/font/bootstrap-icons.min.css"> -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&display=swap" rel="stylesheet"> -->
    <!-- <link rel="stylesheet" href="{{ asset('css/facultad.css') }}"> -->
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
<h1>Facultades</h1>
<hr class="linea">
<div id="">
    <div class="container-fluid mt-3">
        <div class="row mb-3">
            <div class="col-md-2">
                <button  href="#addEmployeeModl" class="btn btn-primary" data-toggle="modal"><i class="bi bi-plus-circle"></i> AGREGAR NUEVO</button>
            </div>
            <div class="col-md-2">
                <div class="dropdown">
                    
                    <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                        <li><a class="dropdown-item" href="#">CSV</a></li>
                        <li><a class="dropdown-item" href="#">Excel</a></li>
                        <li><a class="dropdown-item" href="#">PDF</a></li>
                    </ul>
                </div>
            </div>
            <!-- <div class="col-md-6">
                <div class="input-group">
                    <input type="text" id="search-input" class="form-control" placeholder="Buscar" onkeyup="searchTable()">
                    <button class="btn btn-outline-secondary" type="button"><i class="bi bi-search"></i></button>
                </div>
            </div> -->
        </div>
        <br>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="my-table" cellspacing="0" width="100%">
                <thead class="bg-dark text-white">
                    <tr>  
                        <th>N°</th>        
                        <th>Facultad</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($facultads as $index => $facultad) 
                    <tr>
                        <td>{{ $index + 1 }}</td> 
                        <td>{{ $facultad->nomfac}}</td>
                        <td>
                            <div class="action-buttons">
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit{{$facultad->idfacultad}}"><i class="bi bi-pencil"></i></button>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"  data-target="#delete{{$facultad->idfacultad}}"><i class="bi bi-trash"></i></button>
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
            <form action="{{ route('Rut.facu.store') }}" method="post">
                @csrf
                <div class="modal-header bg-primary text-white">  
                    <h4 class="modal-title" id="addEmployeeModlLabel">Agregar nueva facultad</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nomfac" class="form-label">Facultad</label>
                        <input type="text" class="form-control" name="nomfac" id="nomfac" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button"  class="btn btn-warning" aria-hidden="true" id="btnCancelar">Limpiar</button>
                    <button type="submit" style="cursor:pointer;" class="btn btn-success" name="save">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

   <!-- edit Modal HTML -->
   @foreach ($facultads as $facultad) 
<div id="edit{{ $facultad->idfacultad }}" class="modal fade" tabindex="-1" aria-labelledby="editModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('Rut.facu.update', $facultad->idfacultad) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editModalLabel">Editar facultad</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nomfac" class="form-label">Facultad</label>
                        <input type="text" class="form-control" name="nomfac" id="nomfac" value="{{ $facultad->nomfac }}" required>
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

@foreach ($facultads as $facultad) 
<div id="delete{{ $facultad->idfacultad }}" class="modal fade" tabindex="-1" aria-labelledby="deleteModalLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('Rut.facu.destroy', $facultad->idfacultad) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Eliminar Facultad</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Estás seguro de eliminar a <strong>{{ $facultad->nomfac }}</strong>?
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

  <script>


document.getElementById('btnCancelar').addEventListener('click', function() {
        document.getElementById('nomfac').value = '';  
    });


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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">  
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    </script>
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