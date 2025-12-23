<!DOCTYPE html>
<html lang="es">

<head>
    @include('Vistas.Header')
    <!-- Bootstrap CSS -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://www.flaticon.es/iconos-gratis/enlace">

    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css"> -->

    <style>
        .card-custom {
            border: none;
            border-radius: 14px;
            overflow: hidden;
            transition: all .3s ease;
            box-shadow: 0 3px 10px rgba(0, 0, 0, .12);
        }

        .card-custom:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, .18);
        }

        .card-header {
            background: #5ca8f0ff;
            border-bottom: 2px solid #84a5e2ff;
            text-align: center;
            padding: 12px;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0;
            color: #ffffffff;
        }

        select.form-control {
            margin: 12px auto;
            border-radius: 8px;
            padding: 8px 10px;
            width: 90%;
        }

        .btn {
            width: 90%;
            margin: 6px auto;
            padding: 8px;
            border-radius: 10px;
            font-weight: 600;
            letter-spacing: .3px;
        }

        .btn-warning {
            background-color: #e8a000 !important;
            border-color: #e8a000 !important;
            color: white !important;
        }

        .btn-warning:hover {
            background-color: #cf8c00 !important;
        }

        .btn-success:hover,
        .btn-primary:hover {
            opacity: .85;
        }

        .section-space {
            padding: 5px 10px;
        }

        .container {
            max-width: 100%;
            padding: 5px 0;
        }

        .card1 {
            width: 100%;
            margin-bottom: 5px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: var(--shadow-sm);
        }
    </style>
</head>

<body>
    <div>
        <div class="container mt-2">
            <div class="card1">
                <div class="card-header bg-primary text-white">
                    <h5 class="text-center mb-0">REPORTES</h5>
                </div>
                <div class="container">
                    <div class="section-space">
                        <div class="row">
                            <!-- EVENTOS PENDIENTES Y CULMINADOS -->
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card-custom">
                                    <div class="card-header">
                                        <h3 class="card-title">Generar Reporte Eventos</h3>
                                    </div>
                                    <div class="card-body text-center">
                                        <a href="{{route('reportevenp')}}" target="_blank" class="btn btn-warning">
                                            <i class="bi bi-printer"></i> Pendientes
                                        </a>
                                        <a href="{{route('reportevenf')}}" target="_blank" class="btn btn-success">
                                            <i class="bi bi-printer"></i> Finalizados
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- EVENTOS EN GENERAL -->
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card-custom">
                                    <div class="card-header">
                                        <h3 class="card-title">Eventos en General</h3>
                                    </div>
                                    <div class="card-body text-center">
                                        <a href="{{ route('reportevento') }}" target="_blank" class="btn btn-success">
                                            <i class="bi bi-printer"></i> Ver eventos
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- EVENTOS MAS ACTIVIDADES -->
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card-custom">
                                    <div class="card-header">
                                        <h3 class="card-title">Eventos + Actividades</h3>
                                    </div>
                                    <div class="card-body text-center">
                                        <a href="{{ route('reprTodosLosSubeventos') }}" target="_blank" class="btn btn-success">
                                            <i class="bi bi-printer"></i> Ver eventos
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- ACTIVIDADES POR EVENTO -->
                            <div class="col-lg-4 col-md-6 mb-4">
                                <form method="get" action="{{ route('reporSubeventosPorEvento') }}" target="_blank">

                                    <div class="card-custom">
                                        <div class="card-header">
                                            <h3 class="card-title">Actividades del evento</h3>
                                        </div>

                                        <select class="form-control" id="ideven" name="ideven" required>
                                            <option value="" disabled selected>Seleccione evento</option>
                                            @foreach ($eventos as $even)
                                            <option value="{{$even->idevento}}">{{$even->eventnom}}</option>
                                            @endforeach
                                        </select>

                                        <div class="card-body text-center">
                                            <button class="btn btn-success">
                                                <i class="bi bi-printer"></i> Generar Reporte
                                            </button>
                                        </div>
                                    </div>

                                </form>
                            </div>

                            <!-- REPORTE DE INSCRITOS AL EVENTO -->
                            <div class="col-lg-4 col-md-6 mb-4">
                                <form method="get" action="{{ route('reportinscripcionporevento') }}" target="_blank">

                                    <div class="card-custom">
                                        <div class="card-header">
                                            <h3 class="card-title">Inscritos al evento</h3>
                                        </div>

                                        <select class="form-control" id="ideven" name="ideven" required>
                                            <option value="" disabled selected>Seleccione evento</option>
                                            @foreach ($eventos as $even)
                                            <option value="{{$even->idevento}}">{{$even->eventnom}}</option>
                                            @endforeach
                                        </select>

                                        <div class="card-body text-center">
                                            <button class="btn btn-success">
                                                <i class="bi bi-printer"></i> Generar Reporte
                                            </button>
                                        </div>
                                    </div>

                                </form>
                            </div>

                            <!-- INSCRITOS POR ESCUELA / FACULTAD -->
                          <div class="col-lg-4 col-md-6 mb-4">
                           <form method="POST" action="{{ route('reportxesxfaxev') }}" target="_blank">
                           @csrf

                            <div class="card-custom">
                            <div class="card-header">
                                <h3 class="card-title">Reporte de Inscritos</h3>
                            </div>
                            <div class="col-lg-4 col-md-6 mb-4">
                                <form method="POST" action="{{ route('reportxesxfaxev') }}" target="_blank">
                                    @csrf
                                    <div class="card-custom">
                                        <div class="card-header">
                                            <h3 class="card-title">Reporte de Inscritos</h3>
                                        </div>

                                        <select class="form-control" id="ideven" name="ideven" required>
                                            <option value="" disabled selected>Seleccione evento</option>
                                            @foreach ($eventos as $even)
                                            <option value="{{$even->idevento}}">{{$even->eventnom}}</option>
                                            @endforeach
                                        </select>

                                        <div class="card-body text-center">
                                            <button type="submit" class="btn btn-success" name="action" value="escuela">
                                                <i class="bi bi-printer"></i> Por Escuela
                                            </button>
                                            <button type="submit" class="btn btn-warning" name="action" value="facultad">
                                                <i class="bi bi-printer"></i> Por Facultad
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- ASISTENCIA GENERAL -->
                            <div class="col-lg-4 col-md-6 mb-4">
                                <form method="get" action="{{ route('asistenciageneral') }}" target="_blank">

                                    <div class="card-custom">
                                        <div class="card-header">
                                            <h3 class="card-title">Asistencia por evento</h3>
                                        </div>

                                        <select class="form-control" id="ideven" name="ideven" required>
                                            <option value="" disabled selected>Seleccione evento</option>
                                            @foreach ($eventos as $even)
                                            <option value="{{$even->idevento}}">{{$even->eventnom}}</option>
                                            @endforeach
                                        </select>

                                        <div class="card-body text-center">
                                            <button class="btn btn-success">
                                                <i class="bi bi-printer"></i> Generar Reporte
                                            </button>
                                        </div>
                                    </div>

                                </form>
                            </div>

                            <!-- ASISTENCIAS (PRESENTES / AUSENTES) -->
                            <div class="col-lg-4 col-md-6 mb-4">
                                <form method="POST" action="{{ route('reportasis') }}" target="_blank">
                                    @csrf
                                    <div class="card-custom">
                                        <div class="card-header">
                                            <h3 class="card-title">Asistencias</h3>
                                        </div>

                                        <select class="form-control" id="ideven" name="ideven" required>
                                            <option value="" disabled selected>Seleccione evento</option>
                                            @foreach ($eventos as $even)
                                            <option value="{{$even->idevento}}">{{$even->eventnom}}</option>
                                            @endforeach
                                        </select>

                                        <div class="card-body text-center">
                                            <button type="submit" class="btn btn-success" name="action" value="presentes">
                                                <i class="bi bi-printer"></i> Presentes
                                            </button>
                                            <button type="submit" class="btn btn-warning" name="action" value="ausentes">
                                                <i class="bi bi-printer"></i> Ausentes
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- CERTIFICADOS GENERAL -->
                            <div class="col-lg-4 col-md-6 mb-4">
                                <form method="get" action="{{ route('reportcertificado') }}" target="_blank">

                                    <div class="card-custom">
                                        <div class="card-header">
                                            <h3 class="card-title">Certificados en General</h3>
                                        </div>

                                        <select class="form-control" id="idevento" name="idevento" required>
                                            <option value="" disabled selected>Seleccione evento</option>
                                            @foreach ($eventos as $even)
                                            <option value="{{ $even->idevento }}">{{ $even->eventnom }}</option>
                                            @endforeach
                                        </select>


                                        <div class="card-body text-center">
                                            <button class="btn btn-success">
                                                <i class="bi bi-printer"></i> Generar Reporte
                                            </button>
                                        </div>
                                    </div>

                                </form>
                            </div>




                            <!-- CERTIFICADOS Normal -->
                            <div class="col-lg-4 col-md-6 mb-4">
                                <form method="get" action="{{ route('reportcertificadoexter') }}" target="_blank">

                                    <div class="card-custom">
                                        <div class="card-header">
                                            <h3 class="card-title">Certificados en exteriores</h3>
                                        </div>

                                        <select class="form-control" id="idevento" name="idevento" required>
                                            <option value="" disabled selected>Seleccione evento</option>
                                            @foreach ($eventos as $even)
                                            <option value="{{ $even->idevento }}">{{ $even->eventnom }}</option>
                                            @endforeach
                                        </select>


                                        <div class="card-body text-center">
                                            <button class="btn btn-success">
                                                <i class="bi bi-printer"></i> Generar Reporte
                                            </button>
                                        </div>
                                    </div>

                                </form>
                            </div>

                            <!-- CERTIFICADOS ENTREGADOS / PENDIENTES -->
                            <div class="col-lg-4 col-md-6 mb-4">
                                <form method="get" action="{{ route('reportcerti') }}" target="_blank">
                                    <div class="card-custom">
                                        <div class="card-header">
                                            <h3 class="card-title">Certificados</h3>
                                        </div>

                                        <select class="form-control" id="ideven" name="ideven" required>
                                            <option value="" disabled selected>Seleccione evento</option>
                                            @foreach ($eventos as $even)
                                            <option value="{{$even->idevento}}">{{$even->eventnom}}</option>
                                            @endforeach
                                        </select>

                                        <div class="card-body text-center">

                                            <!-- BOTÓN ENTREGADOS -->
                                            <button class="btn btn-success" name="action" value="entregado">
                                                <i class="bi bi-printer"></i> Entregados
                                            </button>

                                            <!-- BOTÓN PENDIENTES -->
                                            <button class="btn btn-warning" name="action" value="pendiente">
                                                <i class="bi bi-printer"></i> Por entregar
                                            </button>

                                        </div>
                                    </div>
                                </form>

                            </div>

                            <!-- FACULTADES -->
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card-custom">
                                    <div class="card-header">
                                        <h3 class="card-title">Reporte de Facultades</h3>
                                    </div>
                                    <div class="card-body text-center">
                                        <a href="{{ route('Vistas.pdffac') }}" target="_blank" class="btn btn-success">
                                            <i class="bi bi-printer"></i> Ver Facultades
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- ESCUELAS -->
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card-custom">
                                    <div class="card-header">
                                        <h3 class="card-title">Reporte de Escuelas</h3>
                                    </div>
                                    <div class="card-body text-center">
                                        <a href="{{ route('Vistas.pdfescu') }}" target="_blank" class="btn btn-success">
                                            <i class="bi bi-printer"></i> Ver Escuelas
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('Vistas.Footer')