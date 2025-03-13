<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$rol = $_SESSION['rol'] ?? 'cliente';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h1>Bienvenido al Panel de Control</h1>
    
    <?php if ($rol == 'admin'): ?>
        <a href="admin/gestionar_habitaciones.php">Gestionar Habitaciones</a>
        <a href="admin/gestionar_reservas.php">Gestionar Reservas</a>
    <?php else: ?>
        <a href="cliente/reservar.php">Hacer una Reserva</a>
        <a href="cliente/mis_reservas.php">Mis Reservas</a>
    <?php endif; ?>
    
    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>
