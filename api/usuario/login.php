<?php
session_start();
require_once __DIR__ . '/../config/database.php';

$conn = conectarBD();

// Obtener datos del formulario
$correo = $_POST['correo_usuario'] ?? '';
$contrasena = $_POST['contrasena_usuario'] ?? '';

// Validar campos
if (empty($correo) || empty($contrasena)) {
    header("Location: ../utils/alerta.php?tipo=error&titulo=¡ERROR!&mensaje=Faltan+campos&redirect=../../login.html");
    exit();
}

// Consultar usuario
$sql = "SELECT * FROM USUARIOS WHERE correo_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $usuario = $result->fetch_assoc();

    if (password_verify($contrasena, $usuario['contraseña_usuario'])) {
        $_SESSION['usuario_id'] = $usuario['id_usuario'];
        $_SESSION['nombre'] = $usuario['nombre_usuario'];
        $_SESSION['email'] = $correo;
        header("Location: ../../perfil.php");
        exit();
    } else {
        header("Location: ../utils/alerta.php?tipo=error&titulo=¡ERROR!&mensaje=Contraseña+incorrecta&redirect=../../login.html");
    }
} else {
    header("Location: ../utils/alerta.php?tipo=error&titulo=¡ERROR!&mensaje=Correo+no+registrado&redirect=../../login.html");
}

$stmt->close();
$conn->close();
