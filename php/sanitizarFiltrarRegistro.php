<?php
include('conexion.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    function sanitizar($dato) {
        $dato = trim($dato);            
        $dato = stripslashes($dato);    
        $dato = htmlspecialchars($dato); 
        return $dato;
    }
    $nombre = sanitizar($_POST["nombre"] ?? '');
    $apellido = sanitizar($_POST["apellido"] ?? '');
    $email = sanitizar($_POST["email"] ?? ''); 
    $usuario = sanitizar($_POST["usuario"] ?? '');
    $password = sanitizar($_POST["password"] ?? '');
    var_dump($email); 
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("El correo electrónico no es válido.");
    }
    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $nombre)) {
        die("El nombre contiene caracteres no permitidos.");
    }
    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $apellido)) {
        die("El apellido contiene caracteres no permitidos.");
    }
    if (!preg_match("/^[a-zA-Z0-9_]+$/", $usuario)) {
        die("El nombre de usuario solo puede contener letras, números y guiones bajos.");
    }
    if (strlen($password) < 1) {
        die("La contraseña debe tener al menos 1 caracteres.");
    }
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    try {
        $sql = "INSERT INTO usuarios (nombre, apellido, email, usuario, password) 
                VALUES (:nombre, :apellido, :email, :usuario, :password)";
        $stmt = $conn->prepare($sql);  
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':email', $email); 
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();
        header("Location: ../logIn.php");
        exit();
        /*
        echo "<h1>Registro exitoso</h1>";
        echo "<p>Nombre: $nombre</p>";
        echo "<p>Apellido: $apellido</p>";
        echo "<p>Email: $email</p>";    
        echo "<p>Usuario: $usuario</p>";*/
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Acceso no autorizado.";
}
?>
