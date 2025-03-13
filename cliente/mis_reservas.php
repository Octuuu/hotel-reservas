<?php
session_start();
include "../config.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Modificar la consulta para obtener 'numero' de la tabla 'habitaciones'
$reservas = $conn->query("SELECT r.id, h.id AS habitacion_id, h.numero, r.fecha_entrada, r.fecha_salida, r.estado 
                          FROM reservas r
                          JOIN habitaciones h ON r.habitacion_id = h.id
                          WHERE r.usuario_id = $usuario_id");

if ($reservas === false) {
    // Si la consulta falla, muestra el error
    echo "Error en la consulta: " . $conn->error;
    exit;
}

// Si la consulta fue exitosa, continuamos con el resto del código
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Reservas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Mis Reservas</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Habitación</th>
                    <th>Fecha Entrada</th>
                    <th>Fecha Salida</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                while ($reserva = $reservas->fetch_assoc()):
                ?>
                <tr>
                    <td><?= $reserva['numero'] ?></td>
                    <td><?= $reserva['fecha_entrada'] ?></td>
                    <td><?= $reserva['fecha_salida'] ?></td>
                    <td><?= $reserva['estado'] ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
