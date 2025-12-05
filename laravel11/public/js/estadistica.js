let attendanceChart, certificadosChart, participantesChart;
let eventosChart, miGrafico;
// rutas de los APIS
const routes = {
    eventosTipo: document.getElementById('api-routes')?.dataset.eventosTipo || '/api/eventos/tipo',
    eventosDistribucion: document.getElementById('api-routes')?.dataset.eventosDistribucion || '/api/eventos/distribucion',
    eventosProximos: document.getElementById('api-routes')?.dataset.eventosProximos || '/eventos-proximos',
    estadisticasEventos: document.getElementById('api-routes')?.dataset.estadisticasEventos || '/estadisticas-eventos',
    eventosResolucion: document.getElementById('api-routes')?.dataset.eventosResolucion || '/eventos-con-resolucion',
    participantesEscuela: document.getElementById('api-routes')?.dataset.participantesEscuela || '/get-participantes-por-escuela',
    eventosAno: document.getElementById('api-routes')?.dataset.eventosAno || '/eventos-por-ano',
    eventosInforme: document.getElementById('api-routes')?.dataset.eventosInforme || '/eventos-con-informe',
    participantesFacultad: document.getElementById('api-routes')?.dataset.participantesFacultad || '/participante/facultad',
    certificadosEvento: document.getElementById('api-routes')?.dataset.certificadosEvento || '/certificados-evento'
};

/** ========== FUNCIÓN DE INICIALIZACIÓN ============= */
$(document).ready(function () {
    cargarGraficoPrincipal();
    cargarGraficoDona();
    cargarEventosProximos();
    cargarDatos();
    cargarDatosParticipantes();
    actualizarGrafico2();
    cargarCertificadosEvento();
});

/**
 * ============================================================================
 * GRÁFICO 1: EVENTOS POR TIPO Y ESTADO (Barras)
 * ============================================================================
 */
function cargarGraficoPrincipal() {
    fetch(routes.eventosTipo)
        .then(response => response.json())
        .then(data => {
            const etiquetas = data.labels.map(label => label.split(' ').slice(0, 6).join(' '));

            const ctx = document.getElementById('eventosChart').getContext('2d');
            eventosChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: etiquetas,
                    datasets: data.datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                callback: value => Number.isInteger(value) ? value : ''
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                title: tooltipItems => data.labels[tooltipItems[0].dataIndex]
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error al cargar gráfico principal:', error));
}

/**
 * ============================================================================
 * GRÁFICO 2: DISTRIBUCIÓN POR TIPO DE EVENTO (Dona)
 * ============================================================================
 */
function cargarGraficoDona() {
    fetch(routes.eventosDistribucion)
        .then(response => response.json())
        .then(data => {
            const etiqueta = data.labels.map(label => label.split(' ').slice(0, 8).join(' '));
            const ctx = document.getElementById('miGrafico').getContext('2d');
            miGrafico = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: etiqueta,
                    datasets: [{
                        data: data.data,
                        backgroundColor: [
                            'rgba(237, 0, 51, 0.8)',
                            'rgba(0, 153, 255, 0.8)',
                            'rgba(0, 249, 249, 0.8)',
                            'rgba(254, 127, 0, 0.8)',
                            'rgba(255, 183, 0, 0.8)',
                            'rgba(26, 255, 0, 0.8)'
                        ]
                    }]
                },
                options: {
                    responsive: false,
                    maintainAspectRatio: false,
                    cutout: '80%',
                    plugins: {
                        legend: {
                            position: 'right'
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const porcentaje = ((context.raw / data.total) * 100).toFixed(2);
                                    return `${context.label}: ${context.raw} (${porcentaje}%)`;
                                }
                            }
                        }
                    }
                }
            });

            // Crear leyenda personalizada
            let legendHTML = '<ul class="list-group list-group-flush">';
            data.labels.forEach((label, index) => {
                const porcentaje = ((data.data[index] / data.total) * 100).toFixed(2);
                legendHTML += `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>${label}</span>
                        <span class="badge bg-success">${data.data[index]} (${porcentaje}%)</span>
                    </li>
                `;
            });
            legendHTML += '</ul>';
            $('#legendaEventos').html(legendHTML);
        })
        .catch(error => console.error('Error al cargar distribución:', error));
}

/**
 * ============================================================================
 * TABLA: EVENTOS PRÓXIMOS
 * ============================================================================
 */
function cargarEventosProximos() {
    fetch(routes.eventosProximos)
        .then(response => response.json())
        .then(eventos => {
            const tbody = $('#tablaEventosProximos tbody');
            tbody.empty();

            if (eventos.length === 0) {
                tbody.append('<tr><td colspan="4" class="text-center">No hay eventos próximos</td></tr>');
                return;
            }

            eventos.forEach((evento, index) => {
                const hora = evento.proxima_hora ? evento.proxima_hora : '--:--';

                tbody.append(`
                    <tr>
                        <td>${index + 1}</td>
                        <td>${evento.eventnom}</td>
                        <td>${evento.proxima_fecha}</td>
                    </tr>
                `);
            });
        })
        .catch(error => console.error('Error al cargar eventos próximos:', error));
}

/**
 * ============================================================================
 * GRÁFICO 3: ESTADÍSTICAS DE ASISTENCIA (ApexCharts)
 * ============================================================================
 */
let asistenciaChart = null;
Chart.register(ChartDataLabels);

$('#event').on('change', cargarDatos);

function cargarDatos() {
    const eventoIdss = $('#event').val();
    if (!eventoIdss) return;

    $.ajax({
        url: routes.estadisticasEventos,
        type: 'GET',
        data: {
            event: eventoIdss
        },
        success: function (data) {
            if (!data) {
                limpiarGrafico();
            } else {
                actualizarGrafico([data]);
            }
        },
        error: error => console.error("Error al cargar asistencia:", error)
    });
}

function actualizarGrafico(eventos) {
    const nombresCompletos = eventos.map(e => e.eventnom);
    const nombresCortos = eventos.map(e => e.eventnom.split(' ').slice(0, 8).join(' '));

    const data = {
        labels: nombresCortos,
        datasets: [{
            label: 'Inscritos',
            data: eventos.map(e => parseInt(e.total_participantes)),
            backgroundColor: 'rgba(54, 162, 235, 0.85)',
            borderColor: 'rgba(4, 147, 243, 1)',
            borderWidth: 1.4,
            borderRadius: 8
        },
        {
            label: 'Asistentes',
            data: eventos.map(e => parseInt(e.asistentes)),
            backgroundColor: 'rgba(75, 192, 92, 0.85)',
            borderColor: 'rgba(4, 250, 41, 1)',
            borderWidth: 1.4,
            borderRadius: 8
        },
        {
            label: 'Ausentes',
            data: eventos.map(e => parseInt(e.ausentes)),
            backgroundColor: 'rgba(255, 99, 132, 0.85)',
            borderColor: 'rgba(239, 4, 55, 1)',
            borderWidth: 1.4,
            borderRadius: 8
        }
        ]
    };

    const ctx = document.getElementById("asistencia").getContext("2d");

    if (asistenciaChart) asistenciaChart.destroy();

    asistenciaChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        font: {
                            size: 12,
                            family: "Roboto, sans-serif"
                        },
                        color: "#333"
                    }
                },
                tooltip: {
                    enabled: true,
                    backgroundColor: "rgba(0,0,0,0.85)",
                    titleFont: {
                        size: 13,
                        weight: "bold"
                    },
                    bodyFont: {
                        size: 12
                    },
                    padding: 10,
                    callbacks: {
                        title: function (items) {
                            const index = items[0].dataIndex;
                            return nombresCompletos[index];
                        },
                        label: function (ctx) {
                            const label = ctx.dataset.label;
                            const value = ctx.raw;
                            const idx = ctx.dataIndex;
                            const total =
                                parseInt(eventos[idx].total_participantes) +
                                parseInt(eventos[idx].asistentes) +
                                parseInt(eventos[idx].ausentes);
                            const porcentaje = total > 0 ?
                                ((value / total) * 100).toFixed(1) + "%" :
                                "0%";
                            return `${label}: ${value} (${porcentaje})`;
                        }
                    }
                },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    color: '#111',
                    font: {
                        size: 11,
                        weight: "bold"
                    },
                    formatter: value => value > 0 ? value : ""
                }
            },
            scales: {
                x: {
                    ticks: {
                        font: {
                            size: 11,
                            family: "Roboto"
                        },
                        color: "#444"
                    },
                    grid: {
                        display: false
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Cantidad',
                        font: {
                            size: 13,
                            weight: "bold"
                        }
                    },
                    ticks: {
                        font: {
                            size: 11
                        },
                        stepSize: 1
                    },
                    beginAtZero: true,
                    grid: {
                        color: "rgba(0,0,0,0.12)",
                        borderDash: [4, 4]
                    }
                }
            },
            animation: {
                duration: 700,
                easing: "easeOutQuart"
            }
        }
    });
}

/**
 * ============================================================================
 * GRÁFICO 6: EVENTOS CON/SIN RESOLUCIÓN
 * ============================================================================
 */
document.addEventListener('DOMContentLoaded', function () {
    fetch(routes.eventosResolucion)
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('eventosresol').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Con Resolución', 'Sin Resolución'],
                    datasets: [{
                        label: 'Eventos',
                        data: [data.conResolucion, data.sinResolucion],
                        backgroundColor: ['#26ff04ff', '#FF4560']
                    }]
                },
                options: {
                    indexAxis: 'y',
                    scales: {
                        x: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => console.error("Error al cargar resoluciones:", error));
});

/**
 * ============================================================================
 * GRÁFICO 9: PARTICIPANTES POR ESCUELA
 * ============================================================================
 */
$('#evento, #facultad').on('change', actualizarGrafico2);

$(window).on("load", function () {
    if ($('#evento').val() && $('#facultad').val()) {
        actualizarGrafico2();
    }
});

function actualizarGrafico2() {
    const eventoId = $('#evento').val();
    const facultadId = $('#facultad').val();

    console.log("Evento:", eventoId, " | Facultad:", facultadId);

    if (!eventoId || !facultadId) return;

    const url = routes.participantesEscuela + "?evento=" + eventoId + "&facultad=" + facultadId;

    console.log("URL:", url);

    fetch(url)
        .then(r => r.json())
        .then(data => {
            const canvas = document.getElementById('graficoEscuelas');
            const ctx = canvas.getContext('2d');

            if (window.miGraficoEscuelas) {
                window.miGraficoEscuelas.destroy();
            }

            if (!data || data.length === 0) {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.fillText("No hay datos para mostrar", canvas.width / 2, canvas.height / 2);
                return;
            }

            const nombres = data.map(e => e.nomescu ?? 'Sin nombre');
            const cantidades = data.map(e => e.total ?? 0);

            window.miGraficoEscuelas = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: nombres,
                    datasets: [{
                        label: "Participantes",
                        data: cantidades,
                        backgroundColor: 'rgba(23,162,184,0.8)',
                        borderColor: 'rgba(23,162,184,1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error("Error al cargar participantes por escuela:", error));
}

/**
 * ============================================================================
 * GRÁFICO 7: CURVA DE EVENTOS POR AÑO
 * ============================================================================
 */
document.addEventListener('DOMContentLoaded', function () {
    fetch(routes.eventosAno)
        .then(response => response.json())
        .then(data => {
            if (data.length === 0) return;

            const anios = [...new Set(data.map(e => e.anio))];
            const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
            ];

            const datasets = anios.map(anio => ({
                label: `Año ${anio}`,
                data: meses.map((mes, i) => {
                    const evento = data.find(e => e.anio == anio && e.mes == (i + 1));
                    return evento ? evento.cantidad : 0;
                }),
                borderColor: `hsl(${Math.random() * 360}, 100%, 50%)`,
                fill: false,
                tension: 0.1
            }));

            const ctx = document.getElementById('eventos-mes-curva').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: meses,
                    datasets
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
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
        })
        .catch(error => console.error("Error al cargar curva:", error));
});

/** ============================================================================
   GRÁFICO 8: EVENTOS CON/SIN INFORME
* ============================================================================ */
document.addEventListener('DOMContentLoaded', function () {
    fetch(routes.eventosInforme)
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
        })
        .catch(error => console.error("Error al cargar informes:", error));
});

/**
 * ============================================================================
 * GRÁFICO 11: PARTICIPANTES POR FACULTAD
 * ============================================================================
 */
function cargarDatosParticipantes() {
    const anio = $('#anioss').val();

    $.ajax({
        url: routes.participantesFacultad,
        type: 'GET',
        data: {
            anioss: anio
        },
        success: data => data.length === 0 ? limpiarGraficoParticipantes() : actualizarGraficoParticipantes(data),
        error: error => console.error("Error al cargar participantes:", error)
    });
}

$('#anioss').on('change', cargarDatosParticipantes);

function actualizarGraficoParticipantes(participantes) {
    const nombres = participantes.map(p => p.facultad);
    const cortos = nombres.map(n => n.split(' ').slice(2, 5).join(' '));
    const cantidades = participantes.map(p => parseInt(p.cantidad_participantes));

    const options = {
        series: [{
            name: 'Participantes',
            type: 'column',
            data: cantidades
        },
        {
            name: 'Tendencia',
            type: 'line',
            data: cantidades
        }
        ],
        chart: {
            height: 450,
            type: 'line'
        },
        stroke: {
            width: [0, 2]
        },
        dataLabels: {
            enabled: true,
            enabledOnSeries: [0]
        },
        xaxis: {
            categories: cortos
        },
        yaxis: [{
            title: {
                text: 'Cantidad de Participantes'
            },
            min: 0,
            max: Math.max(...cantidades) + 1,
            tickAmount: Math.max(...cantidades) + 1
        }],
        tooltip: {
            x: {
                formatter: (val, opts) => nombres[opts.dataPointIndex]
            }
        }
    };

    if (participantesChart) participantesChart.destroy();
    participantesChart = new ApexCharts(document.querySelector("#attendance-chartFacultad"), options);
    participantesChart.render();
}

function limpiarGraficoParticipantes() {
    if (participantesChart) participantesChart.destroy();
    participantesChart = new ApexCharts(document.querySelector("#attendance-chartFacultad"), {
        series: [],
        chart: {
            height: 350,
            type: 'line'
        }
    });
    participantesChart.render();
}

// ======================== CERTIFICADOS POR EVENTO ==========================
let graficoCertificados;
$('#eventos').on('change', cargarCertificadosEvento);

$(window).on("load", function () {
    if ($('#eventos').val()) {
        cargarCertificadosEvento();
    }
});

function cargarCertificadosEvento() {
    const eventoIds = document.getElementById("eventos").value;
    if (!eventoIds) return;

    const url = routes.certificadosEvento + "?evento=" + eventoIds;

    console.log("URL:", url);
    fetch(url)
        .then(r => r.json())
        .then(data => {
            const entregados = data.entregados ?? 0;
            const noEntregados = data.no_entregados ?? 0;

            const canvas = document.getElementById("certificados-entregados");
            const ctx = canvas.getContext("2d");

            if (graficoCertificados) graficoCertificados.destroy();

            graficoCertificados = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: ["Entregados", "No Entregados"],
                    datasets: [{
                        data: [entregados, noEntregados],
                        backgroundColor: [
                            "rgba(40, 167, 69, 0.80)",
                            "rgba(220, 53, 69, 0.80)"
                        ],
                        borderColor: [
                            "rgba(40, 167, 69, 1)",
                            "rgba(220, 53, 69, 1)"
                        ],
                        borderWidth: 2,
                        borderRadius: 6,
                        barThickness: 45
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Cantidad de Certificados',
                                color: '#333',
                                font: {
                                    size: 12,
                                    weight: 'bold'
                                }
                            },
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function (ctx) {
                                    const total = entregados + noEntregados;
                                    const porcentaje = total > 0 ?
                                        ((ctx.raw / total) * 100).toFixed(1) :
                                        0;
                                    return `${ctx.label}: ${ctx.raw} (${porcentaje}%)`;
                                }
                            }
                        }
                    },
                    animation: {
                        duration: 900,
                        easing: 'easeOutBounce'
                    }
                }
            });
        })
}