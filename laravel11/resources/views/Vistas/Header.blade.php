<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Eventos</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/themify-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/jvectormap/jquery-jvectormap-2.0.3.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.min.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Font Awesome 5 (versión gratuita) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        .widget-stat-icon {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

        h2 {
            font-size: 9vw;

            margin-top: 5px;
            font-weight: 600;
            font-size: 30px;
            text-align: center;


            background: linear-gradient(45deg,
                    #00bfff,
                    #33ccff,
                    #87cefa,
                    #b0e0e6,
                    #d1e7f2,
                    #b0e0e6,
                    #87cefa,
                    #33ccff);


            font-family: 'Roboto', sans-serif;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-fill-color: transparent;
        }
    </style>
</head>

<body class="fixed-navbar">
    <div class="page-wrapper">
        <!-- START HEADER-->
        <header class="header">

            <div class="page-brand">
                <a class="link" href="Principal.html">
                    <span class="brand">Eventos
                    </span>
                </a>
            </div>
            <div class="flexbox flex-1">
                <ul class="nav navbar-toolbar">
                    <li>
                        <a style="color:aliceblue" class="nav-link sidebar-toggler js-sidebar-toggler"><i class="ti-menu"></i></a>
                    </li>
                </ul>
                <ul>
                    <div class="text-center">

                        <h2>SISCERTIF</h2>
                    </div>
                </ul>

                <ul class="nav navbar-toolbar">
                    <li class="dropdown dropdown-user">
                        <a class="nav-link dropdown-toggle link" data-toggle="dropdown" style="color: #00bfff; text-align: right; display: block;">
                            @if (session('usuario') && session('usuario')->datosperusu && session('usuario')->datosperusu->persona)
                            <span>{{ session('usuario')->datosperusu->persona->nombre }} {{ session('usuario')->datosperusu->persona->apell }}</span>
                            @else
                            <span>{{ session('usuario') ? session('usuario')->nomusu : 'Nombre de usuario por defecto' }}</span> <!-- Muestra el nombre del usuario ingresado -->
                            @endif
                        </a>
                    </li>
                </ul>
            </div>
        </header>
        <!-- END HEADER-->
        <!-- START SIDEBAR-->
        <nav class="page-sidebar" id="sidebar">
            <div id="sidebar-collapse">
                <ul class="side-menu metismenu">

                    <li>
                        <a class="active" href="{{ route('principal') }}"><i class="sidebar-item-icon fa fa-th-large"></i>
                            <span class="nav-label">Inicio</span>
                        </a>
                    </li>
                    <li class="heading">FEATURES</li>
                    <li>
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-bookmark"></i>
                            <span class="nav-label">Eventos</span><i class="fa fa-angle-left arrow"></i>
                        </a>
                        <ul class="collapse">
                            <li class="nav-item">
                                <a href="{{ route('Rut.evento') }}" class="nav-link d-flex align-items-center ml-3">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="ml-2">Eventos</span>
                                </a>
                            </li>
                             <li class="nav-item">
                                <a href="{{ route('Rut.subevent') }}" class="nav-link d-flex align-items-center ml-3">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="ml-2">Actividades paralelas</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('tipo.evento') }}" class="nav-link d-flex align-items-center ml-3">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="ml-2">Tipo evento</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('Rut.tipreso') }}" class="nav-link d-flex align-items-center ml-3">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="ml-2">Tipo de Resoluciones</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('Rut.reso') }}" class="nav-link d-flex align-items-center ml-3">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="ml-2">Resolución evento</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-bookmark"></i>
                            <span class="nav-label">Organizadores</span><i class="fa fa-angle-left arrow"></i>
                        </a>
                        <ul class="collapse">
                            <li class="nav-item">
                                <a href="{{ route('Rut.tipoorg') }}" class="nav-link d-flex align-items-center ml-3">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="ml-2">Tipo de organizadores</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('Rut.orga') }}" class="nav-link d-flex align-items-center ml-3">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="ml-2">Organizadores</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('Rut.evenorg') }}" class="nav-link d-flex align-items-center ml-3">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="ml-2">Organizador de evento</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <i class="sidebar-item-icon fa fa-user"></i>
                            <span class="nav-label">Participante</span>
                            <i class="fa fa-angle-left arrow"></i>
                        </a>
                        <ul class="collapse">
                            <li class="nav-item">
                                <a href="{{ route('Rut.inscri') }}" class="nav-link d-flex align-items-center ml-3">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="ml-2">Inscripcion</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('Rut.asistenc') }}" class="nav-link d-flex align-items-center ml-3">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="ml-2">Asistencia</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-table"></i>
                            <span class="nav-label">Certificado</span><i class="fa fa-angle-left arrow"></i>
                        </a>
                        <ul class="collapse">
                            <li class="nav-item">
                                <a href="{{ route('Rut-certiss') }}" class="nav-link d-flex align-items-center ml-3">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="ml-2">Certificado</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('Rut.infor') }}" class="nav-link d-flex align-items-center ml-3">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="ml-2">Informe</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('Rut.tipinfo') }}" class="nav-link d-flex align-items-center ml-3">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="ml-2">Tipo de informe</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-bar-chart"></i>
                            <span class="nav-label">Facultades</span><i class="fa fa-angle-left arrow"></i>
                        </a>
                        <ul class="collapse">
                            <li class="nav-item">
                                <a href="{{ route('Rut.facu') }}" class="nav-link d-flex align-items-center ml-3">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="ml-2">Facultad</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('Rut.escu') }}" class="nav-link d-flex align-items-center ml-3">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="ml-2">Escuela</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <i class="sidebar-item-icon fa fa-user"></i>
                            <span class="nav-label">Acceso</span>
                            <i class="fa fa-angle-left arrow"></i>
                        </a>
                        <ul class="collapse">
                            <li class="nav-item">
                                <a href="{{ route('Rutususario') }}" class="nav-link d-flex align-items-center ml-3">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="ml-2">Usuarios</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('Rutususario.per') }}" class="nav-link d-flex align-items-center ml-3">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="ml-2">Datos Usuarios</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('Rut.tipusu') }}" class="nav-link d-flex align-items-center ml-3">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="ml-2">Tipo de Usuarios</span>
                                </a>
                            </li>

                        </ul>
                    <li>


                        <a href="{{ route('Vtareport') }}"><i class="sidebar-item-icon fa fa-calendar"></i>
                            <span class="nav-label">Reportes</span>
                        </a>
                    </li>
                    <li>


                        <a href="{{ route('auditorias') }}"><i class="sidebar-item-icon fa fa-file-contract"></i>
                            <span class="nav-label">Auditorias</span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-cog"></i>
                            <span class="nav-label">Configuraciones</span>
                            <i class="fa fa-angle-left arrow"></i>
                        </a>
                        <ul class="collapse">
                            <li class="nav-item">
                                <a href="#" onclick="window.open('http://localhost/even/Evento_Web/WEB/main.php', '_blank')">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="ml-2">Web</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('subirimagen.index') }}" class="nav-link d-flex align-items-center ml-3">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="ml-2">Subir Imagen</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <i class="sidebar-item-icon fa fa-user"></i>
                            <span class="nav-label">Tablas Independientes</span>
                            <i class="fa fa-angle-left arrow"></i>
                        </a>
                        <ul class="collapse">
                            <li class="nav-item">
                                <a href="" class="nav-link d-flex align-items-center ml-3">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="ml-2">---</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('tema.index') }}" class="nav-link d-flex align-items-center ml-3">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="ml-2">Temas</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('tipresolucionagrad.index') }}" class="nav-link d-flex align-items-center ml-3">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="ml-2">Tip Resol Agrad</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="mainnav__bottom-content border-top"></div>
            <ul id="mainnav" class="mainnav__menu nav flex-column">
                <li class="nav-item">
                    <a id="logout" href="{{ route('login') }}" class="nav-link collapsed">
                        <i class="nav-icon fas fa-user-alt"></i>
                        <span class="nav-label ml-3 text-while">Salir</span>
                    </a>
                </li>
            </ul>
    </div>
    </nav>
    <!-- END SIDEBAR-->
    <div class="content-wrapper">