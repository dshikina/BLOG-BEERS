<?php
session_start();
try {
    $pdo = new PDO('mysql:host=localhost;dbname=cerveza', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query("SELECT nombre, descripcion, imagen FROM categorias");
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorías de Cervezas</title>
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
        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            background-color: #333;
            display: flex;
            justify-content: center;
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
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        nav ul li a:hover {
            background-color: #ffcc00;
            color: #333;
        }
        .categorias-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .categoriaCaja {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-align: center;
            overflow: hidden;
        }
        .categoriaCaja:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        .categoriaCaja img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .categoriaCaja p {
            text-align: justify;
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
        .back-link {
            display: block;
            text-align: center;
            margin: 0 auto;
            margin-top: 20px;
            font-size: 1.1em;
            color: #333;
            text-decoration: none;
            width: 200px;
            padding: 10px;
            background-color: #ffcc00;
            border-radius: 5px;
            font-weight: bold;
            transition: transform 0.3s ease;
        }
        .back-link:hover {
            transform: scale(1.05);
        }
        .spacer {
            height: 40px; 
        }
        @media (max-width: 768px) {
            .categorias-container {
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
    <h1>Categorías de Cervezas</h1>
    <h2>Explora las categorías de cervezas y descubre más sobre ellas.</h2>
    <div class="categorias-container">
        <?php foreach ($categorias as $categoria): ?>
            <div class="categoriaCaja">
                <h3><?= htmlspecialchars($categoria['nombre']) ?></h3>
                <?php if (strtolower($categoria['nombre']) === 'stout'): ?>
                    <p><?= htmlspecialchars($categoria['descripcion']) ?></p>
                    <img src="imagenes/<?= htmlspecialchars($categoria['imagen']) ?>" alt="<?= htmlspecialchars($categoria['nombre']) ?>" class="stout">
                <?php else: ?>
                    <img src="imagenes/<?= htmlspecialchars($categoria['imagen']) ?>" alt="<?= htmlspecialchars($categoria['nombre']) ?>">
                    <p><?= htmlspecialchars($categoria['descripcion']) ?></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <a href="index.php" class="back-link">Volver al inicio</a>
    <div class="spacer"></div>
    <footer>
        <p>&copy; 2024 Blog de Cervezas</p>
    </footer>
</body>
</html>
