<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Web - Dirección de Incubadora de Empresas - UNASAM</title>
    <meta name="description"
        content="Universidad Nacional Santiago Antunez de Mayolo ubicada en la ciudad de Huaraz Ancash-Perú">
    <meta name="author" content="Yurlin Jaramillo Pinedo">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/eventweb.css') }}">
</head>

<body>
    <header class="fixed-top main-header-container">
        <div class="top-header institutional-bar py-2 d-none d-lg-block">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 text-start">
                        <ul class="list-unstyled d-flex mb-0 top-contact-info">
                            <li class="me-4">
                                <i class="fas fa-phone-alt me-2 text-primary"></i>
                                <strong>(043) 640-020</strong>
                            </li>
                            <li>
                                <i class="fas fa-envelope me-2 text-primary"></i>
                                mesadepartesdigital@unasam.edu.pe
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-6 text-end d-flex justify-content-end align-items-center">
                        <div class="social-icons top-social-icons">
                            <a href="https://www.facebook.com/unasam.edu.pe" target="_blank" title="Facebook">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                            <a href="https://www.youtube.com/channel/UCHUxOdDI4zrMgghSpTDxttw" target="_blank" title="YouTube">
                                <i class="fa-brands fa-youtube"></i>
                            </a>
                            <a href="https://www.instagram.com/unasam_oficial/" target="_blank" title="Instagram">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="main-header bg-black py-3">
            <div class="container">
                <div class="row ">
                    <div class="col-12 ">
                        <div class="logo-section d-flex justify-content-between">
                            <a href="">
                                <img src="https://www.unasam.edu.pe/web/logounasam/logo-17-10-2024-23-04-54.png"
                                    alt="UNASAM" class="main-logo">
                            </a>
                            <a href="https://web.facebook.com/IncubaUnasam/photos?locale=es_LA&_rdc=1&_rdr#" target="_blank" class="header-utility-link me-4 d-flex align-items-center">
                                <img alt="Incubadora" height="30" src="{{ asset('img/incubadora.jpg') }}" class="me-2 rounded">
                                <span class="text-white">Incubadora UNASAM</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <style>
        .event-detail-section {
            margin-top: 90px;
        }
    </style>

    <section class="event-detail-section py-3">
        <div class="container">
            <!-- <h2 class="text-center mb-4 fw-bold">{{ $eventoDetalle->eventnom }}</h2> -->
            <hr class="mb-5">
            <h4 class="mb-4 fw-bold">Evento <i>(Se puede inscribir antes que inicie el primer subevento)</i></h4>
            <div class="row">
                <div class="col-md-5 mb-4">
                    <div class="event-image-container shadow-lg rounded overflow-hidden" style="position: relative;">
                        <div class="image-overlay-title p-3 w-100" style="position: absolute; bottom: 0; 
                            left: 0; z-index: 10; background: rgba(0, 0, 0, 0.6); color: white;">
                            <h3 class="event-title mb-0 fw-bold">{{ $eventoDetalle->eventnom }}</h3>
                        </div>
                        <img src="{{ asset('img/logounasam.jpg') }}"
                            alt="Portada del Evento {{ $eventoDetalle->eventnom }}"
                            class="img-fluid w-100"
                            style="max-height: 450px; object-fit: cover;">
                    </div>
                </div>

                <div class="col-md-7 mb-4">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="inscripcion-tab" data-bs-toggle="tab" data-bs-target="#inscripcion-pane" type="button" role="tab" aria-controls="inscripcion-pane" aria-selected="true">
                                <i class="fas fa-edit me-1"></i> Inscripción
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="detalle-tab" data-bs-toggle="tab" data-bs-target="#detalle-pane" type="button" role="tab" aria-controls="detalle-pane" aria-selected="false">
                                <i class="fas fa-list-alt me-1"></i> Detalle del Evento
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content border border-top-0 p-4 bg-white shadow-sm" id="myTabContent">
                        <div class="tab-pane fade show active" id="inscripcion-pane" role="tabpanel" aria-labelledby="inscripcion-tab">
                            <h5 class="fw-bold mb-3"><i>Formulario de Inscripción</i></h5>
                            <form id="inscripcionFormulario" action="{{ route('Rut.inscri.store') }}" method="post">
                                @csrf
                                <input type="hidden" id="idevento" name="idevento" value="{{ $eventoDetalle->idevento }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label for="dni" class="fw-bold">DNI <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="dni" name="dni" required>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="nombre" class="fw-bold">Nombres <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="email" class="fw-bold">Correo electrónico <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="idgenero" class="fw-bold">Género <span class="text-danger">*</span></label>
                                            <select id="idgenero" name="idgenero" class="form-control" required>
                                                <option value="">-- Seleccione el género --</option>
                                                {{-- Usar la variable en PLURAL: $generos --}}
                                                @foreach ($generos as $gen)
                                                <option value="{{ $gen->idgenero }}">{{ $gen->nomgen }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label for="apell" class="fw-bold">Apellidos <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="apell" name="apell" required>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="tele" class="fw-bold">Teléfono <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="tele" name="tele" required>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="direc" class="fw-bold">Dirección <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="direc" name="direc" required>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="idescuela" class="fw-bold">Escuela <span class="text-danger">*</span></label>
                                            <select id="idescuela" name="idescuela" class="form-control" required>
                                                <option value="">-- Seleccione la escuela --</option>
                                                {{-- Usar la variable en PLURAL: $escuelas --}}
                                                @foreach ($escuelas as $escu)
                                                <option value="{{ $escu->idescuela }}">{{ $escu->nomescu }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end pt-3 border-top mt-4">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-check-circle me-1"></i> Confirmar Inscripción
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="detalle-pane" role="tabpanel" aria-labelledby="detalle-tab">
                            <div class="mt-0 p-3 border rounded bg-light d-flex justify-content-between">
                                <p class="mb-1"><strong>Fecha de Inicio:</strong> {{ \Carbon\Carbon::parse($eventoDetalle->fecini)->format('d/m/Y') }}</p>
                                <p class="mb-1"><strong>Fecha de Fin:</strong> {{ \Carbon\Carbon::parse($eventoDetalle->fechculm)->format('d/m/Y') }}</p>
                                <!-- <p class="mb-0"><strong>Tipo de Evento:</strong> {{-- tipo de evento --}}</p> -->
                            </div>
                            <h5 class="fw-bold mb-3 mt-2">Descripción General</h5>
                            <p class="lead"><i>{{ $eventoDetalle->descripción }}</i></p>

                            <h5 class="mt-4 fw-bold text-info">Sub-eventos / Sesiones</h5>
                            <ul class="list-group">
                                @forelse ($subEventos as $sub)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong class="text-dark">{{ $sub->Descripcion }}</strong><br>
                                        <small class="text-muted">
                                            <i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($sub->fechsubeve)->format('d/m/Y') }}
                                            | <i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($sub->horini)->format('H:i') }} - {{ \Carbon\Carbon::parse($sub->horfin)->format('H:i') }}
                                        </small>
                                    </div>
                                    <span class="badge bg-secondary rounded-pill">
                                        {{-- Yurlin Jaramillo --}}
                                    </span>
                                </li>
                                @empty
                                <li class="list-group-item text-center text-muted">Aún no hay sub-eventos programados.</li>
                                @endforelse
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="main-footer pt-5">
        <div class="container">
            <div class="row">

                <div class="col-md-12 col-lg-4 mb-5 mb-lg-4 text-center text-lg-start">
                    <img src="https://www.unasam.edu.pe/img/unasam.png" alt="UNASAM Logo" class="footer-logo mb-3" style="max-width: 150px;">
                    <p class="text-white-50">
                        Universidad Nacional Santiago Antúnez de Mayolo. Formando profesionales líderes.
                    </p>
                    {{-- Redes Sociales: Se mueve a esta columna para mejor impacto visual --}}
                    <h5 class="footer-title mt-4">Síguenos</h5>
                    <div class="footer-social">
                        {{-- Usamos iconos de Bootstrap en lugar de una imagen estática --}}
                        <a href="https://www.facebook.com/unasam.edu.pe" target="_blank" class="social-icon facebook"><i class="bi bi-facebook"></i></a>
                        <a href="https://twitter.com/unasamoficial" target="_blank" class="social-icon twitter"><i class="bi bi-twitter"></i></a>
                        <a href="https://www.youtube.com/channel/UCHUxOdDI4zrMgghSpTDxttw" target="_blank" class="social-icon youtube"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3 mb-4">
                    <h5 class="footer-title">Servicios Institucionales</h5>
                    <ul class="list-unstyled footer-links">
                        <li>
                            <a href="http://campus.unasam.edu.pe/">
                                <i class="bi bi-chevron-right me-2"></i>SVA Campus Virtual
                            </a>
                        </li>
                        <li>
                            <a href="http://sga.unasam.edu.pe/login">
                                <i class="bi bi-chevron-right me-2"></i>SGA UNASAM
                            </a>
                        </li>
                        <li>
                            <a href="http://sgapg.unasam.edu.pe/login">
                                <i class="bi bi-chevron-right me-2"></i>SGA Postgrado
                            </a>
                        </li>
                        <li>
                            <a href="http://repositorio.unasam.edu.pe/">
                                <i class="bi bi-chevron-right me-2"></i>Repositorio Institucional
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-md-4 col-lg-3 mb-4">
                    <h5 class="footer-title">Contáctenos</h5>
                    <ul class="list-unstyled footer-contact">
                        <li>
                            <i class="bi bi-geo-alt-fill me-2"></i>Av. Centenario Nro. 200, Huaraz
                        </li>
                        <li>
                            <i class="bi bi-telephone-fill me-2"></i>(043) 640-020
                        </li>
                        <li>
                            <i class="bi bi-envelope-fill me-2"></i>mesadepartesdigital@unasam.edu.pe
                        </li>
                        <li class="mt-3">
                            <i class="bi bi-card-text me-2"></i>RUC: 20166550239
                        </li>
                    </ul>
                </div>

                <div class="col-md-4 col-lg-2 mb-4">
                    <h5 class="footer-title">Legal</h5>
                    <ul class="list-unstyled footer-links">
                        <li><a href="#"><i class="bi bi-chevron-right me-2"></i>Términos</a></li>
                        <li><a href="#"><i class="bi bi-chevron-right me-2"></i>Privacidad</a></li>
                    </ul>
                </div>

            </div>
        </div>

        <div class="footer-bottom py-3 mt-4">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <p class="mb-0 text-white-50 small">
                            © Copyright 2025. Universidad Nacional Santiago Antúnez de Mayolo - Todos los Derechos Reservados.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/SU_PROPIO_KIT_CODE.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> {{-- Usaremos SweetAlert2 para mensajes --}}
    <script>
        $(document).ready(function() {
            const $dniInput = $('#dni');
            const $form = $('#inscripcionFormulario');
            const $decisionInput = $('<input type="hidden" name="decision" id="decision_input" value="N">');
            $form.append($decisionInput);

            // === BÚSQUEDA DE PARTICIPANTE POR DNI ==========
            
            $dniInput.on('input', function() {
                const dni = $(this).val();

                if (dni.length === 8) {
                    clearFormFields(false);
                    $dniInput.prop('disabled', true);

                    $.ajax({
                        url: `{{ url('/api/participante') }}/${dni}`,
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.success && response.data) {
                                const data = response.data;
                                $('#nombre').val(data.nombre);
                                $('#apell').val(data.apell);
                                $('#email').val(data.email);
                                $('#tele').val(data.tele);
                                $('#direc').val(data.direc);
                                $('#idgenero').val(data.idgenero);

                                if (data.idescuela) {
                                    $('#idescuela').val(data.idescuela);
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Participante Encontrado',
                                        text: 'Se encontraron datos de inscripciones anteriores.'
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Participante Nuevo o sin Inscripciones',
                                        text: 'Se encontraron los datos personales. Complete la información restante.'
                                    });
                                }

                                disableFormFields(true);

                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Participante Nuevo',
                                    text: 'No se encontraron datos para este DNI. Complete todos los campos.'
                                });
                                disableFormFields(false);
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error de Conexión',
                                text: 'Ocurrió un error al intentar buscar al participante.'
                            });
                            disableFormFields(false);
                        },
                        complete: function() {
                            $dniInput.prop('disabled', false);
                        }
                    });

                } else if (dni.length < 8) {
                    clearFormFields(false);
                    disableFormFields(false);
                    if (dni.length === 0) {
                        $dniInput.prop('disabled', false);
                    }
                }
            });

            // ==  ENVÍO Y MANEJO DEL FORMULARIO DE INSCRIPCIÓN ===================

            $form.on('submit', function(e) {
                e.preventDefault();
                const $submitBtn = $(this).find('button[type="submit"]');
                $submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...');

                const formData = $form.serialize();

                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Éxito', response.message, 'success');
                            clearFormFields(true);
                        } else if (response.showAlert) {
                            showConfirmationAlert(response.message);
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        const error = xhr.responseJSON;
                        const message = error ? error.message : 'Error de servidor desconocido.';
                        Swal.fire('Error', message, 'error');
                    },
                    complete: function() {
                        $submitBtn.prop('disabled', false).html('<i class="fas fa-check-circle me-1"></i> Confirmar Inscripción');
                        $decisionInput.val('N');
                    }
                });
            });

            // ======  FUNCIONES AUXILIARES  ==================================

            function clearFormFields(clearDni = true) {
                $form.find('input[type="text"], input[type="email"]').each(function() {
                    if (clearDni || this.id !== 'dni') {
                        $(this).val('');
                    }
                });
                $form.find('select').val('');
                $decisionInput.val('N');
            }

            function disableFormFields(isFound) {
                const fieldsToDisable = ['nombre', 'apell', 'email', 'tele', 'direc', 'idgenero'];
                fieldsToDisable.forEach(id => {
                    $(`#${id}`).prop('disabled', isFound);
                });
            }

            function showConfirmationAlert(message) {
                Swal.fire({
                    title: '¡Advertencia!',
                    text: message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, cambiar escuela e inscribir',
                    cancelButtonText: 'No, mantener escuela actual',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $decisionInput.val('S');
                        $form.trigger('submit');
                    } else {
                        Swal.fire('Cancelado', 'La inscripción fue cancelada.', 'error');
                        $decisionInput.val('N');
                    }
                });
            }

            disableFormFields(false);
            $('#dni').prop('disabled', false);
        });
    </script>

</body>

</html>