<?php
include 'conexion.php'; // Conexión a la base de datos

$sql = "SELECT eventnom FROM evento WHERE fecini BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 10 DAY)";
$result = mysqli_query($conn, $sql);

echo '<ul>'; // Abrir la lista desordenada

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo '<li><a class="dropdown-item" href="#">' . $row["eventnom"] . '</a></li>';
    }
} else {
    echo '<li><a class="dropdown-item" href="#">No hay eventos disponibles</a></li>';
}

echo '</ul>'; // Cerrar la lista desordenada

mysqli_close($conn);
?>