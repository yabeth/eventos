<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <title>Reporte</title>
@php
    use Carbon\Carbon;
    @endphp

    <style>
        body {
            padding-bottom: 50px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .header-table td {
            padding: 0px;
        }
        .header-table img {
            width: 85px;
        }
        .header-text {
            text-align: center;
            font-weight: bold;
        }
        .table-container {
            display: flex;
            justify-content: center;
        }
        .table-bordered {
            width: 100%;
            margin: 0 auto;
            border-collapse: collapse;
        }
        .table-bordered th, 
        .table-bordered td {
            border: 1px solid #000;
            padding: 5px;
        }
        .table-bordered th {
            background-color: #e7e7e7;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            position: fixed;
            bottom: 10px;
            width: 100%;
        }
    </style>
</head>
<body>

     <table class="header-table" style="font-size: 8pt; width: 100%; text-align: center">
        <tr>
            <td>
                <img src="{{ public_path('images/escudoPeru.png') }}" alt="Imagen de Producto 1" width="50" height="100">
            </td>
     
    
            <td class="header-text" style="text-align: center; font-weight: bold; line-height:0.4;">
                <h1 style="font-size:40px; letter-spacing:1px">Universidad Nacional</h1>
                 <h1 style="font-size:26px; letter-spacing:0.5px" > Santiago Antúnez de Mayolo </h1><hr>
                <p><h1 style="letter-spacing:1px; line-height:0.1;"> Huaraz-Ancash-Perú </h1></p> 
           
            </td>
    
    
            <td style="text-align: right;">
                <img src="{{ public_path('images/logou.png') }}" alt="Escudo de Perú" width="80" height="100">
            </td>
        </tr>
        
    </table>

   <hr style="height: 0.5px;border: 0;background-color: black;">       
        <h3 style="text-align: center; margin-top: 20px; margin-bottom: 20px;">
            Listado de las actividades de los eventos
        </h3>
        
    @foreach ($eventos as $evento)

        <div class="evento-titulo">
            Evento: <span style="font-weight: normal;">{{ $evento->eventnom }}</span>
        </div>
        <br>

        {{-- SI NO TIENE ACTIVIDADES --}}
        @if ($evento->subeventos->isEmpty())
            <p class="sin-actividades">Este evento no tiene actividades registradas.</p>

        @else

            {{-- TABLA DE ACTIVIDADES --}}
            <div class="table-container">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Descripción</th>
                            <th>Fecha de la actividad</th>
                            <th>Hora de inicio</th>
                            <th>Hora de cierre</th>
                            <th>Canal</th>
                            <th>Modalidad</th>
                            <th>URL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($evento->subeventos as $index => $sub)
                            <tr>
                                <td style="text-align:center">{{ $index + 1 }}</td>
                                <td>{{ $sub->Descripcion }}</td>
                                <td>{{ $sub->fechsubeve }}</td>
                                <td>{{ $sub->horini }}</td>
                                <td>{{ $sub->horfin }}</td>
                                <td>{{ $sub->canal->canal }}</td>
                                <td>{{ $sub->canal->modalidad->modalidad }}</td>
                                <td>{{ $sub->url }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @endif

    @if (!$loop->last)
      <div style="page-break-after: always;"></div>
    @endif

    @endforeach

</body>
</html>
