<!doctype html>
<html lang="es">
<head>
    <title>Iniciar sesión</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            background-image: url('{{ asset("images/una.jpg") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            position: relative;
            overflow-x: hidden;
        }

        /* Circulos de fondos animados */
        .bg-circle-1 {
            position: absolute;
            width: 24rem;
            height: 24rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -12rem;
            left: -12rem;
            filter: blur(60px);
            z-index: 2;
        }

        .bg-circle-2 {
            position: absolute;
            width: 24rem;
            height: 24rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            bottom: -12rem;
            right: -12rem;
            filter: blur(60px);
            z-index: 2;
        }

        .bg-circle-3 {
            position: absolute;
            width: 16rem;
            height: 16rem;
            background: rgba(168, 85, 247, 0.2);
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            filter: blur(40px);
            animation: pulse 4s ease-in-out infinite;
            z-index: 2;
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.5; transform: translate(-50%, -50%) scale(1); }
            50% { opacity: 0.8; transform: translate(-50%, -50%) scale(1.1); }
        }

        /* Contenedor de inicio de sesion */
        .login-container {
            position: relative;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 1.5rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 28rem;
            z-index: 10;
        }

        /* Encabezado con degradado */
        .login-header {
            position: relative;
            height: 10rem;
            background: linear-gradient(135deg, #3b82f6 0%, #3b8bdfff 50%, #3eb1f0ff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .login-header::before,
        .login-header::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            filter: blur(30px);
        }

        .login-header::before {
            width: 5rem;
            height: 5rem;
            top: 1rem;
            right: 1rem;
        }

        .login-header::after {
            width: 4rem;
            height: 4rem;
            bottom: 1rem;
            left: 1rem;
        }

        .logo-container {
            position: relative;
            width: 7rem;
            height: 7rem;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            z-index: 10;
        }

        .logo-container img {
            width: 5rem;
            height: 5rem;
            object-fit: contain;
        }

        /* Cuerpo de inicio de sesion */
        .login-body {
            padding: 2rem;
            margin-top: -1.5rem;
            background: rgba(255, 255, 255, 0.98);
            border-radius: 0 0 1.5rem 1.5rem;
        }

        .login-title {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-title h2 {
            font-size: 1.875rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .login-title p {
            color: #6b7280;
            font-size: 0.875rem;
        }

        /* Grupos de formulario */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .form-label i {
            color: #8b5cf6;
            font-size: 1rem;
        }

        .input-wrapper {
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            padding-left: 3rem;
            background: #f9fafb;
            border: 2px solid #e5e7eb;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .form-control:focus {
            outline: none;
            background: white;
            border-color: #8b5cf6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
        }

        .form-control::placeholder {
            color: #9ca3af;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            pointer-events: none;
        }

        .input-icon-right {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            cursor: pointer;
            transition: color 0.2s;
        }

        .input-icon-right:hover {
            color: #8b5cf6;
        }

        /* Estilo de selección */
        select.form-control {
            appearance: none;
            background-position: right 0.75rem center;
            background-size: 1.25rem;
            padding-right: 2.5rem;
            background-color: linear-gradient(to right, #eff6ff, #f3e8ff);
            border-color: #c4b5fd;
            font-weight: 500;
        }

        select.form-control {
            background: linear-gradient(to right, #eff6ff, #f3e8ff);
        }

        /* Botón */
        .btn-primary {
            width: 100%;
            padding: 0.875rem 1rem;
            background: linear-gradient(135deg, #2d6ff3ff 0%, #354deeff 100%);
            color: white;
            border: none;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 4px 12px rgba(70, 1, 232, 0.4);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(139, 92, 246, 0.6);
        }

        .forgot-password {
            text-align: center;
            margin-top: 1rem;
        }

        .forgot-password a {
            color: #5512f2ff;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: color 0.2s;
        }

        .forgot-password a:hover {
            color: #7c3aed;
            text-decoration: underline;
        }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            animation: fadeIn 0.3s ease-out;
        }

        .modal-overlay.active {
            display: flex;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Modal */
        .modal {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 32rem;
            max-height: 90vh;
            overflow-y: auto;
            animation: slideUp 0.3s ease-out;
        }

        /* Ocultar scrollbar pero mantener funcionalidad */
        .modal::-webkit-scrollbar {
            width: 8px;
        }

        .modal::-webkit-scrollbar-track {
            background: transparent;
        }

        .modal::-webkit-scrollbar-thumb {
            background: rgba(139, 92, 246, 0.3);
            border-radius: 10px;
        }

        .modal::-webkit-scrollbar-thumb:hover {
            background: rgba(139, 92, 246, 0.5);
        }

        .modal-header {
            background: linear-gradient(135deg, #206fefff 0%, #591aebff 100%);
            padding: 1.5rem;
            border-radius: 1.5rem 1.5rem 0 0;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .modal-header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .modal-icon {
            width: 2.5rem;
            height: 2.5rem;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-icon i {
            color: white;
            font-size: 1.25rem;
        }

        .modal-title {
            color: white;
        }

        .modal-title h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .modal-title p {
            font-size: 0.875rem;
            opacity: 0.9;
        }

        .modal-close {
            width: 2rem;
            height: 2rem;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }

        .modal-close:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .modal-close i {
            color: white;
            font-size: 1.25rem;
        }

        .modal-body {
            padding: 1.5rem;
        }

        /* Sección de campos de actualización */
        .update-section {
            display: none;
            border-top: 2px solid #e5e7eb;
            padding-top: 1.25rem;
            margin-top: 1.25rem;
            animation: slideDown 0.3s ease-out;
        }

        .update-section.active {
            display: block;
        }

        .success-badge {
            background: #d1fae5;
            border-left: 4px solid #10b981;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .success-badge i {
            color: #10b981;
            font-size: 1.25rem;
        }

        .success-badge p {
            color: #065f46;
            font-weight: 600;
            font-size: 0.875rem;
        }

        /* Variantes de Botón */
        .btn-verify {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
        }

        .btn-update {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .btn-update:hover {
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.6);
        }

        /* Modal de éxito */
        .success-modal .modal-header {
            background: linear-gradient(135deg, #39ecb1ff 0%, #059669 100%);
            text-align: center;
        }

        .success-icon-large {
            width: 5rem;
            height: 5rem;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .success-icon-large i {
            color: #10b981;
            font-size: 2.5rem;
        }

        .success-modal .modal-title h3 {
            text-align: center;
        }

        .success-modal .modal-body {
            text-align: center;
        }

        .success-modal .modal-body p {
            color: #6b7280;
            margin-bottom: 1.5rem;
        }

        /* Responsivo */
        @media (max-width: 640px) {
            .login-container {
                max-width: 100%;
            }

            .modal {
                max-width: 100%;
                border-radius: 1rem;
            }

            .login-title h2 {
                font-size: 1.5rem;
            }
        }

        /* Clase oculta */
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="bg-circle-1"></div>
    <div class="bg-circle-2"></div>
    <div class="bg-circle-3"></div>

    <div class="login-container">
        <div class="login-header">
            <div class="logo-container">
                <img src="{{ asset('images/logou.png') }}" alt="Logo">
            </div>
        </div>

        <!-- Cuerpo -->
        <div class="login-body">
            <div class="login-title">
                <h2>Bienvenido</h2>
                <p>Ingresa tus credenciales para continuar</p>
            </div>

            <form action="{{ route('authenticate') }}" method="POST">
                @csrf
                <!-- Tipo de Usuario -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-shield-alt"></i>
                        Tipo de usuario
                    </label>
                    <div class="input-wrapper">
                        <select name="idTipUsua" id="idTipUsua" class="form-control" required>
                            @foreach ($tipousuarios as $tip)
                                <option value="{{ $tip->idTipUsua }}">{{ $tip->tipousu }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Usuario  -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-user"></i>
                        Usuario
                    </label>
                    <div class="input-wrapper">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" name="nomusu" class="form-control" placeholder="Ingresa tu usuario" required>
                    </div>
                </div>

                <!-- Contraseña -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-lock"></i>
                        Contraseña
                    </label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="pasword" id="password-field" class="form-control" placeholder="Ingresa tu contraseña" required>
                        <i class="fas fa-eye input-icon-right" id="toggle-password"></i>
                    </div>
                </div>

                <!-- Boton para iniciar sesion -->
                <button type="submit" class="btn-primary">
                    <i class="fas fa-lock"></i>
                    INICIAR SESIÓN
                </button>

                <div class="forgot-password">
                    <a href="#" id="forgot-link">
                        <i class="fas fa-envelope"></i>
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de Recuperación -->
    <div class="modal-overlay" id="recovery-modal">
        <div class="modal">
            <div class="modal-header">
                <div class="modal-header-content">
                    <div class="modal-header-left">
                        <div class="modal-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div class="modal-title">
                            <h3>Recuperar Contraseña</h3>
                            <p>Verifica tu identidad para continuar</p>
                        </div>
                    </div>
                    <button class="modal-close" id="modal-close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <div class="modal-body">
                <form id="recovery-form">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-id-card"></i>
                            DNI
                        </label>
                        <input type="text" id="dni" name="dni" class="form-control" placeholder="Ingresa tu DNI" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-map-marker-alt"></i>
                            Ubigeo
                        </label>
                        <input type="text" id="ubigeo" name="ubigeo" class="form-control" placeholder="Código de ubigeo" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-calendar"></i>
                            Fecha de Emisión
                        </label>
                        <input type="date" id="fecemi" name="fecemi" class="form-control" required>
                    </div>
                    <div class="update-section" id="update-fields">
                        <div class="success-badge">
                            <i class="fas fa-check-circle"></i>
                            <p>Verificado - Actualiza tus credenciales</p>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-user"></i>
                                Nuevo Nombre de Usuario
                            </label>
                            <input type="text" id="newUsername" name="newUsername" class="form-control" placeholder="Nuevo usuario">
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-lock"></i>
                                Nueva Contraseña
                            </label>
                            <div class="input-wrapper">
                                <input type="password" id="newPassword" name="newPassword" class="form-control" placeholder="Nueva contraseña">
                                <i class="fas fa-eye input-icon-right" id="toggle-new-password"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-lock"></i>
                                Confirmar Contraseña
                            </label>
                            <div class="input-wrapper">
                                <input type="password" id="newPassword_confirmation" name="newPassword_confirmation" class="form-control" placeholder="Confirma tu contraseña">
                                <i class="fas fa-eye input-icon-right" id="toggle-confirm-password"></i>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn-primary btn-verify" id="verify-btn">
                            <i class="fas fa-shield-alt"></i>
                            Verificar Identidad
                        </button>
                        <button type="button" class="btn-primary btn-update hidden" id="update-btn">
                            <i class="fas fa-check"></i>
                            Actualizar Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Éxito -->
    <div class="modal-overlay" id="success-modal">
        <div class="modal success-modal">
            <div class="modal-header">
                <div class="success-icon-large">
                    <i class="fas fa-check"></i>
                </div>
                <div class="modal-title">
                    <h3>¡Éxito!</h3>
                    <p>Tu usuario ha sido actualizado</p>
                </div>
            </div>

            <div class="modal-body">
                <p>Usuario actualizado exitosamente. Ahora puedes iniciar sesión con tus nuevas credenciales.</p>
                <button type="button" class="btn-primary btn-update" id="success-close">
                    Aceptar
                </button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.getElementById('toggle-password').addEventListener('click', function() {
            const passwordField = document.getElementById('password-field');
            const icon = this;
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        document.getElementById('toggle-new-password').addEventListener('click', function() {
            const field = document.getElementById('newPassword');
            const icon = this;
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        document.getElementById('toggle-confirm-password').addEventListener('click', function() {
            const field = document.getElementById('newPassword_confirmation');
            const icon = this;
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        document.getElementById('forgot-link').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('recovery-modal').classList.add('active');
        });

        document.getElementById('modal-close').addEventListener('click', function() {
            document.getElementById('recovery-modal').classList.remove('active');
            document.getElementById('update-fields').classList.remove('active');
            document.getElementById('verify-btn').classList.remove('hidden');
            document.getElementById('update-btn').classList.add('hidden');
            document.getElementById('recovery-form').reset();
        });

        document.getElementById('verify-btn').addEventListener('click', function() {
            const dni = document.getElementById('dni').value;
            const ubigeo = document.getElementById('ubigeo').value;
            const fecemi = document.getElementById('fecemi').value;

            if (!dni || !ubigeo || !fecemi) {
                alert('Por favor complete todos los campos de verificación');
                return;
            }

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
                        document.getElementById('update-fields').classList.add('active');
                        document.getElementById('verify-btn').classList.add('hidden');
                        document.getElementById('update-btn').classList.remove('hidden');
                    } else {
                        alert("Datos incorrectos. Por favor, verifique su información.");
                    }
                },
                error: function() {
                    alert("Error al procesar la solicitud. Intente nuevamente.");
                }
            });
        });
        // Actualizar usuario
        document.getElementById('update-btn').addEventListener('click', function() {
            const dni = document.getElementById('dni').value;
            const newUsername = document.getElementById('newUsername').value;
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('newPassword_confirmation').value;

            if (!newUsername || !newPassword || !confirmPassword) {
                alert('Por favor complete todos los campos de actualización');
                return;
            }

            if (newPassword !== confirmPassword) {
                alert("Las contraseñas no coinciden. Por favor, verifica.");
                return;
            }

            $.ajax({
                url: "{{ route('updateUser') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    dni: dni,
                    newUsername: newUsername,
                    newPassword: newPassword
                },
                success: function(response) {
                    if (response.success) {
                        document.getElementById('recovery-modal').classList.remove('active');
                        document.getElementById('success-modal').classList.add('active');
                        document.getElementById('recovery-form').reset();
                        document.getElementById('update-fields').classList.remove('active');
                        document.getElementById('verify-btn').classList.remove('hidden');
                        document.getElementById('update-btn').classList.add('hidden');
                    } else {
                        alert("Error al actualizar el usuario. Intente nuevamente.");
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    alert("Error al procesar la solicitud. Intente nuevamente.");
                }
            });
        });

        // Cerrar modal de éxito
        document.getElementById('success-close').addEventListener('click', function() {
            document.getElementById('success-modal').classList.remove('active');
            window.location.reload();
        });

        // Cerrar modales al hacer clic fuera
        document.querySelectorAll('.modal-overlay').forEach(function(overlay) {
            overlay.addEventListener('click', function(e) {
                if (e.target === overlay) {
                    overlay.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>