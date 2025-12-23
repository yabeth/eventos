<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Web - Dirección de Incubadora de Empresas - UNASAM</title>
    <meta name="description" content="Universidad Nacional Santiago Antunez de Mayolo ubicada en la ciudad de Huaraz Ancash-Perú">
    <meta name="author" content="Yurlin Jaramillo Pinedo">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.unasam.edu.pe/">
    <meta property="og:title" content="Incubadora de Empresas - UNASAM">
    <meta property="og:description" content="Próximos eventos y actividades de la Universidad Nacional Santiago Antúnez de Mayolo">
    <meta property="og:image" content="https://www.unasam.edu.pe/img/unasam.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://www.unasam.edu.pe/">
    <meta property="twitter:title" content="Incubadora de Empresas - UNASAM">
    <meta property="twitter:description" content="Próximos eventos y actividades de la Universidad Nacional Santiago Antúnez de Mayolo">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/eventweb.css') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --success-color: #198754;
            --danger-color: #dc3545;
            --dark-color: #212529;
            --light-color: #f8f9fa;
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Poppins', sans-serif;
            padding-top: 140px;
            background-color: #eceaeaff;
        }

        
    </style>
</head>

<body>
    <!-- Header -->
    <header class="fixed-top main-header-container">
        <div class="top-header institutional-bar py-2 d-none d-lg-block">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 text-start">
                        <ul class="list-unstyled d-flex mb-0 top-contact-info">
                            <li class="me-4">
                                <i class="fas fa-phone-alt me-2"></i>
                                <strong>(043) 640-020</strong>
                            </li>
                            <li>
                                <i class="fas fa-envelope me-2"></i>
                                mesadepartesdigital@unasam.edu.pe
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-6 text-end d-flex justify-content-end align-items-center">
                        <div class="social-icons top-social-icons">
                            <a href="https://www.facebook.com/unasam.edu.pe" target="_blank" title="Facebook" aria-label="Facebook">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                            <a href="https://www.youtube.com/channel/UCHUxOdDI4zrMgghSpTDxttw" target="_blank" title="YouTube" aria-label="YouTube">
                                <i class="fa-brands fa-youtube"></i>
                            </a>
                            <a href="https://www.instagram.com/unasam_oficial/" target="_blank" title="Instagram" aria-label="Instagram">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-header py-3">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="logo-section">
                            <a href="#">
                                <img src="https://www.unasam.edu.pe/web/logounasam/logo-17-10-2024-23-04-54.png" alt="UNASAM" class="main-logo">
                            </a>
                            <a href="https://web.facebook.com/IncubaUnasam/" target="_blank" class="header-utility-link d-flex align-items-center">
                                <img alt="Incubadora" height="40" src="{{ asset('img/incubaunsam.png') }}" class="me-2">
                            </a>
                            <ul class="nav-menu">
                                <li><a href="#" class="active"><i class="fas fa-home me-2"></i>Inicio</a></li>
                                <li><a href="#eventos"><i class="fas fa-calendar me-2"></i>Eventos</a></li>
                                <li><a href="#nosotros"><i class="fas fa-users me-2"></i>Nosotros</a></li>
                                <li><a href="#contacto"><i class="fas fa-envelope me-2"></i>Contacto</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Carrusel -->
    <section class="hero-section py-3">
        <div class="container">
            <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                <div class="carousel-indicators">
                    @forelse ($imagenes as $index => $img)
                    <button type="button"
                        data-bs-target="#heroCarousel"
                        data-bs-slide-to="{{ $index }}"
                        class="{{ $index == 0 ? 'active' : '' }}"
                        aria-current="{{ $index == 0 ? 'true' : 'false' }}"
                        aria-label="Slide {{ $index + 1 }}">
                    </button>
                    @empty
                    @endforelse
                </div>

                <div class="carousel-inner">
                    @forelse ($imagenes as $index => $img)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <img src="{{ asset($img->ruta_imagen) }}" class="d-block w-100" alt="{{ $img->nombre_imagen }}" loading="{{ $index == 0 ? 'eager' : 'lazy' }}">
                        <div class="carousel-caption">
                            <div class="banner-text">
                                <h2>{{ $img->nombre_imagen }}</h2>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="carousel-item active">
                        <img src="{{ asset('img/banner_vacio.jpg') }}" class="d-block w-100" alt="No hay imágenes" loading="eager">
                        <div class="carousel-caption d-none d-md-block">
                            <div class="banner-text">
                                <h2>No se han cargado imágenes para el carrusel.</h2>
                            </div>
                        </div>
                    </div>
                    @endforelse
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

    <!-- ESTADÍSTICAS DINÁMICAS -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6">
                    <div class="stat-box">
                        <i class="fas fa-users" style="font-size: 3rem; margin-bottom: 15px;"></i>
                        <span class="stat-number" data-target="{{ $totalInscripciones ?? 1500 }}">0</span>
                        <span class="stat-label">Estudiantes Inscritos</span>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="stat-box">
                        <i class="fas fa-calendar-check" style="font-size: 3rem; margin-bottom: 15px;"></i>
                        <span class="stat-number" data-target="{{ $totalEventos ?? 85 }}">0</span>
                        <span class="stat-label">Eventos Realizados</span>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="stat-box">
                        <i class="fas fa-certificate" style="font-size: 3rem; margin-bottom: 15px;"></i>
                        <span class="stat-number" data-target="{{ $totalCertificados ?? 420 }}">0</span>
                        <span class="stat-label">Certificados Emitidos</span>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="stat-box">
                        <i class="fas fa-award" style="font-size: 3rem; margin-bottom: 15px;"></i>
                        <span class="stat-number" data-target="{{ $totalAsistencias ?? 280 }}">0</span>
                        <span class="stat-label">Escuelas</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- EVENTOS CON BLADE -->
    <section class="events-section py-5" id="eventos">
        <div class="container">
            <div class="text-center mb-1">
                <h2 class="section-title display-5 fw-bold text-primary">Próximos Eventos UNASAM</h2>
                <p class="lead text-muted">¡No te pierdas nuestras actividades!</p>
            </div>
            <div class="search-container">
                <input type="text" class="search-input" id="searchInput" placeholder="Buscar eventos por nombre...">
                <button class="search-btn" aria-label="Buscar">
                    <i class="fas fa-search"></i>
                </button>
            </div>

            <div class="no-results" id="noResults">
                <i class="fas fa-search"></i>
                <h4>No se encontraron eventos</h4>
                <p>Intenta con otros términos de búsqueda o filtros</p>
            </div>
            <div class="events-box shadow-lg p-4 p-md-5 bg-white rounded-3">
                <div class="row" id="eventsGrid">

                    @forelse ($eventosProximos as $evento)

                    @php
                    $fechaInicio = \Carbon\Carbon::parse($evento->fechsubeve_min);
                    $horaInicio = $evento->horini_min;
                    $fechaCierre = \Carbon\Carbon::parse($evento->fecha_cierre);
                    @endphp

                    <div class="col-md-6 col-lg-4 mb-4 event-item"
                        data-tipo="tipo-{{ $evento->idTipoeven }}"
                        data-nombre="{{ strtolower($evento->eventnom) }}">

                        <a href="{{ route('eventos.detalle', ['id' => $evento->idevento]) }}"
                            class="event-link text-decoration-none d-block">

                            <div class="card event-card-compact h-100 border-0 shadow-sm">

                                {{-- FECHA DEL PRIMER SUBEVENTO --}}
                                <div class="event-date-badge-compact position-absolute top-0 end-0 m-2 text-center bg-primary text-white p-2 rounded" style="z-index: 10;">
                                    <span class="day fw-bold d-block display-6 lh-1">
                                        {{ $fechaInicio->format('d') }}
                                    </span>
                                    <span class="month small d-block">
                                        {{ strtoupper($fechaInicio->locale('es')->format('M')) }}
                                    </span>
                                </div>

                                <img src="{{ asset('img/uni.jpg') }}"
                                    class="card-img-top event-img-compact"
                                    alt="Evento {{ $evento->eventnom }}"
                                    loading="lazy">

                                <div class="card-body p-3 d-flex flex-column">

                                    <h6 class="card-title fw-bold text-dark mb-2">
                                        {{ Str::limit($evento->eventnom, 50) }}
                                    </h6>

                                    <p class="text-secondary small mb-2">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        Inicio: {{ $fechaInicio->format('d/m/Y') }}
                                    </p>

                                    <p class="text-success small fw-bold mb-2">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ substr($horaInicio, 0, 5) }} hrs
                                    </p>

                                    <!-- @if($evento->modalidad)
                                    <p class="text-info small mb-2">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        {{ $evento->modalidad }}
                                    </p>
                                    @endif -->

                                    <div class="mb-2 p-2 bg-light rounded">
                                        <p class="text-warning small fw-bold mb-1">
                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                            Cierre de inscripciones:
                                        </p>
                                        <p class="text-dark small mb-0">
                                            <i class="fas fa-calendar-times me-1"></i>
                                            {{ $fechaCierre->format('d/m/Y') }}

                                            @if(!$evento->inscripcion_cerrada)
                                            @if($evento->dias_restantes === 0)
                                            <span class="badge bg-danger ms-1">¡HOY!</span>
                                            @elseif($evento->dias_restantes === 1)
                                            <span class="badge bg-warning text-dark ms-1">Mañana</span>
                                            @else
                                            <span class="badge bg-info ms-1">
                                                {{ $evento->dias_restantes }} días
                                            </span>
                                            @endif
                                            @endif
                                        </p>
                                    </div>

                                    {{-- ESTADO --}}
                                    @if($evento->inscripcion_cerrada)
                                    <span class="badge bg-secondary text-white p-2 mt-auto">
                                        <i class="fas fa-lock me-1"></i>
                                        INSCRIPCIONES CERRADAS
                                    </span>
                                    @elseif($evento->dias_restantes === 0)
                                    <span class="badge bg-danger text-white p-2 mt-auto">
                                        <i class="fas fa-fire me-1"></i>
                                        INSCRIPCIONES - ¡ÚLTIMO DÍA!
                                        <!-- ¡ÚLTIMO DÍA! - {{ max(0, $evento->horas_restantes) }}h -->
                                    </span>
                                    @else
                                    <span class="badge bg-success text-white p-2 mt-auto">
                                        <i class="fas fa-user-plus me-1"></i>
                                        INSCRIPCIONES ABIERTAS
                                    </span>
                                    @endif

                                </div>
                            </div>
                        </a>
                    </div>

                    @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle me-2"></i>
                            No hay eventos próximos disponibles para inscripción.
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- TESTIMONIOS -->
    <section class="testimonials-section" id="nosotros">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title display-5 fw-bold text-primary">Lo Que Dicen Nuestros Estudiantes</h2>
                <p class="lead text-muted">Historias de éxito de nuestra comunidad</p>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="testimonial-card">
                        <p class="testimonial-text">"La incubadora me ayudó a convertir mi idea en un negocio real. El apoyo y mentoría que recibí fue invaluable."</p>
                        <div class="testimonial-author">
                            <div class="author-avatar">MA</div>
                            <div>
                                <strong class="d-block">María A.</strong>
                                <small class="text-muted">Fundadora</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="testimonial-card">
                        <p class="testimonial-text">"Los eventos y talleres son de primera calidad. He aprendido más aquí que en cualquier otro lugar."</p>
                        <div class="testimonial-author">
                            <div class="author-avatar">JR</div>
                            <div>
                                <strong class="d-block">José R.</strong>
                                <small class="text-muted">Estudiante - Ingeniería</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="testimonial-card">
                        <p class="testimonial-text">"Encontré socios, mentores y amigos. La red de contactos que construí aquí es increíble."</p>
                        <div class="testimonial-author">
                            <div class="author-avatar">LS</div>
                            <div>
                                <strong class="d-block">Laura S.</strong>
                                <small class="text-muted">Co-fundadora</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="main-footer pt-5" id="contacto">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-4 mb-5 mb-lg-4 text-center text-lg-start justify-content-center">
                    <img src="https://www.unasam.edu.pe/img/unasam.png" alt="UNASAM Logo" class="footer-logo mb-3" style="max-width: 150px;">
                    <p class="text-white-50">Universidad Nacional Santiago Antúnez de Mayolo. Formando profesionales líderes.</p>
                    <h5 class="footer-title mt-4">Síguenos</h5>
                    <div class="footer-social">
                        <a href="https://www.facebook.com/unasam.edu.pe" target="_blank" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="https://twitter.com/unasamoficial" target="_blank" aria-label="Twitter"><i class="bi bi-twitter"></i></a>
                        <a href="https://www.youtube.com/channel/UCHUxOdDI4zrMgghSpTDxttw" target="_blank" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                        <a href="https://www.instagram.com/unasam_oficial/" target="_blank" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3 mb-4">
                    <h5 class="footer-title">Servicios Institucionales</h5>
                    <ul class="list-unstyled footer-links">
                        <li><a href="http://campus.unasam.edu.pe/"><i class="bi bi-chevron-right me-2"></i>SVA Campus Virtual</a></li>
                        <li><a href="http://sga.unasam.edu.pe/login"><i class="bi bi-chevron-right me-2"></i>SGA UNASAM</a></li>
                        <li><a href="http://sgapg.unasam.edu.pe/login"><i class="bi bi-chevron-right me-2"></i>SGA Postgrado</a></li>
                        <li><a href="http://repositorio.unasam.edu.pe/"><i class="bi bi-chevron-right me-2"></i>Repositorio Institucional</a></li>
                    </ul>
                </div>

                <div class="col-md-4 col-lg-3 mb-4">
                    <h5 class="footer-title">Contáctenos</h5>
                    <ul class="list-unstyled footer-contact">
                        <li><i class="bi bi-geo-alt-fill me-2"></i>Av. Centenario Nro. 200, Huaraz</li>
                        <li><i class="bi bi-telephone-fill me-2"></i>(043) 640-020</li>
                        <li><i class="bi bi-envelope-fill me-2"></i>mesadepartesdigital@unasam.edu.pe</li>
                        <li class="mt-2"><i class="bi bi-card-text me-2"></i>RUC: 20166550239</li>
                    </ul>
                </div>

                <div class="col-md-4 col-lg-2 mb-4">
                    <h5 class="footer-title">Legal</h5>
                    <ul class="list-unstyled footer-links">
                        <li><a href="#"><i class="bi bi-chevron-right me-2"></i>Términos</a></li>
                        <li><a href="#"><i class="bi bi-chevron-right me-2"></i>Privacidad</a></li>
                        <li><a href="#"><i class="bi bi-chevron-right me-2"></i>Libro de Reclamaciones</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer-bottom py-3 mt-4">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <p class="mb-0 text-white-50 small">© Copyright 2025. Universidad Nacional Santiago Antúnez de Mayolo - Todos los Derechos Reservados.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- SCROLL TO TOP -->
    <button class="scroll-to-top" id="scrollToTop" aria-label="Volver arriba">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // CONTADOR ANIMADO
        function animateCounter(element) {
            const target = parseInt(element.getAttribute('data-target'));
            const duration = 2000;
            const increment = target / (duration / 16);
            let current = 0;

            const updateCounter = () => {
                current += increment;
                if (current < target) {
                    element.textContent = Math.floor(current);
                    requestAnimationFrame(updateCounter);
                } else {
                    element.textContent = target;
                }
            };

            updateCounter();
        }

        // OBSERVER PARA ESTADÍSTICAS
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counters = entry.target.querySelectorAll('.stat-number');
                    counters.forEach(counter => animateCounter(counter));
                    statsObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.5
        });

        const statsSection = document.querySelector('.stats-section');
        if (statsSection) statsObserver.observe(statsSection);

        // BÚSQUEDA Y FILTROS
        const searchInput = document.getElementById('searchInput');
        const filterBtns = document.querySelectorAll('.filter-btn');
        const eventItems = document.querySelectorAll('.event-item');
        const noResults = document.getElementById('noResults');

        let currentFilter = 'all';

        function filterEvents() {
            let visibleCount = 0;

            eventItems.forEach(item => {
                const tipo = item.getAttribute('data-tipo');
                const nombre = item.getAttribute('data-nombre');
                const searchTerm = searchInput.value.toLowerCase();

                const matchesFilter = currentFilter === 'all' || tipo === currentFilter;
                const matchesSearch = nombre.includes(searchTerm);

                if (matchesFilter && matchesSearch) {
                    item.style.display = 'block';
                    setTimeout(() => {
                        item.style.opacity = '1';
                        item.style.transform = 'translateY(0)';
                    }, visibleCount * 50);
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            noResults.style.display = visibleCount === 0 ? 'block' : 'none';
        }

        searchInput.addEventListener('input', filterEvents);

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                currentFilter = btn.getAttribute('data-filter');
                filterEvents();
            });
        });

        // SCROLL TO TOP
        const scrollToTop = document.getElementById('scrollToTop');

        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                scrollToTop.classList.add('show');
            } else {
                scrollToTop.classList.remove('show');
            }
        });

        scrollToTop.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // SMOOTH SCROLL PARA NAVEGACIÓN
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href !== '#' && href.length > 1) {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        const offset = 160;
                        const targetPosition = target.offsetTop - offset;
                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });

        // ACTIVE NAV LINK
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.nav-menu a');

        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (pageYOffset >= sectionTop - 200) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (current && link.getAttribute('href') === `#${current}`) {
                    link.classList.add('active');
                } else if (!current && link.getAttribute('href') === '#') {
                    link.classList.add('active');
                }
            });
        });

        // ANIMACIÓN DE ENTRADA PARA TARJETAS
        const cardObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, index * 100);
                    cardObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });

        document.querySelectorAll('.event-item').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            cardObserver.observe(card);
        });

        // PREVENIR SUBMIT EN BÚSQUEDA
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
            }
        });

        console.log('Portal UNASAM Incubadora cargado correctamente ✓');
    </script>
</body>

</html>