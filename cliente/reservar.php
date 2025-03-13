<?php
session_start();
include "../config.php";

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit;
}

// Obtener habitaciones disponibles
$habitaciones = $conn->query("SELECT * FROM habitaciones WHERE estado = 'disponible'");

// Procesar la reserva
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $habitacion_id = $_POST['habitacion_id'];
    $fecha_entrada = $_POST['fecha_entrada'];
    $fecha_salida = $_POST['fecha_salida'];
    $usuario_id = $_SESSION['usuario_id'];

    // Insertar la reserva en la base de datos
    $stmt = $conn->prepare("INSERT INTO reservas (usuario_id, habitacion_id, fecha_entrada, fecha_salida, estado) VALUES (?, ?, ?, ?, 'pendiente')");
    $stmt->bind_param("iiss", $usuario_id, $habitacion_id, $fecha_entrada, $fecha_salida);
    
    if ($stmt->execute()) {
        // Actualizar estado de la habitación a no disponible
        $conn->query("UPDATE habitaciones SET estado = 'no disponible' WHERE id = $habitacion_id");
        echo "Reserva realizada con éxito.";
    } else {
        echo "Error al realizar la reserva.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservar Habitación</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <h1>Hacer una Reserva</h1>

    <form method="post">
        <label for="habitacion_id">Seleccionar Habitación:</label>
        <select name="habitacion_id" required>
            <?php while ($habitacion = $habitaciones->fetch_assoc()): ?>
            <option value="<?= $habitacion['id'] ?>"><?= $habitacion['numero'] ?> - <?= $habitacion['tipo'] ?> - $<?= $habitacion['precio'] ?> por noche</option>
            <?php endwhile; ?>
        </select>

        <label for="fecha_entrada">Fecha de Entrada:</label>
        <input type="date" name="fecha_entrada" required>

        <label for="fecha_salida">Fecha de Salida:</label>
        <input type="date" name="fecha_salida" required>

        <button type="submit">Hacer Reserva</button>
    </form>

    <a href="mis_reservas.php">Ver mis reservas</a>
</body>
</html>
