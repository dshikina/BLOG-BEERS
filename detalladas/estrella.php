<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo "Debes iniciar sesión para dejar una reseña.";
    exit();
}
include('../php/conexion.php');
$query = "SELECT c.*, cat.nombre AS categoria_nombre 
          FROM cervezas c 
          INNER JOIN categorias cat ON c.id_categoria = cat.id_categoria 
          WHERE c.nombre = 'Estrella'"; 
$stmt = $conn->prepare($query);
$stmt->execute();
$cerveza = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$cerveza) {
    echo "Cerveza no encontrada.";
    exit;
}
$imagePath = "../imagenes/" . $cerveza['imagen'];
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comentario'])) {
    $comentario = $_POST['comentario'];
    $fecha = date('Y-m-d H:i:s'); 
    $id_usuario = $_SESSION['id_usuario']; 
    $id_cerveza = $cerveza['id'];  
    $query_insert = "INSERT INTO resenias (fecha, comentario, id_usuario, id_cerveza) 
                     VALUES (:fecha, :comentario, :id_usuario, :id_cerveza)";
    $stmt = $conn->prepare($query_insert);
    $stmt->bindParam(':fecha', $fecha);
    $stmt->bindParam(':comentario', $comentario);
    $stmt->bindParam(':id_usuario', $id_usuario); 
    $stmt->bindParam(':id_cerveza', $id_cerveza);
    if ($stmt->execute()) {
    } else {
        echo "<p>Hubo un error al guardar la reseña.</p>";
    }
}
$query_reseñas = "SELECT r.comentario, r.fecha, u.nombre, u.apellido, r.id 
                  FROM resenias r 
                  INNER JOIN usuarios u ON r.id_usuario = u.id 
                  WHERE r.id_cerveza = :id_cerveza 
                  ORDER BY r.fecha DESC"; 
$stmt_reseñas = $conn->prepare($query_reseñas);
$stmt_reseñas->bindParam(':id_cerveza', $cerveza['id']);
$stmt_reseñas->execute();
$reseñas = $stmt_reseñas->fetchAll(PDO::FETCH_ASSOC);
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['eliminar_comentario'])) {
    $id_comentario = $_POST['eliminar_comentario'];
    $id_usuario = $_SESSION['usuario'];
    $id_usuario_query = "SELECT id FROM usuarios WHERE usuario = :usuario";
    $stmt_id_usuario = $conn->prepare($id_usuario_query);
    $stmt_id_usuario->bindParam(':usuario', $id_usuario);
    $stmt_id_usuario->execute();
    $id_usuario_result = $stmt_id_usuario->fetch(PDO::FETCH_ASSOC);
    $id_usuario = $id_usuario_result['id'];

    $query_delete = "DELETE FROM resenias WHERE id = :id_comentario AND id_usuario = :id_usuario";
    $stmt_delete = $conn->prepare($query_delete);
    $stmt_delete->bindParam(':id_comentario', $id_comentario);
    $stmt_delete->bindParam(':id_usuario', $id_usuario);
    if ($stmt_delete->execute()) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Hubo un error al eliminar el comentario.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Cerveza Estrella</title>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            color: #333;
            margin: 0;
            padding: 0;
        }
        h1 {
            background-color: #333;
            color: #ffcc00;
            text-align: center;
            padding: 20px 0;
            margin: 0;
        }
        h2 {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }
        .cerveza-detail {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .cerveza-detail img {
            display: block;
            margin: 0 auto 20px auto; 
            max-width: 100%;
            border-radius: 8px;
        }
        .cerveza-detail p {
            font-size: 1.1em;
            color: #555;
            margin-bottom: 10px;
        }
        .cerveza-detail strong {
            color: #333;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 30px;
            font-size: 1.1em;
            color: #ffcc00;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        .reseñas-section {
            margin-top: 30px;
            text-align: center;
        }
        .reseñas-section h3 {
            font-size: 1.3em;
            color: #333;
        }
        .reseña {
            background-color: #ffcc00;
            border: 2px solid black;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .reseña .usuario {
            font-size: 1em;
            font-weight: bold;
            color: #333;
            margin-right: 10px;
        }
        .reseña .fecha {
            font-size: 0.9em;
            color: #888;
            margin-top: 10px;
        }
        .reseña .comentario {
            text-align: center;
            font-size: 1em;
            color: #555;
            margin: 10px 0;
            width: 60%; 
            margin-left: 20px;
        }
        .eliminar-btn {
            background-color: red;
            color: white;
            border: none;
            padding: 10px;
            font-size: 20px;
            width: 40px;
            height: 40px;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            margin-left: 10px;
        }

        .eliminar-btn:hover {
            background-color: darkred;
        }
        .comentario-box {
            width: 60%;
            margin: 20px auto;
            padding: 15px;
            background-color: #f0f0f0;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 1em;
            color: #555;
            resize: none;
            min-height: 150px;
            max-height: 250px;
            display: block;
            margin-bottom: 20px;
        }
        .comentario-btn {
            padding: 10px 20px;
            font-size: 1.1em;
            background-color: #ffcc00;
            color: #333;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: block;
            margin: 0 auto;
        }
        .comentario-btn:hover {
            background-color: #e6b800;
        }
        footer {
            background-color: #333;
            color: #ffcc00;
            text-align: center;
            padding: 20px;
            position: relative;
            width: 100%;
            bottom: 0;
            left: 0;
            z-index: 10;
        }
        footer p{
            color: #ffcc00;
        }
    </style>
</head>
<body>
<h1>Cerveza <?php echo $cerveza['nombre']; ?></h1>
<div class="cerveza-detail">
    <img src="<?php echo $imagePath; ?>" alt="Cerveza <?php echo $cerveza['nombre']; ?>">
    <h2>Descripción Completa</h2>
    <p><?php echo $cerveza['descripcion']; ?></p>
    <h3>Datos de la Cerveza</h3>
    <p><strong>Categoría:</strong> <?php echo $cerveza['categoria_nombre']; ?></p>
    <p><strong>País de origen:</strong> <?php echo $cerveza['origen']; ?></p>
    <p><strong>Alcohol:</strong> <?php echo $cerveza['alcohol']; ?>%</p>
    <p><strong>Fecha de creación:</strong> <?php echo $cerveza['fecha_creacion']; ?></p>
    <h3>Notas de Cata</h3>
    <p><?php echo $cerveza['notaDeCata']; ?></p>
    <div class="reseñas-section">
        <h3>Reseñas</h3>
        <?php if (count($reseñas) > 0): ?>
            <?php foreach ($reseñas as $reseña): ?>
                <div class="reseña">
                    <div class="left">
                        <p class="usuario">Usuario: <?php echo $reseña['nombre'] . ' ' . $reseña['apellido']; ?></p>
                        <p class="fecha">Fecha: <?php echo $reseña['fecha']; ?></p>
                    </div>
                    <div class="comentario">
                        <p><?php echo nl2br(htmlspecialchars($reseña['comentario'])); ?></p>
                    </div>
                    <form method="POST" style="display:inline;">
                        <button type="submit" name="eliminar_comentario" value="<?php echo $reseña['id']; ?>" class="eliminar-btn">-</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay reseñas disponibles para esta cerveza.</p>
        <?php endif; ?>
        <form method="POST">
            <textarea class="comentario-box" name="comentario" placeholder="Escribe tu reseña sobre esta cerveza..."></textarea>
            <button type="submit" class="comentario-btn">Comentar</button>
        </form>
    </div>
    <a href="../index.php" class="back-link">Volver al blog</a>
</div>
<footer>
    <p>&copy; 2024 Blog de Cervezas</p>  
</footer>
</body>
</html>

