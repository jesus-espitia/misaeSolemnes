<?php
require_once __DIR__ . '/../config/database.php';

$conn = conectarBD();

// Obtener datos
$nombre = $_POST['nombre_usuario'] ?? '';
$correo = $_POST['correo_usuario'] ?? '';
$contraseña = $_POST['contraseña_usuario'] ?? '';
$pais = $_POST['pais_usuario'] ?? '';

if (empty($nombre) || empty($correo) || empty($contraseña) || empty($pais)) {
    header("Location: ../utils/alerta.php?tipo=error&titulo=¡ERROR!&mensaje=Faltan+campos&redirect=../../registro.html");
    exit();
}

// Hashear contraseña
$hash = password_hash($contraseña, PASSWORD_BCRYPT);

// Insertar en BD
$stmt = $conn->prepare("INSERT INTO USUARIOS (nombre_usuario, correo_usuario, contraseña_usuario, pais_usuario) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $nombre, $correo, $hash, $pais);

if ($stmt->execute()) {
    header("Location: ../utils/alerta.php?tipo=success&titulo=¡BIEN+HECHO!&mensaje=Ya+puedes+ingresar&redirect=../../login.html");
} else {
    header("Location: ../utils/alerta.php?tipo=info&titulo=¡YA+TIENES+UNA+CUENTA!&mensaje=El+correo+ya+existe&redirect=../../registro.html");}

$stmt->close();
$conn->close();
