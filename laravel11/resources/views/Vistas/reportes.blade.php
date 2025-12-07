
<!DOCTYPE html>
<html lang="es">
<head>
    @include('Vistas.Header')
    <!-- Bootstrap CSS -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css"> 
    <link rel="stylesheet" href="https://www.flaticon.es/iconos-gratis/enlace">
    
    <style>
        /* Tarjetas con bordes redondeados y sombra */
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        /* Efecto hover en tarjetas */
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        /* Espaciado entre botones */
        .btn {
            margin-bottom: 10px;
            margin-right: 5px;
        }

        /* Ajustar tamaño del icono */
        .bi {
            font-size: 1.2rem;
        }

        /* Efecto hover en botones */
        .btn:hover {
            background-color: #17a2b8;
            border-color: #17a2b8;
            color: white;
        }

        /* Ajustes de la tipografía */
        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
        }

        #ideven {
            margin: 10px 10px;
             /* Ajusta el valor de 10px según el espacio deseado */
        }

        .eveknkkkkkkktt {
    margin: 0 5px; /* Ajusta el valor de 5px según el espacio deseado */
}
        .card-body {
            font-size: 1rem;
            text-align: center; /* Alinear texto al centro */

        }

        /* Espaciado interno en las tarjetas */
        .card-header {
            background-color: #91d2f4;
            border-bottom: 2px solid #dee2e6;
            text-align: center; /* Alinear texto al centro */

        }

        /* Mejorar espaciado interno en select */
        .form-control {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container-fluid mt-3">
        <br><br>
        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        <div class="row">

               <!-- Reporte de Eventos -->
               <div class="col-lg-4 col-md-6 mb-4">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title">Generar Reporte Eventos</h3>
                    </div>
                    <div class="card-body">
                        <a href="{{route('reportevenp')}}" class="btn btn-warning" style="background-color: ##DD8C0B; border-color: ##DD8C0B;" target="_blank">
                            <i class="bi bi-printer"></i> Pendientes
                        </a>
                        <a href="{{route('reportevenf')}}" class="btn btn-success"  target="_blank">
                            <i class="bi bi-printer"></i> Finalizados
                        </a>


                        
                    </div>
                </div>
            </div>


            
            <!-- Segunda tarjeta: Eventos en general -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title">Eventos en General</h3>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('reportevento')}}" class="btn btn-success" target="_blank">
                            <i class="bi bi-printer"></i> Ver eventos
                        </a>
                    </div>
                </div>
            </div>



              
            <!-- Eventos en general con sus actividades -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title">Eventos en General con sus actividades</h3>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('reprTodosLosSubeventos')}}" class="btn btn-success" target="_blank">
                            <i class="bi bi-printer"></i> Ver eventos
                        </a>
                    </div>
                </div>
            </div>









                 <div class="col-lg-4 col-md-6 mb-4">
                            <form method="get" action="{{ route('reporSubeventosPorEvento') }}" target="_blank">
                    
                        <div class="card card-outline card-info">
                            <div class="card-header">
                                <h3 class="card-title">Actividades de los eventos</h3>
                            </div>
                            <select class="eventt" id="ideven" name="ideven" class="form-control" required>
                            <option value="" disabled selected>Seleccione evento</option>
                                
                                @foreach ($eventos as $even) 
                                    <option value="{{$even->idevento}}">{{$even->eventnom}}</option>
                                @endforeach
                            </select>
                            <div class="card-body">
                                <button type="submit" name="action" value="escuela" class="btn btn-success">
                                    <i class="bi bi-printer"></i> Generar Reporte
                                </button>
                            </div>
                        </div>
                  
                    </form> 
                </div>





   <div class="col-lg-4 col-md-6 mb-4">
                            <form method="get" action="{{ route('reportinscripcionporevento') }}" target="_blank">
                    
                        <div class="card card-outline card-info">
                            <div class="card-header">
                                <h3 class="card-title">Reporte de Inscritos al evento</h3>
                            </div>
                            <select class="eventt" id="ideven" name="ideven" class="form-control" required>
                            <option value="" disabled selected>Seleccione evento</option>
                                
                                @foreach ($eventos as $even) 
                                    <option value="{{$even->idevento}}">{{$even->eventnom}}</option>
                                @endforeach
                            </select>
                            <div class="card-body">
                                 <button type="submit" name="action" value="escuela" class="btn btn-success">
                                    <i class="bi bi-printer"></i> Generar Reporte
                                </button>
                            </div>
                        </div>
                  
                </form>  </div>









   <div class="col-lg-4 col-md-6 mb-4">
                            <form method="get" action="{{ route('reportxesxfaxev') }}" target="_blank">
                    
                        <div class="card card-outline card-info">
                            <div class="card-header">
                                <h3 class="card-title">Reporte de Inscritos</h3>
                            </div>
                            <select class="eventt" id="ideven" name="ideven" class="form-control" required>
                            <option value="" disabled selected>Seleccione evento</option>
                                
                                @foreach ($eventos as $even) 
                                    <option value="{{$even->idevento}}">{{$even->eventnom}}</option>
                                @endforeach
                            </select>
                            <div class="card-body">
                                <button type="submit" name="action" value="escuela" class="btn btn-success">
                                    <i class="bi bi-printer"></i> Por Escuela
                                </button>
                                <button type="submit" name="action" value="facultad" class="btn btn-warning" style="background-color: ##DD8C0B; border-color: ##DD8C0B;">
                                    <i class="bi bi-printer"></i> Por Facultad
                                </button>
                            </div>
                        </div>
                  
                </form>  </div>




               <div class="col-lg-4 col-md-6 mb-4">
                            <form method="get" action="{{ route('asistenciageneral') }}" target="_blank">
                    
                        <div class="card card-outline card-info">
                            <div class="card-header">
                                <h3 class="card-title">Asistencia de los eventos</h3>
                            </div>
                            <select class="eventt" id="ideven" name="ideven" class="form-control" required>
                            <option value="" disabled selected>Seleccione evento</option>
                                @foreach ($eventos as $even) 
                                    <option value="{{$even->idevento}}">{{$even->eventnom}}</option>
                                @endforeach
                            </select>
                            <div class="card-body">
                                <button type="submit" name="action" value="presentes" class="btn btn-success">
                                    <i class="bi bi-printer"></i>Generar Reporte
                                </button>
                            </div>
                        </div>
                        {{-- @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                        @endif --}}
                       
                  
                </form>  
            
            </div>


                   <div class="col-lg-4 col-md-6 mb-4">
                            <form method="get" action="{{ route('reportasis') }}" target="_blank">
                    
                        <div class="card card-outline card-info">
                            <div class="card-header">
                                <h3 class="card-title">Asistencias</h3>
                            </div>
                            <select class="eventt" id="ideven" name="ideven" class="form-control" required>
                            <option value="" disabled selected>Seleccione evento</option>
                                @foreach ($eventos as $even) 
                                    <option value="{{$even->idevento}}">{{$even->eventnom}}</option>
                                @endforeach
                            </select>
                            <div class="card-body">
                                <button type="submit" name="action" value="presentes" class="btn btn-success">
                                    <i class="bi bi-printer"></i> Ver Presentes
                                </button>
                                <button type="submit" name="action" value="ausentes" class="btn btn-warning" style="background-color: ##DD8C0B; border-color: ##DD8C0B;">
                                    <i class="bi bi-printer"></i> Ver Ausentes
                                </button>
                            </div>
                        </div>
                        {{-- @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                        @endif --}}
                       
                  
                </form>  
            
            </div>


               <!-- Tercera tarjeta: Certificado por evento -->
            <div class="col-lg-4 col-md-6 mb-4">
                <form method="get" action="{{ route('reportcertificado') }}" target="_blank">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">Certificado en general</h3>
                        </div>
                        <select class="eventt" id="ideven" name="ideven" class="form-control" required>
                            <option value="" disabled selected>Seleccione evento</option> <!-- Opción por defecto -->
                            @foreach ($eventos as $even) 
                                <option value="{{$even->idevento}}">{{$even->eventnom}}</option>
                            @endforeach
                        </select>
                        <div class="card-body">
                            <button type="submit" name="action" value="entregado" class="btn btn-success">
                                <i class="bi bi-printer"></i> Generar reporte
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tercera tarjeta: Certificado por evento -->
            <div class="col-lg-4 col-md-6 mb-4">
                <form method="get" action="{{ route('reportcerti') }}" target="_blank">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">Certificado</h3>
                        </div>
                        <select class="eventt" id="ideven" name="ideven" class="form-control" required>
                            <option value="" disabled selected>Seleccione evento</option> <!-- Opción por defecto -->
                            @foreach ($eventos as $even) 
                                <option value="{{$even->idevento}}">{{$even->eventnom}}</option>
                            @endforeach
                        </select>
                        <div class="card-body">
                            <button type="submit" name="action" value="entregado" class="btn btn-success">
                                <i class="bi bi-printer"></i> Entregados
                            </button>
                            <button type="submit" name="action" value="pendiente" class="btn btn-warning" style="background-color: ##DD8C0B; border-color: ##DD8C0B;">
                                <i class="bi bi-printer"></i> Por entregar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
     

                     



            

                
            







             <!-- Reporte de Facultades -->
             <div class="col-lg-4 col-md-6 mb-4">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title">Generar Reporte Facultad</h3>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('Vistas.pdffac') }}" class="btn btn-success" target="_blank">
                            <i class="bi bi-printer"></i> Listado de las Facultades
                        </a>
                    </div>
                </div>
            </div>

            

            <!-- Reporte de Escuelas -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title">Generar Reporte Escuelas</h3>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('Vistas.pdfescu') }}" class="btn btn-success" target="_blank">
                            <i class="bi bi-printer"></i> Listado de las Escuelas
                        </a>
                    </div>
                </div>
            </div>

                
                             <!-- Reporte de Eventos Pendientes -->
                
                             <div class="col-lg-4 col-md-6 mb-4">
                    
                
                            </div>
                
                
                
        </div>

    </div>
                        
                
@include('Vistas.Footer')
                