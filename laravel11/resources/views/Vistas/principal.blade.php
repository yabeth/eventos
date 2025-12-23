@include('Vistas.Header')
<div class="page-content fade-in-up">
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <a href="{{ route('Rut.evento') }}">
                <div class="ibox bg-info color-white widget-stat">
                    <div class="ibox-body">
                        <h3 class="m-b-5 font-strong">Eventos</h3>
                        <div class="m-b-5">S</div>
                        <i class="fa fa-calendar evento-icon widget-stat-icon"></i>
                        <div><i class="fa fa-level-up m-r-5"></i><small>17% higher</small></div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6">
            <a href="{{ route('tipo.evento') }}">
                <div class="ibox bg-success color-white widget-stat">
                    <div class="ibox-body">
                        <h3 class="m-b-5 font-strong">Tipo de eventos</h3>
                        <div class="m-b-5">T</div><i class="fa fa-tag widget-stat-icon"></i>
                        <div><i class="fa fa-level-up m-r-5"></i><small>22% higher</small></div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6">
            <a href="{{ route('Rut.inscri') }}">
                <div class="ibox bg-danger color-white widget-stat">
                    <div class="ibox-body">
                        <h3 class="m-b-5 font-strong">Inscripciones</h3>
                        <div class="m-b-5">N</div><i class="fa fa-pencil widget-stat-icon"></i>
                        <div><i class="fa fa-level-down m-r-5"></i><small>-12% Lower</small></div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6">
            <a href="{{ route('Rut-certiss') }}">
                <div class="ibox bg-pink color-white widget-stat">
                    <div class="ibox-body">
                        <h3 class="m-b-5 font-strong">Certificados</h3>
                        <div class="m-b-5">R</div><i class="fa fa-certificate widget-stat-icon"></i>
                        <div><i class="fa fa-level-up m-r-5"></i><small>25% higher</small></div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6">
            <a href="{{ route('Rutususario') }}">
                <div class="ibox bg-purple color-white widget-stat">
                    <div class="ibox-body">
                        <h3 class="m-b-5 font-strong">Usuarios</h3>
                        <div class="m-b-5">S</div>
                        <i class="fa fa-user widget-stat-icon"></i>
                        <div><i class="fa fa-level-up m-r-5"></i><small>17% higher</small></div>
                    </div>
                </div>
            </a>
        </div>

        <!-- <div class="col-lg-3 col-md-6">
            <a href="{{ route('Rutususario.per') }}">
                <div class="ibox bg-orange color-white widget-stat">
                    <div class="ibox-body">
                        <h3 class="m-b-5 font-strong">Usuario con Datos</h3>
                        <div class="m-b-5">T</div>
                        <i class="fa fa-database widget-stat-icon"></i>
                        <div><i class="fa fa-level-up m-r-5"></i><small>22% higher</small></div>
                    </div>
                </div>
            </a>
        </div> -->

        <div class="col-lg-3 col-md-6">
            <a href="{{ route('vista.ConAsistencia') }}">
                <div class="ibox bg-silver-300 color-white widget-stat">
                    <div class="ibox-body">
                        <h3 class="m-b-5 font-strong">Asistencias</h3>
                        <div class="m-b-5">A</div>
                        <i class="fa fa-check-circle widget-stat-icon"></i>
                        <div><i class="fa fa-level-down m-r-5"></i><small>-12% Lower</small></div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6">
            <a href="{{ route('Rut.infor') }}">
                <div class="ibox bg-ebony color-white widget-stat">
                    <div class="ibox-body">
                        <h3 class="m-b-5 font-strong">Informes</h3>
                        <div class="m-b-5">R</div><i class="fa fa-file-text widget-stat-icon"></i>
                        <div><i class="fa fa-level-up m-r-5"></i><small>25% higher</small></div>
                    </div>
                </div>
            </a>
        </div>


        <div class="col-lg-3 col-md-6">
            <a href="{{ route('Rut.facu') }}">
                <div class="ibox bg-yellow color-white widget-stat">
                    <div class="ibox-body">
                        <h3 class="m-b-5 font-strong">Facultades</h3>
                        <div class="m-b-5">S</div><i class="fa fa-university widget-stat-icon"></i>
                        <div><i class="fa fa-level-up m-r-5"></i><small>17% higher</small></div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6">
            <a href="{{ route('Rut.escu') }}">
                <div class="ibox bg-dark color-white widget-stat">
                    <div class="ibox-body">
                        <h3 class="m-b-5 font-strong">Escuelas</h3>
                        <div class="m-b-5">T</div><i class="fa fa-graduation-cap widget-stat-icon"></i>
                        <div><i class="fa fa-level-up m-r-5"></i><small>22% higher</small></div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6">
            <a href="{{ route('vista.eventoweb') }}" target="_blank" rel="noopener noreferrer">
                <div class="ibox bg-secondary color-white widget-stat">
                    <div class="ibox-body">
                        <h3 class="m-b-5 font-strong">Web</h3>
                        <div class="m-b-5">N</div><i class="fa fa-globe widget-stat-icon"></i>
                        <div><i class="fa fa-level-down m-r-5"></i><small>-12% Lower</small></div>
                    </div>
                </div>
            </a>
        </div>


        <div class="col-lg-3 col-md-6">
            <a href="{{ route('Vtareport') }}">
                <div class="ibox bg-primary color-white widget-stat">
                    <div class="ibox-body">
                        <h3 class="m-b-5 font-strong">Reportes</h3>
                        <div class="m-b-5">R</div>
                        <!-- Cambié el icono a fa-bar-chart -->
                        <i class="fa fa-bar-chart widget-stat-icon"></i>
                        <div><i class="fa fa-level-up m-r-5"></i><small>25% higher</small></div>
                    </div>
                </div>
            </a>
        </div>



        <div class="col-lg-3 col-md-6">
            <a href="{{ route('Rut.reso') }}">
                <div class="ibox bg-purple color-white widget-stat">
                    <div class="ibox-body">
                        <h3 class="m-b-5 font-strong">Resolución evento</h3>
                        <div class="m-b-5">T</div><i class="fa fa-file-text widget-stat-icon"></i>
                        <div><i class="fa fa-arrow-up m-r-5"></i><small>22% higher</small></div>
                    </div>
                </div>
            </a>
        </div>

        <!-- <div class="col-lg-3 col-md-6">
            <a href="{{ route('Rut.tipreso') }}">
                <div class="ibox bg-secondary color-white widget-stat">
                    <div class="ibox-body">
                        <h3 class="m-b-5 font-strong">Tipo resoluciones</h3>
                        <div class="m-b-5">T</div><i class="fa fa-folder widget-stat-icon"></i>
                        <div><i class="fa fa-arrow-up m-r-5"></i><small>22% higher</small></div>
                    </div>
                </div>
            </a>
        </div> -->

        <!-- <div class="col-lg-3 col-md-6">
            <a href="{{ route('Rut.tipusu') }}">
                <div class="ibox bg-dark color-white widget-stat">
                    <div class="ibox-body">
                        <h3 class="m-b-5 font-strong">Tipo usuarios</h3>
                        <div class="m-b-5">T</div><i class="fa fa-users widget-stat-icon"></i>
                        <div><i class="fa fa-arrow-up m-r-5"></i><small>22% higher</small></div>
                    </div>
                </div>
            </a>
        </div> -->

        <!-- <div class="col-lg-3 col-md-6">
            <a href="{{ route('subirimagen.index') }}">
                <div class="ibox bg-secondary color-white widget-stat">
                    <div class="ibox-body">
                        <h3 class="m-b-5 font-strong">Configuraciones</h3>
                        <div class="m-b-5">N</div>
                        <i class="fa fa-cog widget-stat-icon"></i>
                        <div><i class="fa fa-level-down m-r-5"></i><small>-12% Lower</small></div>
                    </div>
                </div>
            </a>
        </div> -->
    </div>

    <?php
        use Illuminate\Support\Facades\DB;

        $eventoscer = DB::table('evento')
            ->select('idevento', 'eventnom')
            ->orderBy('idevento', 'desc')
            ->get();
        $facultadess = DB::table('facultad')->select('idfacultad', 'nomfac')->get();
    ?>
    <div class="row">
        <div class="col-lg-7 col-md-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Eventos Pendientes y Culminados
                    </h4>
                    <select name="anioos" id="anioos" class="form-select form-select-sm w-auto">
                        @for ($i = 2020; $i <= date('Y'); $i++)
                            <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="card-body">
                    <canvas id="eventosChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-5 col-md-12 mb-4">
            <div class="card shadow-sm"  style="height: 400px; overflow-y: auto;">
                <div class="card-header bg-success text-white">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-chart-pie me-2"></i>Distribución por Tipo
                    </h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-center">
                        <canvas id="miGrafico" style="height: 150px;"></canvas>
                    </div>
                    <div id="legendaEventos" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-calendar-alt me-2"></i>Eventos Próximos
                    </h4>
                </div>
                <div class="collapse show" id="collapseEventos">
                    <div class="card-body" style="max-height: 450px; overflow-y: auto;">
                        <table class="table table-hover table-sm" id="tablaEventosProximos">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Evento</th>
                                    <th>Fecha Inicio</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-users me-2"></i>Estadísticas de Asistencia
                    </h4>
                    <div class=" gap-2 mt-2">
                        <div class="col-md-12 col-lg-12">
                            <label class="form-label text-white small mb-1">
                                <i class="fas fa-calendar-check me-1"></i>Evento:
                            </label>
                            <select name="event" id="event" class="form-select form-select-sm">
                                @if(isset($eventoscer) && $eventoscer->isNotEmpty())
                                @foreach ($eventoscer as $index => $eve)
                                <option value="{{ $eve->idevento }}"
                                    {{ $index === 0 ? 'selected' : '' }}
                                    title="{{ $eve->eventnom }}">
                                    {{ Str::limit($eve->eventnom, 50, '...') }}
                                </option>
                                @endforeach
                                @else
                                <option value="">No hay eventos disponibles</option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="asistencia" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-school me-2"></i>Participantes por Escuela
                        </h4>
                    </div>

                    <div class="row g-2">
                        <div class="col-md-12 col-lg-6">
                            <label class="form-label text-white small mb-1">
                                <i class="fas fa-calendar-check me-1"></i>Evento:
                            </label>
                            <select name="evento" id="evento" class="form-select form-select-sm">
                                @if(isset($eventoscer) && $eventoscer->isNotEmpty())
                                @foreach ($eventoscer as $index => $eve)
                                <option value="{{ $eve->idevento }}"
                                    {{ $index === 0 ? 'selected' : '' }}
                                    title="{{ $eve->eventnom }}">
                                    {{ Str::limit($eve->eventnom, 50, '...') }}
                                </option>
                                @endforeach
                                @else
                                <option value="">No hay eventos disponibles</option>
                                @endif
                            </select>
                            @if(isset($eventoscer) && $eventoscer->isNotEmpty())
                            <small class="text-white-50 d-block mt-1">
                                {{ $eventoscer->count() }} eventos disponibles
                            </small>
                            @endif
                        </div>

                        <div class="col-md-12 col-lg-6">
                            <label class="form-label text-white small mb-1">
                                <i class="fas fa-university me-1"></i>Facultad:
                            </label>
                            <select name="facultad" id="facultad" class="form-select form-select-sm">
                                @if(isset($facultadess) && $facultadess->isNotEmpty())
                                @foreach ($facultadess as $index => $facultad)
                                <option value="{{ $facultad->idfacultad }}"
                                    {{ $index === 0 ? 'selected' : '' }}
                                    title="{{ $facultad->nomfac }}">
                                    {{ Str::limit($facultad->nomfac, 50, '...') }}
                                </option>
                                @endforeach
                                @else
                                <option value="">No hay facultades disponibles</option>
                                @endif
                            </select>
                            @if(isset($facultadess) && $facultadess->isNotEmpty())
                            <small class="text-white-50 d-block mt-1">
                                {{ $facultadess->count() }} facultades disponibles
                            </small>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <canvas id="graficoEscuelas" height="300"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-file-alt me-2"></i>Eventos con Resolución
                    </h4>
                </div>
                <div class="card-body">
                    <canvas id="eventosresol" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-chart-line me-2"></i>Evolución de Eventos por Año
                    </h4>
                </div>
                <div class="card-body">
                    <canvas id="eventos-mes-curva" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-md-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-certificate me-2"></i>Certificados Entregados por cada Evento
                    </h4>
                    <div class=" gap-2 mt-2">
                        <div class="col-md-12 col-lg-12">
                            <label class="form-label text-white small mb-1">
                                <i class="fas fa-calendar-check me-1"></i>Evento:
                            </label>
                            <select name="eventos" id="eventos" class="form-select form-select-sm">
                                @if(isset($eventoscer) && $eventoscer->isNotEmpty())
                                @foreach ($eventoscer as $index => $eve)
                                <option value="{{ $eve->idevento }}"
                                    {{ $index === 0 ? 'selected' : '' }}
                                    title="{{ $eve->eventnom }}">
                                    {{ Str::limit($eve->eventnom, 50, '...') }}
                                </option>
                                @endforeach
                                @else
                                <option value="">No hay eventos disponibles</option>
                                @endif
                            </select>
                            @if(isset($eventoscer) && $eventoscer->isNotEmpty())
                            <small class="text-white-50 d-block mt-1">
                                {{ $eventoscer->count() }} eventos disponibles
                            </small>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="certificados-entregados" height="250"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-clipboard-list me-2"></i>Eventos con Informe
                    </h4>
                </div>
                <div class="card-body">
                    <canvas id="eventos-informe" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-university me-2"></i>Participantes por Facultad
                    </h4>
                    <select name="anioss" id="anioss" class="form-select form-select-sm w-auto">
                        @for ($i = 2020; $i <= date('Y'); $i++)
                            <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                    </select>
                </div>
                <div class="card-body">
                    <div id="attendance-chartFacultad"></div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            border: none;
            border-radius: 10px;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .card-header {
            border-radius: 10px 10px 0 0 !important;
            padding: 1rem 1.25rem;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .form-select-sm {
            min-width: 100px;
        }

        canvas {
            max-height: 400px;
        }
    </style>

</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<div id="api-routes" 
     data-eventos-tipo="{{ route('api.eventos.tipo') }}"
     data-eventos-distribucion="{{ route('api.eventos.distribucion') }}"
     data-eventos-proximos="{{ url('/eventos-proximos') }}"
     data-estadisticas-eventos="{{ url('/estadisticas-eventos') }}"
     data-eventos-resolucion="{{ url('/eventos-con-resolucion') }}"
     data-participantes-escuela="{{ url('get-participantes-por-escuela') }}"
     data-eventos-ano="{{ url('/eventos-por-ano') }}"
     data-eventos-informe="{{ url('/eventos-con-informe') }}"
     data-participantes-facultad="{{ route('participante.facultad') }}"
     data-certificados-evento="{{ url('certificados-evento') }}"
     style="display:none;">
</div>

<script src="{{ asset('js/estadistica.js') }}"></script>


@include('Vistas.Footer')