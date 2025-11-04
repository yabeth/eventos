<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $dni = $_POST['dni'];
    $apellidos = $_POST['apellidos'];
    $nombres = $_POST['nombres'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $direccion = $_POST['direccion'];
    $genero = $_POST['genero'];
    $escuela = $_POST['escuela'];
    $idevento = $_POST['idevento'];
    // $fech = date('Y-m-d'); // Fecha actual
    $fech = date("Y-m-d H:i:s"); // Captura la fecha y hora actual en el formato correcto
    $idtipasis = 2; // Cambia esto según el tipo de asistencia
    $idestado = 1; // Cambia esto según el estado que necesites

    // Obtener el idpersona de la tabla personas utilizando el DNI
    $sql_persona = "SELECT idpersona FROM personas WHERE dni = ?";
    $stmt = $conn->prepare($sql_persona);
    $stmt->bind_param("s", $dni);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // La persona ya existe en la base de datos
        $row = $result->fetch_assoc();
        $idpersona = $row['idpersona'];
    } else {
        // Insertar en la tabla personas si no existe
        $sql_insert_persona = "INSERT INTO personas (dni, nombre, apell, tele, email, direc, idgenero) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_insert_persona);
        $stmt->bind_param("ssssssi", $dni, $nombres, $apellidos, $telefono, $correo, $direccion, $genero);

        if ($stmt->execute()) {
            $idpersona = $stmt->insert_id; // Obtener el nuevo idpersona insertado
        } else {
            echo json_encode(["status" => "error", "message" => "Error al registrar persona: " . $conn->error]);
            exit();
        }
    }

    // Verificar si la persona ya está inscrita en el mismo evento
    $sql_verificar = "SELECT COUNT(*) as count FROM inscripcion WHERE idpersona = ? AND idevento = ?";
    $stmt = $conn->prepare($sql_verificar);
    $stmt->bind_param("ii", $idpersona, $idevento);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        echo json_encode(["status" => "error", "message" => "No puede registrarse dos veces en el mismo evento"]);
    } else {
        // Insertar en la tabla inscripcion
        $sql_inscripcion = "INSERT INTO inscripcion (idescuela, idpersona, idevento) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql_inscripcion);
        $stmt->bind_param("iii", $escuela, $idpersona, $idevento);

        if ($stmt->execute()) {
            $idincrip = $stmt->insert_id; // Obtener el ID de inscripción

            // Insertar en la tabla asistencia
            $sql_asistencia = "INSERT INTO asistencia (fech, idtipasis, idincrip, idestado) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql_asistencia);
            $stmt->bind_param("siii", $fech, $idtipasis, $idincrip, $idestado);

            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Registro exitoso"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error al registrar asistencia: " . $conn->error]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Error al registrar inscripción: " . $conn->error]);
        }
    }

    $stmt->close();
    $conn->close();
}
?>
