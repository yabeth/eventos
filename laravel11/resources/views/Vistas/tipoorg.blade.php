
@include('Vistas.Header')
 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css"> 
    <link rel="stylesheet" href="https://www.flaticon.es/iconos-gratis/enlace"> 
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&display=swap" rel="stylesheet"> 
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

.dataTables_length {
        float: right;
        margin-right: 10px;
    }

    .dataTables_length label {
        display: flex;
        align-items: center;
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
        .container {
            max-width: 100%; 
            padding: 0 5px;
        }

        .card {
            width: 100%; 
        }
    </style>
</head>

<body>
<div id="tabla-tipeven">
    <div class="container mt-2">
        <div class="card">
            <div class="card-header">
                <h5 class="text-center">Tipo de organizador</h5>
            </div>
            <div class="container">
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="row mb-3">
                            <div class="col-md-5 d-flex justify-content-start">
                                <button href="#addEmployeeModl" class="btn btn-primary" data-bs-toggle="modal">
                                    <i class="bi bi-plus-circle"></i> AGREGAR NUEVO
                                </button>
                            </div>
                        </div>

                        <table class="table table-striped table-bordered table-hover"  id="my-table" cellspacing="0" width="100%" class="table">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th>N°</th>
                                    <th>Tipo de organizador</th>
                                    <th style="width: 90px;">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tipoorgs as $index => $tipo)
                                  <tr>
                                  <td>{{ $index + 1 }}</td> 
                                    <td>{{ $tipo->nombre}}</td>
                                    <td>
                                        <center>
                                            <div class="action-buttons">
                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit{{$tipo->idtipo}}">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete{{$tipo->idtipo}}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </center>
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
     <div id="addEmployeeModl" class="modal fade" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form action="{{ route('Rut.tipoorg.store') }}" method="post">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="addEmployeeModlLabel">Agregar nuevo Tipo de organizador</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">  
                          <span aria-hidden="true">&times;</span>  
                        </button> 
                    
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Tipo de organizador</label>
                            <input type="text" class="form-control" name="nombre" id="nombre">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCancelar">Limpiar</button>
                        <button type="submit" class="btn btn-success" name="save">Guardar</button>
                    </div>
                </form>
        </div>
    </div>
</div>







    <!-- Modal Editar -->
    @foreach($tipoorgs as $tipo)
    <div id="edit{{ $tipo->idtipo}}" class="modal fade" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('Rut.tipoorg.update', $tipo->idtipo) }}" method="POST" >
                    @csrf
                    @method('PUT')
                    
                    <div class="modal-header bg-primary text-white">            
                    <h4 class="modal-title" id="editModalLabel">Editar Tipo de organizador</h4>  
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" style="color: white;">  
                        <span aria-hidden="true">&times;</span>  
                    </button>  
                </div>  
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Tipo de organizador</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" value="{{ $tipo->nombre}}">
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
    @foreach($tipoorgs as $tipo)
<div id="delete{{ $tipo->idtipo}}" class="modal fade" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content text-center">
            <form action="{{ route('Rut.tipoorg.destroy', $tipo->idtipo) }}" method="POST">
            @csrf
            @method('DELETE')
                <div class="modal-header border-0 justify-content-center pb-1">
                    <div class="modal-title">
                        <i class="bi bi-exclamation-circle" style="font-size: 80px; color: #f4c542;"></i>
                    </div>
                </div>


                
                <div class="modal-body pt-2 pb-3">
                    <h4 class="mb-1">Confirmar</h4>
                    <p class="mb-3">¿Estás seguro que deseas eliminar <strong>{{ $tipo->nombre }}</strong>?</p>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> 
     <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>   
   <script>


document.getElementById('btnCancelar').addEventListener('click', function() {
        document.getElementById('nombre').value = ''; 
    });


$('.close').on('click', function () {  
    $('#addEmployeeModl').modal('hide');   
});  


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





    document.getElementById('saveBtn').addEventListener('click', function() {
        let formData = new FormData(document.getElementById('addEmployeeForm'));

        fetch('{{ route("Rut.tipoorg.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: data.message,
                });

                // Aquí puedes cerrar el modal si lo deseas
                document.getElementById('addEmployeeModl').modal('hide');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Ocurrió un error al intentar guardar el tipo de evento',
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error en el servidor',
            });
            console.error('Error:', error);
        });
    });

</script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
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
