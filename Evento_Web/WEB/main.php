<?php include 'conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Web</title>

    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        #bgVideo {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            object-fit: cover;
            z-index: -1;
        }


        .small-card-container {
            max-width: 90%;
            /* Ajusta el tamaño general del card */
            padding: 10px;
            /* Opcional: Espaciado interno */
            margin: 10px auto;
            /* Acomoda márgenes entre cards */
            font-size: 0.9rem;
            /* Reduce ligeramente el texto dentro de las tarjetas */
        }

        .card-body {
            padding: 15px;
            /* Ajusta el espacio interno en el cuerpo de la tarjeta */
        }

        .btn {
            min-width: 100px;
            /* Evita botones demasiado pequeños */
            font-size: 16px;
            /* Tamaño inicial del texto */
            padding: 10px 10px;
            text-align: center;
            white-space: nowrap;
        }

        @media (max-width: 768px) {
            .btn {
                font-size: 14px;
                padding: 8px 16px;
                /* Ajustar el espaciado */
            }
        }

        @media (max-width: 480px) {
            .btn {
                font-size: 12px;
                padding: 6px 12px;
            }
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            /* Permite que las tarjetas se envuelvan */
            justify-content: space-around;
            /* Espacio entre las tarjetas */
            gap: 20px;
            /* Espacio entre las tarjetas */
        }

       

    

        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 2%;
        }

        .btn {
            align-self: flex-start;
            /* Para mantener el botón alineado a la izquierda */
        }

        /* Medidas de ajuste para pantallas más pequeñas */



        .img {
            max-width: 100%;
            /* La imagen nunca será más ancha que su contenedor */
            height: auto;
            /* Mantiene la proporción de la imagen */
            display: block;
            /* Elimina espacios debajo de las imágenes en algunos navegadores */
            margin: 0 auto;
            /* Centra la imagen horizontalmente si es necesario */
        }

        /* Ajustes adicionales para tamaños específicos */
        @media (max-width: 768px) {
            .img {
                width: 80%;
                /* Reduce el ancho al 80% del contenedor en tablets */
            }
        }

        @media (max-width: 480px) {
            .img {
                width: 60%;
                /* Reduce aún más el ancho en pantallas pequeñas */
            }
        }


        /* REDES SOCIALES */
        /* Contenedor de íconos alineado a la derecha */
        .social-icons {
            display: flex;
            /* Los íconos se alinean en fila por defecto */
            flex-wrap: wrap;
            /* Permite que los íconos se muevan a la siguiente línea si no hay suficiente espacio */
            justify-content: flex-end;
            /* Alinea los íconos a la derecha */
            gap: 15px;
            /* Espaciado entre los íconos */
            list-style: none;
            /* Elimina los estilos de lista */
            margin: 0;
            padding: 0;
        }

        /* Iconos dentro de un círculo con borde de color */
        .social-icons .nav-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #f0f0f0;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }


        /* Tamaño de los iconos */
        /* Iconos individuales */
        .social-icons .nav-link i {
            font-size: 1.25rem;
            /* color: #333; */
        }

        .social-icons .nav-link:hover {
            background-color: #91868f;
            /color fondo/
            border-color: #41e306;
            /*color borde */
        }

        /* Responsividad para pantallas más pequeñas */

        @media (max-width: 790px) {
            .social-icons {
                flex-direction: row;
                /* Asegura que estén en una fila horizontal */
                flex-wrap: wrap;
                /* Permite que los íconos pasen a la siguiente fila si no hay espacio suficiente */
                justify-content: center;
                /* Centra los íconos en pantallas pequeñas */
                gap: 15px;
                /* Aumenta el espacio entre íconos */
            }

            .social-icons .nav-link {
                width: 40px;
                /* Aumenta el tamaño del botón */
                height: 40px;
                /* Aumenta el tamaño del botón */
            }

            .social-icons .nav-link i {
                font-size: 1.2rem;
                /* Aumenta el tamaño de los íconos */
            }
        }

        /* Para dispositivos aún más pequeños */
        @media (max-width: 480px) {
            .social-icons {
                flex-direction: row;
                /* Asegura que estén en una fila horizontal */
                justify-content: center;
                /* Mantiene los íconos centrados */
            }

            .social-icons .nav-link {
                width: 35px;
                /* Aumenta el tamaño del botón */
                height: 35px;
                /* Aumenta el tamaño del botón */
            }

            .social-icons .nav-link i {
                font-size: 1.1rem;
                /* Ajusta el tamaño de los íconos */
            }
        }

        /* Colores específicos para cada icono */
        .nav-link .fa-facebook-f {
            color: #1877F2;
            border-color: #1877F2;
        }

        .nav-link .fa-whatsapp {
            color: #25D366;
            border-color: #25D366;
        }

        .nav-link .fa-youtube {
            color: #FF0000;
            border-color: #FF0000;
        }

        .nav-link .fa-instagram {
            color: #C13584;
            border-color: #C13584;
        }

        .nav-link .fa-twitter {
            color: #1DA1F2;
            border-color: #1DA1F2;
        }

        .nav-link .fa-envelope {
            color: #D44638;
            border-color: #D44638;
        }

        .nav-link .fs-globe {
            color: #000000;
            border-color: #000000;
        }

        /* Efecto de hover */
        .nav-link:hover {
            background-color: white;
            transform: scale(1.1);
        }

        .carousel-item {
            height: 100%;
        }

        .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        #carouselExampleControls {
            width: 100%;
            /* Ocupa todo el ancho disponible */
            max-width: 1270px;
            /* Ancho máximo */
            margin: auto;
            /* Centra horizontalmente */

            /* Transición suave para cambios de tamaño */
            transition: max-width 0.3s ease-in-out;
        }

        /* Puntos de corte responsivos */
        @media (max-width: 1300px) {
            #carouselExampleControls {
                max-width: 95%;
                /* Reduce al 95% en pantallas más pequeñas */
            }
        }

        @media (max-width: 992px) {
            #carouselExampleControls {
                max-width: 90%;
                /* Reduce al 90% en tablets */
            }
        }

        @media (max-width: 768px) {
            #carouselExampleControls {
                max-width: 100%;
                /* Ocupa todo el ancho en móviles */
                padding: 0 15px;
                /* Pequeño padding en los bordes */
            }
        }

      

        .small-card-container {
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.card-title {
    font-size: 1.25rem;
    font-weight: bold;
    margin-bottom: 15px;
}

.card-text {
    font-size: 1rem;
    color: #555;
    margin-bottom: 15px;
}

.evento {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 10px;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    margin-bottom: 15px;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #004085;
}
    </style>
</head>

<body>

    <video autoplay muted loop id="bgVideo">
        <source src="images/videouna.mp4" type="video/mp4">
    </video>

    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <img class="img" src="images/logo.png" alt="Imagen 2">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Menú de eventos y número de contacto (izquierda) -->
                <ul class="navbar-nav mr-auto">
                    <?php 
                // Consulta para obtener los nombres de los eventos
                $sql = "SELECT eventnom FROM evento WHERE fecini BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 10 DAY)";
                $result = mysqli_query($conn, $sql);
                ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Lista de los Eventos
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                $eventnom = $row["eventnom"];
                                echo '<a class="dropdown-item" href="#">' . htmlspecialchars($eventnom) . '</a>';
                            }
                        } else {
                            echo '<a class="dropdown-item" href="#">No hay eventos</a>';
                        }
                        ?>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">(043) 640-020</a>
                    </li>
                </ul>
                <!-- Íconos de redes sociales (derecha) -->
                <ul class="navbar-nav ml-auto social-icons">
                    <li class="nav-item">
                        <a href="https://www.facebook.com/unasam.edu.pe" class="nav-link" target="_blank">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="https://wa.me/tuNumero" class="nav-link" target="_blank">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="https://www.youtube.com/channel/UCHUxOdDI4zrMgghSpTDxttw" class="nav-link"
                            target="_blank">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="https://instagram.com/tupagina" class="nav-link" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="https://twitter.com/tupagina" class="nav-link" target="_blank">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="mailto:tucorreo@gmail.com" class="nav-link" target="_blank">
                            <i class="fas fa-envelope"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="https://www.unasam.edu.pe" class="nav-link" target="_blank">
                            <i class="fas fa-globe"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <main>



        <section class="slider">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <?php
                // Ruta base para las imágenes en la carpeta de Laravel
                $base_url = 'http://localhost/even/laravel11/public/';
                    $sql = "SELECT ruta_imagen FROM imagenes";
                    $result = mysqli_query($conn, $sql);
                    $active = true;

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $ruta_imagen = $base_url . htmlspecialchars($row['ruta_imagen']);
                            // echo '<p>Ruta generada: ' . $ruta_imagen . '</p>'; // Para comprobar la ruta
                            echo '<div class="carousel-item ' . ($active ? 'active' : '') . '">';
                            echo '<img src="' . $ruta_imagen . '" class="d-block w-100" alt="Imagen">';
                            echo '</div>';
                            $active = false;
                        }
                    } else {
                        echo '<div class="carousel-item active">';
                        echo '<img src="' . $base_url . 'images/default.png" class="d-block w-100" alt="Imagen por defecto">';
                        echo '</div>';
                    }
            ?>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Anterior</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Siguiente</span>
                </a>
            </div>
        </section>



        <div>
            <section class="events">
                <div class="row">
                    <?php 
                    // Modificamos la consulta para que también compare la hora de inicio del evento
                    $sql = "SELECT idevento, eventnom, descripción, fecini, horain, lugar, ponente
                            FROM evento 
                            WHERE (fecini > CURDATE() OR (fecini = CURDATE() AND horain > CURTIME()))
                            AND fecini BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 10 DAY)";
                    
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $idevento = $row["idevento"];
                            $eventnom = $row["eventnom"];
                            $descripcion = $row["descripción"];
                            $fecini = $row["fecini"];
                            $horain = $row["horain"];
                            $lugar = $row["lugar"];
                            $ponente = $row["ponente"];
                            ?>
                    <div class="col-md-4">
                        <div class="card small-card-container">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <?php echo $eventnom; ?>
                                </h5>
                                <p class="card-text">
                                    <?php echo $descripcion; ?>
                                </p>
                               
                                <button class="btn btn-primary" data-toggle="modal" data-target="#registerModal"
                                    data-idevento="<?php echo $idevento; ?>">Inscripción</button>&nbsp;&nbsp;&nbsp;
                                <div class="evento">
                                    <a>Día del evento:
                                        <?php echo $fecini; ?>
                                    </a>
                                </div>
                                <div class="evento">
                                    <a>Hora de inicio:
                                        <?php echo $horain; ?>
                                    </a>
                                </div>
                                <div>
                                    <a>Lugar:
                                        <?php echo $lugar; ?>
                                    </a>
                                </div>
                                <div >
                                    <a>Ponente:
                                        <?php echo $ponente; ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                        }
                    } else {
                        echo "No hay eventos disponibles";
                    }
                    ?>
                </div>
            </section>
        </div>

        <!-- Tu modal -->
        <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registerModalLabel">COMPLETE LOS SIGUIENTES CAMPOS</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Aquí se cambia la acción del formulario para enviar a tu archivo PHP -->
                        <form id="registroForm" method="post" action="procesar_registro.php">

                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Campos del formulario -->
                                    <div class="form-group">
                                        <label for="dni"><strong>DNI</strong></label>
                                        <input type="text" class="form-control" id="dni" name="dni" maxlength="8"
                                            onkeypress="return soloNumeros(event)" placeholder="Ingrese su DNI" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="apellidos"><strong>Apellidos</strong></label>
                                        <input type="text" class="form-control" id="apellidos" name="apellidos"
                                            onkeypress="return soloLetras(event)" placeholder="Ingrese sus apellidos" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nombres"><strong>Nombres</strong></label>
                                        <input type="text" class="form-control" id="nombres" name="nombres"
                                            onkeypress="return soloLetras(event)" placeholder="Ingrese sus nombres" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="telefono"><strong>N° de Celular</strong></label>
                                        <input type="text" class="form-control" id="telefono" name="telefono"
                                            maxlength="9" onkeypress="return validarTelefono(event)"
                                            placeholder="Ingrese su número de celular" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="correo"><strong>Correo</strong></label>
                                        <input type="email" class="form-control" id="correo" name="correo"
                                            placeholder="Ingrese su correo eléctronico" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="direccion"><strong>Dirección</strong></label>
                                        <input type="text" class="form-control" id="direccion" name="direccion"
                                            placeholder="Ingrese su dirección" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="genero"><strong>Género</strong></label>
                                        <select class="form-control" id="genero" name="genero" required>
                                          
                                            <?php
                                    $sql = "SELECT idgenero, nomgen FROM generos";
                                    $result = mysqli_query($conn, $sql);

                                    if (mysqli_num_rows($result) > 0) {
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo '<option value="' . $row["idgenero"] . '">' . $row["nomgen"] . '</option>';
                                        }
                                    } else {
                                        echo '<option value="">No hay géneros disponibles</option>';
                                    }
                                    ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="escuela"><strong>Escuela</strong></label>
                                        <select class="form-control" id="escuela" name="escuela" required>
                                    
                                            <?php
                                    $sql = "SELECT idescuela, nomescu FROM escuela";
                                    $result = mysqli_query($conn, $sql);

                                    if (mysqli_num_rows($result) > 0) {
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo '<option value="' . $row["idescuela"] . '">' . $row["nomescu"] . '</option>';
                                        }
                                    } else {
                                        echo '<option value="">No hay escuelas disponibles</option>';
                                    }
                                    ?>
                                        </select>
                                    </div>
                                    <!-- Campo oculto para capturar el idevento -->
                                    <input type="hidden" name="idevento" id="idevento" class="form-control"
                                        value="<?php echo $idevento; ?>">
                                    <!-- <input type="text" name="idevento_display" id="idevento_display" value="<?php echo $idevento; ?>" readonly> -->

                                </div>
                            </div>
                            <button type="submit" class="btn btn-success"><strong>Grabar datos</strong></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <script>
        //Restrinciones para el modal
        // Función para permitir solo números (validación para DNI)
        function soloNumeros(e) {
            var key = e.charCode || e.keyCode || 0;
            if (key < 48 || key > 57) { // Permitir solo dígitos del 0 al 9
                return false;
            }
            return true;
        }

        // Función para permitir solo letras (validación para Nombres y Apellidos)
        function soloLetras(e) {
            var key = e.charCode || e.keyCode || 0;
            if ((key >= 65 && key <= 90) || (key >= 97 && key <= 122) || key == 32) { // Letras mayúsculas, minúsculas y espacio
                return true;
            }
            return false;
        }

        // Validación para teléfono (debe empezar con 9 y solo permite 9 dígitos)
        function validarTelefono(e) {
            var key = e.charCode || e.keyCode || 0;
            var telefono = document.getElementById('telefono').value;

            if (telefono.length === 0 && key != 57) { // Si el campo está vacío, solo puede empezar con 9 (ASCII de '9' = 57)
                return false;
            }

            if (telefono.length >= 9) { // No permitir más de 9 dígitos
                return false;
            }

            return soloNumeros(e); // Validar que el resto de los dígitos sean numéricos
        } 
    </script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="ga.js"></script>
</body>

</html>