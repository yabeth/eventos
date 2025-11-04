<bs5-1>
<!doctype html>
<html lang="en">
  <head>
  	<title>Iniciar sesión</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
 <style>
    #forgotPasswordModal .modal-content {
         /* Fondo azul translúcido */
        color: #000; /* Asegura el color de texto negro en el modal */
        font-size: 14px;
        text-align: center;

    }
    #forgotPasswordModal .form-control {
        color: #000; /* Asegura que el texto en los campos de entrada sea negro */
        border: 1px solid #ced4da; 
        /* Bordes visibles para los campos */
        background-color: #fff; /* Fondo blanco para los campos de entrada */
        font-size: 14px;
        text-align: center;

    }
    #forgotPasswordModal input::placeholder {
        color: #6c757d; /* Color de los placeholders para que sea visible */
        opacity: 1;
        font-size: 14px;
        text-align: center;

    }
    #updateFields .form-control {
        color: #000;
        border: 1px solid #ced4da; /* Bordes visibles para los campos */
        background-color: #fff;
        font-size: 14px;
        text-align: center;

    }
	.container{	
        min-height:500px;
        width: 450px;
        border: 0.5px solid #999;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, .2);
        backdrop-filter: blur(10px);
        top: 50%;
        left: 50%;
        transform: translate( -50% -50%);
        box-sizing: absolute;
        padding: 70px 30px;
    }
    .containermod{	
        min-height:400px;
        width: 380px;
        border: 0.5px solid #999;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, .2);
        backdrop-filter: blur(10px);
        top: 50%;
        left: 50%;
        transform: translate( -50% -50%);
        box-sizing: absolute;
        padding: 70px 30px;
    }
    .form-group{
        width: 310px;
        /* margin-left: -70px; */
    }
    .form-group-modal{
        width: 310px;
        color: #000;
        /* margin-left: -70px; */
    }
    .usrimg { 
        width: 130px;
        height: 150px;
        overflow: hidden;
        position: absolute;
        top: calc(-100px/2);
        left: calc(50% - 50px);
        margin-left: -20px;
	}

    .btn-link {
    display: inline-block;
    font-style: italic;
    font-weight: bold;
    text-decoration: none;
    color: #007bff; /* Color del texto */
    padding: 10px 20px;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.btn-link:hover {
    background-color: #e0e0e1; /* Color de fondo al pasar el cursor */
    color: #0056b3; /* Color del texto al pasar el cursor */
}

 </style>
	</head>
        <body style="background-image: url({{ asset('images/una.jpg') }});">
	        <section class="ftco-section">
                <div class="container">
                    <div class="row justify-content-center mb-4">
                        <div class="col-md-6 text-center" >
                            <img class="usrimg img-fluid" src="{{ asset('images/logou.png') }}" alt="Logo"> 
                        </div>
                    </div>
                    <br><br><br>
                    <div class="row justify-content-center mb-4">
                        <div class="login-wrap p-0">
                            <h2 class="heading-section text-center">Iniciar sesión</h2>
                            <form action="{{ route('authenticate') }}" method="POST" class="signin-form">
                                @csrf
                                <div class="form-group">
                                    <label>Tipo de usuario</label>
                                    <select name="idTipUsua" id="idTipUsua" class="form-control mb-2" style="background-color: #427eb3; color: white;" required>
                                        @foreach ($tipousuarios as $tip)
                                            <option value="{{ $tip->idTipUsua }}">{{ $tip->tipousu }}</option>
                                        @endforeach
                                    </select> 
                                </div>
                                <div class="form-group">
                                    <input type="text" name="nomusu" class="form-control" placeholder="Usuario" required>
                                </div>
                                <div class="form-group">
                                    <input id="password-field" type="password" name="pasword" class="form-control" placeholder="Contraseña" required>
                                    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="form-control btn btn-green submit px-3">INICIAR SESIÓN</button>
                                </div>
                                <div style="text-align: center;"><a href="#" class="btn-link" data-toggle="modal" data-target="#forgotPasswordModal">¿Olvidaste la contraseña?</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>


            <div class="modal fade" id="forgotPasswordModal" tabindex="-1" role="dialog" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog d-flex justify-content-center" role="document">
        <div class="modal-content p-4" style="display: flex; align-items: center; justify-content: center;">
                <div class="modal-header">
                    <h5 class="modal-title" id="forgotPasswordModalLabel">Recuperar contraseña</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <div class="containermod  background-color: rgba(0, 123, 255, 0.8)">
                    <form id="forgotPasswordForm">
                   
                    
                        @csrf
                        <div class="form-group text-center">
                            <label for="dni">DNI</label>
                            <input type="text" id="dni" name="dni" class="form-control form-control mb-2" style="background-color: #427eb3; color: red; text-align: center;" required>
                        </div>
                        <div class="form-group">
                            <label for="ubigeo">Ubigeo</label>
                            <input type="text" id="ubigeo" name="ubigeo" class="form-control" style="background-color: #427eb3; color: red;" required>
                        </div>
                        <div class="form-group">
                            <label for="fecemi">Fecha de Emisión</label>
                            <input type="date" id="fecemi" name="fecemi" class="form-control" style="background-color: #427eb3; color: red;" required>
                        </div>
                        <div class="form-group" id="updateFields" style="display: none;">
                            <label for="newUsername">Nuevo Nombre de Usuario</label>
                            <input type="text" id="newUsername" name="newUsername" class="form-control" style="background-color: #427eb3; color: red;">
                            


<label for="newPassword">Nueva Contraseña</label>
<div class="input-group">
    <input type="password" id="newPassword" name="newPassword" class="form-control" style="background-color: #427eb3; color: red;">
    <div class="input-group-append">
        <span class="input-group-text" onclick="togglePasswordVisibility('newPassword')">
            <i class="fa fa-eye" id="toggleNewPassword"></i>
        </span>
    </div>
</div>

<label for="newPassword_confirmation">Confirmar Nueva Contraseña</label>
<div class="input-group">
    <input type="password" id="newPassword_confirmation" name="newPassword_confirmation" class="form-control" style="background-color: #427eb3; color: red;">
    <div class="input-group-append">
        <span class="input-group-text" onclick="togglePasswordVisibility('newPassword_confirmation')">
            <i class="fa fa-eye" id="toggleNewPasswordConfirmation"></i>
        </span>
    </div>
</div>

</div>
                        <button type="button" onclick="validateUser()" class="btn btn-success mt-3">Verificar</button>
                        <button type="button" onclick="updateUser()" class="btn btn-success mt-3">Actualizar Usuario</button>
                    </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>




    <!-- Modal de Éxito -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Éxito</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Usuario actualizado exitosamente.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>

	    </body>
  <script src="{{ asset('js/jquery.min.js') }}"></script>
  <script src="{{ asset('js/popper.js') }}"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/main.js') }}"></script>
  <script>
     function validateUser() {
            // Obtener valores del formulario
            const dni = document.getElementById("dni").value;
            const ubigeo = document.getElementById("ubigeo").value;
            const fecemi = document.getElementById("fecemi").value;

            // Realizar una solicitud AJAX para verificar los datos
            $.ajax({
                url: "{{ route('validateUser') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    dni: dni,
                    ubigeo: ubigeo,
                    fecemi: fecemi
                },
                success: function(response) {
                    if (response.valid) {
                        // Si los datos son correctos, mostrar campos para actualizar
                        document.getElementById("updateFields").style.display = "block";
                    } else {
                        alert("Datos incorrectos. Por favor, verifique su información.");
                    }
                },
                error: function() {
                    alert("Error al procesar la solicitud. Intente nuevamente.");
                }
            });
        }
        function updateUser() {
            const dni = document.getElementById("dni").value;
    const newUsername = document.getElementById("newUsername").value;
    const newPassword = document.getElementById("newPassword").value;
    const confirmPassword = document.getElementById("newPassword_confirmation").value;

    if (newPassword !== confirmPassword) {
        alert("Las contraseñas no coinciden. Por favor, verifica.");
        return;
    }

    $.ajax({
        url: "{{ route('updateUser') }}", // Ajusta esta ruta según tu configuración
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            dni: dni,
            newUsername: newUsername,
            newPassword: newPassword
        },
        success: function(response) {
            if (response.success) {
                $('#forgotPasswordModal').modal('hide');
                $('#forgotPasswordForm')[0].reset();
                $('#successModal').modal('show');
                $('#successModal').on('hidden.bs.modal', function () {
            window.location.reload(); 
        });
            } else {
                alert("Error al actualizar el usuario. Intente nuevamente.");
            }
        },
        error: function(xhr, status, error) {
    console.log(xhr.responseText); // Verifica los detalles del error
    alert("Error al procesar la solicitud. Intente nuevamente.");
}
    });
}
function togglePasswordVisibility(fieldId) {
    const passwordField = document.getElementById(fieldId);
    const icon = document.querySelector(`#toggle${fieldId.charAt(0).toUpperCase() + fieldId.slice(1)}`);
    
    if (passwordField.type === "password") {
        passwordField.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        passwordField.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}
  </script>
</html>

</bs5-1>





