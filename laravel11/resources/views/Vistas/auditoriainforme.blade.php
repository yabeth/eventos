@include('Vistas.Header')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.1/font/bootstrap-icons.min.css"> 
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">  

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

<div>
<h3 class="text-center p-3">Auditoria informes</h3>
    <hr class="linea">
    <div class="container-fluid mt-3">
        <table class="table table-striped table-bordered table-hover" id="my-table" cellspacing="0" width="100%">
            <thead class="bg-dark text-white">
                <tr>
                    <th>N°</th>
                    <th>Usuario</th>
                    <th>Operación</th>
                    <th>Fecha de Operación</th>
                    <th>Ruta</th>
                    <th>Fecha de Presentación</th>
                    <th>Nombre de Usuario</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($informe_auditoria as $index => $auditoria)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $auditoria->usuario }}</td>
                    <td>{{ $auditoria->operacion }}</td>
                    <td>{{ $auditoria->fecha_operacion }}</td>
                    <td>{{ $auditoria->rta }}</td>
                    <td>{{ $auditoria->fecha_presentacion }}</td>
                    <td>{{ $auditoria->nombreusuario }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
            "search": "Buscar:",
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
