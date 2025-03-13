<?php
session_start();
include "../config.php";

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Obtener las reservas del usuario logueado
$reservas = $conn->query("SELECT r.id, h.numero, r.fecha_entrada, r.fecha_salida, r.estado
                          FROM reservas r
                          JOIN habitaciones h ON r.habitacion_id = h.id
                          WHERE r.usuario_id = $usuario_id");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Reservas</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <h1>Mis Reservas</h1>

    <?php if ($reservas->num_rows > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Habitación</th>
                <th>Fecha de Entrada</th>
                <th>Fecha de Salida</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($reserva = $reservas->fetch_assoc()): ?>
            <tr>
                <td><?= $reserva['numero'] ?></td>
                <td><?= $reserva['fecha_entrada'] ?></td>
                <td><?= $reserva['fecha_salida'] ?></td>
                <td><?= $reserva['estado'] ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
    <p>No tienes reservas.</p>
    <?php endif; ?>

    <a href="reservar.php">Hacer nueva reserva</a>
</body>
</html>
