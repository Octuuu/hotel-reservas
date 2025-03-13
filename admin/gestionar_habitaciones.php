<?php
session_start();
include "../config.php";

// Verificar si el usuario es admin
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

// Agregar una nueva habitación
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar'])) {
    $numero = trim($_POST['numero']);
    $tipo = trim($_POST['tipo']);
    $precio = $_POST['precio'];
    
    $stmt = $conn->prepare("INSERT INTO habitaciones (numero, tipo, precio, estado) VALUES (?, ?, ?, 'disponible')");
    $stmt->bind_param("ssd", $numero, $tipo, $precio);
    
    if ($stmt->execute()) {
        echo "Habitación agregada exitosamente.";
    } else {
        echo "Error al agregar la habitación.";
    }
    $stmt->close();
}

// Editar habitación
if (isset($_GET['editar'])) {
    $id = $_GET['editar'];
    $result = $conn->query("SELECT * FROM habitaciones WHERE id = $id");
    $habitacion = $result->fetch_assoc();
}

// Actualizar habitación
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editar'])) {
    $id = $_POST['id'];
    $numero = trim($_POST['numero']);
    $tipo = trim($_POST['tipo']);
    $precio = $_POST['precio'];
    
    $stmt = $conn->prepare("UPDATE habitaciones SET numero = ?, tipo = ?, precio = ? WHERE id = ?");
    $stmt->bind_param("ssdi", $numero, $tipo, $precio, $id);
    
    if ($stmt->execute()) {
        echo "Habitación actualizada exitosamente.";
    } else {
        echo "Error al actualizar la habitación.";
    }
    $stmt->close();
}

// Eliminar habitación
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $conn->query("DELETE FROM habitaciones WHERE id = $id");
    header("Location: gestionar_habitaciones.php");
    exit;
}

$habitaciones = $conn->query("SELECT * FROM habitaciones");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Habitaciones</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <h1>Gestionar Habitaciones</h1>
    
    <h2>Agregar Nueva Habitación</h2>
    <form method="post">
        <input type="text" name="numero" placeholder="Número de Habitación" required>
        <input type="text" name="tipo" placeholder="Tipo de Habitación" required>
        <input type="number" step="0.01" name="precio" placeholder="Precio por Noche" required>
        <button type="submit" name="agregar">Agregar Habitación</button>
    </form>

    <h2>Habitaciones Existentes</h2>
    <table>
        <thead>
            <tr>
                <th>Número</th>
                <th>Tipo</th>
                <th>Precio</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($habitacion = $habitaciones->fetch_assoc()): ?>
            <tr>
                <td><?= $habitacion['numero'] ?></td>
                <td><?= $habitacion['tipo'] ?></td>
                <td><?= $habitacion['precio'] ?></td>
                <td><?= $habitacion['estado'] ?></td>
                <td>
                    <a href="?editar=<?= $habitacion['id'] ?>">Editar</a> |
                    <a href="?eliminar=<?= $habitacion['id'] ?>" onclick="return confirm('¿Seguro que quieres eliminar esta habitación?')">Eliminar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <?php if (isset($_GET['editar'])): ?>
    <h2>Editar Habitación</h2>
    <form method="post">
        <input type="hidden" name="id" value="<?= $habitacion['id'] ?>">
        <input type="text" name="numero" value="<?= $habitacion['numero'] ?>" required>
        <input type="text" name="tipo" value="<?= $habitacion['tipo'] ?>" required>
        <input type="number" step="0.01" name="precio" value="<?= $habitacion['precio'] ?>" required>
        <button type="submit" name="editar">Actualizar Habitación</button>
    </form>
    <?php endif; ?>
</body>
</html>
