<?php
require_once __DIR__ . '/../config/database.php';

$conn = conectarBD();

if(!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}
session_start();


// Hashear contraseña
$hash = password_hash($_SESSION['password'], PASSWORD_BCRYPT);

// Insertar en BD
$stmt = $conn->prepare("INSERT INTO USUARIOS (nombre_usuario, correo_usuario, contraseña_usuario, pais_usuario) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $_SESSION['nameInput'], $_SESSION['email'], $hash, $_SESSION['countryUser']);

if ($stmt->execute()) {
    header("Location: ../utils/alerta.php?tipo=success&titulo=¡BIEN+HECHO!&mensaje=Ya+puedes+ingresar&redirect=../../login.html");
} else {
    header("Location: ../utils/alerta.php?tipo=info&titulo=¡YA+TIENES+UNA+CUENTA!&mensaje=El+correo+ya+existe&redirect=../../registro.html");
}

$stmt->close();
$conn->close();
