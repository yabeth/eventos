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
                        <a href="{{ route('Rut-certi') }}">
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
                                    <!-- Cambié el icono a fa-user en lugar de ti-user -->
                                    <i class="fa fa-user widget-stat-icon"></i>
                                    <div><i class="fa fa-level-up m-r-5"></i><small>17% higher</small></div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('Rutususario.per') }}">
                            <div class="ibox bg-orange color-white widget-stat">
                                <div class="ibox-body">
                                    <h3 class="m-b-5 font-strong">Usuario con Datos</h3>
                                    <div class="m-b-5">T</div>
                                    <!-- Cambié el icono a fa-database para representar 'Datos' -->
                                    <i class="fa fa-database widget-stat-icon"></i>
                                    <div><i class="fa fa-level-up m-r-5"></i><small>22% higher</small></div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('Rut.asistenc') }}">
                            <div class="ibox bg-silver-300 color-white widget-stat">
                                <div class="ibox-body">
                                    <h3 class="m-b-5 font-strong">Asistencias</h3>
                                    <div class="m-b-5">N</div>
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
                    <a href="#" onclick="window.open('http://localhost/even/Evento_Web/WEB/main.php', '_blank')">
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

                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('Rut.tipreso') }}">
                            <div class="ibox bg-secondary color-white widget-stat">
                                <div class="ibox-body">
                                    <h3 class="m-b-5 font-strong">Tipo resoluciones</h3>
                                    <div class="m-b-5">T</div><i class="fa fa-folder widget-stat-icon"></i>
                                    <div><i class="fa fa-arrow-up m-r-5"></i><small>22% higher</small></div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('Rut.tipusu') }}">
                            <div class="ibox bg-dark color-white widget-stat">
                                <div class="ibox-body">
                                    <h3 class="m-b-5 font-strong">Tipo usuarios</h3>
                                    <div class="m-b-5">T</div><i class="fa fa-users widget-stat-icon"></i>
                                    <div><i class="fa fa-arrow-up m-r-5"></i><small>22% higher</small></div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-6">  
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
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                
                <?php
                    use Illuminate\Support\Facades\DB;
                    $eventos = DB::table('evento')
                        ->join('tipoevento', 'evento.idTipoeven', '=', 'tipoevento.idTipoeven')
                        ->join('estadoevento', 'evento.idestadoeve', '=', 'estadoevento.idestadoeve')
                        ->select(
                            'tipoevento.nomeven as tipo_evento', 
                            'estadoevento.nomestado as estado_evento', 
                            DB::raw('COUNT(evento.idevento) as cantidad')
                        )
                        ->whereIn('estadoevento.nomestado', ['pendiente', 'culminado'])
                        ->groupBy('tipoevento.nomeven', 'estadoevento.nomestado')
                        ->orderBy('tipoevento.nomeven')
                        ->get();
                
                    $labels = $eventos->pluck('tipo_evento')->unique()->values();
                    $estados = $eventos->pluck('estado_evento')->unique()->values();
                    
                    $data = [];
                    
                    foreach ($estados as $estado) {
                        $data[$estado] = [];
                    
                        foreach ($labels as $tipoEvento) {
                            $evento = $eventos->where('estado_evento', $estado)
                                            ->where('tipo_evento', $tipoEvento)
                                            ->first();
                    
                            $data[$estado][$tipoEvento] = $evento ? $evento->cantidad : 0;
                        }
                    }
                    
                    // Crear un array para datasets
                    $datasets = [];
                    
                    foreach ($estados as $estado) {
                        $datasets[] = [
                            'label' => $estado,
                            'data' => array_values($data[$estado]),
                            'backgroundColor' => $estado === 'culminado' ? 'rgba(0, 255, 0, 0.5)' : 'rgba(255, 99, 132, 1)',
                            'borderColor' => $estado === 'culminado' ? 'rgba(0, 255, 0, 0.5)' : 'rgba(255, 99, 132, 1)',
                            'borderWidth' => 1,
                        ];
                    }
                
                
                    // consulta para el grafico dinamico
                    $eventos = DB::table('evento')
                        ->join('tipoevento', 'evento.idTipoeven', '=', 'tipoevento.idTipoeven')
                        ->join('estadoevento', 'evento.idestadoeve', '=', 'estadoevento.idestadoeve')
                        ->select('tipoevento.nomeven as tipo_evento', 'estadoevento.nomestado as estado_evento', DB::raw('COUNT(evento.idevento) as cantidad'))
                        ->groupBy('tipoevento.nomeven', 'estadoevento.nomestado')
                        ->get();

                    $labels = $eventos->pluck('tipo_evento')->unique()->values();
                    $totalEventos = $eventos->sum('cantidad');

                    $dataDona = [];

                    foreach ($eventos as $evento) {
                    if (!isset($dataDona[$evento->tipo_evento])) {
                        $dataDona[$evento->tipo_evento] = 0;
                    }
                    $dataDona[$evento->tipo_evento] += $evento->cantidad;
                    }

                    // consulta para mostrar eventos proximos en el mes actual
                    use Carbon\Carbon;

                    $eventosPendientes = DB::table('evento')
                        ->select('evento.idevento', 'evento.eventnom', 'evento.descripción', 'evento.fecini', 'evento.horain')
                        ->where(function ($query) {
                            $query->whereDate('evento.fecini', Carbon::today('America/Lima'))
                                ->whereTime('evento.horain', '>', Carbon::now('America/Lima')->format('H:i:s'));
                        })
                        ->orWhere(function ($query) {
                            $query->whereDate('evento.fecini', '>', Carbon::today('America/Lima'));
                            $query->whereBetween('evento.fecini', [
                                Carbon::today('America/Lima'),
                                Carbon::today('America/Lima')->addDays(20)
                            ]);
                        })
                        ->orderBy('evento.fecini', 'asc')
                        ->orderBy('evento.horain', 'asc')
                        ->get();

                        
                    $eventoscer = DB::table('evento')
                        ->select('idevento', 'eventnom')
                        ->orderBy('idevento', 'desc')
                        ->get();
                    $facultadess = DB::table('facultad')->select('idfacultad', 'nomfac')->get();
                ?>

                @if ($labels->isNotEmpty() && !empty($data))
                <div class="row">
                    <div class="col-lg-8">
                        <div class="ibox">
                            <div class="ibox-body">
                                <div class="flexbox ibox-head mb-4">
                                    <h3 class="card-title">Estadistica Eventos pendientes y culminados</h3>
                                </div>
                                <div>
                                    <canvas id="eventosChart" style="height: 260px;"></canvas>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <script>
                        function obtenerPrimerasDosPalabras(label) {
                            return label.split(' ').slice(0, 3).join(' ');
                        }

                        const etiquetasModificadas = @json($labels).map(label => obtenerPrimerasDosPalabras(label));
                        
                        const datasets = @json($datasets);

                        const ctx = document.getElementById('eventosChart').getContext('2d');
                        const eventosChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: etiquetasModificadas,
                                datasets: datasets
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            stepSize: 1, 
                                            callback: function(value) {
                                                return Number.isInteger(value) ? value : ''; 
                                            }
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    },
                                    tooltip: {
                                        callbacks: {
                                            title: function(tooltipItems) {
                                                const index = tooltipItems[0].dataIndex;
                                                return @json($labels)[index];
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    </script>
                    @else
                        <p>No hay datos disponibles para mostrar el gráfico.</p>
                    @endif

                    @if ($labels->isNotEmpty())
                    <div class="col-lg-4">
                        <div class="ibox" style="height: 500px; overflow-y: auto;">
                            <div class="ibox-head">
                                <div class="ibox-title">Estadísticas por Tipo de Evento</div>
                            </div>
                            <br>
                            <div class="ibox-body" style="margin-top: -60px;">
                                <div style="overflow-x: auto; width: 100%;">
                                    <div class="row align-items-center">
                                        <div class="col-md-12">
                                            <canvas id="miGrafico" style="width: 100%; height: auto;"></canvas>
                                        </div>
                                    </div>
                                    <br>
                                    <ul class="list-group list-group-divider list-group-full" style="margin-top: -40px; white-space: nowrap;">
                                        @foreach ($dataDona as $tipo => $cantidad)
                                            <li class="list-group-item">{{ $tipo }}
                                                <span class="float-right text-success">{{ $cantidad }} ({{ number_format(($cantidad / $totalEventos) * 100, 2) }}%)</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <script>
                        const dataDona = @json(array_values($dataDona));
                        const tipos = @json(array_keys($dataDona));

                        const ctxDona = document.getElementById('miGrafico').getContext('2d');
                        const miGrafico = new Chart(ctxDona, {
                            type: 'doughnut',
                            data: {
                                labels: tipos,
                                datasets: [{
                                    data: dataDona,
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 1)', // Color 1
                                        'rgba(54, 162, 235, 1)', // Color 2
                                        'rgba(75, 192, 192, 1)', // Color 3
                                        'rgba(255, 159, 64, 1)', // Color 4
                                        'rgba(255, 206, 86, 1)'  // Color 5
                                    ],
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'right',
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(tooltipItem) {
                                                const tipo = tooltipItem.label;
                                                const cantidad = tooltipItem.raw;
                                                const porcentaje = (cantidad / {{ $totalEventos }}) * 100;
                                                return `${tipo}: ${cantidad} (${porcentaje.toFixed(2)}%)`;
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    </script>
                    @else
                        <p>No hay datos disponibles para mostrar los gráficos.</p>
                    @endif
                </div>
                
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card mb-4" style="height: 450px; overflow-y: auto;">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3><small>Eventos próximos a realizarse</small></h3>
                                <ul class="nav">
                                    <li>
                                        <a class="btn btn-link" data-toggle="collapse" href="#table1" role="button" aria-expanded="false">
                                            <i class="fa fa-chevron-up"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="btn btn-link"><i class="fa fa-close"></i></a>
                                    </li>
                                </ul>
                            </div>
                            <div id="table1" class="collapse show">
                                <div class="card-body">
                                    <table class="table">
                                        <thead class="bg-dark text-white">
                                            <tr>
                                                <th>#</th>
                                                <th>Evento</th>
                                                <th>Descripción</th>
                                                <th>Fecha</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($eventosPendientes) && $eventosPendientes->isNotEmpty())
                                                @foreach ($eventosPendientes as $t)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $t->eventnom }}</td>
                                                        <td>{{ $t->descripción }}</td>
                                                        <td>{{ $t->fecini }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="4">No hay eventos próximos.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="card-title">Estadísticas de Asistencia</h3>
                                    
                                    <form id="filtro-form" method="GET" action="{{ route('estadisticas.eventos') }}" class="d-flex">
                                        <div class="d-flex align-items-center me-3">
                                            <label for="mes" class="form-label me-2">Mes:</label>
                                            <select name="mes" id="mes" class="form-control form-control-sm">
                                                @for ($i = 1; $i <= 12; $i++)
                                                    <option value="{{ $i }}" {{ isset($mes) && $mes == $i ? 'selected' : ($i == date('n') ? 'selected' : '') }}>
                                                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <label for="anio" class="form-label me-2">Año:</label>
                                            <select name="anio" id="anio" class="form-control form-control-sm">
                                                @for ($i = 2020; $i <= date('Y'); $i++)
                                                    <option value="{{ $i }}" {{ isset($anio) && $anio == $i ? 'selected' : ($i == date('Y') ? 'selected' : '') }}>{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="position-relative">
                                    <div id="attendance-chart" ></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="card mb-4">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">Eventos realizados por mes en el año</h3>
                                    <select id="anioSelect" class="form-select" style="width: 100px;">
                                        @for($i = date('Y'); $i >= 2020; $i--)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="position-relative">
                                    <canvas id="eventosCharts" height="170"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card mb-4">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <div class="ibox-head">
                                        <div class="ibox-title">Estadísticas de Eventos con Resolución</div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="position-relative">
                                    <canvas id="eventosresol"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="card-title">Cantidad de Eventos por Año</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="position-relative">
                                    <canvas id="eventos-mes-curva" height="100"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="card-title">Eventos pendientes por año</h3>
                                    <div class="d-flex align-items-center">
                                        <label for="anio" class="form-label me-2">Año:</label>
                                        <select id="anioSelect1" class="form-select" style="width: 100px;">
                                            @for($i = date('Y'); $i >= 2020; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="position-relative">
                                    <canvas id="eventos-pendientes"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h3 class="card-title">Cantidad de Participantes por Escuela de cada facultad</h3>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <label for="evento" class="form-label me-3">Evento:</label>
                                        <select name="evento" id="evento" class="form-control form-control-sm">
                                            @foreach ($eventoscer as $index => $eve)
                                                <option value="{{ $eve->idevento }}" {{ $index === 0 ? 'selected' : '' }}>{{ $eve->eventnom }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <label for="facultad" class="form-label me-1">Facultad:</label>
                                        <select name="facultad" id="facultad" class="form-control form-control-sm">
                                            @foreach ($facultadess as $index => $facultad)
                                                <option value="{{ $facultad->idfacultad }}" {{ $index === 0 ? 'selected' : '' }}>{{ $facultad->nomfac }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="position-relative">
                                    <canvas id="graficoEscuelas" width="400" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="card-title">Estadísticas de Certificados Entregados</h3>
                                    <form id="filtro-form" method="GET" action="{{ route('certificados.evento') }}" class="d-flex">
                                        <div class="d-flex align-items-center me-3">
                                            <label for="meses" class="form-label me-2">Mes:</label>
                                            <select name="meses" id="meses" class="form-control form-control-sm">
                                                @for ($i = 1; $i <= 12; $i++)
                                                    <option value="{{ $i }}" {{ isset($meses) && $meses == $i ? 'selected' : ($i == date('n') ? 'selected' : '') }}>
                                                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <label for="anios" class="form-label me-2">Año:</label>
                                            <select name="anios" id="anios" class="form-control form-control-sm">
                                                @for ($i = 2020; $i <= date('Y'); $i++)
                                                    <option value="{{ $i }}" {{ isset($anios) && $anios == $i ? 'selected' : ($i == date('Y') ? 'selected' : '') }}>{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="position-relative">
                                    <div id="attendance-chartst"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="card-title">Eventos con Informe.</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="position-relative">
                                    <canvas id="eventos-informe" style="height: 350px"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="card-title">Participantes por Facultad</h3>
                                    <form id="filtro-form" method="GET" action="{{ route('participante.facultad') }}" class="d-flex">
                                        <div class="d-flex align-items-center">
                                            <label for="anioss" class="form-label me-2">Año:</label>
                                            <select name="anioss" id="anioss" class="form-control form-control-sm">
                                                @for ($i = 2020; $i <= date('Y'); $i++)
                                                    <option value="{{ $i }}" {{ isset($anioss) && $anioss == $i ? 'selected' : ($i == date('Y') ? 'selected' : '') }}>{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="position-relative">
                                    <div id="attendance-chartFacultad"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"></script>
<script>
    function cargarDatos() {
        const mes = $('#mes').val();
        const anio = $('#anio').val();

        $.ajax({
            url: "{{ route('estadisticas.eventos') }}",
            type: 'GET',
            data: { mes: mes, anio: anio },
            success: function(data) {
                if (data.length === 0) {
                    limpiarGrafico();
                } else {
                    actualizarGrafico(data);
                }
            },
            error: function(error) {
                console.error("Error al cargar los datos", error);
            }
        });
    }

    $(document).ready(function() {
        cargarDatos();
    });

    $('#mes, #anio').on('change', function() {
        cargarDatos();
    });

    function obtenerPrimerasDosPalabras(nombre) {
        return nombre.split(' ').slice(0, 2).join(' ');
    }

    function actualizarGrafico(eventos) {
        const nombresCompletos = eventos.map(evento => evento.eventnom);
        
        const nombresEventos = eventos.map(evento => obtenerPrimerasDosPalabras(evento.eventnom));
        
        const totalParticipantes = eventos.map(evento => parseInt(evento.total_participantes));
        const asistentes = eventos.map(evento => parseInt(evento.asistentes));
        const ausentes = eventos.map(evento => parseInt(evento.ausentes));

        const attendanceChartOptions = {
            series: [
                {
                    name: 'Inscritos',
                    data: totalParticipantes
                },
                {
                    name: 'Asistentes',
                    data: asistentes
                },
                {
                    name: 'Ausentes',
                    data: ausentes
                }
            ],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded',
                    dataLabels: {
                        position: 'top' 
                    }
                }
            },
            legend: {
                position: 'top'
            },
            colors: ['#008FFB', '#00E396', '#FF4560'],
            dataLabels: {
                enabled: true,
                formatter: function(val, opts) {
                    return val;
                },
                style: {
                    fontSize: '10px',
                    colors: ["#000"]
                },
                offsetY: -15
            },
            yaxis: {
                title: {
                    text: 'Cantidad'
                }
            },
            xaxis: {
                categories: nombresEventos,
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                x: {
                    formatter: function(val, opts) {
                        return nombresCompletos[opts.dataPointIndex];
                    }
                }
            }
        };

        if (typeof attendanceChart !== "undefined") {
            attendanceChart.destroy();
        }

        attendanceChart = new ApexCharts(
            document.querySelector("#attendance-chart"),
            attendanceChartOptions
        );

        attendanceChart.render();
    }

    function limpiarGrafico() {
        if (typeof attendanceChart !== "undefined") {
            attendanceChart.destroy();
        }

        const attendanceChartOptions = {
            series: [],
            chart: {
                type: 'bar',
                height: 350
            },
            xaxis: {
                categories: []
            },
            dataLabels: {
                enabled: false
            }
        };

        attendanceChart = new ApexCharts(
            document.querySelector("#attendance-chart"),
            attendanceChartOptions
        );

        attendanceChart.render();
    }
</script>
            <!-- scrip de los eventos realizados -->
<script>
    document.getElementById('anioSelect').addEventListener('change', function() {
        var selectedYear = this.value;
        actualizarGraficos(selectedYear);
    });

    function actualizarGraficos(year) {
        fetch(`{{ url('/eventos-por-mes') }}/${year}`)
            .then(response => response.json())
            .then(data => {
                const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
               
                var labels = data.map(evento => meses[evento.mes - 1]).reverse();
                var cantidades = data.map(evento => evento.cantidad).reverse();

                var ctx = document.getElementById('eventosCharts').getContext('2d');
                if (window.eventosChart instanceof Chart) {
                    window.eventosChart.destroy();
                }
                window.eventosChart = new Chart(ctx, {
                    type: 'bar',
                    height: 350,
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Eventos Culminados',
                            data: cantidades,
                            backgroundColor: '#008FFB'
                        }]
                    },
                    options: {
                        indexAxis: 'y', 
                        scales: {
                            x: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    callback: function(value) {
                                        return Number.isInteger(value) ? value : '';
                                    }
                                }
                            }
                        },
                        plugins: {
                            datalabels: {
                                anchor: 'end',
                                align: 'end',
                                formatter: function(value) {
                                    return value;
                                },
                                color: '#000',
                                font: {
                                    size: '12px'
                                }
                            },
                            legend: {
                                position: 'top'
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        var label = context.dataset.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        label += context.raw;
                                        return label;
                                    }
                                }
                            }
                        }
                    }
                });
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        var initialYear = document.getElementById('anioSelect').value;
        actualizarGraficos(initialYear);
    });
</script>


<!-- scrip de los eventos pendientes por año -->

<script>
    document.getElementById('anioSelect1').addEventListener('change', function() {
        var selectedYear1 = this.value;
        actualizarGraficosPendientes(selectedYear1);
    });

    function actualizarGraficosPendientes(year) {
        fetch(`{{ url('/eventos-por-ano') }}/${year}`)
            .then(response => response.json())
            .then(data => {
                const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                
                var labels = data.map(evento => meses[evento.mes - 1]).reverse();
                var cantidades = data.map(evento => evento.cantidad).reverse();

                var ctx = document.getElementById('eventos-pendientes').getContext('2d');
                if (window.eventosChartPendientes instanceof Chart) {
                    window.eventosChartPendientes.destroy();
                }
                window.eventosChartPendientes = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Eventos Pendientes',
                            data: cantidades,
                            backgroundColor: '#FF4560'
                        }]
                    },
                    options: {
                        indexAxis: 'y', 
                        scales: {
                            x: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    callback: function(value) {
                                        return Number.isInteger(value) ? value : '';
                                    }
                                }
                            }
                        },
                        plugins: {
                            datalabels: {
                                anchor: 'end',
                                align: 'end',
                                formatter: function(value) {
                                    return value;
                                },
                                color: '#000',
                                font: {
                                    size: '12px'
                                }
                            },
                            legend: {
                                position: 'top'
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        var label = context.dataset.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        label += context.raw;
                                        return label;
                                    }
                                }
                            }
                        }
                    }
                });
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        var initialYear1 = document.getElementById('anioSelect1').value;
        actualizarGraficosPendientes(initialYear1);
    });

</script>

<!-- SCRIP DE LOS EVENTOS QUE TIENEN RESOLUCION Y CUANTOS NO -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch(`{{ url('/eventos-con-resolucion') }}`)
            .then(response => response.json())
            .then(data => {
                var ctx = document.getElementById('eventosresol').getContext('2d');
                var chartData = {
                    labels: ['Con Resolución', 'Sin Resolución'],
                    datasets: [{
                        label: 'Eventos',
                        data: [data.conResolucion, data.sinResolucion],
                        backgroundColor: ['#00E396', '#FF4560'],
                        barPercentage: 0.5, 
                        categoryPercentage: 0.8 
                    }]
                };

                var chartOptions = {
                    indexAxis: 'y',
                    scales: {
                        x: {
                            beginAtZero: true
                        }
                    }
                };

                new Chart(ctx, {
                    type: 'bar',
                    data: chartData,
                    options: chartOptions
                });
            });
    });
</script>

<!-- SCRIP DE CURVA DE EVENTOS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    var ctx = document.getElementById('eventos-mes-curva').getContext('2d');

    fetch(`{{ url('/eventos-por-ano') }}`)
        .then(response => response.json())
        .then(eventosPorMesAno => {
            console.log(eventosPorMesAno);

            if (eventosPorMesAno.length > 0) {
                var anios = [...new Set(eventosPorMesAno.map(e => e.anio))];
                var meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

                var datasets = anios.map(function(anio) {
                    return {
                        label: 'Año ' + anio,
                        data: meses.map(function(mes, index) {
                            var eventoMes = eventosPorMesAno.find(e => e.anio == anio && e.mes == (index + 1));
                            return eventoMes ? eventoMes.cantidad : 0;
                        }),
                        borderColor: `hsl(${Math.random() * 360}, 100%, 50%)`,
                        backgroundColor: 'rgba(0, 0, 0, 0)',
                        fill: false,
                        tension: 0.1
                    };
                });

                var eventosMesCurva = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: meses,
                        datasets: datasets 
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Meses'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Cantidad de eventos'
                                }
                            }
                        }
                    }
                });
            } else {
                console.log("No hay datos disponibles para mostrar los gráficos.");
            }
        })
        .catch(error => {
            console.error("Error al cargar los datos:", error);
        });
    });
</script>

<!-- scrip de los eventos que tienen informe -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch(`{{ url('/eventos-con-informe') }}`)
            .then(response => response.json())
            .then(data => {
                var ctx = document.getElementById('eventos-informe').getContext('2d');
                var chartData = {
                    labels: ['Con Informe', 'Sin Informe'],
                    datasets: [{
                        label: 'Eventos',
                        data: [data.conResolucion, data.sinResolucion],
                        backgroundColor: ['#00E396', '#FF4560'],
                        barPercentage: 0.5, 
                        categoryPercentage: 0.8 
                    }]
                };

                var chartOptions = {
                    indexAxis: 'x',
                    responsive: true,
                    maintainAspectRatio: false, 
                    scales: {
                        x: {
                            beginAtZero: true
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1 
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                font: {
                                    size: 12
                                }
                            }
                        }
                    }
                };

                new Chart(ctx, {
                    type: 'bar',
                    data: chartData,
                    options: chartOptions
                });
            });
    });
</script>



<!-- Participantes por escuela en dicho evento -->

<script>
    // Inicializa window.miGrafico como null al principio
    window.miGrafico = null;

    document.getElementById('evento').addEventListener('change', actualizarGrafico2);
    document.getElementById('facultad').addEventListener('change', actualizarGrafico2);

    function actualizarGrafico2() {
        const eventoId = document.getElementById('evento').value;
        const facultadId = document.getElementById('facultad').value;

        if (eventoId && facultadId) {
            fetch(`{{ url('/get-participantes-por-escuela') }}?evento=${eventoId}&facultad=${facultadId}`)
                .then(response => response.json())
                .then(data => {
                    console.log("Datos recibidos:", data);

                    const nombresEscuelas = data.map(escuela => escuela.nomescu);
                    const cantidadParticipantes = data.map(escuela => escuela.total);

                    if (window.miGrafico !== null) {
                        window.miGrafico.destroy();
                    }

                    const ctx = document.getElementById('graficoEscuelas').getContext('2d');
                    window.miGrafico = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: nombresEscuelas,
                            datasets: [{
                                label: 'Participantes por escuela',
                                data: cantidadParticipantes,
                                backgroundColor: 'rgba(0, 0, 255, 0.8)',
                                borderColor: 'rgba(0, 0, 255, 0.6)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1,
                                        callback: function(value) {
                                            return Number.isInteger(value) ? value : '';
                                        }
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        actualizarGrafico2();
    });
</script>


<!-- certificados entregados a los participantes de dicho evento -->

<script>
    function cargarDatosCertificados() {
        const mes = $('#meses').val();
        const anio = $('#anios').val();

        $.ajax({
            url: "{{ route('certificados.evento') }}",
            type: 'GET',
            data: { meses: mes, anios: anio },
            success: function(data) {
                if (data.length === 0) {
                    limpiarGraficoCertificados();
                } else {
                    actualizarGraficoCertificados(data);
                }
            },
            error: function(error) {
                console.error("Error al cargar los datos de certificados", error);
            }
        });
    }

    $(document).ready(function() {
        cargarDatosCertificados();
    });

    $('#meses, #anios').on('change', function() {
        cargarDatosCertificados();
    });

    function obtenerPrimerasCincoPalabras(nombre) {
        return nombre.split(' ').slice(0, 6).join(' ');
    }

    function actualizarGraficoCertificados(eventos) {
        const nombresCompletos = eventos.map(evento => obtenerPrimerasCincoPalabras(evento.evento));
        const certificadosEntregados = eventos.map(evento => parseInt(evento.certificados_entregados));
        const certificadosNoEntregados = eventos.map(evento => parseInt(evento.certificados_no_entregados));

        const certificadosChartOptions = {
            series: [
                {
                    name: 'Certificados Entregados',
                    data: certificadosEntregados
                },
                {
                    name: 'Certificados No Entregados',
                    data: certificadosNoEntregados
                }
            ],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '40%',
                    endingShape: 'rounded',
                    dataLabels: {
                        position: 'top' 
                    }
                }
            },
            legend: {
                position: 'top'
            },
            colors: ['#28a745', '#dc3545'],
            dataLabels: {
                enabled: true,
                formatter: function(val) {
                    return val;
                },
                style: {
                    fontSize: '10px',
                    colors: ["#000"]
                },
                offsetY: -15
            },
            yaxis: {
                title: {
                    text: 'Cantidad'
                }
            },
            xaxis: {
                categories: nombresCompletos,
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                x: {
                    formatter: function(val, opts) {
                        return nombresCompletos[opts.dataPointIndex];
                    }
                }
            }
        };

        if (typeof certificadosChart !== "undefined") {
            certificadosChart.destroy();
        }

        certificadosChart = new ApexCharts(
            document.querySelector("#attendance-chartst"),
            certificadosChartOptions
        );

        certificadosChart.render();
    }


    function limpiarGraficoCertificados() {
        if (typeof certificadosChart !== "undefined") {
            certificadosChart.destroy();
        }

        const certificadosChartOptions = {
            series: [],
            chart: {
                type: 'bar',
                height: 350
            },
            xaxis: {
                categories: []
            },
            dataLabels: {
                enabled: false
            }
        };

        certificadosChart = new ApexCharts(
            document.querySelector("#attendance-chartst"),
            certificadosChartOptions
        );

        certificadosChart.render();
    }
</script>



<script>
    function cargarDatosParticipantes() {
        const anio = $('#anioss').val();

        $.ajax({
            url: "{{ route('participante.facultad') }}",
            type: 'GET',
            data: { anioss: anio },
            success: function(data) {
                if (data.length === 0) {
                    limpiarGraficoParticipantes();
                } else {
                    actualizarGraficoParticipantes(data);
                }
            },
            error: function(error) {
                console.error("Error al cargar los datos de participantes", error);
            }
        });
    }

    $(document).ready(function() {
        cargarDatosParticipantes();
    });

    $('#anioss').on('change', function() {
        cargarDatosParticipantes();
    });

    function obtenerNombreFacultad(nombreCompleto) {
        return nombreCompleto.split(' ').slice(2, 5).join(' ');
    }

    function actualizarGraficoParticipantes(participantes) {
        const nombresCompletos = participantes.map(participante => participante.facultad);
        const etiquetasCortas = nombresCompletos.map(obtenerNombreFacultad);
        const cantidades = participantes.map(participante => parseInt(participante.cantidad_participantes));

        const chartOptions = {
            series: [{
                name: 'Participantes',
                type: 'column',
                data: cantidades
            }, {
                name: 'Tendencia',
                type: 'line',
                data: cantidades
            }],
            chart: {
                height: 450,
                type: 'line'
            },
            stroke: {
                width: [0, 2]
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '45%'
                }
            },
            dataLabels: {
                enabled: true,
                enabledOnSeries: [0]
            },
            xaxis: {
                categories: etiquetasCortas,
            },
            tooltip: {
                x: {
                    formatter: function(val, opts) {
                        return nombresCompletos[opts.dataPointIndex];
                    }
                }
            },
            yaxis: [{
                title: {
                    text: 'Cantidad de Participantes'
                },
                min: 0,
                max: Math.max(...cantidades) + 1,
                tickAmount: Math.max(...cantidades) + 1, 
                labels: {
                    formatter: function(val) {
                        return val.toFixed(0);
                    }
                }
            }]
        };

        if (typeof participantesChart !== "undefined") {
            participantesChart.destroy();
        }

        participantesChart = new ApexCharts(
            document.querySelector("#attendance-chartFacultad"),
            chartOptions
        );

        participantesChart.render();
    }

    function limpiarGraficoParticipantes() {
        if (typeof participantesChart !== "undefined") {
            participantesChart.destroy();
        }

        participantesChart = new ApexCharts(
            document.querySelector("#attendance-chartFacultad"),
            {
                series: [],
                chart: {
                    height: 350,
                    type: 'line'
                },
                xaxis: {
                    categories: []
                },
                yaxis: [{
                    title: {
                        text: 'Cantidad de Participantes'
                    }
                }]
            }
        );

        participantesChart.render();
    }
</script>




<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@include('Vistas.Footer')