@include('Vistas.Header')
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <!-- <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&display=swap" rel="stylesheet"> -->
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

background: linear-gradient(
  45deg,
  #000000,
  #1c1c1c,
  #383838,  
  #545454,  
  #707070,  
  #888888,  
  #a9a9a9,  
  #d3d3d3  
);


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
            padding: 0 0px;
        }

        .card {
            width: 100%; 
        }
    </style>
<body>

<div id="tabla-datos" >
    <div class="container mt-3">
        <div class="card">
            <div class="card-header">
                <h5 class="text-center">Datos de los usuarios</h5>
            </div>
            <div class="container">
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#addEmployeeModl">
                                    <i class="bi bi-plus-circle"></i> AGREGAR NUEVO
                                </button>
                            </div>
                           
                            <div class="col-md-6">
                            <div class="input-group">
                            <input type="text" id="search-input" class="form-control" placeholder="Buscar" onkeyup="searchTable()">
                            <button class="btn btn-outline-secondary" type="button"><i class="bi bi-search"></i></button>
                        </div>
                            </div>
                        </div>
                        <br>

                        <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th>N°</th>
                                    <th>DNI</th>
                                    <th>Apellidos y Nombres</th>
                                    <th>Dirección</th>
                                    <th>Email</th>
                                    <th>Teléfono</th>
                                    <th>Género</th>
                                    <th>Tipo de usuario</th>
                                    <th>Usuario</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datosperusus as $index => $dat)
                                <tr> 
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $dat->persona->dni }}</td>
                                    <td>{{ $dat->persona->apell }} {{ $dat->persona->nombre }}</td>
                                    <td>{{ $dat->persona->direc }}</td>
                                    <td>{{ $dat->persona->email }}</td>
                                    <td>{{ $dat->persona->tele }}</td>
                                    <td>{{ $dat->persona->genero->nomgen }}</td>
                                    <td>{{ $dat->usuario->tipousuario->tipousu }}</td>
                                    <td>{{ $dat->usuario->nomusu }}</td>
                                    <td>
                                        <div class="btn-group action-buttons">
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit{{$dat->idatosPer}}"><i class="bi bi-pencil"></i></button>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"  data-target="#delete{{$dat->idatosPer}}"><i class="bi bi-trash"></i></button>
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
    <div id="addEmployeeModl" class="modal fade">
        <div class="modal-dialog modal-lg"> <!-- Cambiado a modal-lg para ancho mayor -->
            <div class="modal-content">
                <form action="{{ route('Rutususario.per.store') }}" method="post">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h4 class="modal-title">Agregar nuevo usuario</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>DNI</label>
                                <input type="text" class="form-control" name="dni" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Apellidos</label>
                                <input type="text" class="form-control" name="apell" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nombres</label>
                                <input type="text" class="form-control" name="nombre" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Dirección</label>
                                <input type="text" class="form-control" name="direc" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="gen">Género</label>
                                <select name="idgenero" class="form-control" required>
                                    @foreach ($generos as $gen)
                                    <option value="{{$gen->idgenero}}">{{$gen->nomgen}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Teléfono</label>
                                <input type="text" class="form-control" name="tele" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Tipo de usuario</label>
                                <select name="idTipUsua" class="form-control" required>
                                    @foreach ($tipousuarios as $tip)
                                    <option value="{{$tip->idTipUsua}}">{{$tip->tipousu}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Usuario</label>
                                <input type="text" class="form-control" name="nomusu" required>
                            </div>
                           
                            <div class="form-group col-md-6">
                                <label for="password-field" class="form-label">Password</label>
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


                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                        <input type="submit" class="btn btn-success" value="Agregar">
                    </div>
                </form>
            </div>
        </div>
    </div>

    
   <!-- edit Modal HTML -->
   @foreach($datosperusus as $dat)  
    <div id="edit{{$dat->idatosPer}}" class="modal fade" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">  
        <div class="modal-dialog modal-lg">  
            <div class="modal-content">  
                <form action="{{ route('Rutususario.per.update', $dat->idatosPer) }}" method="POST">  
                    @csrf  
                    @method('PUT')  
                    <div class="modal-header bg-primary text-white">
                        <h4 class="modal-title">Editar datos de usuario</h4>  
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>  
                    </div>  
                    <div class="modal-body">  
                        <div class="form-row">  
                            <div class="form-group col-md-6">  
                                <label>DNI</label>  
                                <input type="text" class="form-control" name="dni" value="{{ $dat->persona->dni }}" placeholder="DNI"/>  
                            </div>  
                            <div class="form-group col-md-6">  
                                <label>Apellidos</label>  
                                <input type="text" class="form-control" name="apell" value="{{ $dat->persona->apell }}" placeholder="Apellidos"/>  
                            </div>  
                        </div>  
                        <div class="form-row">  
                            <div class="form-group col-md-6">  
                                <label>Nombres</label>  
                                <input type="text" class="form-control" name="nombre" value="{{ $dat->persona->nombre }}" placeholder="Nombres"/>  
                            </div>  
                            <div class="form-group col-md-6">  
                                <label>Dirección</label>  
                                <input type="text" class="form-control" name="direc" value="{{ $dat->persona->direc }}" placeholder="Dirección"/>  
                            </div>  
                        </div>  
                        <div class="form-row">  
                            <div class="form-group col-md-6">  
                                <label>Teléfono</label>  
                                <input type="text" class="form-control" name="tele" value="{{ $dat->persona->tele }}" placeholder="Teléfono"/>  
                            </div>  
                            <div class="form-group col-md-6">  
                                <label>Tipo de usuario</label>  
                                <select name="idTipUsua" class="form-control" required>  
                                    @foreach ($tipousuarios as $tip)  
                                        <option value="{{$tip->idTipUsua}}" {{ $tip->idTipUsua == $dat->usuario->idTipUsua ? 'selected' : '' }}>  
                                            {{$tip->tipousu}}  
                                        </option>  
                                    @endforeach  
                                </select>  
                            </div>  
                        </div>  
                        <div class="form-row">  
                            <div class="form-group col-md-6">  
                                <label>Género</label>  
                                <select name="idgenero" class="form-control">  
                                    @foreach ($generos as $gen)  
                                        <option value="{{$gen->idgenero}}" {{ $gen->idgenero == $dat->persona->idgenero ? 'selected' : '' }}>  
                                            {{$gen->nomgen}}  
                                        </option>  
                                    @endforeach  
                                </select>  
                            </div>  
                            <div class="form-group col-md-6">
                                <label>Email</label>
                                <input type="email" class="form-control"name="email" value="{{ $dat->persona->email }}" placeholder="email">
                            </div>
                        </div>  
                        <div class="form-row">  
                            <div class="form-group col-md-6">  
                                <label>Usuario</label>  
                                <input type="text" class="form-control" name="nomusu" value="{{ $dat->usuario->nomusu }}" placeholder="Usuario"/>  
                            </div>  
                            <!-- <div class="form-group col-md-6">  
                                <label for="password">Password</label>  
                                <div class="password-wrapper">  
                                    <input type="password" class="form-control" name="pasword"  aria-describedby="helpId" placeholder="" />  
                                    <div class="toggle-button">  
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="eye-icon">  
                                            <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />  
                                            <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clip-rule="evenodd" />  
                                        </svg>  
                                    </div>  
                                </div>  
                            </div>   -->


                            <div class="form-group col-md-6">
                        <div class="mb-3">
               <label  class="form-label">
                  Password
               </label>
               <div class="password-wrapper">
                  <input type="password" id="password-field" class="form-control" name="pasword" required/>
                  <div class="toggle-button">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="eye-icon">
                        <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                        <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clip-rule="evenodd" />
                     </svg>
                  </div>
               </div>
            </div>

                        </div>  
                    </div>  
                    <div class="modal-footer">  
                        <button type="button" class="btn btn-warning" data-dismiss="modal">CANCELAR</button>  
                        <input type="submit" class="btn btn-success" value="MODIFICAR"/>  
                    </div>  
                </form>  
            </div>  
        </div>  
    </div>  
@endforeach


<!-- Eliminar usuario Modal HTML -->
@foreach ($datosperusus as $dat)
<div id="delete{{$dat->idatosPer}}" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('Rutususario.per.destroy', $dat->idatosPer)}}" method="post">
                @csrf
                @method('delete')
                <div class="modal-header bg-primary text-white">          
                    <h4 class="modal-title">Eliminar Usuario</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">            
                    <p>¿Está seguro que desea eliminar a este usuario?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>


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




 
        function searchTable() {
    var query = $('#search-input').val(); 
    $.ajax({
        url: "{{ route('buscar.datosperusu') }}", 
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
            "order": [[0, "asc"]],
            "columnDefs": [
                {
                    "targets": 1,
                    "orderable": false
                }
            ],
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
