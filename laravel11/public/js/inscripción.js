$(document).ready(function(){
	// Activate tooltip
	$('[data-toggle="tooltip"]').tooltip();
	
	// Select/Deselect checkboxes
	var checkbox = $('table tbody input[type="checkbox"]');
	$("#selectAll").click(function(){
		if(this.checked){
			checkbox.each(function(){
				this.checked = true;                        
			});
		} else{
			checkbox.each(function(){
				this.checked = false;                        
			});
		} 
	});
	checkbox.click(function(){
		if(!this.checked){
			$("#selectAll").prop("checked", false);
		}
	});
});
$(document).ready(function() {
    $("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass( "fa-eye-slash" );
            $('#show_hide_password i').removeClass( "fa-eye" );
        }else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass( "fa-eye-slash" );
            $('#show_hide_password i').addClass( "fa-eye" );
        }
    });
});



$(document).ready(function () {  
    function updateSelectedEvent() {  
        var selectedEventId = $('#ideven').val();
        var selectedEventText = $('#ideven').find('option:selected').text();  
        $('#eventoo').text(selectedEventText || 'Ninguno');  
        $('#evenselec').text(selectedEventText || 'Ninguno');  
        $('#idevento').val(selectedEventId);  // Actualiza el campo oculto
    }  

    $('#ideven').on('change', function () {  
        updateSelectedEvent();
    });  

    updateSelectedEvent();

    // Asegúrate de que el ID del evento se incluya al enviar el formulario
    $('#addEmployeeModal').on('submit', function() {
        var selectedEventId = $('#ideven').val();
        $('#idevento').val(selectedEventId);
    });
    });

	
	$(document).ready(function() {
		$('#dni').on('keyup', function() {
			var dni = $(this).val();
			console.log("DNI ingresado: " + dni);
	
			// Si el campo DNI está vacío, limpiar los campos automáticamente
			if (dni.length === 0) {
				limpiarCampos();
				return;
			}
	
			if (dni.length === 8) {
				$.ajax({
					url: 'participant/' + dni,
					method: 'GET',
					success: function(response) {
						if (response.success) {
							$('#nombre').val(response.data.nombre);
							$('#apell').val(response.data.apell);
							$('#tele').val(response.data.tele);
							$('#email').val(response.data.email);
							$('#direc').val(response.data.direc);
							$('#tip_usu').val(response.data.idgenero); // género
							$('#idescuela').val(response.data.idescuela); // escuela
						} else {
							limpiarCampos();
						}
					},
					error: function(jqXHR, textStatus, errorThrown) {
						limpiarCampos(); // Limpiar campos en caso de error AJAX
						alert("Error en la llamada AJAX: " + textStatus + " - " + errorThrown);
					}
				});
			} else {
				limpiarCampos(); // Limpiar campos si el DNI no tiene 8 caracteres
			}
		   });
			function limpiarCampos() {
			$('#nombre').val('');
			$('#apell').val('');
			$('#tele').val('');
			$('#email').val('');
			$('#direc').val('');
			$('#tip_usu').val('');
			$('#idescuela').val('');
		}
	});

	
	
$(document).ready(function() {
    // Manejar el cambio en el select de eventos
    $('#ideven').change(function() {
        var eventId = $(this).val();

        // Enviar una solicitud AJAX al servidor
        $.ajax({
            url: 'filter-by-event',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}', // Agregar el token CSRF
                event_id: eventId
            },
            success: function(data) {
                // Limpiar la tabla actual
                $('#inscripcionTable tbody').empty();

                // Llenar la tabla con los datos nuevos
                $.each(data, function(index, inscrip) {
                    var row = `<tr>
                        <td>${inscrip.persona.dni}</td>
                        <td>${inscrip.persona.apell} ${inscrip.persona.nombre}</td>
                        <td>${inscrip.persona.tele}</td>
                        <td>${inscrip.persona.email}</td>
                        <td>${inscrip.persona.direc}</td>
                        <td>${inscrip.persona.genero.nomgen}</td>
                        <td>${inscrip.escuela.nomescu}</td>
                        <td>
                            <div class="btn-group action-buttons">
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit${inscrip.idincrip}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete${inscrip.idincrip}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>`;
                    $('#inscripcionTable tbody').append(row);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });
});