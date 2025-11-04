<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>EVENTOS</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">
  <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="{{ asset('css/_all-skins.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  
  
  
  <style>
   body {
    background-color: #f1f1f1;
}

.menu-item {
    background-color: #25466B;
    color: white;
    border-radius: 5px;
}

.menu-item:hover {
    background-color: #3a2d7d;
}

.menu-item .card-body {
    padding: 20px;
    font-size: 14px;
    font-weight: bold;
}

.menu-item i {
    color: white; /* Asegura que los iconos sean de color blanco */
}
    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<header class="main-header">
      <a class="logo" style="background-color:#25466B; height: 70px;">
        <span class="logo-lg" style="color: #FFFFFF;"><b>EVENTOS</b></span>
      </a>
      <nav class="navbar navbar-static-top" role="navigation" style="background-color: #0056b3;">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button" style="color: #ffffff;">
          <span class="sr-only">Navegación</span>
        </a>
        <ul >
        <img src="{{ asset('img/uuss.png') }}" alt="User Image" style="width: 270px;">
    
        </ul>
      <div class="navbar-custom-menu">
     
    <ul class="nav navbar-nav">
        <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- El nombre y los tres palos del ícono se centran en el contenedor -->
                <span class="hidden-xs" style="color: #FFFFFF;">Cueva Sanchez Yabeth Yesenia</span>
            </a>
            <ul class="dropdown-menu">
                <li class="user-footer">
                    <div class="pull-right">
                        <a href="#" class="btn btn-default btn-flat">Cerrar</a>
                    </div>
                </li>
            </ul>
        </li>
    </ul>
</div>
      </nav>
    </header>

    <aside class="main-sidebar" style="background-color: #0056b3;">
      <section class="sidebar">
        <ul class="sidebar-menu">
          <li class="header"></li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-calendar" style="color: #FFFFFF;"></i>
              <span style="color: #FFFFFF;">Eventos</span>
              <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <li><a href="#" onclick="loadContent('{{ route('Rut.evento') }}')" style="color: #FFFFFF;"><i class="fa fa-circle-o"></i> Evento</a></li>
              <li><a href="#" onclick="loadContent('{{ route('tipo.evento') }}')" style="color: #FFFFFF;"><i class="fa fa-circle-o"></i> Tipo de evento</a></li>
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fas fa-users" style="color: #FFFFFF;"></i>
              <span style="color: #FFFFFF;">Participante</span>
              <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu" >
              <li><a href="#" onclick="loadContent('{{ route('Rut.inscri') }}')" style="color: #FFFFFF;"><i class="fa fa-circle-o"></i> Inscripción</a></li>
              <li><a href="#" onclick="loadContent('{{ route('Rut.asistenc') }}')" style="color: #FFFFFF;"><i class="fa fa-circle-o"></i>Asistencia</a></li>
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fas fa-certificate" style="color: #FFFFFF;"></i>
              <span style="color: #FFFFFF;">Certificado</span>
              <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <li><a href="#" onclick="loadContent('{{ route('Rut-certi') }}')" style="color: #FFFFFF;"><i class="fa fa-circle-o"></i> Certificado</a></li>
              <li><a href="#" onclick="loadContent('{{ route('Rut.infor') }}')" style="color: #FFFFFF;"><i class="fa fa-circle-o"></i> Informe</a></li>
              <!-- <li><a href="ventas/cliente" style="color: #FFFFFF;"><i class="fa fa-circle-o"></i> Clientes</a></li> -->
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fas fa-building" style="color: #FFFFFF;"></i> <span style="color: #FFFFFF;">Facultades</span>
              <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <li><a href="#" onclick="loadContent('{{ route('Rut.facu') }}')" style="color: #FFFFFF;"><i class="fa fa-circle-o"></i>Facultad</a></li>
              <li><a href="#" onclick="loadContent('{{ route('Rut.escu') }}')" style="color: #FFFFFF;"><i class="fa fa-circle-o"></i> Escuela</a></li>
            </ul>
          </li>
  
          <li class="treeview">
            <a href="#">
              <i class="fa fas fa-key" style="color: #FFFFFF;"></i> <span style="color: #FFFFFF;">Acceso</span>
              <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <li><a href="#" onclick="loadContent('{{ route('Rutususario') }}')" style="color: #FFFFFF;"><i class="fa fa-circle-o"></i> Usuarios</a></li>
              <li><a href="#" onclick="loadContent('{{ route('Rutususario.per') }}')" style="color: #FFFFFF;"><i class="fa fa-circle-o"></i> Datos Usuarios</a></li>
            </ul>
          </li>
        </ul>
      </section>
    </aside>
  
    <div class="content-wrapper" >
      <section class="content" id="myContent">
      <div class="container mt-5">
    <div class="row">
        <!-- Columna 1 -->
        <div class="col-md-2">
            <div class="card mb-3 menu-item">
                <div class="card-body text-center">
                    <a href="#" onclick="loadContent('{{ route('Rut.evento') }}')">
                        <i class="fas fa-database fa-2x mb-2"></i>
                    </a>
                    <div>Evento</div>
                </div>
            </div>
            <div class="card mb-3 menu-item">
                <div class="card-body text-center">
                    <a href="#" onclick="loadContent('{{ route('tipo.evento') }}')">
                        <i class="fas fa-list-alt fa-2x mb-2"></i>
                    </a>
                    <div>Tipo de evento</div>
                </div>
            </div>
        </div>

        <!-- Columna 2 -->
        <div class="col-md-2">
            <div class="card mb-3 menu-item">
                <div class="card-body text-center">
                    <a href="#" onclick="loadContent('{{ route('Rut.inscri') }}')">
                        <i class="fas fa-wallet fa-2x mb-2"></i>
                    </a>
                    <div>Inscripción</div>
                </div>
            </div>
            <div class="card mb-3 menu-item">
                <div class="card-body text-center">
                    <a href="#" onclick="loadContent('{{ route('Rut.asistenc') }}')">
                        <i class="fas fa-receipt fa-2x mb-2"></i>
                    </a>
                    <div>Asistencia</div>
                </div>
            </div>
        </div>

        <!-- Columna 3 -->
        <div class="col-md-2">
            <div class="card mb-3 menu-item">
                <div class="card-body text-center">
                    <a href="#" onclick="loadContent('{{ route('Rut-certi') }}')">
                        <i class="fas fa-certificate fa-2x mb-2"></i>
                    </a>
                    <div>Certificado</div>
                </div>
            </div>
            <div class="card mb-3 menu-item">
                <div class="card-body text-center">
                    <a href="#" onclick="loadContent('{{ route('Rut.infor') }}')">
                        <i class="fas fa-file-alt fa-2x mb-2"></i>
                    </a>
                    <div>Informes</div>
                </div>
            </div>
        </div>

        <!-- Columna 4 -->
        <div class="col-md-2">
            <div class="card mb-3 menu-item">
                <div class="card-body text-center">
                    <a href="#" onclick="loadContent('{{ route('Rut.escu') }}')">
                        <i class="fas fa-school fa-2x mb-2"></i>
                    </a>
                    <div>Escuela</div>
                </div>
            </div>
            <div class="card mb-3 menu-item">
                <div class="card-body text-center">
                    <a href="#" onclick="loadContent('{{ route('Rut.facu') }}')">
                        <i class="fas fa-university fa-2x mb-2"></i>
                    </a>
                    <div>Facultad</div>
                </div>
            </div>
        </div>

        <!-- Columna 5 -->
        <div class="col-md-2">
            <div class="card mb-3 menu-item">
                <div class="card-body text-center">
                    <a href="#" onclick="loadContent('{{ route('Rutususario') }}')">
                        <i class="fas fa-user fa-2x mb-2"></i>
                    </a>
                    <div>Usuario</div>
                </div>
            </div>
            <div class="card mb-3 menu-item">
                <div class="card-body text-center">
                    <a href="#" onclick="loadContent('{{ route('Rutususario.per') }}')">
                        <i class="fas fa-user-check fa-2x mb-2"></i>
                    </a>
                    <div>Usuario con datos</div>
                </div>
            </div>
        </div>

        <!-- Columna 6 -->
        <div class="col-md-2">
            <div class="card mb-3 menu-item">
                <div class="card-body text-center">
                    <a href="#" onclick="loadContent('{{ route('Rut.evento') }}')">
                        <i class="fas fa-clipboard-list fa-2x mb-2"></i>
                    </a>
                    <div>Configuración</div>
                </div>
            </div>
            <div class="card mb-3 menu-item">
                <div class="card-body text-center">
                    <a href="#" onclick="window.open('http://localhost/even/Evento_Web/main.php', '_blank')">
                        <i class="fas fa-globe fa-2x mb-2"></i>
                    </a>
                    <div>Web</div>
                </div>
            </div>
            <div class="card mb-3 menu-item">
                <div class="card-body text-center">
                    <a href="#" onclick="loadContent('{{ route('Rut.evento') }}')">
                        <i class="fas fa-chart-pie fa-2x mb-2"></i>
                    </a>
                    <div>Reporte</div>
                </div>
            </div>
        </div>
    </div>
</div>

      </section>
    </div>
     
  </div>

  



  <script src="{{ asset('js/app.min.js')}}"></script>
  <script src="{{ asset('js/usuario.js')}}"></script>
  <script>
function loadContent(url) {
    $.ajax({
        url: url,
        method: 'GET',
        success: function(data) {
            $('#myContent').html(data); // Actualiza solo el contenido del div #myContent
        },
        error: function(xhr, status, error) {
            $('#myContent').html('<p>Error al cargar el contenido.</p>'); // Muestra un mensaje en caso de error
            console.error('Error al cargar el contenido:', error); // Registra el error en la consola para depuración
        }
    });
}



   
  </script>
</body> 
</div>  
</html>





