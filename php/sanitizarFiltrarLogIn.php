<?php
include('conexion.php'); 
session_start();    
function sanitizarDatos($datos) {
    $datos = trim($datos);         
    $datos = stripslashes($datos);  
    $datos = htmlspecialchars($datos); 
    return $datos;
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuarioOEmail = isset($_POST['usuarioOEmail']) ? sanitizarDatos($_POST['usuarioOEmail']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    if (empty($usuarioOEmail) || empty($password)) {
        header("Location: ../logIn.php?error=datos_incorrectos"); 
        exit();
    }
    try {
        $campo = filter_var($usuarioOEmail, FILTER_VALIDATE_EMAIL) ? 'email' : 'usuario';
        $sql = "SELECT id, usuario, tipo_usuario, password FROM usuarios WHERE $campo = :dato";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':dato', $usuarioOEmail);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC); 
        if ($usuario && password_verify($password, $usuario['password'])) {
            $_SESSION['id_usuario'] = $usuario['id']; 
            $_SESSION['usuario'] = $usuario['usuario'];
            $_SESSION['tipo_usuario'] = $usuario['tipo_usuario']; 
            header("Location: ../index.php");
            exit();
        } else {
            header("Location: ../logIn.php?error=datos_incorrectos");
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
