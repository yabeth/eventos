<?php
include 'conexion.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dni = $_POST['dni'];

    // Consulta para obtener los datos de la persona
    $sql = "SELECT 
    p.apell,
    p.nombre,
    p.tele,
    p.email,
    p.direc,
    g.idgenero AS genero,
    e.idescuela AS escuela,
    i.idevento
FROM 
    personas p
JOIN 
    inscripcion i ON p.idpersona = i.idpersona
JOIN 
    generos g ON p.idgenero = g.idgenero
JOIN 
    escuela e ON i.idescuela = e.idescuela
WHERE 
    p.dni = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $dni);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $response = array(
            'success' => true,
            'data' => array(
                'apellidos' => $data['apell'],
                'nombres' => $data['nombre'],
                'telefono' => $data['tele'],
                'correo' => $data['email'],
                'direccion' => $data['direc'],
                'genero' => $data['genero'],
                'escuela' => $data['escuela']
            )
        );
    } else {
        $response = array(
            'success' => false,
            'message' => 'Persona no encontrada.'
        );
    }

    echo json_encode($response);
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(array('success' => false, 'message' => 'Método no permitido.'));
}
?>