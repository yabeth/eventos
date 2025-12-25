@include('Vistas.Header')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</head>
<style>
    .password-wrapper {
        position: relative;
    }

    .toggle-button,
    .toggle-button-edit {
        display: inline-flex;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        right: 12px;
        cursor: pointer;
        z-index: 10;
    }

    .eye-icon {
        width: 20px;
        height: 20px;
    }

    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

    .container {
        max-width: 100%;
        padding: 0 5px;
    }

    .card {
        width: 100%;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
    }

    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #3a4ccfff 100%);
        padding: 10px;
    }

    .ibox-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 20px 0;
        gap: 15px;
        flex-wrap: wrap;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #3157cbff 100%);
        border: none;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .table {
        margin-top: 20px;
    }

    .table thead {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
    }

    .action-buttons {
        display: flex;
        gap: 5px;
    }

    .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #3246b7ff 100%);
    }

    .form-group label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .required-field::after {
        content: " *";
        color: #e74c3c;
        font-weight: bold;
    }

    .btn-success {
        background: linear-gradient(135deg, #3fda54ff 0%, #38ef7d 100%);
        border: none;
    }

    .btn-warning {
        background: linear-gradient(135deg, #ca2e4bff 0%, #f5576c 100%);
        border: none;
    }

    .btn-danger {
        background: linear-gradient(135deg, #ccc55dff 0%, #fee140 100%);
        border: none;
    }

    .permiso-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .permiso-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
    }
</style>

<body>
    <div id="tabla-usuarios">
        <div class="container-fluid mt-3">
            <div class="card">
                <div class="card-header text-white">
                    <h5 class="text-center mb-0"> Gestión de Usuarios</h5>
                </div>
                <div class="container">
                    <div class="page-content fade-in-up">
                        <div class="ibox">
                            <div class="ibox-head">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#addEmployeeModl">
                                    <i class="bi bi-plus-circle"></i> Agregar Nuevo
                                </button>
                                <div class="input-group" style="width: 450px;">
                                    <input type="text" id="search-input" class="form-control" placeholder="Buscar usuario..." onkeyup="searchTable()">
                                    <button class="btn btn-outline-secondary" type="button">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                                <div>
                                    <form action="{{ route('reportusuario') }}" method="get">
                                        <button class="btn btn-success">
                                            <i class="bi bi-file-earmark-text"></i> Reporte
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
                                <thead class="text-white">
                                    <tr>
                                        <th>N°</th>
                                        <th>Usuario</th>
                                        <th>Tipo</th>
                                        <th>F. Emisión</th>
                                        <th>DNI</th>
                                        <th>Apellidos y Nombres</th>
                                        <th>Teléfono</th>
                                        <th>Género</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($usuarios as $index => $usu)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><strong>{{ $usu->nomusu }}</strong></td>
                                        <td>
                                            <span class="badge badge-info">{{ $usu->tipousuario->tipousu ?? '' }}</span>
                                        </td>
                                        <td>{{ $usu->fechaemision }}</td>
                                        <td>{{ $usu->persona->dni }}</td>
                                        <td>{{ $usu->persona->apell }} {{ $usu->persona->nombre }}</td>
                                        <td>{{ $usu->persona->tele }}</td>
                                        <td>{{ $usu->persona->genero->nomgen }}</td>
                                        <td>
                                            <div class="btn-group action-buttons">
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit{{ $usu->idusuario }}" title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{ $usu->idusuario }}" title="Eliminar">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#permiso{{ $usu->idusuario }}" title="Permisos">
                                                    <i class="bi bi-shield-check"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Agregar Usuario -->
    <div id="addEmployeeModl" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="formañadir" action="{{route('Rutususario.store')}}" method="POST">
                    @csrf
                    <div class="modal-header text-white">
                        <h4 class="modal-title">
                            <i class="bi bi-person-plus-fill"></i> Agregar Nuevo Usuario
                        </h4>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="idTipUsua" class="required-field">Tipo de usuario</label>
                                <select name="idTipUsua" id="idTipUsua" class="form-control" required>
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    @foreach ($tipousuarios as $tip)
                                    <option value="{{$tip->idTipUsua}}">{{$tip->tipousu}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nomusu" class="required-field">Usuario</label>
                                <input type="text" class="form-control" name="nomusu" id="nomusu" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="password-field" class="required-field">Contraseña</label>
                                <div class="password-wrapper">
                                    <input type="password" id="password-field" class="form-control" name="pasword" required />
                                    <div class="toggle-button">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="eye-icon">
                                            <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                            <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="dni" class="required-field">DNI</label>
                                <input type="text" class="form-control" name="dni" id="dni" maxlength="8" oninput="this.value = this.value.replace(/[^0-9]/g,'')" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nombre" class="required-field">Nombres</label>
                                <input type="text" class="form-control" name="nombre" id="nombre" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="apell" class="required-field">Apellidos</label>
                                <input type="text" class="form-control" name="apell" id="apell" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="direc" class="required-field">Dirección</label>
                                <input type="text" class="form-control" name="direc" id="direc" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="idgenero" class="required-field">Género</label>
                                <select name="idgenero" id="idgenero" class="form-control" required>
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    @foreach ($generos as $gen)
                                    <option value="{{$gen->idgenero}}">{{$gen->nomgen}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="email" class="required-field">Email</label>
                                <input type="email" class="form-control" name="email" id="email" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tele" class="required-field">Teléfono</label>
                                <input type="text" class="form-control" name="tele" id="tele" maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="ubigeo" class="required-field">Ubigeo</label>
                                <input type="text" id="ubigeo" name="ubigeo" class="form-control" maxlength="6" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="fecemi" class="required-field">Fecha de Emisión</label>
                                <input type="date" id="fecemi" name="fecemi" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Cerrar
                        </button>
                        <button type="button" class="btn btn-secondary" id="btnCancelar">
                            <i class="bi bi-arrow-counterclockwise"></i> Limpiar
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> AGREGAR
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modales de Editar -->
    @foreach($usuarios as $usu)
    <div id="edit{{$usu->idusuario}}" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('Rutususario.update', $usu->idusuario) }}" method="POST">
                    @csrf
                    <div class="modal-header text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-pencil-square"></i> Editar usuario: {{ $usu->nomusu }}
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="idTipUsua_{{$usu->idusuario}}" class="required-field">Tipo de usuario</label>
                                <select name="idTipUsua" id="idTipUsua_{{$usu->idusuario}}" class="form-control" required>
                                    <option value="">Seleccione una opción</option>
                                    @foreach ($tipousuarios as $tip)
                                    <option value="{{$tip->idTipUsua}}" {{ $tip->idTipUsua == $usu->idTipUsua ? 'selected' : '' }}>
                                        {{$tip->tipousu}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nomusu_{{$usu->idusuario}}" class="required-field">Usuario</label>
                                <input type="text" class="form-control" name="nomusu" id="nomusu_{{$usu->idusuario}}" value="{{ $usu->nomusu }}" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="pasword_{{$usu->idusuario}}">Contraseña</label>
                                <div class="password-wrapper">
                                    <input type="password" id="pasword_{{$usu->idusuario}}" class="form-control password-field-edit" name="pasword" placeholder="Dejar vacío para no cambiar">
                                    <div class="toggle-button-edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="eye-icon">
                                            <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                            <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Dejar en blanco para mantener la actual</small>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="ubigeo_{{$usu->idusuario}}">Ubigeo</label>
                                <input type="text" id="ubigeo_{{$usu->idusuario}}" name="ubigeo" class="form-control" maxlength="6" placeholder="Dejar vacío para no cambiar" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                <small class="form-text text-muted">Opcional: solo si desea modificar</small>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="fecemi_{{$usu->idusuario}}">Fecha de Emisión</label>
                                <input type="date" id="fecemi_{{$usu->idusuario}}" name="fecemi" class="form-control" value="{{ $usu->fechaemision ?? '' }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="dni_{{$usu->idusuario}}" class="required-field">DNI</label>
                                <input type="text" class="form-control" name="dni" id="dni_{{$usu->idusuario}}" value="{{ $usu->persona->dni ?? '' }}" maxlength="8" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nombre_{{$usu->idusuario}}" class="required-field">Nombres</label>
                                <input type="text" class="form-control" name="nombre" id="nombre_{{$usu->idusuario}}" value="{{ $usu->persona->nombre ?? '' }}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="apell_{{$usu->idusuario}}" class="required-field">Apellidos</label>
                                <input type="text" class="form-control" name="apell" id="apell_{{$usu->idusuario}}" value="{{ $usu->persona->apell ?? '' }}" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="direc_{{$usu->idusuario}}" class="required-field">Dirección</label>
                                <input type="text" class="form-control" name="direc" id="direc_{{$usu->idusuario}}" value="{{ $usu->persona->direc ?? '' }}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="idgenero_{{$usu->idusuario}}" class="required-field">Género</label>
                                <select name="idgenero" id="idgenero_{{$usu->idusuario}}" class="form-control" required>
                                    <option value="">Seleccione un género</option>
                                    @foreach ($generos as $gen)
                                    <option value="{{$gen->idgenero}}" {{ (isset($usu->persona->idgenero) && $gen->idgenero == $usu->persona->idgenero) ? 'selected' : '' }}>
                                        {{$gen->nomgen}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="tele_{{$usu->idusuario}}" class="required-field">Teléfono</label>
                                <input type="text" class="form-control" name="tele" id="tele_{{$usu->idusuario}}" value="{{ $usu->persona->tele ?? '' }}" maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email_{{$usu->idusuario}}" class="required-field">Email</label>
                                <input type="email" class="form-control" name="email" id="email_{{$usu->idusuario}}" value="{{ $usu->persona->email ?? '' }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Cerrar
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> ACTUALIZAR
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Modales de Eliminar -->
    @foreach($usuarios as $usu)
    <div id="delete{{$usu->idusuario}}" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{route('Rutususario.destroy', $usu->idusuario)}}" method="POST">
                    @csrf
                    <div class="modal-header bg-danger text-white">
                        <h4 class="modal-title">
                            <i class="bi bi-exclamation-triangle"></i> Eliminar usuario
                        </h4>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-circle"></i>
                            <strong>¿Está seguro?</strong>
                        </div>
                        <p>¿Desea eliminar al usuario <strong>{{ $usu->nomusu }}</strong>?</p>
                        <p class="text-muted small">Esta acción no se puede deshacer.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="bi bi-x-circle"></i> CANCELAR
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> ELIMINAR
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Modales de Permisos -->
    @foreach($usuarios as $usu)
    <div class="modal fade" id="permiso{{ $usu->idusuario }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-ui-dialog-content modal-dialog-scrollable">
            <div class="modal-content shadow-lg border-0 rounded-4">
                <div class="modal-header bg-primary text-white rounded-top-4">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-shield-lock-fill me-2"></i>
                        Asignar permisos
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('PermisoUsuario', $usu->idusuario) }}" method="POST">
                        @csrf
                        <div class="modal-body bg-light">
                            <input type="hidden" name="usuario_id" value="{{ $usu->idusuario }}">
                            <div class="alert alert-info d-flex align-items-center mb-2">
                                <div>
                                    <strong>Usuario:</strong>
                                    <span class="badge bg-dark ms-1">{{ $usu->nomusu }}</span>
                                </div>
                            </div>

                            <div class="row g-3">
                                @foreach($permisos as $permiso)
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm h-100 permiso-card">
                                        <div class="card-body py-2 px-3 d-flex align-items-center">
                                            <div class="form-check form-switch">
                                                <input
                                                    class="form-check-input me-4"
                                                    type="checkbox"
                                                    role="switch"
                                                    name="permisos[]"
                                                    value="{{ $permiso->id }}"
                                                    id="permiso{{ $permiso->id }}_{{ $usu->idusuario }}"
                                                    {{ $usu->permisos->contains('id', $permiso->id) ? 'checked' : '' }}>
                                            </div>
                                            <label
                                                class="ms-2 fw-semibold text-dark mb-0"
                                                for="permiso{{ $permiso->id }}_{{ $usu->idusuario }}">
                                                <i class="bi bi-key-fill text-primary me-1"></i>
                                                {{ $permiso->nombre_permiso }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="modal-footer bg-light rounded-bottom-4">
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                                <i class="bi bi-x-circle me-1"></i> Cancelar
                            </button>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check-circle-fill me-1"></i> Guardar cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('swal_error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '¡Error!',
                text: "{{ session('swal_error') }}",
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        });
    </script>
    @endif

    <script>
        // Limpiar formulario de agregar
        document.getElementById('btnCancelar').addEventListener('click', function() {
            document.getElementById('formañadir').reset();
        });

        // Toggle password para modal de agregar
        $(document).on('click', '.toggle-button', function() {
            const passwordField = $(this).closest('.password-wrapper').find('input');
            const icon = $(this).find('svg');

            if (passwordField.attr('type') === 'password') {
                passwordField.attr('type', 'text');
                icon.html('<path d="M3.53 2.47a.75.75 0 00-1.06 1.06l18 18a.75.75 0 101.06-1.06l-18-18zM22.676 12.553a11.249 11.249 0 01-2.631 4.31l-3.099-3.099a5.25 5.25 0 00-6.71-6.71L7.759 4.577a11.217 11.217 0 014.242-.827c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113z" /><path d="M15.75 12c0 .18-.013.357-.037.53l-4.244-4.243A3.75 3.75 0 0115.75 12zM12.53 15.713l-4.243-4.244a3.75 3.75 0 004.243 4.243z" /><path d="M6.75 12c0-.619.107-1.213.304-1.764l-3.1-3.1a11.25 11.25 0 00-2.63 4.31c-.12.362-.12.752 0 1.114 1.489 4.467 5.704 7.69 10.675 7.69 1.5 0 2.933-.294 4.242-.827l-2.477-2.477A5.25 5.25 0 016.75 12z" />');
            } else {
                passwordField.attr('type', 'password');
                icon.html('<path d="M12 15a3 3 0 100-6 3 3 0 000 6z" /><path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clip-rule="evenodd" />');
            }
        });

        // Toggle password para modales de editar
        $(document).on('click', '.toggle-button-edit', function() {
            const passwordField = $(this).closest('.password-wrapper').find('.password-field-edit');
            const icon = $(this).find('svg');

            if (passwordField.attr('type') === 'password') {
                passwordField.attr('type', 'text');
                icon.html('<path d="M3.53 2.47a.75.75 0 00-1.06 1.06l18 18a.75.75 0 101.06-1.06l-18-18zM22.676 12.553a11.249 11.249 0 01-2.631 4.31l-3.099-3.099a5.25 5.25 0 00-6.71-6.71L7.759 4.577a11.217 11.217 0 014.242-.827c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113z" /><path d="M15.75 12c0 .18-.013.357-.037.53l-4.244-4.243A3.75 3.75 0 0115.75 12zM12.53 15.713l-4.243-4.244a3.75 3.75 0 004.243 4.243z" /><path d="M6.75 12c0-.619.107-1.213.304-1.764l-3.1-3.1a11.25 11.25 0 00-2.63 4.31c-.12.362-.12.752 0 1.114 1.489 4.467 5.704 7.69 10.675 7.69 1.5 0 2.933-.294 4.242-.827l-2.477-2.477A5.25 5.25 0 016.75 12z" />');
            } else {
                passwordField.attr('type', 'password');
                icon.html('<path d="M12 15a3 3 0 100-6 3 3 0 000 6z" /><path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clip-rule="evenodd" />');
            }
        });

        // Función de búsqueda
        function searchTable() {
            var query = $('#search-input').val();
            $.ajax({
                url: "{{ route('buscar.usuario') }}",
                type: 'GET',
                data: {
                    search: query
                },
                success: function(data) {
                    $('tbody').html(data);
                },
                error: function(xhr, status, error) {
                    console.error("Error en la búsqueda:", error);
                }
            });
        }

        function cargarPermisos(idusuario) {
            // Función para cargar permisos (si es necesario)
            console.log('Cargando permisos para usuario:', idusuario);
        }
    </script>

    <style>
        .dataTables_length {
            float: right;
            margin-right: 10px;
        }

        .dataTables_length label {
            display: flex;
            align-items: center;
        }
    </style>

    <script>
        $(document).ready(function() {
            $('#example-table').DataTable({
                "order": [
                    [0, "asc"]
                ],
                "columnDefs": [{
                    "targets": 8,
                    "orderable": false
                }],
                "language": {
                    "search": "",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
                    "zeroRecords": "No se encontraron registros",
                    "paginate": {
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                "dom": 'ltrip',
            });
        });
    </script>

    @if(session('success'))
    <script>
        Swal.fire({
            title: '¡Éxito!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'Aceptar',
            timer: 3000
        });
    </script>
    @endif

    <script>
        $(document).ready(function() {
            let busquedaTimeout = null;

            $(document).on('input', '#dni', function() {
                clearTimeout(busquedaTimeout);

                let dni = $(this).val().trim();

                if (dni.length !== 8 || !/^\d{8}$/.test(dni)) {
                    limpiarCamposPersona();
                    return;
                }

                busquedaTimeout = setTimeout(function() {
                    buscarPersona(dni);
                }, 600);
            });

            function buscarPersona(dni) {
                $.ajax({
                    url: '{{ route("personas.buscar", "") }}/' + dni,
                    type: 'GET',
                    dataType: 'json',
                    beforeSend: function() {
                        $('#dni').addClass('is-loading');
                    },
                    success: function(data) {
                        if (!data) {
                            limpiarCamposPersona();
                            mostrarAlerta('No se encontró persona con DNI: ' + dni, 'warning');
                            return;
                        }

                        $('#nombre').val(data.nombre);
                        $('#apell').val(data.apell);
                        $('#tele').val(data.tele);
                        $('#email').val(data.email);
                        $('#direc').val(data.direc);
                        $('#idgenero').val(data.idgenero);

                        mostrarAlerta('Datos de persona cargados automáticamente', 'success');
                    },
                    error: function(xhr) {
                        console.error('Error AJAX:', xhr.responseText);
                        limpiarCamposPersona();
                        mostrarAlerta('Error al buscar la persona', 'error');
                    },
                    complete: function() {
                        $('#dni').removeClass('is-loading');
                    }
                });
            }

            function limpiarCamposPersona() {
                $('#nombre').val('');
                $('#apell').val('');
                $('#tele').val('');
                $('#email').val('');
                $('#direc').val('');
                $('#idgenero').val('');
            }

            function mostrarAlerta(mensaje, tipo = 'info') {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: tipo,
                        title: mensaje,
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                } else {
                    alert(mensaje);
                }
            }
        });
    </script>




    @include('Vistas.Footer')