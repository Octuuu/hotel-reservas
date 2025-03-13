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
    
    if ($result && $result->num_rows > 0) {
        $habitacion = $result->fetch_assoc();
    } else {
        echo "Habitación no encontrada.";
        exit;
    }
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Gestionar Habitaciones</h1>
        
        <h2>Agregar Nueva Habitación</h2>
        <form method="post">
            <div class="mb-3">
                <input type="text" name="numero" class="form-control" placeholder="Número de Habitación" required>
            </div>
            <div class="mb-3">
                <input type="text" name="tipo" class="form-control" placeholder="Tipo de Habitación" required>
            </div>
            <div class="mb-3">
                <input type="number" step="0.01" name="precio" class="form-control" placeholder="Precio por Noche" required>
            </div>
            <button type="submit" name="agregar" class="btn btn-primary">Agregar Habitación</button>
        </form>

        <h2 class="mt-5">Habitaciones Existentes</h2>
        <table class="table table-striped">
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
                        <a href="?editar=<?= $habitacion['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="?eliminar=<?= $habitacion['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que quieres eliminar esta habitación?')">Eliminar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <?php if (isset($_GET['editar'])): ?>
        <h2 class="mt-5">Editar Habitación</h2>
        // Formulario de edición
        <form method="post">
            <input type="hidden" name="id" value="<?= $habitacion['id'] ?>">
            <div class="mb-3">
                <input type="text" name="numero" class="form-control" value="<?= $habitacion['numero'] ?>" required>
            </div>
            <div class="mb-3">
                <input type="text" name="tipo" class="form-control" value="<?= $habitacion['tipo'] ?>" required>
            </div>
            <div class="mb-3">
                <input type="number" step="0.01" name="precio" class="form-control" value="<?= $habitacion['precio'] ?>" required>
            </div>
            <div class="mb-3">
                <textarea name="descripcion" class="form-control"><?= $habitacion['descripcion'] ?></textarea>
            </div>
            <button type="submit" name="editar" class="btn btn-success">Actualizar Habitación</button>
        </form>

        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
