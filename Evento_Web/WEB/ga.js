$(document).ready(function() {
    $('#carouselExampleControls').carousel({
        interval: 5000
    });
});

$(document).ready(function(){
    $('#registerModal').on('show.bs.modal', function (event) {
        console.log('Modal is about to be shown');
        
        var button = $(event.relatedTarget); // Botón que abre el modal
        console.log('Button:', button);
        
        var idevento = button.data('idevento'); // Extrae el valor de data-idevento
        console.log('Evento ID:', idevento);
        
        // Actualiza el campo hidden con el idevento
        var modal = $(this);
        modal.find('input[name="idevento"]').val(idevento);
    });
});
  

// Registrar persona
document.getElementById('registroForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Evitar que el formulario se envíe de forma predeterminada

    const formData = new FormData(this); // Obtener los datos del formulario
    let emptyFields = false;

    // Asegurarse de que los campos se han actualizado después del autocompletado
    setTimeout(() => {
        formData.forEach((value, key) => {
            if (value.trim() === '') {
                emptyFields = true;
                console.log('Campo vacío:', key); // Depuración
            }
        });

        if (emptyFields) {
            Swal.fire({
                icon: 'warning',
                title: 'Campos incompletos',
                text: 'Por favor, complete todos los campos.',
                confirmButtonText: 'OK'
            });
            return; // No enviar el formulario si hay campos vacíos
        }

    // Obtener el valor del campo DNI y teléfono
    const dni = formData.get('dni').trim();
    const telefono = formData.get('telefono').trim();

    // Validar que el DNI tenga exactamente 8 dígitos
    if (dni.length !== 8 || isNaN(dni)) {
        Swal.fire({
            icon: 'warning',
            title: 'DNI inválido',
            text: 'El DNI debe contener exactamente 8 dígitos numéricos.',
            confirmButtonText: 'OK'
        });
        return; // No enviar el formulario si el DNI no es válido
    }

    // Validar que el teléfono tenga exactamente 9 dígitos
    if (telefono.length !== 9 || isNaN(telefono)) {
        Swal.fire({
            icon: 'warning',
            title: 'Teléfono inválido',
            text: 'El teléfono debe contener exactamente 9 dígitos numéricos.',
            confirmButtonText: 'OK'
        });
        return; // No enviar el formulario si el teléfono no es válido
    }

        // Enviar datos al servidor
        fetch('procesar_registro.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Registro exitoso',
                    text: '✔️ Se enviaron los datos correctamente.',
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    willClose: () => {
                        window.location.href = ''; // Redirige a la página principal
                    }
                });
            } else if (data.status === 'error' && data.message.includes('No puede registrarse dos veces')) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de registro',
                    text: 'No puede registrarse dos veces en el mismo evento.',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message,
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error fatal',
                text: 'Hubo un problema en la solicitud',
                confirmButtonText: 'OK'
            });
        });
    }, 100); // Se da un pequeño retraso para asegurarse de que el autocompletado haya ocurrido
});


//Autocompletado si ya existe la perosna
document.addEventListener('DOMContentLoaded', function() {
    const dniInput = document.getElementById('dni');
    const ideventoInput = document.getElementById('idevento');

    dniInput.addEventListener('input', function() {
        const dni = dniInput.value.trim();

        // Verificar si el DNI tiene 8 dígitos antes de realizar la búsqueda
        if (dni.length === 8) {
            fetch('buscar_persona.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({ 'dni': dni })
            })
            .then(response => response.json())  // Ya sabemos que el JSON es válido
            .then(data => {
                if (data.success) {
                    document.getElementById('apellidos').value = data.data.apellidos;
                    document.getElementById('nombres').value = data.data.nombres;
                    document.getElementById('telefono').value = data.data.telefono;
                    document.getElementById('correo').value = data.data.correo;
                    document.getElementById('direccion').value = data.data.direccion;
                    document.getElementById('genero').value = data.data.genero;
                    document.getElementById('escuela').value = data.data.escuela;
                    // No cambiar el idevento, ya que debe permanecer el que se abrió al mostrar el modal
                } else {
                    console.log('Persona no encontrada');
                    // Si no se encuentra la persona, se pueden limpiar los campos, excepto idevento
                    document.getElementById('apellidos').value = '';
                    document.getElementById('nombres').value = '';
                    document.getElementById('telefono').value = '';
                    document.getElementById('correo').value = '';
                    document.getElementById('direccion').value = '';
                    document.getElementById('genero').value = 'E';
                    document.getElementById('escuela').value = 'E';
                }
            })
            .catch(error => console.error('Error al buscar persona:', error));
        } else {
            // Limpiar los campos si el DNI tiene menos de 8 dígitos
            document.getElementById('apellidos').value = '';
            document.getElementById('nombres').value = '';
            document.getElementById('telefono').value = '';
            document.getElementById('correo').value = '';
            document.getElementById('direccion').value = '';
            document.getElementById('genero').value = 'E';
            document.getElementById('escuela').value = 'E';
        }
    });
});


//limpiar modal

document.addEventListener('DOMContentLoaded', function() {
    const dniInput = document.getElementById('dni');
    const modal = document.getElementById('registerModal');

    // Función para limpiar los campos del modal
    function clearModalFields() {
        document.getElementById('dni').value = '';
        document.getElementById('apellidos').value = '';
        document.getElementById('nombres').value = '';
        document.getElementById('telefono').value = '';
        document.getElementById('correo').value = '';
        document.getElementById('direccion').value = '';
        document.getElementById('genero').value = 'E';
        document.getElementById('escuela').value = 'E';
        // No limpiar idevento ya que se debe mantener el mismo valor
    }

    // Limpiar campos al cerrar el modal con la X
    document.querySelector('#registerModal .close').addEventListener('click', function() {
        clearModalFields();
    });

    // Limpiar campos al hacer clic fuera del modal
    $('#registerModal').on('hidden.bs.modal', function () {
        clearModalFields();
    });



});
