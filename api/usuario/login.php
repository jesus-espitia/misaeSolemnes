<?php
session_start();
require_once __DIR__ . '/../config/database.php';

$conn = conectarBD();

// Obtener datos del formulario
$correo = $_POST['correo_usuario'] ?? '';
$contrasena = $_POST['contrasena_usuario'] ?? '';

// Validar campos
if (empty($correo) || empty($contrasena)) {
    echo "<script>alert('Por favor, completa todos los campos'); window.location.href='../../public/login.html';</script>";
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
        header("Location: ../../public/inicio.html");
        exit();
    } else {
        echo "<script>alert('Contraseña incorrecta'); window.location.href='../../public/login.html';</script>";
    }
} else {
    echo "<script>alert('Correo no registrado'); window.location.href='../../public/login.html';</script>";
}

$stmt->close();
$conn->close();
