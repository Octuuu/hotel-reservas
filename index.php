<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Reservas</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <h1>Bienvenido al Sistema de Reservas del Hotel</h1>
    <nav>
        <?php if(isset($_SESSION['usuario'])): ?>
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php">Cerrar sesión</a>
        <?php else: ?>
            <a href="register.php">Registrarse</a>
            <a href="login.php">Iniciar sesión</a>
        <?php endif; ?>
    </nav>
</body>
</html>
