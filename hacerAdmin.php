<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo_usuario'] !== 'administrador') {
    header("Location: index.php"); 
    exit();
}
include('php/conexion.php');
$query = "SELECT id, nombre, apellido, tipo_usuario FROM usuarios WHERE tipo_usuario = 'usuario'";
$result = $conn->query($query);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['usuario']) || !is_numeric($_POST['usuario'])) {
        echo "Debes seleccionar un usuario válido.";
        exit();
    }
    $id_usuario = (int)$_POST['usuario'];
    $query_update = "UPDATE usuarios SET tipo_usuario = 'administrador' WHERE id = :id_usuario";
    $stmt = $conn->prepare($query_update);
    $stmt->bindParam(':id_usuario', $id_usuario);
    if ($stmt->execute()) {
        $message = "El usuario ha sido promovido a administrador.";
    } else {
        $message = "Error al actualizar el tipo de usuario.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hacer Administrador</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #ffcc00;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        h1 {
            font-size: 24px;
            color: #333;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            font-size: 14px;
            color: #555;
            margin-bottom: 8px;
            text-align: left;
        }
        select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        select {
            background-color: #f9f9f9;
        }
        button {
            background-color: #000000;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #333;
        }
        p {
            font-size: 14px;
        }
        .btn-secondary {
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            background-color: #000000;
            color: white;
            padding: 10px 15px;
            border-radius: 4px;
            font-size: 14px;
        }
        .btn-secondary:hover {
            background-color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Convertir Usuario normal a Administrador</h1>
        <form method="POST" action="hacerAdmin.php">
            <label for="usuario">Selecciona un usuario para hacer administrador:</label>
            <select name="usuario" id="usuario" required>
                <option value="">-- Selecciona un usuario --</option>
                <?php foreach ($result as $row): ?>
                    <option value="<?= htmlspecialchars($row['id']) ?>">
                        <?= htmlspecialchars($row['nombre']) ?> <?= htmlspecialchars($row['apellido']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Promover a Administrador</button>
        </form>
        <?php if (isset($message)): ?>
            <p><?= $message ?></p>
        <?php endif; ?>
        <a href="index.php" class="btn-secondary">Volver al inicio</a>
    </div>
</body>
</html>
