@include('Vistas.Header')
<div class="">
    <h3 class="text-center p-3">Auditoria de Inscripcion</h3>
</div>
<hr class="linea">
<div class="container-fluid mt-3">
    <table class="table table-striped table-bordered table-hover" id="my-table" cellspacing="0" width="100%">
        <thead class="bg-dark text-white">
            <tr>
                <th>ID Auditoría</th>
                <th>Operación</th>
                <th>Escuela</th>
                <th>Persona</th>
                <th>Evento</th>
                <th>Fecha Modificación</th>
                <th>Usuario</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inscripcion as $audit)
                <tr>
                    <td>{{ $audit->id_auditoria }}</td>
                    <td>{{ $audit->operacion }}</td>
                    <td>{{ $audit->escuela }}</td>
                    <td>{{ $audit->personas }}</td>
                    <td>{{ $audit->evento }}</td>
                    <td>{{ $audit->fecha_modificacion }}</td>
                    <td>{{ $audit->nomusu }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>



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