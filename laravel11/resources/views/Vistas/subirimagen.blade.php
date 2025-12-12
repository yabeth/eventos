@include('Vistas.Header')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
    body {
        background: #f5f7fa;
        font-family: "Roboto", sans-serif;
    }

    .card-custom {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        border: none;
    }

    .card-header-custom {
        background: linear-gradient(45deg, #0d6efd, #0a58ca);
        color: #fff;
        padding: 15px 20px;
        text-align: center;
    }

    .form-control,
    .form-select {
        border-radius: 8px !important;
    }

    .btn-primary {
        border-radius: 6px;
    }

    .upload-container {
        background: #ffffff;
        padding: 20px;
        border-radius: 10px;
        border: 1px solid #e5e5e5;
        margin-bottom: 20px;
    }

    .table img {
        border-radius: 6px;
        border: 1px solid #ddd;
    }

    .container {
        max-width: 100%;
        padding: 5px 0;
    }

    .card {
        width: 100%;
        margin-bottom: 5px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
</style>

<body>
<div class="container mt-4">

    <div class="card card-custom">
        <div class="card-header-custom">
            <h5 class="mb-0">GESTIÓN DE IMAGENES</h5>
        </div>
        <div class="card-body">
            <div class="upload-container">
                <form id="uploadForm" enctype="multipart/form-data" class="row g-3">
                    @csrf

                    <div class="col-md-6">
                        <label class="form-label">Nombre de la Imagen</label>
                        <input type="text" id="nombre_imagen" name="nombre_imagen" required
                               class="form-control" placeholder="Ej: Incubadora de Empresas 2025">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Archivo de Imagen</label>
                        <input type="file" id="imagen" name="imagen" required class="form-control">
                    </div>

                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-cloud-upload"></i> Subir Imagen
                        </button>
                    </div>
                </form>
            </div>

            <p class="text-muted fst-italic">
                Las imágenes deben tener <strong>1200px de ancho</strong> × <strong>455px de alto</strong>.
            </p>

            <h5 class="mt-4"><i class="bi bi-images me-2"></i>Contenido de imágenes en Web</h5>
            <hr>
            @if($imagenes->isEmpty())
                <p class="text-center text-muted">No hay imágenes subidas</p>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Miniatura</th>
                            <th>Nombre</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($imagenes as $key => $imagen)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <img src="{{ asset($imagen->ruta_imagen) }}"
                                         alt="{{ $imagen->nombre_imagen }}"
                                         width="90">
                                </td>
                                <td>{{ $imagen->nombre_imagen }}</td>

                                <td class="text-center">
                                    <a href="{{ asset($imagen->ruta_imagen) }}" target="_blank"
                                       class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i> Ver
                                    </a>

                                    <button type="button"
                                            class="btn btn-sm btn-danger"
                                            onclick="confirmDelete({{ $imagen->id }})">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>
            @endif

        </div>
    </div>

</div>

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
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Imagen subida',
                        text: data.message
                    }).then(() => location.reload());
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => Swal.fire('Error', error.message, 'error'));
    });

    function confirmDelete(id) {
        Swal.fire({
            title: '¿Eliminar imagen?',
            text: "No se podrá recuperar después",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar'
        }).then(result => {
            if (result.isConfirmed) {
                fetch(`{{ url('/subirimagen') }}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        data.success
                            ? Swal.fire("Eliminado", data.message, "success").then(() => location.reload())
                            : Swal.fire("Error", data.message, "error");
                    });
            }
        });
    }
</script>
