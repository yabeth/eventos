<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="utf-8">  
    <meta http-equiv="X-UA-Compatible" content="IE=edge">  
    <meta name="viewport" content="width=device-width, initial-scale=1">  
    <title>Event Selection Test</title>  
    
    <!-- Bootstrap CSS -->  
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">  
</head>  
<body>  
    <div class="container mt-4">  
        <!-- Dropdown para seleccionar evento -->  
        <div class="form-group">  
            <label for="even">Evento</label>  
            <select id="even" class="form-control">  
                <option value="">Seleccione un evento</option>  
                <option value="1">Evento 1</option>  
                <option value="2">Evento 2</option>  
                <option value="3">Evento 3</option>  
            </select>  
        </div>  
        
        <!-- Botón para abrir el modal -->  
        <button class="btn btn-success" data-toggle="modal" data-target="#addEmployeeModal">Abrir Modal</button>  
        
        <!-- Modal -->  
        <div id="addEmployeeModal" class="modal fade" tabindex="-1" role="dialog">  
            <div class="modal-dialog" role="document">  
                <div class="modal-content">  
                    <div class="modal-header">  
                        <h5 class="modal-title">Modal</h5>  
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">  
                            <span aria-hidden="true">&times;</span>  
                        </button>  
                    </div>  
                    <div class="modal-body">  
                        <p>Evento Seleccionado: <span id="selected-event">Ninguno</span></p>  
                    </div>  
                    <div class="modal-footer">  
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>  
                    </div>  
                </div>  
            </div>  
        </div>  
    </div>  
    
    <!-- jQuery -->  
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>  
    <!-- Bootstrap JS -->  
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>  
    
    <script>  
        $(document).ready(function () {  
            // Función para actualizar el evento seleccionado  
            function updateSelectedEvent() {  
                var selectedEvent = $('#even').find('option:selected').text();  
                $('#selected-event').text(selectedEvent || 'Ninguno');  
            }  

            // Actualiza el evento seleccionado en el modal cuando se muestra  
            $('#addEmployeeModal').on('show.bs.modal', function () {  
                updateSelectedEvent();  
            });  

            // Actualiza el evento seleccionado si el usuario cambia la selección  
            $('#even').on('change', function () {  
                if ($('#addEmployeeModal').hasClass('show')) {  
                    updateSelectedEvent();  
                }  
            });  
        });  
    </script>  
</body>  
</html>