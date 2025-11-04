<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <title>Reporte</title>
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
            padding: 10px;
        }
        .header-table img {
            width: 100px;
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
            width: 80%;
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


<table class="header-table" style="font-size: 8pt; width: 100%">
    <tr>
        <!-- Coloca la imagen dentro de un <td> -->
        <td>
            <img src="{{ public_path('images/escudoPeru.png') }}" alt="Imagen de Producto 1" width="60" height="100">
        </td>
        <td class="header-text" style="text-align: center; font-weight: bold;"><h1>Universidad Nacional Santiago Antúnez de Mayolo <br><hr></h1><p><h2>Huaraz-Ancash-Perú</h2></p> 
       
        </td>
        <td style="text-align: right;">
            <img src="{{ public_path('images/Unasam.png') }}" alt="Escudo de Perú" width="80" height="100">
        </td>
    </tr>
    <tr>
        <td></td>
        <td></td>
    </tr>
</table>
    <h2 style="text-align:center"><u>Reporte de Presentes al evento {{$nome}}</u></h2>
    <br>

    <div class="table-container">
{{$mensaje}}

    </div>

    <div class="footer">
    </div>
</body>
</html>