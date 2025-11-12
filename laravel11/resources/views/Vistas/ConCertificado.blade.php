@include('Vistas.Header')

<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" rel="stylesheet">

<style>
    body {
        background-color: #f8f9fa;
    }

    .container {
        max-width: 100%;
        padding: 5px 0;
        box-sizing: border-box;
        margin: 0 auto;
    }

    .card {
        width: 100%;
        margin-bottom: 5px;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .table-container {
        background: white;
        padding: 10px;
        border-radius: 8px;
    }

    .btn-sm {
        margin: 2px;
    }

    #tablaCertificados {
        font-size: 11px;
    }

    table.dataTable.dtr-inline.collapsed>tbody>tr>td.dtr-control:before,
    table.dataTable.dtr-inline.collapsed>tbody>tr>th.dtr-control:before {
        background-color: #0d6efd;
    }

    table.dataTable.dtr-inline.collapsed>tbody>tr.parent>td.dtr-control:before {
        background-color: #dc3545;
    }
</style>

{{-- HEADER --}}


<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white text-center">
            <h5 class="card-title mb-0">GESTIÓN DE CERTIFICADOS</h5>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="ideven" class="form-label">Eventos: <span class="text-danger">*</span></label>
                    <select id="ideven" name="ideven" class="form-select" required>
                        <option value="" selected disabled>Seleccione un evento --</option>
                        @if(isset($eventos) && $eventos->count() > 0)
                            @foreach ($eventos as $even)
                            <option value="{{ $even->idevento }}">{{ $even->eventnom }}</option>
                            @endforeach
                            @else
                            <option value="" disabled>No hay eventos disponibles</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="obser" class="form-label">Descripción</label>
                    <textarea name="obser" id="obser" rows="2" class="form-control"
                        placeholder="Ingrese una descripción"></textarea>
                </div>
            </div>

            <div class="table-container">
                <h6 class="mb-3">Lista de Certificados</h6>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" id="tablaCertificados"
                        style="width:100%">
                        <thead class="table-info">
                            <tr>
                                <th>N°</th>
                                <th>DNI</th>
                                <th>N° Certi</th>
                                <th>Nombres</th>
                                <th>Teléfono</th>
                                <th>Correo</th>
                                <th>Estado</th>
                                <th>Tipo Certificado</th>
                                <th>Cuaderno</th>
                                <th>Folio</th>
                                <th>N° Reg</th>
                                <th>Token</th>
                                <th>Descripción</th>
                                <th>PDF</th>
                                <th>Inser N° Certi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<script>
    $(document).ready(function() {
        $('#ideven').change(function() {
            var eventId = $(this).val();
            loadCertificados(eventId);
        });
    });
    function loadCertificados(eventId) {
        $.ajax({
            url: 'filter-by-eventos',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                event_id: eventId
            },
            success: function(certificados) {
                if ($.fn.DataTable.isDataTable('#tablaCertificados')) {
                    $('#tablaCertificados').DataTable().destroy();
                }

                $('#tablaCertificados tbody').empty();
                let numeroCertificado = 1;

                $.each(certificados, function(index, certificado) {
                    if (!certificado.certiasiste ||
                        !certificado.certiasiste.asistencia ||
                        !certificado.certiasiste.asistencia.inscripcion ||
                        !certificado.certiasiste.asistencia.inscripcion.persona) {
                        console.warn('Certificado sin persona asociada:', certificado.idCertif);
                        return;
                    }

                    var persona = certificado.certiasiste.asistencia.inscripcion.persona;
                    var estadoCerti = certificado.estado_certificado || {};
                    var tipoCerti = certificado.tipo_certificado || {};

                    var estadoText = estadoCerti.nomestadc || 'Sin estado';
                    var estadoClass = certificado.idestcer == 2 ? 'btn-success' : 'btn-warning';

                    var pdfLink = certificado.pdff ?
                        `<a href="${certificado.pdff}" target="_blank" class="btn btn-xs btn-info">Ver PDF</a>` :
                        'Sin PDF';

                    var row = `  
                <tr>  
                    <td>${numeroCertificado}</td>  
                    <td>${persona.dni || 'N/A'}</td>  
                    <td>${certificado.nro || 'No asignado'}</td>  
                    <td>${persona.apell || ''} ${persona.nombre || ''}</td>  
                    <td>${persona.tele || 'N/A'}</td>  
                    <td>${persona.email || 'N/A'}</td>  
                    <td>  
                        <button class="btn btn-xs ${estadoClass} cambiar-estado" 
                            data-id="${certificado.idCertif}" 
                            data-estado="${certificado.idestcer}">  
                            ${estadoText}  
                        </button>  
                    </td>  
                    <td>${tipoCerti.tipocertifi || 'N/A'}</td>  
                    <td>${certificado.cuader || 'N/A'}</td>  
                    <td>${certificado.foli || 'N/A'}</td>  
                    <td>${certificado.numregis || 'N/A'}</td>  
                    <td><span class="badge bg-secondary">${certificado.tokenn || 'N/A'}</span></td>  
                    <td>${certificado.descr || 'Sin descripción'}</td>  
                    <td>${pdfLink}</td>  
                    <td>  
                        <button class="btn btn-xs btn-primary ingresar-numero" 
                            data-id="${certificado.idCertif}">  
                            Ingresar N°  
                        </button>  
                    </td>  
                </tr>`;

                    $('#tablaCertificados tbody').append(row);
                    numeroCertificado++;
                });

                $('#tablaCertificados').DataTable({
                    responsive: true,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                    },
                    order: [
                        [0, 'asc']
                    ],
                    pageLength: 25
                });

                bindButtonEvents();
            },
            error: function(xhr, status, error) {
                console.error("Error al cargar certificados:", xhr.responseText);
                alert('Error al cargar los certificados. Revise la consola para más detalles.');
            }
        });
    }
</script>

@include('Vistas.Footer')
@include('Vistas.Scrip')