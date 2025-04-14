<?php
require_once __DIR__ . '/../config/database.php';

$conn = conectarBD();

// Obtener datos
$nombre = $_POST['nombre_usuario'] ?? '';
$correo = $_POST['correo_usuario'] ?? '';
$contraseña = $_POST['contraseña_usuario'] ?? '';
$pais = $_POST['pais_usuario'] ?? '';

if (empty($nombre) || empty($correo) || empty($contraseña) || empty($pais)) {
    echo "<script>alert('Todos los campos son obligatorios'); window.location.href='../../public/registro.html';</script>";
    exit();
}

// Hashear contraseña
$hash = password_hash($contraseña, PASSWORD_BCRYPT);

// Insertar en BD
$stmt = $conn->prepare("INSERT INTO USUARIOS (nombre_usuario, correo_usuario, contraseña_usuario, pais_usuario) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $nombre, $correo, $hash, $pais);

if ($stmt->execute()) {
    echo "<script>alert('Registro exitoso. Ahora puedes iniciar sesión.'); window.location.href='../../public/login.html';</script>";
} else {
    echo "<script>alert('Error al registrar. ¿El correo ya existe?'); window.location.href='../../public/registro.html';</script>";
}

$stmt->close();
$conn->close();
