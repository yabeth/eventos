<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <title>Incritos por rango de fecha</title>
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
            font-size: 12px;
        }
        .table-body-size {
            font-size: 14px;
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

<br><br>
    <blockquote>
        <h4 style="position: relative; top: -30px; line-height: 1.6; font-size: 16px">
            Listado de Inscritos desde {{$fecinicio}} hasta {{$fecfin}}:
        </h4>
    </blockquote>

    <div class="table-container" style="position: relative; top: -30px;">
        <table class="table table-bordered table-sm table-font-size">
            <thead class="table-body-size">
                <tr>
                    <th>N°</th>
                    <th>DNI</th>
                    <th>Nombres y Apellidos</th>
                    <th>Escuela Profesional</th>        
                    <th>Fecha de Inscripción</th>   
                </tr>
            </thead>
            <tbody>
                @foreach($inscritos as $index => $inscri)
                <tr>
                    <td style="text-align:center">{{ $index + 1 }}</td>
                    <td>{{ $inscri->persona->dni }}</td>
                    <td>{{ $inscri->persona->apell." ".$inscri->persona->nombre }}</td>
                    <td>{{ $inscri->escuela->nomescu }}</td>
                    <td>{{ $inscri->fecinscripcion }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <!-- Footer content here -->
    </div>
</body>
</html>
