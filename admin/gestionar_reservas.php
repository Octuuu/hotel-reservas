<?php
session_start();
include "../config.php";

// Verificar si el usuario es admin
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

// Cambiar estado de reserva
if (isset($_GET['estado']) && isset($_GET['id'])) {
    $estado = $_GET['estado'];
    $id = $_GET['id'];
    
    $stmt = $conn->prepare("UPDATE reservas SET estado = ? WHERE id = ?");
    $stmt->bind_param("si", $estado, $id);
    
    if ($stmt->execute()) {
        echo "Estado de la reserva actualizado.";
    } else {
        echo "Error al actualizar el estado.";
    }
    $stmt->close();
}

$reservas = $conn->query("SELECT r.id, u.nombre, h.numero, r.fecha_entrada, r.fecha_salida, r.estado 
                         FROM reservas r
                         JOIN usuarios u ON r.usuario_id = u.id
                         JOIN habitaciones h ON r.habitacion_id = h.id");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Reservas</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <h1>Gestionar Reservas</h1>

    <table>
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Habitación</th>
                <th>Fecha Entrada</th>
                <th>Fecha Salida</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($reserva = $reservas->fetch_assoc()): ?>
            <tr>
                <td><?= $reserva['nombre'] ?></td>
                <td><?= $reserva['numero'] ?></td>
                <td><?= $reserva['fecha_entrada'] ?></td>
                <td><?= $reserva['fecha_salida'] ?></td>
                <td><?= $reserva['estado'] ?></td>
                <td>
                    <?php if ($reserva['estado'] == 'pendiente'): ?>
                    <a href="?estado=confirmada&id=<?= $reserva['id'] ?>">Confirmar</a> |
                    <a href="?estado=cancelada&id=<?= $reserva['id'] ?>">Cancelar</a>
                    <?php else: ?>
                    <span>No disponible</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
