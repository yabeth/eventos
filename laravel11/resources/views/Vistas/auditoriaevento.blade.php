@include('Vistas.Header')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.1/font/bootstrap-icons.min.css"> 
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
<div id="">
<h1>@if(Auth::check())
    <p>Bienvenido, {{ Auth::user()->nomusu }}!</p>
@else
    <p>Por favor, inicia sesión.</p>
@endif</h1>
<hr class="linea">
<div class="container-fluid mt-3">
    
        <div class="col-md-6 d-flex align-items-start">  
    <div class="p-4 rounded border" style="background: linear-gradient(135deg, #d1e7ff, #eaf8ff); box-shadow: 0 1px 1px rgba(0,0,0,0.2); padding-top: 0;">  
        <form action="{{ route('auditevenfecha') }}" method="get" class="d-flex w-100" style="margin-top: 0;">  
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
                {{ session('error') }}
            </div>
        @endif
    </div>
</div>
       <br>
       <table class="table table-striped table-bordered table-hover" id="my-table" cellspacing="0" width="100%">
    <thead class="bg-dark text-white">
        <tr>
            <th>N°</th>
            <th>Usuario</th>
            <th>Operación</th>
            <th>Descripción</th>
            <th>Fecha de Operación</th>
            
        </tr>
    </thead>
    <tbody>
    @foreach ($evento_auditoria as $index => $auditoria )
        <tr>
            <td>{{ $index + 1 }}</td> 
            <td>{{ $auditoria->nombreusuario }}</td>
            <td>{{ $auditoria->operacion }}</td>
            <td>{{ $auditoria->descripcioneven }}</td>
            <td>{{ $auditoria->fecha_operacion }}</td>
            
        </tr>
    @endforeach
    </tbody>
</table>

</div> 

     <!-- crear Modal HTML -->
<div id="addEmployeeModl" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered"> <!-- modal centrado verticalmente -->
        <div class="modal-content">
            <form  action="{{ route('Rut.evento.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addEventModalLabel">Agregar Nuevo Evento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

               


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