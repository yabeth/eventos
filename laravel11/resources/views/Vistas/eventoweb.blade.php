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

                        <a href="#" class="header-utility-link me-4 d-flex align-items-center">
                            <img alt="Incubadora" height="30" src="{{ asset('img/incubadora.jpg') }}" class="me-2 rounded">
                            <span>Incubadora UNASAM</span>
                        </a>

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

        <div class="main-header bg-white py-3">
            <div class="container">
                <div class="row ">
                    <div class="col-12 ">
                        <div class="logo-section">
                            <a href="">
                                <img src="https://www.unasam.edu.pe/web/logounasam/logo-17-10-2024-23-04-54.png"
                                    alt="UNASAM" class="main-logo">
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </header>

    <section class="hero-section py-3">
        <div class="container">
            <div id="heroCarousel" class="carousel slide hero-banner" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>

                <div class="carousel-inner">

                    <div class="carousel-item active">
                        <img src="{{ asset('img/incubadora1.jpg') }}" class="d-block w-100 mini-img" alt="Cursos Libres">
                        <div class="carousel-caption">
                            <div class="banner-text">
                                <!-- <h2>Encuesta Egresados 2025</h2> -->
                            </div>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <img src="{{ asset('img/incubadora2.jpg') }}" class="d-block w-100" alt="Comunicado UNASAM">

                        <div class="carousel-caption">
                            <div class="banner-text">
                                <!-- <h2>¡Inscripciones Abiertas para el Semestre 2026-I!</h2> -->
                            </div>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <img src="{{ asset('img/incubadora3.jpg') }}" class="d-block w-100" alt="Comunicado UNASAM">

                        <div class="carousel-caption">
                            <div class="banner-text">
                                <!-- <h2>¡Inscripciones Abiertas para el Semestre 2026-I!</h2> -->
                            </div>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <img src="https://picsum.photos/1920/1080?random=3" class="d-block w-100" alt="Evento Deportivo">

                        <div class="carousel-caption">
                            <div class="banner-text">
                                <!-- <h2>Gran Final de las Olimpiadas Universitarias</h2> -->
                            </div>
                        </div>
                    </div>

                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Siguiente</span>
                </button>
            </div>
        </div>
    </section>

    <!-- <hr style="padding: 0;"> -->
    <section class="events-section py-5">
        <div class="container">

            <div class="text-center mb-4">
                <h2 class="section-title display-5 fw-bold text-primary">Próximos Eventos UNASAM</h2>
                <p class="lead text-muted">¡No te pierdas nuestras actividades!</p>
            </div>
            <div class="events-box shadow-lg p-4 p-md-5 bg-white rounded-3">
                <div class="row">
                    @forelse ($eventosProximos as $evento)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <a href="{{ route('eventos.detalle', ['id' => $evento->idevento]) }}" class="event-link">
                            <div class="card event-card-compact h-100 border-0">
                                <div class="event-date-badge-compact">
                                    <span class="day">{{ \Carbon\Carbon::parse($evento->fechsubeve_min)->format('d') }}</span>
                                    <span class="month">{{ strtoupper(\Carbon\Carbon::parse($evento->fechsubeve_min)->format('M')) }}</span>
                                </div>
                                <img src="{{ asset('img/logounasam.jpg') }}"
                                    class="card-img-top event-img-compact"
                                    alt="Evento {{ $evento->eventnom }}">
                                <div class="card-body p-3 d-flex flex-column">
                                    <h6 class="card-title fw-bold text-dark mb-1">{{ Str::limit($evento->eventnom, 40) }}</h6>
                                    <p class="text-secondary small mb-2">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        {{ \Carbon\Carbon::parse($evento->fechsubeve_min)->format('Y') }}
                                    </p>

                                    <p class="text-success small fw-bold mt-auto mb-2">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ \Carbon\Carbon::parse($evento->horini_min)->format('H:i') }}
                                    </p>

                                    <span class="badge bg-danger text-white p-1">
                                        INSCRIPCIONES ABIERTAS
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                    @empty
                    <div class="col-12">
                        <p class="alert alert-info text-center">No hay eventos próximos disponibles para inscripción.</p>
                    </div>
                    @endforelse
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
                    <h5 class="footer-title mt-4">Síguenos</h5>
                    <div class="footer-social">
                        {{-- Usamos iconos de Bootstrap en lugar de una imagen estática --}}
                        <a href="https://www.facebook.com/unasam.edu.pe" target="_blank" class="social-icon facebook"><i class="bi bi-facebook"></i></a>
                        <a href="https://twitter.com/unasamoficial" target="_blank" class="social-icon twitter"><i class="bi bi-twitter"></i></a>
                        <a href="https://www.youtube.com/c/UNASAMHD" target="_blank" class="social-icon youtube"><i class="bi bi-youtube"></i></a>
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

</body>

</html>