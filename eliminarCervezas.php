<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo "Debes iniciar sesión para eliminar una cerveza.";
    exit();
}
include('php/conexion.php');
try {
    $query = "SELECT id, nombre FROM cervezas";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $cervezas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al cargar las cervezas: " . $e->getMessage();
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['cerveza']) || !is_numeric($_POST['cerveza'])) {
        echo "Debes seleccionar una cerveza válida.";
        exit();
    }
    $id = (int)$_POST['cerveza'];
    try {
        $query_select = "SELECT imagen FROM cervezas WHERE id = :id";
        $stmt_select = $conn->prepare($query_select);
        $stmt_select->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt_select->execute();
        $cerveza = $stmt_select->fetch(PDO::FETCH_ASSOC);
        if (!$cerveza) {
            echo "La cerveza seleccionada no existe.";
            exit();
        }
        $query_delete = "DELETE FROM cervezas WHERE id = :id";
        $stmt_delete = $conn->prepare($query_delete);
        $stmt_delete->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt_delete->execute()) {
            if (!empty($cerveza['imagen'])) {
                $ruta_imagen = 'imagenes/' . $cerveza['imagen'];
                if (file_exists($ruta_imagen)) {
                    unlink($ruta_imagen); 
                }
            }
        } else {
            echo "<p style='color: red;'>Error al eliminar la cerveza.</p>";
        }
    } catch (PDOException $e) {
        echo "Error en la base de datos: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Cerveza</title>
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
            background-color:#ffcc00;
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
        p {
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Eliminar Cerveza</h1>
        <form action="eliminarCervezas.php" method="POST">
            <label for="cerveza">Selecciona la cerveza que deseas eliminar:</label>
            <select name="cerveza" id="cerveza" required>
                <option value="">-- Selecciona una cerveza --</option>
                <?php foreach ($cervezas as $cerveza): ?>
                    <option value="<?= htmlspecialchars($cerveza['id']) ?>">
                        <?= htmlspecialchars($cerveza['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Eliminar Cerveza</button>
        </form>
        <a href="index.php" class="btn-secondary">Volver al inicio</a>
    </div>
</body>
</html>
