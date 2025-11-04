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
<h1>@if(Auth::check())
    <p>Auditoria Certificados</p>
@else
    <p>Por favor, inicia sesión.</p>
@endif</h1>
<hr class="linea">
<div class="container-fluid mt-3">
    
@if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>
</div>
       <br>
       <table class="table table-striped table-bordered table-hover" id="my-table" cellspacing="0" width="100%" class="table">
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
    @foreach ($certificado_auditoria as $index => $auditoria )
        <tr>
            <td>{{ $index + 1 }}</td> 
            <td>{{ $auditoria->nombreusuario }}</td>
            <td>{{ $auditoria->operacion }}</td>
            <td>{{ $auditoria->descripcion}}</td>
            <td>{{ $auditoria->fecha_operacion }}</td>
            
        </tr>
    @endforeach
    </tbody>
</table>

</div> 

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">  
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11">

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

     #my-table {
        width: 100% !important;
    }

    #my-table th, #my-table td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
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
            },
       
        });
    });
</script>
@include('Vistas.Footer')