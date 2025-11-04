<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";       
$password = "";    
$dbname = "eventos";   

// Crear la conexión
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificar la conexión
if (!$conn) {
    die("Error en la conexión: " . mysqli_connect_error());
}
?>
