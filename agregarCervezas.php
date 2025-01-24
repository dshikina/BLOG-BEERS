<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo "Debes iniciar sesión para agregar una cerveza.";
    exit();
}
include('php/conexion.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $origen = $_POST['origen'];
    $alcohol = $_POST['alcohol'];
    $categoria = (int)$_POST['categoria']; 
    $descripcion = $_POST['descripcion'];
    $notaDeCata = $_POST['notaDeCata'];
    $descripcionCorta = $_POST['descripcionCorta'];
    $imagen = null;
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $imagen_tmp = $_FILES['imagen']['tmp_name'];
        $imagen_nombre = basename($_FILES['imagen']['name']);
        $imagen_nombre = preg_replace('/[^a-zA-Z0-9\.\-_]/', '_', $imagen_nombre);
        $directorio = 'imagenes/';
        if (!is_dir($directorio)) {
            mkdir($directorio, 0777, true);
        }
        $imagen_destino = $directorio . $imagen_nombre;
        if (strpos($_FILES['imagen']['type'], 'image') === false) {
            die("El archivo no es una imagen válida.");
        }
        if (!move_uploaded_file($imagen_tmp, $imagen_destino)) {
            die("Hubo un error al mover la imagen.");
        }
        $imagen = $imagen_nombre;
    }
    $fecha_creacion = date('Y-m-d H:i:s');
    $query_insert = "INSERT INTO cervezas (nombre, origen, alcohol, fecha_creacion, id_categoria, descripcion, notaDeCata, imagen, descripcionCorta) 
                     VALUES (:nombre, :origen, :alcohol, :fecha_creacion, :id_categoria, :descripcion, :notaDeCata, :imagen, :descripcionCorta)";
    $stmt = $conn->prepare($query_insert);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':origen', $origen);
    $stmt->bindParam(':alcohol', $alcohol);
    $stmt->bindParam(':fecha_creacion', $fecha_creacion);
    $stmt->bindParam(':id_categoria', $categoria); // Asegúrate de que esto sea correcto
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':notaDeCata', $notaDeCata);
    $stmt->bindParam(':imagen', $imagen);
    $stmt->bindParam(':descripcionCorta', $descripcionCorta);
    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        print_r($stmt->errorInfo());
        echo "Hubo un error al agregar la cerveza.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nueva Cerveza</title>
    <style>
body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            padding-top: 30px;
        }
        .container {
            width: 100%;
            max-width: 700px; 
            display: flex;
            flex-direction: column;
            align-items: stretch; 
        }
        h1 {
            font-size: 2.5em;
            color: #ffcc00;
            background-color: #1d1d1d;
            padding: 20px;
            margin: 0;
            border-radius: 8px 8px 0 0;
            text-align: center;
            text-transform: uppercase;
            width: 100%;  
            box-sizing: border-box; 
        }
        form {
            background-color: #fff;
            width: 100%;  
            padding: 30px;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            box-sizing: border-box;  
        }
        .form-group {
            display: flex;
            flex-direction: column;
        }
        label {
            font-size: 1.1em;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }
        input[type="text"],
        select,
        textarea {
            width: 100%;
            padding: 12px;
            font-size: 1.1em;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
        }
        textarea {
            height: 120px;
            resize: vertical;
        }
        button {
            grid-column: span 2;
            padding: 12px;
            background-color: #ffcc00;
            border: none;
            color: #1d1d1d;
            font-weight: bold;
            font-size: 1.2em;
            cursor: pointer;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #e6b800;
        }
        @media (max-width: 768px) {
            form {
                grid-template-columns: 1fr;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Agregar Nueva Cerveza</h1>
        <form action="agregarCervezas.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="origen">Origen:</label>
                <input type="text" id="origen" name="origen" required>
            </div>
            <div class="form-group">
                <label for="alcohol">Porcentaje de Alcohol:</label>
                <input type="text" id="alcohol" name="alcohol" required>
            </div>
            <div class="form-group">
            <label for="categoria">Categoría:</label>
                <select id="categoria" name="categoria" required>
                    <option value="1">IPA</option>
                    <option value="2">Lager</option>
                    <option value="3">Stout</option>
                </select>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" required></textarea>
            </div>
            <div class="form-group">
                <label for="notaDeCata">Nota de Cata:</label>
                <textarea id="notaDeCata" name="notaDeCata" required></textarea>
            </div>
            <div class="form-group">
                <label for="descripcionCorta">Descripción Corta:</label>
                <textarea id="descripcionCorta" name="descripcionCorta" required></textarea>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" name="imagen" accept="image/*" required>
            </div>
            <button type="submit">Agregar Cerveza</button>
        </form>
    </div>
</body>
</html>

