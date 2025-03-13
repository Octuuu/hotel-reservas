<?php
$host = "localhost";
$user = "root";  // Cambia esto si tienes otro usuario en phpMyAdmin
$pass = "";      // Si tienes contraseña, agrégala aquí
$db = "hotel_reservas";

// Crear conexión
$conn = new mysqli($host, $user, $pass, $db);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
