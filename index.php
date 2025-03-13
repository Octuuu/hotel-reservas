<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Reservas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Bienvenido al Sistema de Reservas del Hotel</h1>
        <nav class="navbar navbar-expand-lg navbar-light bg-light mt-4">
            <div class="container-fluid">
                <?php if(isset($_SESSION['usuario'])): ?>
                    <a href="dashboard.php" class="btn btn-primary">Dashboard</a>
                    <a href="logout.php" class="btn btn-danger ms-2">Cerrar sesión</a>
                <?php else: ?>
                    <a href="register.php" class="btn btn-success">Registrarse</a>
                    <a href="login.php" class="btn btn-info ms-2">Iniciar sesión</a>
                <?php endif; ?>
            </div>
        </nav>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
