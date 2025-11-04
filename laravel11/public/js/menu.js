function cargarTipoEvento(event) {  
    event.preventDefault(); // Evitar el comportamiento por defecto del enlace  

    // Realizar la solicitud AJAX  
    $.ajax({  
        url: '/tipo-evento',  
        type: 'GET',  
        success: function(data) {  
            // Suponiendo que `data` contiene el HTML que quieres mostrar  
            $('#contenido').html(data); // Reemplazar el contenido de un div con id "contenido"  
        },  
        error: function(xhr, status, error) {  
            console.error("Error al cargar el tipo de evento: ", error);  
        }  
    });  
}