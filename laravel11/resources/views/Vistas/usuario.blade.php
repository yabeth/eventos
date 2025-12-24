@include('Vistas.Header')
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<!-- <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&display=swap" rel="stylesheet"> -->
<!-- <link rel="stylesheet" href="{{ asset('css/usuarios.css') }}"> -->
</head>
<style>
    .password-wrapper {
        position: relative;
    }

    .toggle-button {
        display: inline-flex;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        right: 12px;
        cursor: pointer;
    }

    .eye-icon {
        width: 20px;
        height: 20px;
    }


    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

    h1 {
        font-size: 9vw;

        margin-top: 20px;
        font-weight: 600;
        font-size: 18px;
        text-align: center;

        background: linear-gradient(45deg,
                #000000,
                #1c1c1c,
                #383838,
                #545454,
                #707070,
                #888888,
                #a9a9a9,
                #d3d3d3);


        font-family: 'Roboto', sans-serif;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-fill-color: transparent;

    }

    .linea {
        border: none;
        height: 0.8px;
        background-color: #888;
        width: 100%;
        margin-top: 10px;
        margin-bottom: 20px;
    }

    .container {
        max-width: 100%;
        padding: 0 5px;
    }

    .card {
        width: 100%;
    }
</style>

<body>
    <div id="tabla-usuarios">
        <div class="container-fluid mt-3">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="text-center mb-0">Usuarios</h5>
                </div>
                <div class="container">
                    <div class="page-content fade-in-up">
                        <div class="ibox">
                            <div class="ibox-head">
                                <button href="#addEmployeeModl" class="btn btn-primary" data-toggle="modal"><i class="bi bi-plus-circle"></i> Agregar Nuevo</button>
                                <div class="input-group" style="width: 450px;">
                                    <input type="text" id="search-input" class="form-control" placeholder="Buscar" onkeyup="searchTable()">
                                    <button class="btn btn-outline-secondary" type="button"><i class="bi bi-search"></i></button>
                                </div>
                                <div class="col-md-2">
                                    <form action="{{ route('reportusuario') }}" method="get">
                                        <button class="btn btn-success">
                                            <i class="bi bi-file-earmark-text"></i> Reporte de Usuarios
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <br>
                            <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th>N°</th>
                                        <th>Usuario</th>
                                        <th>Tipo de usuario</th>
                                        <th>Fecha de emisión</th>
                                        <th>DNI</th>
                                        <th>Apellidos y Nombre</th>
                                        <th>Teléfono</th>
                                        <th>Email</th>
                                        <th>Dirección</th>
                                        <th>Género</th>
                                        
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($usuarios as $index => $usu)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>                         
                                        <td>{{ $usu->nomusu }}</td>
                                        <td>{{ $usu->tipousuario->tipousu ?? '' }}</td>
                                        <td>{{ $usu->fechaemision }}</td>
                                        <td>{{ $usu->persona->dni }}</td>
                                        <td>{{ $usu->persona->apell }} {{ $usu->persona->nombre }}</td>
                                        <td>{{ $usu->persona->tele }}</td>
                                        <td>{{ $usu->persona->email }}</td>
                                        <td>{{ $usu->persona->direc }}</td>
                                        <td>{{ $usu->persona->genero->nomgen }}</td>
                                 
                                        <td>
                                            <div class="btn-group action-buttons">
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit{{ $usu->idusuario }}"><i class="bi bi-pencil"></i></button>
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{ $usu->idusuario }}"><i class="bi bi-trash"></i></button>
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" onclick="cargarPermisos({{ $usu->idusuario}})" data-target="#permiso{{ $usu->idusuario }}">Asignar Permisos</button>

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
    <!-- Crear Modal HTML -->
    <div id="addEmployeeModl" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addEmployeeModlLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="formañadir" action="{{route('Rutususario.store')}}" method="post">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h4 class="modal-title">Agregar nuevo usuario</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                <div class="modal-body">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="idTipUsua">Tipo de usuario</label>
            <select name="idTipUsua" id="idTipUsua" class="form-control" >
                <option value="" disabled selected>Seleccione una opción</option>
                @foreach ($tipousuarios as $tip)
                <option value="{{$tip->idTipUsua}}">{{$tip->tipousu}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="nomusu">Usuario</label>
            <input type="text" class="form-control" name="nomusu" id="nomusu" >
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="password-field" class="form-label">Password</label>
            <div class="password-wrapper">
                <input type="password" id="password-field" class="form-control" name="pasword"  />
                <div class="toggle-button">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="eye-icon">
                        <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                        <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="dni">DNI</label>
            <input type="text" class="form-control" name="dni" id="dni" >
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="nombre">Nombres</label>
            <input type="text" class="form-control" name="nombre" id="nombre" >
        </div>
        <div class="form-group col-md-6">
            <label for="apell">Apellidos</label>
            <input type="text" class="form-control" name="apell" id="apell" >
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="direc">Dirección</label>
            <input type="text" class="form-control" name="direc" id="direc">
        </div>
        <div class="form-group col-md-6">
            <label for="idgenero">Género</label>
            <select name="idgenero" id="idgenero" class="form-control" >
                @foreach ($generos as $gen)
                <option value="{{$gen->idgenero}}">{{$gen->nomgen}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" id="email" >
        </div>
        <div class="form-group col-md-6">
            <label for="tele">Teléfono</label>
            <input type="text" class="form-control" name="tele" id="tele" >
        </div>
    </div>
    
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="ubigeo" class="form-label">Ubigeo</label>
            <input type="text" id="ubigeo" name="ubigeo" class="form-control" maxlength="6" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
        </div>
        <div class="form-group col-md-6">
            <label for="fecemi" class="form-label">Fecha de Emisión</label>
            <input type="date" id="fecemi" name="fecemi" class="form-control">
        </div>
    </div>
    
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" id="btnCancelar">Limpiar</button>
    <button type="submit" class="btn btn-success" id="submitBtn">AGREGAR</button>
</div>
            

        </div>
    </div>
    </div>
    </div>


  
    <!-- edit Modal HTML -->

 @foreach($usuarios as $usu)
<div id="edit{{$usu->idusuario}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel{{$usu->idusuario}}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            {{-- Formulario de actualización del usuario --}}
            <form action="{{ route('Rusuario.update', $usu->idusuario) }}" method="post">
                @csrf
                @method('PATCH')

                {{-- Encabezado del Modal --}}
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editUserModalLabel{{$usu->idusuario}}">Editar usuario: {{ $usu->nomusu }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                {{-- Cuerpo del Modal (Contenido del formulario) --}}
                <div class="modal-body">

                    {{-- Fila 1: Tipo de Usuario y Nombre de Usuario --}}
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="idTipUsua">Tipo de usuario</label>
                            <select name="idTipUsua" id="idTipUsua" class="form-control" >
                                <option value="">Seleccione una opción</option>
                                @foreach ($tipousuarios as $tip)
                                <option value="{{$tip->idTipUsua}}" @if($tip->idTipUsua == $usu->idTipUsua) selected @endif>
                                    {{$tip->tipousu}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nomusu">Usuario</label>
                            <input type="text" class="form-control" name="nomusu" id="nomusu" value="{{ $usu->nomusu }}" >
                        </div>
                    </div>

                    {{-- Fila 2: Contraseña y Campos Condicionales (Ubigeo/Fecha Emisión) --}}
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="password-field">Password</label>
                            <div class="password-wrapper">
                                {{-- Se recomienda no precargar la contraseña. Se puede dejar en blanco o poner un placeholder. --}}
                                {{-- Si se quiere actualizar, el campo 'required' debe ser manejado por validación para permitir dejarlo vacío si no se desea cambiar. --}}
                                <input type="password" id="password-field" class="form-control" name="pasword" placeholder="Dejar vacío para no cambiar" />
                                <div class="toggle-button">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="eye-icon" style="width: 24px; height: 24px;">
                                        <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                        <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="ubigeo" class="form-label">Ubigeo</label>
                            <input type="text" id="ubigeo" name="ubigeo" class="form-control"  placeholder="Ubigeo">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="fecemi" class="form-label">Fecha de Emisión</label>
                            <input type="date" id="fecemi" name="fecemi" class="form-control" value="{{ $usu->fechaemision ?? '' }}">
                        </div>
                  
                    </div>

                    {{-- Fila 3: DNI y Apellidos (Datos de la Persona) --}}
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="dni">DNI</label>
                            <input type="text" class="form-control" name="dni" id="dni" value="{{ $usu->persona->dni ?? '' }}" placeholder="DNI"/>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="apell">Apellidos</label>
                            <input type="text" class="form-control" name="apell" id="apell" value="{{ $usu->persona->apell ?? '' }}" placeholder="Apellidos"/>
                        </div>
                    </div>

                    {{-- Fila 4: Nombres y Dirección (Datos de la Persona) --}}
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nombre">Nombres</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" value="{{ $usu->persona->nombre ?? '' }}" placeholder="Nombres"/>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="direc">Dirección</label>
                            <input type="text" class="form-control" name="direc" id="direc" value="{{ $usu->persona->direc ?? '' }}" placeholder="Dirección"/>
                        </div>
                    </div>

                    {{-- Fila 5: Teléfono y Género (Datos de la Persona) --}}
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="tele">Teléfono</label>
                            <input type="text" class="form-control" name="tele" id="tele" value="{{ $usu->persona->tele ?? '' }}" placeholder="Teléfono"/>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="idgenero">Género</label>
                            <select name="idgenero" id="idgenero" class="form-control">
                                <option value="">Seleccione un género</option>
                                @foreach ($generos as $gen)
                                <option value="{{$gen->idgenero}}" {{ (isset($usu->persona->idgenero) && $gen->idgenero == $usu->persona->idgenero) ? 'selected' : '' }}>
                                    {{$gen->nomgen}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Fila 6: Email (Dato de la Persona) --}}
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" value="{{ $usu->persona->email ?? '' }}" placeholder="email">
                        </div>
                    </div>

                </div>

                {{-- Pie de página del Modal --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">ACTUALIZAR</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
    <!-- delete Modal HTML -->
    @foreach($usuarios as $usu)
    <div id="delete{{$usu->idusuario}}" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{route('Rutususario.destroy',$usu->idusuario)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header bg-primary text-white">
                        <h4 class="modal-title">Eliminar usuario</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro de que deseas eliminar este registro?</p>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-warning" data-dismiss="modal" value="CANCELAR">
                        <input type="submit" class="btn btn-danger" value="ELIMINAR">
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
    <!-- Modal de Datos -->
    <!-- Modal para ver los datos 
    <div class="modal fade" id="datosEmployeeModl" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('Rutususario.per.store') }}" method="post">
                    @csrf
                    <div class="modal-h-eader -bg-primary text-white">
                        <h5 class="modal-title" id="exampleModalLabel">Datos del Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="" class="form-label">DNI</label>
                                    <input type="text" id="dniField" name="dni" class="form-control" placeholder="DNI">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="" class="form-label">Nombre</label>
                                    <input type="text" id="nombreField" name="nombre" class="form-control" placeholder="Nombre">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="" class="form-label">Apellido</label>
                                    <input type="text" id="apellidoField" name="apell" class="form-control" placeholder="Apellido">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="" class="form-label">Direccion</label>
                                    <input type="text" id="direcField" name="direc" class="form-control" placeholder="Dirección">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="" class="form-label">Email</label>
                                    <input type="email" id="emailField" name="email" class="form-control" placeholder="Email">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="" class="form-label">Telefono</label>
                                    <input type="tel" id="teleField" name="tele" class="form-control" placeholder="Teléfono">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="idgeneroField" class="form-label">Género</label>
                                    <select name="idgenero" id="idgeneroField" class="form-select form-control">
                                        @foreach ($generos as $gen)
                                        <option value="{{ $gen->idgenero }}">{{ $gen->nomgen }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="idTipUsuaField" class="form-label">Tipo de Usuario</label>
                                    <select name="idTipUsua" id="idTipUsuaField" class="form-select form-control">
                                        @foreach ($tipousuarios as $tip)
                                        <option value="{{ $tip->idTipUsua }}">{{ $tip->tipousu }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="" class="form-label">Usuario</label>
                                    <input type="text" id="nomusuField" name="nomusu" class="form-control" placeholder="Nombre de Usuario">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="" class="form-label">Contraseña</label>
                                    <input type="password" id="paswordField" name="pasword" class="form-control mb-2" placeholder="Contraseña">
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Agregar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>-->

  <!-- Modal de Permisos -->
    @foreach($usuarios as $usu)
    <div class="modal fade" id="permiso{{ $usu->idusuario }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #6c5ce7; color: white;">
                    <h5 class="modal-title" id="exampleModalLabel">Asignar Permisos para {{ $usu->nomusu }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('PermisoUsuario', $usu->idusuario) }}" method="POST">
                    @csrf
                    <div class="modal-body" style="background-color: #f1f2f6;">
                        <input type="hidden" name="usuario_id" value="{{ $usu->idusuario }}">
                        <div class="row">
                            @foreach($permisos as $permiso)
                            <div class="col-md-6">
                                <div class="form-group d-flex align-items-center">
                                    <label class="mr-2" style="font-weight: bold; color: #2d3436;">{{ $permiso->nombre_permiso }}</label>
                                    <input type="checkbox" name="permisos[]" value="{{ $permiso->id }}"
                                        {{ $usu->permisos->contains('id', $permiso->id) ? 'checked' : '' }}
                                        class="form-control-sm ml-auto">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer" style="background-color: #f1f2f6;">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 20px; padding: 10px 20px;">Cerrar</button>
                        <button type="submit" class="btn btn-primary" style="background-color: #6c5ce7; border: none; border-radius: 20px; padding: 10px 20px;">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">  -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
   
    <script>
        document.getElementById('btnCancelar').addEventListener('click', function() {
            document.getElementById('nomusu').value = '';
            document.getElementById('password-field').value = '';
        });

        document.addEventListener('DOMContentLoaded', function() {
            @if(session('swal_error'))
            Swal.fire({
                title: '¡Error!',
                text: "{{ session('swal_error') }}",
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
            @endif
        });
        const eyeIcons = {
            open: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="eye-icon"><path d="M12 15a3 3 0 100-6 3 3 0 000 6z" /><path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clip-rule="evenodd" /></svg>',
            closed: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="eye-icon"><path d="M3.53 2.47a.75.75 0 00-1.06 1.06l18 18a.75.75 0 101.06-1.06l-18-18zM22.676 12.553a11.249 11.249 0 01-2.631 4.31l-3.099-3.099a5.25 5.25 0 00-6.71-6.71L7.759 4.577a11.217 11.217 0 014.242-.827c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113z" /><path d="M15.75 12c0 .18-.013.357-.037.53l-4.244-4.243A3.75 3.75 0 0115.75 12zM12.53 15.713l-4.243-4.244a3.75 3.75 0 004.243 4.243z" /><path d="M6.75 12c0-.619.107-1.213.304-1.764l-3.1-3.1a11.25 11.25 0 00-2.63 4.31c-.12.362-.12.752 0 1.114 1.489 4.467 5.704 7.69 10.675 7.69 1.5 0 2.933-.294 4.242-.827l-2.477-2.477A5.25 5.25 0 016.75 12z" /></svg>'
        };

        function addListeners() {
            const toggleButton = document.querySelector(".toggle-button");

            if (!toggleButton) {
                return;
            }

            toggleButton.addEventListener("click", togglePassword);
        }

        function cargarPermisos(idusuario) {
            // Realizamos la solicitud a la ruta permisos.index
            fetch(`'/usuarios/permisos/${idusuario}`)
                .then(response => response.text())
                .then(html => {
                    // Reemplazamos el contenido del modal con los permisos
                    document.getElementById('modal-body-content').innerHTML = html;
                })
                .catch(error => {
                    console.error('Error al cargar los permisos:', error);
                    document.getElementById('modal-body-content').innerHTML = '<p>Error al cargar los permisos.</p>';
                });
        }

        function togglePassword() {
            const passwordField = document.querySelector("#password-field");
            const toggleButton = document.querySelector(".toggle-button");

            if (!passwordField || !toggleButton) {
                return;
            }

            toggleButton.classList.toggle("open");

            const isEyeOpen = toggleButton.classList.contains("open");

            toggleButton.innerHTML = isEyeOpen ? eyeIcons.closed : eyeIcons.open;
            passwordField.type = isEyeOpen ? "text" : "password";
        }




        document.addEventListener("DOMContentLoaded", addListeners);


        //submit



       /* $('#datosEmployeeModl').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var dni = button.data('dni');
            var nombre = button.data('nombre');
            var apell = button.data('apell');
            var direc = button.data('direc');
            var email = button.data('email');
            var tele = button.data('tele');
            var idgenero = button.data('idgenero');
            var nomusu = button.data('nomusu');
            var pasword = button.data('pasword');
            var idTipUsua = button.data('idTipUsua');

            // Update the modal's content.var modal = $(this);
            modal.find('#dni').val(dni);
            modal.find('#nombre').val(nombre);
            modal.find('#apell').val(apell);
            modal.find('#direc').val(direc);
            modal.find('#email').val(email);
            modal.find('#tele').val(tele);
            modal.find('#idgenero').val(idgenero);
            modal.find('#nomusu').val(nomusu);
            modal.find('#pasword').val(pasword);
            modal.find('#idTipUsua').val(idTipUsua);
        });*/

       /* $(document).on('click', '[data-bs-target="#datosEmployeeModl"]', function() {
            // Obtén los datos desde los atributos data-* del botón
            const dni = $(this).data('dni');
            const nombre = $(this).data('nombre');
            const apellido = $(this).data('apellido');
            const direc = $(this).data('direc');
            const email = $(this).data('email');
            const tele = $(this).data('tele');
            const idgenero = $(this).data('idgenero');
            const nomusu = $(this).data('nomusu');
            const pasword = $(this).data('pasword');
            const idTipUsua = $(this).data('idtipusua');

            // Asigna los datos a los campos del modal
            $('#dniField').val(dni);
            $('#nombreField').val(nombre);
            $('#apellidoField').val(apellido);
            $('#direcField').val(direc);
            $('#emailField').val(email);
            $('#teleField').val(tele);
            $('#nomusuField').val(nomusu);
            $('#paswordField').val(pasword);

            // Maneja el select de género
            if (typeof idgenero === 'string') {
                $('#idgeneroField option').filter(function() {
                    return $(this).text().toLowerCase() === idgenero.toLowerCase();
                }).prop('selected', true);
            } else {
                $('#idgeneroField').val(idgenero);
            }

            // Maneja el select de tipo de usuario
            if (typeof idTipUsua === 'string') {
                $('#idTipUsuaField option').filter(function() {
                    return $(this).text().toLowerCase() === idTipUsua.toLowerCase();
                }).prop('selected', true);
            } else {
                $('#idTipUsuaField').val(idTipUsua);
            }

            // Verifica los valores antes de asignar
            console.log('ID Género:', idgenero);
            console.log('ID Tipo Usuario:', idTipUsua);

            // Verifica si los valores fueron correctamente asignados
            console.log('Género asignado:', $('#idgeneroField').val());
            console.log('Tipo de usuario asignado:', $('#idTipUsuaField').val());
        });


*/
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
    </script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

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
                    "targets": 1,
                    "orderable": false
                }],
                "language": {
                    "search": "",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    "paginate": {
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                "dom": 'ltrip',
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('success'))
    <script>
        Swal.fire({
            title: '¡Éxito!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'Aceptar'
        });
    </script>
    
    @endif


    @include('Vistas.Footer')