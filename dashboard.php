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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Bienvenido al Panel de Control</h1>
        <div class="text-center mt-4">
            <?php if ($rol == 'admin'): ?>
                <a href="admin/gestionar_habitaciones.php" class="btn btn-primary">Gestionar Habitaciones</a>
                <a href="admin/gestionar_reservas.php" class="btn btn-warning ms-2">Gestionar Reservas</a>
            <?php else: ?>
                <a href="cliente/reservar.php" class="btn btn-success">Hacer una Reserva</a>
                <a href="cliente/mis_reservas.php" class="btn btn-info ms-2">Mis Reservas</a>
            <?php endif; ?>
        </div>
        <div class="text-center mt-3">
            <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>