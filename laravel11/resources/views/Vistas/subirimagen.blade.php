@include('Vistas.Header')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css"> 
<link rel="stylesheet" href="https://www.flaticon.es/iconos-gratis/enlace">
<style>
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');
           
        body {
            
            background-color: #f8f9fa;
            margin: 0;
            color: #333;
        }

        .linea {
        border: none;
        height: 0.8px; 
        background-color: #888; 
        width: 100%; 
        margin-top: 10px;
        margin-bottom: 20px; 
        }

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
        /* h1{
        text-align: center;
        padding: 10px 0; 
        color:black;
        /* font-weight: bold;   
        } */

        form {
        display: flex;
        justify-content: center;
        margin-bottom: 10px;
        }

        input[type="file"] {
        padding: 7px;
        margin-right: 10px;
        border: 2px solid #ced4da;
        border-radius: 5px;
        width: 350px;
        height: 45px;

        
            background-color: black;
            /* Fondo negro */
            color: white;
            /* Texto blanco */
            /* border: 2px solid #ccc; */
            /* padding: 10px; */
            cursor: pointer;
        }
        

        button {
        padding: 10px 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 10px;
        transition: background-color 0.3s;
        background-color: #4CAF50;
            color: white;
            /* padding: 10px 20px; */
            /* border: none; */
            /* cursor: pointer; */
        }

        button[type="submit"] {
            background-color: #28a745; /* Success */
            color: white;
        }

        button[type="submit"]:hover {
            background-color: #0bf22c;
        }

        .btn-info {
            background-color: #f80303; /* Info */
            color: white;
        }

        .btn-info:hover {
            background-color: #c21f1f;
        }

        .btn-primary {
            background-color: #007bff; /* Primary */
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        /* table {
            /* /* width: 80%; */
            /* margin: 20px auto;
            border-collapse: collapse;
            text-align: center;
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);  
        } */

        td {
            padding: 10px;
            border: 1px solid #b7d413;
            color: black;
        }
        /*encabezado de la tabla */
        /* th {
            background-color: #429feb;
            
        } */

        .ojo {
            font-size: 10px; /* Ajusta el tamaño del ícono */
            text-decoration: none; /* Quitar subrayado */
            display: inline-block; /*Permite aplicar padding */
            padding: 5px; /* Espaciado interno opcional */
            color: black; /*Cambia el color del ícono */
        }

        .btn-primary {
            background-color: #007bff; /* Color de fondo para el botón */
            border: none; /* Sin borde */
            border-radius: 4px; /* Bordes redondeados */
            padding: 10px; /* Espaciado interno */
            color: white; /* Color del texto */
            cursor: pointer; /* Cambia el cursor al pasar sobre el botón */
        }
        h4{
            text-align: center;
            padding: 10px 0; 
            color:black;
            /* font-weight: bold;   */

        }
        text {
            color: bro;
            text-align: center;
            font-weight: bold;   /* Hace el texto en negrita */
            font-size: 12px;     /* Ajusta el tamaño del texto a algo más pequeño */
            display: block;      /* Asegura que el texto se alinee en el centro */
            margin: 0 auto;      /* Centra el texto si es necesario */
        }
        
        
</style>
<body>
    <div class="container">
        <h1>Imagenes en el Slider</h1>
        <form id="uploadForm" enctype="multipart/form-data">
            @csrf
            <input type="file" name="imagen" required>
            <button type="submit" class="btn ">Subir Imagen</button>
        </form>

        <text>Las imágenes deben tener el tamaño de 1200px de ancho y 455px de alto.</text>
        <h4>Contenido de imagenes en Web</h4>
        @if($imagenes->isEmpty())
            <p>No hay imágenes subidas</p>
        @else
        <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover" id="my-table" cellspacing="0" width="100%">
                <thead class="bg-dark text-white">
                    <tr>
                        <th>Número</th>
                        <th>Imagen</th>
                        <th>Nombre de la Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($imagenes as $key => $imagen)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><img src="{{ asset($imagen->ruta_imagen) }}" alt="{{ $imagen->nombre_imagen }}" style="width: 50px;"></td>
                            <td>{{ $imagen->nombre_imagen }}</td>
                            <td>
                                <a href="{{ asset('uploads/' . $imagen->nombre_imagen) }}" target="_blank" class="btn btn-primary">Ver</a>


                                <form id="deleteForm-{{ $imagen->id }}" action="{{ route('subirimagen.destroy', $imagen->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $imagen->id }})">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
        @endif
    </div>
</body>
@include('Vistas.Footer')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
        document.getElementById('uploadForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);

            fetch("{{ route('subirimagen.store') }}", {
                method: "POST",
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // SweetAlert para éxito
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: data.message,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload(); // Recarga la página después del SweetAlert de éxito
                    });
                } else {
                    // Manejar errores
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message, // Mensaje específico desde el controlador
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload(); // Recarga la página después del SweetAlert de error
                    });
                }
            })
            .catch(error => {
                // Manejo genérico de errores
                Swal.fire({
                    icon: 'warning',
                    title: 'Error',
                    text: 'Solo formatos de imagen y las dimensiones especificadas.', // Mensaje genérico de error
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload(); // Recarga la página después del SweetAlert de error
                });
            });
        });
</script>

    
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: '¿Estás seguro de eliminar esta imagen?',
            text: "No podrás revertir esta acción",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`{{ url('/subirimagen') }}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Eliminado', data.message, 'success').then(() => {
                            location.reload(); // Recarga la página después del SweetAlert de éxito
                        });
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => Swal.fire('Error', 'No se pudo eliminar la imagen', 'error'));
            }
        });
    }
</script>
