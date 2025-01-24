<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        h1 {
            background-color: #333;
            color: #ffcc00;
            text-align: center;
            padding: 20px 0;
            margin-bottom: 20px;
        }
        form {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        label {
            display: block;
            font-size: 1em;
            color: #333;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            font-size: 1em;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button[type="submit"] {
            padding: 10px 20px;
            font-size: 1em;
            background-color: #ffcc00;
            color: #333;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-weight: bold;
        }
        button[type="submit"]:hover {
            background-color: #e6b800;
        }
        a {
            color: #ffcc00;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .error-message {
            color: red;
            font-size: 0.9em;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <form action="php/sanitizarFiltrarLogIn.php" method="POST">
        <h1>Iniciar Sesión</h1>
        <label for="usuarioOEmail">Usuario o Correo:</label>
        <input type="text" id="usuarioOEmail" name="usuarioOEmail" placeholder="Usuario o Correo" required>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Iniciar sesión</button>
        <h3>¿No tienes una cuenta? <a href="registrarse.html">Regístrate acá</a>.</h3>
        <?php if (isset($_GET['error']) && $_GET['error'] === 'datos_incorrectos'): ?>
            <p class="error-message">Datos incorrectos, vuelve a ingresarlos.</p>
        <?php endif; ?>
        
    </form>
</body>
</html>
