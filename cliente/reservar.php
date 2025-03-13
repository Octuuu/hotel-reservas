<?php
session_start();
include "../config.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$habitaciones = $conn->query("SELECT * FROM habitaciones WHERE estado = 'disponible'");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $habitacion_id = $_POST['habitacion_id'];
    $fecha_entrada = $_POST['fecha_entrada'];
    $fecha_salida = $_POST['fecha_salida'];

    $stmt = $conn->prepare("INSERT INTO reservas (usuario_id, habitacion_id, fecha_entrada, fecha_salida, estado) VALUES (?, ?, ?, ?, 'pendiente')");
    $stmt->bind_param("iiss", $usuario_id, $habitacion_id, $fecha_entrada, $fecha_salida);

    if ($stmt->execute()) {
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Hacer una Reserva</h1>

        <form method="post">
            <div class="mb-3">
                <label for="habitacion_id" class="form-label">Seleccionar Habitación:</label>
                <select name="habitacion_id" class="form-select" required>
                    <?php while ($habitacion = $habitaciones->fetch_assoc()): ?>
                    <option value="<?= $habitacion['id'] ?>"><?= $habitacion['numero'] ?> - <?= $habitacion['tipo'] ?> - $<?= $habitacion['precio'] ?> por noche</option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="fecha_entrada" class="form-label">Fecha de Entrada:</label>
                <input type="date" name="fecha_entrada" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="fecha_salida" class="form-label">Fecha de Salida:</label>
                <input type="date" name="fecha_salida" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Hacer Reserva</button>
        </form>

        <a href="mis_reservas.php" class="btn btn-link mt-3">Ver mis reservas</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
