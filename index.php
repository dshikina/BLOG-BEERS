<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && (isset($_GET['categoria']) || isset($_GET['detalles']))) {
        header('Location: logIn.php');
        exit();
    }
}
try {
    $pdo = new PDO('mysql:host=localhost;dbname=cerveza', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
    $sql = "SELECT c.id, c.nombre, c.descripcionCorta, c.imagen, ca.nombre AS categoria
            FROM cervezas c
            INNER JOIN categorias ca ON c.id_categoria = ca.id_categoria";
    if ($categoria != '') {
        $sql .= " WHERE ca.nombre = :categoria";
    }
    $stmt = $pdo->prepare($sql);
    if ($categoria != '') {
        $stmt->bindParam(':categoria', $categoria, PDO::PARAM_STR);
    }
    $stmt->execute();
    $cervezas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog de Cervezas</title>
    
<style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.6;
        }
        h1 {
            background-color: #1d1d1d;
            color: #ffcc00;
            text-align: center;
            padding: 30px;
            font-size: 2.5em;
            letter-spacing: 1px;
            margin: 0;
        }
        h2 {
            color: #333;
            text-align: center;
            margin-top: 20px;
            font-size: 1.4em;
            font-weight: normal;
            padding: 0 10px;
        }
        h3 {
            font-size: 1.2em;
            color: #333;
            margin-bottom: 15px;
        }
        p {
            font-size: 1em;
            color: #555;
            margin-bottom: 15px;
        }
        a {
            color: #ffcc00;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }
        a:hover {
            color: #e6b800;
        }
        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            background-color: #333;
            display: flex;
            justify-content: center;
            position: relative; 
        }
        nav ul li {
            margin: 0 20px;
        }
        nav ul li a {
            display: block;
            padding: 15px;
            font-weight: bold;
            text-align: center;
            color: #fff;
            transition: background-color 0.3s ease;
        }
        nav ul li a:hover {
            background-color: #ffcc00;
            color: #333;
        }
        form {
            text-align: center;
            margin: 20px auto;
            padding: 10px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        label {
            font-size: 1.1em;
            color: #333;
            margin-right: 10px;
        }
        select {
            padding: 8px;
            font-size: 1em;
            margin-right: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #ffcc00;
            border: none;
            color: #333;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
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
        .cervezas-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .cervezaCaja {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-align: center;
            cursor: pointer;
            overflow: hidden;
        }
        .cervezaCaja:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        .cervezaCaja img.cerveza-img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        @media (max-width: 768px) {
            .cervezas-container {
                grid-template-columns: 1fr;
            }
            h1 {
                font-size: 2em;
            }
            h2 {
                font-size: 1.2em;
            }
        }
        @media (max-width: 480px) {
            nav ul {
                flex-direction: column;
            }
            nav ul li {
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <h1>Blog de Cervezas</h1>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <?php if (isset($_SESSION['usuario'])): ?>
                <nav>
                    <ul>
                        <li><a href="categorias.php">Categorías</a></li>
                        <?php if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 'administrador'): ?>
                            <li><a href="agregarCervezas.php">Agregar Cervezas</a></li>
                            <li><a href="eliminarCervezas.php">Eliminar Cervezas</a></li>
                            <li><a href="hacerAdmin.php">Hacer Admin</a></li>
                            <li><a href="quitarAdmin.php">Quitar Admin</a></li>
                        <?php endif; ?>
                        <li><a href="cerrarSesion.php">Cerrar sesión</a></li>
                    </ul>
                </nav>
            <?php else: ?>
                <li><a href="logIn.php">Iniciar sesión</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <?php if (isset($_SESSION['usuario'])): ?>
        <form action="index.php" method="get">
            <label for="categoria">Filtrar por categoría:</label>
            <select id="categoria" name="categoria">
                <option value="">Selecciona una categoría</option>
                <option value="Lager" <?= isset($_GET['categoria']) && $_GET['categoria'] == 'Lager' ? 'selected' : '' ?>>Lager</option>
                <option value="Stout" <?= isset($_GET['categoria']) && $_GET['categoria'] == 'Stout' ? 'selected' : '' ?>>Stout</option>
                <option value="IPA" <?= isset($_GET['categoria']) && $_GET['categoria'] == 'IPA' ? 'selected' : '' ?>>IPA</option>
            </select>
            <input type="submit" value="Filtrar">
        </form>
    <?php endif; ?>
    <div class="cervezas-container">
        <?php foreach ($cervezas as $cerveza): ?>
            <div class="cervezaCaja">
                <img src="imagenes/<?= htmlspecialchars($cerveza['imagen']) ?>" alt="Cerveza <?= htmlspecialchars($cerveza['nombre']) ?>" class="cerveza-img">
                <h3><?= htmlspecialchars($cerveza['nombre']) ?></h3>
                <p><?= htmlspecialchars($cerveza['descripcionCorta']) ?></p>
                <p><strong>Categoría:</strong> <?= htmlspecialchars($cerveza['categoria']) ?></p>
                <?php if (isset($_SESSION['usuario'])): ?>
                    <a href="detalladas/<?= htmlspecialchars($cerveza['nombre']) ?>.php">Leer más</a>
                <?php else: ?>
                    <a href="logIn.php">Inicia sesión para ver más detalles</a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <footer>
        <p>&copy; 2024 Blog de Cervezas</p>  
    </footer>
</body>
</html>
