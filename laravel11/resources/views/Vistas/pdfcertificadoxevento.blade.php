<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <title>Reporte de certificados General</title>
    @php
    use Carbon\Carbon;
    @endphp


    <style>
        body {
            margin-left: 0.8cm; /* Margen izquierdo de 2.54 cm */
            margin-right: 0.8cm;
            padding-top: 0px; /* Reduce el espacio superior */
            padding-bottom: 50px;
            
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        

        .header-table td {
            padding: 0px;
            vertical-align: middle; /* Centra verticalmente el contenido de cada celda */
        }
        .header-table img {
            width: 70px; /* Ajusta a tamaño deseado */
            height: auto; /* Mantiene proporciones */
        }
        .header-text {
            text-align: center;
            font-weight: bold;
            margin: 0;
        }
        .table-container {
            display: flex;
            justify-content: center;
            text-align: center;

        }
        .table-bordered {
            width: 95%;
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
        .table-font-size {
            font-size: 14px;
            text-align: center;      /* Centra el texto horizontalmente */
    vertical-align: middle;
        }
        .table-body-size {
            font-size: 15px;
            text-align: center;      /* Centra el texto horizontalmente */
    vertical-align: middle;
        }
    </style>
</head>
<body>
    <table class="header-table" style="font-size: 8pt; text-align: center; margin-top: 0;">
        <tr>
            <td>
                <img src="{{ public_path('images/escudoPeru.png') }}" alt="Imagen de Producto 1">
            </td>
            <td class="header-text" style="text-align: center; font-weight: bold; line-height: 1;">
                <h1 style="font-size: 25px; letter-spacing: 1px; margin: 0;">Universidad Nacional Licenciada</h1>
                <h1 style="font-size: 20px; letter-spacing: 0.5px; margin: 0;">Santiago Antúnez de Mayolo</h1>
                <hr> 
                <h2 style="letter-spacing: 1px; line-height: 1.2; font-size: 18px; margin: 0;">Huaraz-Ancash-Perú</h2>

            </td>
            <td>
                <img src="{{ public_path('images/logou.png') }}" alt="Escudo de Perú" height="50px">
            </td>
        </tr>
        
    </table>

    <hr style="height: 0.2px; border: 0; background-color: black;">       

<br>
      
        <blockquote>
            <h3 style="position: relative; top: -25px; line-height:1;">
                Listado de certificados del evento: {{ $nome }}
                @if(empty($descrip))
        <p><em>No hay Observaciones</em></p>
    @else
                <p>Observación: {{ $descrip }}</p> @endif
            </h3>
        </blockquote>
<br><br><br>
    <div class="table-container" style="position: relative; top: -30px">

            <table class="table table-bordered table-sm table-font-size">
                <thead class="table-body-size">
                    <tr>
                    <th>N°</th>
                    <th>N° de certificado</th>        
                    <th>DNI</th>
                    <th>Participante</th>
                    <th>Certificado</th>
                    <th>Fecha de Entrega</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($certi as $index => $certi)
                    <tr>
                        <td style="text-align:center">{{ $index + 1 }}</td>
                       
                        <td>{{ $certi->nro }}</td>
                        <td>{{ $certi->asistencia->inscripcion->persona->dni}}</td>
                        <td>{{ $certi->asistencia->inscripcion->persona->apell." ".$certi->asistencia->inscripcion->persona->nombre}}</td>
                        <td>{{ $certi->estadocerti->nomestadc }}</td>
                        <td> @if(is_null($certi->fecentrega))
        <p><em>Certificado NO entregado</em></p>
    @else
    <p>{{ $certi->fecentrega }}</p>
    @endif</td>
                      

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    
        <div class="footer">
        </div>
    </body>
    </html>