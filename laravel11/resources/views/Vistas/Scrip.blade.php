    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> -->

<!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>


    <script>
    $(document).ready(function () {
        $('#tablaCertificados').DataTable({
            responsive: true,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            },            
            pageLength: 10,
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            order: [[0, 'asc']],
            columnDefs: [
                // Columna de control (+)
                {
                    className: 'dtr-control',
                    orderable: false,
                    targets: 0,
                    defaultContent: '',
                    width: '30px'
                },

                // ===== COLUMNAS VISIBLES (Prioridad alta) =====
                { responsivePriority: 1, targets: 1 },  // N°
                { responsivePriority: 2, targets: 2 },  // DNI
                { responsivePriority: 3, targets: 3 },  // N° Certificado
                { responsivePriority: 4, targets: 4 },  // Nombres
                { responsivePriority: 5, targets: 5 },  // Teléfono
                { responsivePriority: 6, targets: 6 },  // Correo
                { responsivePriority: 7, targets: 7 },  // Estado
                { responsivePriority: 8, targets: 13 }, // PDF
                { responsivePriority: 9, targets: 14 }, // Inser N° Certi
                { responsivePriority: 10, targets: 15 }, // Acción

                // ===== COLUMNAS OCULTAS (desplegable) =====
                { targets: [8, 9, 10, 11, 12], className: 'none' } // Tipo, Cuaderno, Folio, N° Reg, Token
            ]
        });
    });
</script>