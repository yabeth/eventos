<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <title>Inscritos por facultad</title>
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
    
        <blockquote>
            <h3 style="position: relative; top: -30px; " >
                Inscritos al evento: <span style="font-weight: normal">{{$nome}}</span>
            </h3>
        </blockquote>

        @foreach($asistentesPorFacultad as $nomfac => $asistentes)

        <blockquote>
            <h3 style="position: relative; top: -35px; line-height:0.4;">
            Facultad: <span style="font-weight: normal">{{ $nomfac }}</span>
            </h3>
        </blockquote>


        
   
    <div class="table-container" style="position: relative; top: -30px">

    <table class="table table-bordered table-sm">
        <thead>
            <tr>
            <th>N°</th>
                <th>DNI</th>
                <th>Nombres y Apellidos</th>     
                <th>Escuela</th>  
                <th>corero</th>
            </tr>
        </thead>
        <tbody>
        @foreach($asistentes as $index => $asistente)
    <tr>
        <td style="text-align:center">{{ $index + 1 }}</td>
        <td>{{ $asistente->inscripcion->persona->dni }}</td>
        <td>{{ $asistente->inscripcion->persona->apell . " " . $asistente->inscripcion->persona->nombre }}</td>
        <td>{{ $asistente->inscripcion->escuela->nomescu }}</td>
        <td>{{ $asistente->inscripcion->persona->email }}</td>
    </tr>
@endforeach
        </tbody>
    </table>
    <br><br>
@endforeach

    </div>

    <div class="footer">
    </div>
</body>
</html>