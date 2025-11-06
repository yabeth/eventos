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